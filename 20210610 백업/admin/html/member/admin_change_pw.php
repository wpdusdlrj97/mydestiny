<?php
//개인정보 변경
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";

//유저 정보 조회
$admin_id = $_GET['id'];

$qry_string_admin = "SELECT * FROM admin_information where admin_email='$admin_id'";
$qry_admin = mysqli_query($connect, $qry_string_admin);
$row_admin = mysqli_fetch_array($qry_admin);
$total_row_admin = mysqli_num_rows($qry_admin);

//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else if ($total_row_admin < 1) {
    echo "<script>alert('잘못된 접근입니다');history.back();</script>";
} else {


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
    <link rel="stylesheet" href="../../css/default.css">
    <link rel="stylesheet" href="../../css/font.css">
    <link rel="stylesheet" href="../../css/style.css" >

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <div class="popup popup-mypage">
            <div class="container">
                <div class="inner">
                    <div class="title">관리자회원 비밀번호 수정</div>
                    <div class="form-wrap">
                        <form onsubmit="return false;">
                            <div class="wrap">
                                <input type="password" id="update_pw" minlength="4" maxlength="16"
                                       placeholder="새 비빌번호">
                                <label for="newPwd">문자와 숫자포함 4~16자 비밀번호를 입력해 주세요</label>
                            </div>
                            <div class="wrap">
                                <input type="password" id="update_pw_check"  minlength="4"
                                       maxlength="16" placeholder="새 비빌번호 확인">
                                <label for="pwdCheck">한 번 더 비밀번호를 입력해 주세요</label>
                            </div>
                            <div class="btn-wrap">
                                <button type="button" class="btn btn_cancel" onClick="javascript:window.close()">취소
                                </button>
                                <button type="button" class="btn btn_sm" onclick="change_pw()">수정완료</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function change_pw() {

            var update_email= '<?php echo $admin_id?>';
            var update_pw= $("#update_pw").val();
            var update_pw_check= $("#update_pw_check").val();


            if(update_pw==''){
                alert('변경할 비밀번호를 입력해주세요');
            }else if(update_pw_check==''){
                alert('변경할 비밀번호 확인을 입력해주세요');
            }else if(update_pw.length<4 || update_pw.length>16){
                alert('변경할 비밀번호를 영문,숫자 4~16자리로 입력해주세요')
            }else if(update_pw!=update_pw_check){
                alert('변경할 비밀번호가 일치하지 않습니다');
            }else{

                $.ajax({
                    type: "POST"
                    ,url: "/admin_server/pw_change_server.php"
                    ,data: {type:'admin',email:update_email,pw:update_pw}
                    ,success:function(result){
                        
                        if(result=='success'){
                            alert('비밀번호를 변경하였습니다');
                            window.close()
                        }else{
                            alert("비밀번호 변경에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            window.close()
                        }
                    }
                    ,error:function(){
                        alert("잠시 후에 다시 시도해주세요");
                        window.close()
                    }
                });

            }

        }

    </script>
</body>
</html>

<?php } ?>