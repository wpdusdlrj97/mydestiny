<?php
error_reporting(0);

session_start();

$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}

//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

$refund = $_POST['refund'];
$user_email = $_POST['user_email'];

$qry_string = "UPDATE user_information set user_retention_point=user_retention_point+$refund where user_email='$user_email'";
$qry = mysqli_query($connect, $qry_string);
if($qry){
    echo 'success';
}else{
    echo 'fail';
}






mysqli_close($connect)

?>