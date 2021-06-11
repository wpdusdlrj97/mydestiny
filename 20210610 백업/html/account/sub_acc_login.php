<?php
//로그인 페이지
session_start();
$user_session = $_SESSION['user_session'];

//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url= $land_url."/html/index.php";

//세션이 있을 경우 메인 페이지 로드
if($user_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}
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
                            <h2 class="tit-wrap l-inline ft_b"><span class="tit on">로그인</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="signup">
                            <form class="login-wrap" onsubmit="return false;">
                                <div class="row row_tit clear">
                                    <span class="join_tit">로그인을 해 주세요.</span>
                                    <span class="join_info"><a href="/html/account/sub_acc_join.php">회원가입</a></span>
                                </div>
                                <div class="row clear">
                                    <label for="userid">ID<span class="details">이메일 주소</span></label>
                                    <div class="bx-input"><input type="text" maxlength="50" id="user_id"></div>
                                </div>



                                <div class="row row_pwd row_hr clear">
                                    <label for="userpwd">비밀번호</label>
                                    <div class="bx-input">
                                        <input type="password" id="user_password" maxlength="16" placeholder="비밀번호를 입력해주세요">
                                        <span class="pwdBtns">
                                            <i class="btn_closed"></i>
                                            <i class="btn_open"></i>
                                        </span>
                                    </div>
                                </div>


                                <button class="row btn bg_v bx-round_l" onclick="login()">로그인</button>
                                <div class="row loginfo clear">
                                    <span class="wrap">
                                        <a href="/html/account/sub_acc_id.php">아이디 찾기</a>
                                        <a href="/html/account/sub_acc_pwd.php">비밀번호 찾기</a>
                                    </span>
                                </div>
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

        //로그인 버튼 클릭 시 작동 스크립트
        function login(){

            var user_id= $("#user_id").val();
            var user_password = $("#user_password").val();

            if(user_id==''){
                alert('아이디를 입력해주세요');
            }else if(user_password==''){
                alert('비밀번호를 입력해주세요');
            }else{
                $.ajax({
                    type: "POST"
                    ,url: "/server/login_server.php"
                    ,data: {id:user_id,password:user_password}
                    ,success:function(result){
                        if(result=='success'){
                            location.href='<?php echo $land_url."/html/index.php";?>';
                            //alert("로그인이 완료되었습니다");
                        }else{
                            alert("올바르지 않은 아이디 혹은 비밀번호입니다");
                        }
                    }
                    ,error:function(){
                       
                    }
                });
            }
        }
    </script>
</body>
</html>