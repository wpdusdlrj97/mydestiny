<?php
//회원가입 완료 페이지
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
                            <h2 class="tit-wrap l-inline ft_b"><span class="tit on">회원가입</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="signup">
                            <form onsubmit="return false;" class="completed">
                                <div class="row row_tit clear">
                                    <span class="join_tit">
                                        <i class="join_icon">
                                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.5 26C20.4036 26 26 20.4036 26 13.5C26 6.59644 20.4036 1 13.5 1C6.59644 1 1 6.59644 1 13.5C1 20.4036 6.59644 26 13.5 26Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.9136 16.625C18.3645 17.5748 17.5752 18.3634 16.6249 18.9116C15.6746 19.4599 14.5969 19.7485 13.4998 19.7485C12.4027 19.7485 11.3249 19.4599 10.3747 18.9117C9.42439 18.3634 8.63507 17.5748 8.08594 16.6251" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.8125 12.459C9.67544 12.459 10.375 11.7594 10.375 10.8965C10.375 10.0335 9.67544 9.33398 8.8125 9.33398C7.94955 9.33398 7.25 10.0335 7.25 10.8965C7.25 11.7594 7.94955 12.459 8.8125 12.459Z" fill="black"/>
                                                <path d="M18.1875 12.459C19.0504 12.459 19.75 11.7594 19.75 10.8965C19.75 10.0335 19.0504 9.33398 18.1875 9.33398C17.3246 9.33398 16.625 10.0335 16.625 10.8965C16.625 11.7594 17.3246 12.459 18.1875 12.459Z" fill="black"/>
                                            </svg>     
                                        </i>    
                                        <span class="name"><?php echo $row_user['user_name']?>님,</span>
                                        <span class="txt">회원가입을 해 주셔서 감사합니다.</span>                                   
                                    </span>
                                </div>
                                <div class="row clear">
                                    <label for="joinName">성명<span class="details">실명가입</span></label>
                                    <div class="bx-input"><input type="text" value="<?php echo $row_user['user_name']?>" readonly></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinNick">닉네임</label>
                                    <div class="bx-input"><input type="text" value="<?php echo $row_user['user_nickname']?>" readonly></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinId">ID<span class="details">이메일주소</span></label>
                                    <div class="bx-input"><input type="email"  value="<?php echo $row_user['user_email']?>" readonly></div>
                                </div>
                                <div class="row row_pwd row_hr clear">
                                    <label for="joinTel">휴대전화 번호</label>
                                    <div class="bx-input"><input type="tel"  value="<?php echo $row_user['user_phone']?>" readonly></div>
                                </div>
                                <div class="row row_check clear">
                                    <span class="txt"><a href="/html/sub_term.php">이용약관</a>&#32;&#183;&#32;<a href="/html/sub_privacy.php">개인정보처리방침</a></span>
                                </div>
                                <a href="/html/index.php" class="row btn bg_v bx-round_l">랜드마킹 홈으로 가기</a>
                                <a href="/html/mypage/sub_mp_menu.php" class="row btn bg_v bx-round_l">마이 페이지로 가기</a>
                            </form>
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