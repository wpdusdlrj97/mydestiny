<?php
//결제 상품 팝업 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";

//서비스 정보 조회
$service_id = $_GET['id'];

$qry_string_service = "SELECT * FROM service_information where service_id='$service_id'";
$qry_service = mysqli_query($connect, $qry_string_service);
$row_service = mysqli_fetch_array($qry_service);
$total_row_service = mysqli_num_rows($qry_service);

//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else if ($total_row_service < 1) {
    echo "<script>alert('잘못된 접근입니다');history.back();</script>";
} else {


?>
<!DOCTYPE html>
<html lang="en">
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
        <div class="popup popup-pay pay-form">
            <div class="container">
                <div class="inner">
                    <div class="form-wrap">
                        <form onsubmit="return false;">
                            <fieldset>
                                <legend class="legend">상품 정보</legend>
                                <div class="wrap clear">
                                    <label for="pdName" class="l-fleft">상품명</label>
                                    <input type="text"  id="service_name" class="l-fright" required value="<?php echo $row_service['service_name']?>">
                                </div>
                                <div class="wrap">
                                    <label for="pdPrice" class="l-fleft">결제 금액</label>
                                    <input type="text"  id="service_price" class="l-fright" required value="<?php echo $row_service['service_price']?>">
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="legend">상품 내용</legend>
                                <textarea name="text" id="" cols="30" rows="10" required>상품내용</textarea>
                            </fieldset>
                            <div class="btn-wrap">
                                <button type="button" class="btn btn_cancel" onClick="javascript:window.close()">취소</button>
                                <button type="button" class="btn btn_sm" onclick="service_update()">수정</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


<script>
    function service_update() {

        var service_id = '<?php echo $service_id;?>';
        var service_name = $("#service_name").val();
        var service_price = $("#service_price").val();


        $.ajax({
            type: "POST"
            , url: "/admin_server/service_server.php"
            , data: {type:'update', name: service_name, price:service_price, id:service_id}
            , success: function (result) {

                if (result == 'success') {
                    alert("해당 서비스의 정보를 수정하였습니다");
                    opener.parent.location.reload();
                    window.close();
                } else {
                    alert("해당 서비스 정보수정에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                }
            }
            , error: function () {
                alert("잠시 후에 다시 시도해주세요");
            }
        });

    }
</script>

</body>

</html>

<?php } ?>