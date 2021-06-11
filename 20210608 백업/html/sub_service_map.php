<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="토지 중개 플랫폼 랜드마킹입니다.">
    <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
    <meta name="author" content="랜드마킹">
    <meta property="og:type" content="website">
    <meta property="og:url" content="url">
    <meta property="og:image" content="../images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹">
    <meta property="og:site_name" content="랜드마킹">
    <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
    <meta property="og:locale" content="ko_KR">
    <title>랜드마킹</title>
    <!-- FAVICON-->

    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/main.css" >

    <!-- SCRIPT -->
    <script src="../js/lib/jquery-3.6.0.min.js"></script>
    <!--[if lte IE 9]>
    <script src="../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../js/lib/html5shiv.min.js"></script>
    <script src="../js/lib/jqPIE.js"></script>
    <script src="../js/lib/PIE.js"></script>
    <![endif]-->
</head>
<body>
<div id="popup"></div>
<div id="wrap" class="sub sub_map">
    <header id="header"></header>
    <main id="main">
        <div class="main-title">
            <div class="container">
                <div class="inner">
                    <div class="tit">
                        <i class="tit-icon icon_pin bx-round_l"></i>
                        <h2 class="tit-wrap l-inline ft_b">
                            <span class="tit">오시는 길</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="inner">
                    <ul class="cont-wrap">
                        <li class="row"><span class="tit">랜드마킹</span><em class="cont">대구광역시 중구 달구벌대로 2204 2층 (대봉동)</em></li>
                        <li class="row"><span class="tit">전화</span><em class="cont">053 - 716 - 2742 (문의 : 평일 09:00 ~ 18:00 / 토,일 휴무)</em></li>
                        <li class="row"><span class="tit">팩스</span><em class="cont">053 - 716 - 2741</em></li>
                        <li class="row"><span class="tit">이메일</span><em class="cont">contact@landmaster.com</em></li>
                    </ul>
                    <div class="map">
                        <div id="daumRoughmapContainer1622087684716" class="root_daum_roughmap root_daum_roughmap_landing"></div>
                        <script charset="UTF-8" class="daum_roughmap_loader_script" src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>
                        <script charset="UTF-8">
                            new daum.roughmap.Lander({
                                "timestamp" : "1622087684716",
                                "key" : "25xv4",
                                "mapHeight" : "500"
                            }).render();
                        </script>
                    </div>
                    <div class="inform">
                        <p>대한민국 전문 컨설턴트들이 직접 검증하는 토지분석 솔루션!</p>
                        <p>토지분석의 혁명을 예고한 랜드마킹이 여러분의 토지증식에 평생 동반자가 되어 드리겠습니다.</p>
                    </div>
                </div>
            </div>
        </div>
</main>
    <footer id="footer"></footer>
</div>
<!-- script -->
<script src=/js/main.js"></script>
<!-- 팝업,헤더,푸터 삽입 스크립트 -->
<script>
    $("#header").load("/html/_header.php");
    $("#footer").load("/html/_footer.php");
    $("#popup").load("/html/_popup.php");
</script>
</body>
</html>