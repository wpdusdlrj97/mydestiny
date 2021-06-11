<?php
error_reporting(0);
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (이름, 닉네임, 아이디, 번호, 비밀번호)
$update_type = $_POST['type'];
$update_email = $_POST['email'];
$update_name = $_POST['name'];
$update_nickname = $_POST['nickname'];
$update_phone = $_POST['phone'];


//테이블 값 삽입 시 예외처리 (, ; ' ")
$update_name = addslashes($update_name);
$update_nickname = addslashes($update_nickname);
$update_phone = addslashes($update_phone);



if($update_type=='user'){

    $qry_string = "UPDATE user_information SET user_name ='$update_name',user_nickname ='$update_nickname' ,user_phone ='$update_phone' WHERE user_email = '$update_email';";
    $qry = mysqli_query($connect, $qry_string);

    if ($qry) {
        echo 'success';
    } else {
        echo 'fail';
    }

}else{

    $qry_string = "UPDATE admin_information SET admin_name ='$update_name',admin_nickname ='$update_nickname' ,admin_phone ='$update_phone' WHERE admin_email = '$update_email';";
    $qry = mysqli_query($connect, $qry_string);

    if ($qry) {
        echo 'success';
    } else {
        echo 'fail';
    }
}





mysqli_close($connect)

?>