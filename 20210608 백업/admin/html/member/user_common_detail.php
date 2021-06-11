<?php
//개인정보 변경
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";

//유저 정보 조회
$user_id=$_GET['id'];

$qry_string_user = "SELECT * FROM user_information where user_email='$user_id'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}else if($total_row_user<1){
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

    <!-- SCRIPT -->
    <!--[if lte IE 9]>
    <script src="../../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../../js/lib/html5shiv.min.js"></script>    
    <script src="../../js/lib/jqPIE.js"></script>    
    <script src="../../js/lib/PIE.js"></script> 
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        /*input number 화살표 제거*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
</head>
<body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">일반회원 상세페이지</h2>
                    <div class="contents">
                        <div class="form-wrap">
                            <form onsubmit="return false;">
                                <div class="wrap">
                                    <label for="userId">아이디<em class="inform">이메일주소</em></label>
                                    <input type="email" id="update_id" value="<?php echo $row_user['user_email']?>" readonly>
                                </div>
                                <div class="wrap">
                                    <label for="userNick">닉네임</label>
                                    <input type="text"  id="update_nickname" minlength="2" maxlength="6" value="<?php echo $row_user['user_nickname']?>" placeholder="변경하실 닉네임을 입력해주세요 (2~6자리)">
                                </div>
                                <div class="wrap">
                                    <label for="userName">실명</label>
                                    <input type="text" id="update_name" minlength="2" maxlength="4" value="<?php echo $row_user['user_name']?>" placeholder="성명(실명)을 기입해주세요">
                                </div>
                                <div class="wrap">
                                    <label for="userTel">휴대전화</label>
                                    <input type="number" id="update_phone" minlength="11" maxlength="11" value="<?php echo $row_user['user_phone']?>" placeholder="변경할 휴대전화 번호 (-제외)를 입력해주세요. ">
                                </div>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_del btn_modal" onclick="delete_user();">회원 삭제</button>
                                    <button type="button" class="btn btn_cancel" onClick="window.open('/admin/html/member/user_change_pw.php?id=<?php echo $row_user['user_email']?>','pop','width=425, height=540, top=200, left=200');">비밀번호 변경</button>
                                    <button type="button" class="btn btn_sm" onclick="update_user();">확인</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../../js/script.js"></script>
    <script>
        $("#header").load("/admin/html/_header.php");
    </script>
    <script>

        var user_email='';
        var user_name= '';
        var user_nickname= '';
        var user_phone= '';

        function delete_user() {

            if (confirm("해당 유저를 삭제하시겠습니까?")) {

                user_email= "'" +"<?php echo $row_user['user_email']?>"+"'";

                $.ajax({
                    type: "POST"
                    , url: "/admin_server/user_delete_server.php"
                    , data: {delete_type: 'user', delete_list: user_email}
                    , success: function (result) {

                        if (result == 'success') {
                            alert("해당 유저를 삭제하였습니다");
                            location.href = "https://landmarking.co.kr/admin/html/member/user_common.php";
                        } else {
                            alert("해당 유저 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    }
                    , error: function () {
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });

            }else{

            }
        }

        function update_user() {

            user_email= '<?php echo $row_user['user_email']?>';
            user_name= $("#update_name").val();
            user_nickname= $("#update_nickname").val();
            user_phone= $("#update_phone").val();

            if (confirm("해당 유저의 정보를 수정하시겠습니까?")) {

                if(user_name==''){
                    alert('이름을 입력해주세요');
                }else if(user_nickname==''){
                    alert('닉네임을 입력해주세요');
                }else if(user_nickname.length<2 || user_nickname.length>6){
                    alert('닉네임을 4~6자리로 입력해주세요')
                }else if(user_phone==''){
                    alert('전화번호를 입력해주세요');
                }else if(user_phone.length!=11){
                    alert('휴대전화번호 11자리를 정확히 입력해주세요');
                }else{

                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/user_update_server.php"
                        , data: {type:'user',email:user_email,name:user_name,nickname:user_nickname,phone:user_phone}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("해당 유저 정보를 수정하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/member/user_common.php";
                            } else {
                                alert("해당 유저 정보 수정에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });
                }

            }else{

            }
        }
    </script>

</body>
</html>
<?php } ?>