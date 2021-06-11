<?php
//이메일 중복검사 백엔드
error_reporting(0);
session_start();

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//타입, 이메일 
$type = $_POST['type'];
$email = $_POST['email'];



if($type=='user'){

    $query = "SELECT * FROM user_information where user_email='$email'";
    $result = mysqli_query($connect, $query);
    $total_rows = mysqli_num_rows($result);

    if($total_rows==0){
        echo 'success';
    }else{
        echo 'fail';
    }


}else{

    $query = "SELECT * FROM admin_information where admin_email='$email'";
    $result = mysqli_query($connect, $query);
    $total_rows = mysqli_num_rows($result);

    if($total_rows==0){
        echo 'success';
    }else{
        echo 'fail';
    }
}






mysqli_close($connect)

?>