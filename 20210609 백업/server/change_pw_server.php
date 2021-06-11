<?php
error_reporting(0);
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (변경할 비밀번호)
$change_password = $_POST['change_password'];


//테이블 값 삽입 시 예외처리 (, ; ' ")
$change_password = addslashes($change_password);
//비밀번호 sha 256 암호화
$change_password_hash = hash("sha256", $change_password);


$qry_string = "UPDATE user_information SET user_password='$change_password_hash' WHERE user_email = '$user_session';";
$qry = mysqli_query($connect, $qry_string);

if ($qry) {
    echo 'success';
} else {
    echo 'fail';
}


mysqli_close($connect)

?>