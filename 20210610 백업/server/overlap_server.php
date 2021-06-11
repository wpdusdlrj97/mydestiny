<?php
error_reporting(0);
session_start();

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");


$user_email = $_POST['email'];



$query = "SELECT * FROM user_information where user_email='$user_email'";
$result = mysqli_query($connect, $query);
$total_rows = mysqli_num_rows($result);

if($total_rows==0){
    echo 'success';
}else{
    echo 'fail';
}


mysqli_close($connect)

?>