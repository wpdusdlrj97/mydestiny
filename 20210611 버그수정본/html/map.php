<?php
//지적도 전체보기 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {


//토지 아이디로 정보 조회
    $land_id = $_GET['id'];
    $qry_string_land = "SELECT * FROM land_information where land_id='$land_id'";
    $qry_land = mysqli_query($connect, $qry_string_land);
    $row_land = mysqli_fetch_array($qry_land);

    ?>
    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="토지 중개 플랫폼 랜드마킹입니다.">
        <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
        <meta name="author" content="랜드마킹">
        <meta property="og:type" content="website">
        <meta property="og:url" content="url">
        <meta property="og:image" content="../../images/common/icon_logo01.png">
        <meta property="og:title" content="랜드마킹">
        <meta property="og:site_name" content="랜드마킹">
        <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
        <meta property="og:locale" content="ko_KR">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>랜드마킹</title>
        <!-- FAVICON-->
      
        <link rel="stylesheet" href="../../css/font.css">
        <script src="../../js/lib/jquery-3.6.0.min.js"></script>
        <script type="text/javascript"
                src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ewzw7q7mjs&submodules=geocoder"></script>
    </head>
    <body>
    <div id="wrap" class="section">
        <h2>랜드마킹 지도 전체보기</h2>
<!--        <div class="buttons">-->
<!--            <input id="cadastral" type="button" value="지적도" class="control-btn"/>-->
<!--        </div>-->
<!--        <div id="map" style="width:100%;height:800px;">-->
<!--        </div>-->
<!--        <code id="snippet" class="snippet"></code>-->
<!--        -->
        <div style="position : relative;width: 100%; height: 800px;">
            <div id="map" class="map bx-round_l bg_g"
                 style="position: absolute;width: 100%; height: 800px;"></div>
            <div style="position: absolute; width: 10%; height: 800px; float: left;">
                <input id="cadastral" type="button" value="지적도" class="control-btn"
                       style="margin:12px;background-color:#7868E6; color: white; width: 120px; height: 30px;font-weight: bolder;font-family:'GmarketSansMedium';"/>
                </button>
            </div>
        </div>
    </div>

    <!-- 네이버 지도 API 자바스크립트-->
    <script>
        var latlng_x = '<?php echo $row_land['land_x']?>';
        var latlng_y = '<?php echo $row_land['land_y']?>';

        var map = new naver.maps.Map('map', {
            useStyleMap: true,
            zoom: 18,
            center: new naver.maps.LatLng(latlng_y, latlng_x),
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: naver.maps.MapTypeControlStyle.DROPDOWN
            }
        });

        function startCadastralLayer() {
            var cadastralLayer = new naver.maps.CadastralLayer({useStyleMap: true});

            var btn = $('#cadastral');

            naver.maps.Event.addListener(map, 'cadastralLayer_changed', function (cadastralLayer) {
                if (cadastralLayer.getMap()) {
                    btn.addClass('control-on').val('지적도 끄기');
                } else {
                    btn.removeClass('control-on').val('지적도 켜기');
                }
            });

            cadastralLayer.setMap(map);

            btn.on('click', function (e) {
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
<?php } ?>