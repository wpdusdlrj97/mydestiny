<?php
//탈퇴 페이지
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
                            <i class="tit-icon icon_shieldSlash bx-round_l"> </i>
                            <h2 class="tit-wrap l-inline ft_b"><span class="tit">탈퇴하기</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="signup">
                            <form onsubmit="return false;" class="unsub completed">
                                <div class="row row_tit clear">
                                    <span class="join_tit">
                                        <i class="join_icon">
                                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.8179 16.4982H14.1859L14.6539 6.07617H12.3679L12.8179 16.4982ZM13.5019 20.7822C14.2579 20.7822 14.8339 20.2062 14.8339 19.4502C14.8339 18.7122 14.2579 18.1362 13.5019 18.1362C12.7459 18.1362 12.1699 18.7122 12.1699 19.4502C12.1699 20.2062 12.7459 20.7822 13.5019 20.7822Z" fill="black"/>
                                                <path d="M13.5 26C20.4036 26 26 20.4036 26 13.5C26 6.59644 20.4036 1 13.5 1C6.59644 1 1 6.59644 1 13.5C1 20.4036 6.59644 26 13.5 26Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>                                                    
                                        </i>                                         
                                        아래 정보가 삭제됩니다.
                                    </span>
                                    <span class="join_info">탈퇴는 취소할 수 없습니다.</span>
                                </div>
                                <div class="row clear">
                                    <label for="joinName">성명<span class="details">실명가입</span></label>
                                    <div class="bx-input"><input type="text" id="joinName" value="<?php echo $row_user['user_name']?>" readonly></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinNick">닉네임</label>
                                    <div class="bx-input"><input type="text" id="joinNick" value="<?php echo $row_user['user_nickname']?>" readonly></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinId">ID<span class="details">이메일주소</span></label>
                                    <div class="bx-input"><input type="email" id="joinId" value="<?php echo $row_user['user_email']?>" readonly></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinTel">휴대전화 번호</label>
                                    <div class="bx-input"><input type="tel" id="joinTel" value="<?php echo $row_user['user_phone']?>" readonly></div>
                                </div>
                                <button class="row btn bg_v bx-round_l" onclick="unsub()">탈퇴 하기</button>
                                <a href="/html/index.php" class="row btn bg_v bx-round_l">랜드마킹 홈으로 가기</a>
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

    <script>
        //탈퇴 버튼 클릭 시 작동 스크립트
        function unsub(){
            location.href='<?php echo $land_url."/server/unsub_server.php";?>';
        }
    </script>
</body>
</html>
<?php }?>