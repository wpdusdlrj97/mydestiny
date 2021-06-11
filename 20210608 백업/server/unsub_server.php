<?php
session_start();
$user_session = $_SESSION['user_session'];
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");

$user_withdraw_date = date( 'YmdHis', time());

$qry_string = "update user_information set user_status='1',user_withdraw_date='$user_withdraw_date' WHERE user_email='$user_session';";
$qry = mysqli_query($connect, $qry_string);


if($qry){
    //세션 삭제
    session_destroy();
    $logout_url= $land_url."/html/mypage/sub_acc_unsub_c.php";
    echo "<meta http-equiv='refresh' content='0; url=$logout_url'>";
}else{
    echo '<script>alert("탈퇴에 실패하였습니다. 잠시 후에 다시 시도해주세요")</script>';
    echo '<script>history.back();</script>';
}


mysqli_close($connect)

?>