<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>주소와 좌표 검색 API 사용하기</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ewzw7q7mjs&submodules=geocoder"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<style type="text/css">
    .search { position:absolute;z-index:1000;top:20px;left:20px; }
    .search #address { width:150px;height:20px;line-height:20px;border:solid 1px #555;padding:5px;font-size:12px;box-sizing:content-box; }
    .search #submit { height:30px;line-height:30px;padding:0 10px;font-size:12px;border:solid 1px #555;border-radius:3px;cursor:pointer;box-sizing:content-box; }
</style>

<div id="wrap" class="section">
    <h2>주소와 좌표 검색 API 사용하기</h2>
    <p>Geocoder 서브 모듈의 Service 객체를 사용하여 주소로 좌표를 검색하거나(Geocode) 좌표로 주소를 검색하는(Reversegeocode) 예제입니다.<br />
        입력 창에 주소를 입력하여 검색하면 해당 주소의 좌표로 이동하며, 지도를 클릭하면 해당 지점의 경위도 좌표로 주소를 검색합니다.<br />
        Geocode API의 자세한 응답값은 <a id="new-window" href="https://apidocs.ncloud.com/ko/ai-naver/maps_geocoding/geocode/" target="_blank">Geocode API</a>를 참고하세요.<br />
        Reversegeocode API의 자세한 응답값은 <a id="new-window" href="https://apidocs.ncloud.com/ko/ai-naver/maps_reverse_geocoding/gc/" target="_blank">ReverseGeocode API</a>를 참고하세요.</p>
    <div id="map" style="width:100%;height:600px;">
        <div class="search" style="">
            <input id="address" type="text" placeholder="검색할 주소" value="불정로 6" />
            <input id="submit" type="button" value="주소 검색" />
        </div>
    </div>
    <code id="snippet" class="snippet"></code>
</div>

<script>
    var map = new naver.maps.Map("map", {
        center: new naver.maps.LatLng(37.3595316, 127.1052133),
        zoom: 15,
        mapTypeControl: true
    });

    var infoWindow = new naver.maps.InfoWindow({
        anchorSkew: true
    });

    map.setCursor('pointer');

    function searchCoordinateToAddress(latlng) {

        infoWindow.close();

        naver.maps.Service.reverseGeocode({
            coords: latlng,
            orders: [
                naver.maps.Service.OrderType.ADDR,
                naver.maps.Service.OrderType.ROAD_ADDR
            ].join(',')
        }, function(status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                if (!latlng) {
                    return alert('ReverseGeocode Error, Please check latlng');
                }
                if (latlng.toString) {
                    return alert('ReverseGeocode Error, latlng:' + latlng.toString());
                }
                if (latlng.x && latlng.y) {
                    return alert('ReverseGeocode Error, x:' + latlng.x + ', y:' + latlng.y);
                }
                return alert('ReverseGeocode Error, Please check latlng');
            }

            var address = response.v2.address,
                htmlAddresses = [];

            if (address.jibunAddress !== '') {
                htmlAddresses.push('[지번 주소] ' + address.jibunAddress);
            }

            if (address.roadAddress !== '') {
                htmlAddresses.push('[도로명 주소] ' + address.roadAddress);
            }

            infoWindow.setContent([
                '<div style="padding:10px;min-width:200px;line-height:150%;">',
                '<h4 style="margin-top:5px;">검색 좌표</h4><br />',
                htmlAddresses.join('<br />'),
                '</div>'
            ].join('\n'));

            infoWindow.open(map, latlng);
        });
    }

    function searchAddressToCoordinate(address) {
        naver.maps.Service.geocode({
            query: address
        }, function(status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                if (!address) {
                    return alert('Geocode Error, Please check address');
                }
                return alert('Geocode Error, address:' + address);
            }

            if (response.v2.meta.totalCount === 0) {
                return alert('도로명이나 지번주소를 정확히 입력해주세요');
            }

            var htmlAddresses = [],
                item = response.v2.addresses[0],
                point = new naver.maps.Point(item.x, item.y);

            if (item.roadAddress) {
                htmlAddresses.push('[도로명 주소] ' + item.roadAddress);
            }

            if (item.jibunAddress) {
                htmlAddresses.push('[지번 주소] ' + item.jibunAddress);
            }

            if (item.englishAddress) {
                htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
            }

            infoWindow.setContent([
                '<div style="padding:10px;min-width:200px;line-height:150%;">',
                '<h4 style="margin-top:5px;">검색 주소 : '+ address +'</h4><br />',
                htmlAddresses.join('<br />'),
                '</div>'
            ].join('\n'));

            map.setCenter(point);
            infoWindow.open(map, point);
        });
    }

    function initGeocoder() {
        if (!map.isStyleMapReady) {
            return;
        }

        map.addListener('click', function(e) {
            searchCoordinateToAddress(e.coord);
        });

        $('#address').on('keydown', function(e) {
            var keyCode = e.which;

            if (keyCode === 13) { // Enter Key
                searchAddressToCoordinate($('#address').val());
            }
        });

        $('#submit').on('click', function(e) {
            e.preventDefault();

            searchAddressToCoordinate($('#address').val());
        });

        searchAddressToCoordinate('정자동 178-1');
    }

    naver.maps.onJSContentLoaded = initGeocoder;
    naver.maps.Event.once(map, 'init_stylemap', initGeocoder);
</script>
</body>
</html>