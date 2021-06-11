<?php
//비밀번호 변경 백엔드
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");



//POST 값 전달 받기 (변경할 비밀번호)
$type = $_POST['type'];
$email = $_POST['email'];
$change_password= $_POST['pw'];

//테이블 값 삽입 시 예외처리 (, ; ' ")
$change_password = addslashes($change_password);
//비밀번호 sha 256 암호화
$change_password_hash = hash("sha256", $change_password);

if($type=='user'){

    $qry_string = "UPDATE user_information SET user_password='$change_password_hash' WHERE user_email = '$email';";
    $qry = mysqli_query($connect, $qry_string);

    if ($qry) {
        echo 'success';
    } else {
        echo 'fail';
    }
    
}else{

    $qry_string = "UPDATE admin_information SET admin_password='$change_password_hash' WHERE admin_email = '$email';";
    $qry = mysqli_query($connect, $qry_string);

    if ($qry) {
        echo 'success';
    } else {
        echo 'fail';
    }
}


mysqli_close($connect)

?>