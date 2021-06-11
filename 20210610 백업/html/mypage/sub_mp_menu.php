<?php
//마이 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
//세션이 없을 경우 로그인 페이지 로드
if(!$user_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}else{

$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

$qry_string_land = "SELECT * FROM land_information where land_register_id='$user_session'";
$qry_land = mysqli_query($connect, $qry_string_land);
$total_row_land = mysqli_num_rows($qry_land);

$qry_string_qna = "SELECT * FROM qna_information where qna_writer_email='$user_session'";
$qry_qna = mysqli_query($connect, $qry_string_qna);
$total_row_qna = mysqli_num_rows($qry_qna);

$qry_string_pay= "SELECT * FROM pay_information where buyer_id='$user_session'";
$qry_pay = mysqli_query($connect, $qry_string_pay);
$total_row_pay = mysqli_num_rows($qry_pay);

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
    <div id="wrap" class="sub">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b on">마이 페이지</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="user-wrap">
                            <span><em class="name"><?php echo $row_user['user_name']?></em><span class="name_desc"> 님 안녕하세요</span></span>
                        </div>
                        <div class="mymenu-wrap">
                            <ul class="clear">
                                <li class="menu bx-round_l bg_n">
                                    <span class="l-box wrap">
                                        <em class="menu-tit">개인정보</em>
                                    </span>
                                    <a href="/html/mypage/sub_acc_edit.php" class="btn bx-round_s bg_v on">확인 &middot; 수정</a>
                                </li>
                                <li class="menu bx-round_l bg_n">
                                    <div class="wrap">
                                        <div class="inner">
                                            <em class="menu-tit">내 토지</em>
                                            <span class="cnt"><span class="value"><?php echo $total_row_land?></span> 개</span>
                                        </div>
                                    </div>
                                    <a href="/html/land/sub_mp_list_all.php" class="btn bx-round_s on">전체보기</a>
                                </li>
                                <li class="menu bx-round_l bg_n">
                                    <div class="wrap">
                                        <div class="inner">
                                            <em class="menu-tit">문의내역</em>
                                            <span class="cnt"><span class="value"><?php echo $total_row_qna?></span> 건</span>
                                        </div>
                                    </div>
                                    <a href="/html/mypage/sub_mp_faq_all.php" class="btn bx-round_s on">전체보기</a>
                                </li>
                                <li class="menu bx-round_l bg_n">
                                    <div class="wrap">
                                        <div class="inner">
                                            <em class="menu-tit">결제내역</em>
                                            <span class="cnt"><span class="value"><?php echo $total_row_pay?></span> 건</span>
                                        </div>
                                    </div>
                                    <a href="/html/mypage/sub_mp_paylist.php" class="btn bx-round_s">전체보기</a>
                                </li>
                            </ul>
                        </div>
                        <div class="useinfo-wrap">
                            <p>
                                <a href="/html/mypage/sub_notice.php">공지사항</a>
                            </p>
                            <p>
                                <a href="/html/sub_term.php">랜드마킹 이용약관</a>
                            </p>
                            <p class="clear">
                                <a href="/html/sub_privacy.php">랜드마킹 개인정보처리방침</a>
                                <a class="btn_unsub" href="/html/mypage/sub_acc_unsub.php">랜드마킹 탈퇴하기</a>
                            </p>
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
</body>
</html>
<?php }?>