<?php
//토지 검색 페이지
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
        <title>랜드마킹</title>
        <!-- FAVICON-->

        <!-- STYLE LINK-->
        <link rel="stylesheet" href="../../css/default.css">
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="../../css/common.css">
        <link rel="stylesheet" href="../../css/main.css">

        <!-- SCRIPT -->
        <script src="../../js/lib/jquery-3.6.0.min.js"></script>
        <!--[if lte IE 9]>
        <script src="../../js/lib/IE9.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="../../js/lib/html5shiv.min.js"></script>
        <script src="../../js/lib/jqPIE.js"></script>
        <script src="../../js/lib/PIE.js"></script>
        <![endif]-->
        <!--네이버 지도 API 이용-->
        <script type="text/javascript"
                src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=egcozauon9&submodules=geocoder"></script>
    </head>
    <body>
    <div id="popup"></div>
    <div id="wrap" class="sub sub-register">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_pencil bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b">토지 등록</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="search-form bx-round_l bg_n">
                            <form class="row row01" onsubmit="return false;">
                                <fieldset class="clear">
                                    <label class="form-item" for="rg_addr">직접 입력하기</label>
                                    <div class="form-item input-wrap l-inline bx-round_s">
                                        <input type="text" id="rg_addr" placeholder="도로명 또는 지번 주소를 입력해보세요">
                                    </div>
                                    <button class="form-item btn bx-round_s bg_v" onclick="rg_search()">열람</button>
                                </fieldset>
                            </form>
                        </div>
                        <div class="inform-box bx-round_l">
                            <div class="wrap">
                                <i class="icon_smile"></i>
                                <p>주소지를 입력하고 <span class="btn l-inlinebox bg_v bx-round_xs">입력</span> 을 눌러주세요.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer id="footer"></footer>
    </div>
    <!-- script -->
    <script src="/js/main.js"></script>
    <!-- 팝업,헤더,푸터 삽입 스크립트 -->
    <script>
        $("#header").load("/html/_header.php");
        $("#footer").load("/html/_footer.php");
        $("#popup").load("/html/_popup.php");
    </script>
    <!-- 토지 등록 시 작동하는 네이버 지도 API 스크립트 -->
    <script>

        function rg_search() {
            var rg_addr = $("#rg_addr").val();
            if (rg_addr == '') {
                alert('도로명 또는 지번 주소를 입력해보세요');
            } else {
                searchAddressToCoordinate(rg_addr);
            }
        }

        //해당 지번 주소 검증 스크립트
        function searchAddressToCoordinate(address) {
            //랜드마킹 주소
            var land_url = '<?php echo $land_url;?>';
            naver.maps.Service.geocode({
                query: address
            }, function (status, response) {
                if (status === naver.maps.Service.Status.ERROR) {
                    if (!address) {
                        return alert('Geocode Error, Please check address');
                    }
                    return alert('Geocode Error, address:' + address);
                }
                var htmlAddresses = [],
                    item = response.v2.addresses[0];
                if (item) {
                    point = new naver.maps.Point(item.x, item.y);
                }

                if (response.v2.meta.totalCount === 0) {
                    return alert('도로명이나 지번주소를 정확히 입력해주세요');
                } else {
                    //return alert(item.x+'/'+item.y);
                    //지번주소로 get 전송

                    if (item.jibunAddress) {
                        location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.jibunAddress + '&x=' + item.x + '&y=' + item.y;
                    } else if (item.roadAddress) {
                        location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.roadAddress + '&x=' + item.x + '&y=' + item.y;
                    } else {
                        alert('도로명이나 지번주소를 정확히 입력해주세요');
                    }
                    // if (item.englishAddress) {
                    //     alert('도로명이나 지번주소를 정확히 입력해주세요');
                    //     //htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
                    // }
                }
            });
        }
    </script>

    </body>
    </html>
<?php } ?>