<?php
//로그인 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

$session_url= "https://landmarking.co.kr/admin/html/member/user_common.php";

//세션이 있을 경우 메인 페이지 로드
if($admin_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="description" content="랜드마킹 관리자 페이지입니다.">
    <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
    <meta name="author" content="랜드마킹">
    <meta property="og:type" content="website">
    <meta property="og:url" content="url">
    <meta property="og:image" content="/images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹 ADMIN">   
    <meta property="og:site_name" content="랜드마킹 ADMIN">   
    <meta property="og:description" content="랜드마킹 관리자 페이지"> 
    <meta property="og:locale" content="ko_KR"> 
    <title>관리자페이지</title>
    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/style.css" >

    <!-- SCRIPT -->
    <!--[if lte IE 9]>
    <script src="../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../js/lib/html5shiv.min.js"></script>    
    <script src="../js/lib/jqPIE.js"></script>    
    <script src="../js/lib/PIE.js"></script> 
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <div class="contents signin">
                        <div class="form-wrap" onsubmit="return false;">
                            <h1 class="tit">랜드마킹 관리자 로그인</h1>
                            <form>
                                <div class="wrap clear">
                                    <label for="userId" class="l-fleft">아이디</label>
                                    <input type="text" maxlength="50" id="admin_id" class="l-fright" placeholder="아이디를 입력해주세요">
                                </div>
                                <div class="wrap clear">
                                    <label for="userPwd"  class="l-fleft">비밀번호</label>
                                    <input type="password" id="admin_password" class="l-fright" maxlength="16" placeholder="비밀번호를 입력해주세요">
                                </div>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_sm" onclick="login()">로그인</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/script.js"></script>
    <script>
        $("#header").load("/admin/html/_header.php");
    </script>
    <script>

        //로그인 버튼 클릭 시 작동 스크립트
        function login(){

            var admin_id= $("#admin_id").val();
            var admin_password = $("#admin_password").val();

            if(admin_id==''){
                alert('아이디를 입력해주세요');
            }else if(admin_password==''){
                alert('비밀번호를 입력해주세요');
            }else{
                $.ajax({
                    type: "POST"
                    ,url: "/admin_server/login_server.php"
                    ,data: {id:admin_id,password:admin_password}
                    ,success:function(result){
                        if(result=='success'){
                            alert("로그인이 완료되었습니다");
                            location.href='<?php echo "https://landmarking.co.kr/admin/html/member/user_common.php";?>';
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
