<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>간단한 지도 표시하기</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ewzw7q7mjs"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="map" style="width:100%;height:800px;"></div>

<script>
    var map = new naver.maps.Map('map', {
        useStyleMap: true,
        center: new naver.maps.LatLng(37.3595316, 127.1052133),
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: naver.maps.MapTypeControlStyle.DROPDOWN
        }
    });

    function startCadastralLayer() {
        var cadastralLayer = new naver.maps.CadastralLayer({ useStyleMap: true });

        var btn = $('#cadastral');

        naver.maps.Event.addListener(map, 'cadastralLayer_changed', function(cadastralLayer) {
            if (cadastralLayer.getMap()) {
                btn.addClass('control-on').val('지적도 끄기');
            } else {
                btn.removeClass('control-on').val('지적도 켜기');
            }
        });

        cadastralLayer.setMap(map);

        btn.on('click', function(e) {
            e.preventDefault();

            if (cadastralLayer.getMap()) {
                cadastralLayer.setMap(null);
                btn.removeClass('control-on').val('지적도 켜기');
            } else {
                cadastralLayer.setMap(map);
                btn.addClass('control-on').val('지적도 끄기');
            }
        });
    }

    naver.maps.Event.once(map, 'init_stylemap', startCadastralLayer);

</script>
</body>
</html>