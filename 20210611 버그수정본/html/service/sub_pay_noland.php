<?php
//분석 서비스 구매 시 -> 토지 없을 때
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";

//사용자 정보
$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    <link rel="stylesheet" href="../../css/main.css" >

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
</head>
<body>
<div id="popup"></div>
<div id="wrap" class="sub sub_pay">
    <header id="header"></header>
    <main id="main">
        <div class="main-title">
            <div class="container">
                <div class="inner">
                    <div class="tit">
                        <i class="tit-icon icon_pencil bx-round_l"></i>
                        <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b">전문분석</span></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container service-box">
                <div class="inner">
                    <div class="title-wrap">
                        <h2 class="title">전문 분석</h2>
                        <p class="desc">
                            <span>토지를 등록했다면 꼭 필요한 심층분석! 랜드마킹이 도와드립니다.</span>
                            <br>
                            <span>전화를 통해 간편하지만 심층적인 상담을, 방문을 통해 가장 심층적인 상담을 받을 수 있습니다.</span>
                        </p>
                        <div class="img_area">
                            <img src="../../images/sub/img_service04.png" alt="전문분석대행">
                        </div>
                    </div>
                    <div class="inform-box bx-round_l">
                        <div class="wrap">
                            <i class="icon_smile"></i>
                            <p class="txt">
                                등록된 토지가 있어야 이용 가능합니다. <a href="#none">토지등록</a>또는 <a href="#none">상품 목록으로 돌아가기</a>를 해 주세요.
                            </p>
                        </div>
                    </div>
                    <p class="warn">
                        <i class="icon"> </i>
                        등록 또는 분석이 불가능하다고 판단되는 경우, 개별 안내 후 환불 처리 됩니다.
                    </p>
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

</html>
<?php } ?>