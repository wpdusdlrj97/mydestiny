<?php
error_reporting(0);
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (이름, 닉네임, 아이디, 번호, 비밀번호)
$user_name = $_POST['name'];
$user_nickname = $_POST['nickname'];
$user_phone = $_POST['phone'];


//테이블 값 삽입 시 예외처리 (, ; ' ")
$user_name = addslashes($user_name);
$user_nickname = addslashes($user_nickname);
$user_phone = addslashes($user_phone);


//해당 이메일이 존재하는지 중복확인 (서버 검토)
$query_email = "SELECT * FROM user_information where user_email='$user_id'";
$result_email = mysqli_query($connect, $query_email);
$total_rows_email = mysqli_num_rows($result_email);


$qry_string = "UPDATE user_information SET user_name ='$user_name',user_nickname ='$user_nickname' ,user_phone ='$user_phone' WHERE user_email = '$user_session';";
$qry = mysqli_query($connect, $qry_string);

if ($qry) {
    echo 'success';
} else {
    echo 'fail';
}


mysqli_close($connect)

?>