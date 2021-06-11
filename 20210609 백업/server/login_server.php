<?php
session_start();
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$user_id = $_POST['id'];
$user_password = $_POST['password'];
$user_password_hash = hash("sha256", $user_password);
$user_latest_date = date( 'YmdHis', time());

$qry_string = "select * from user_information where user_email='$user_id' and user_password='$user_password_hash' and user_status='0'";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);

if($total_row>0){

    $qry_update = "update user_information set user_latest_date='$user_latest_date' where user_email='$user_id'";
    $qry_update = mysqli_query($connect, $qry_update);

    if($qry_update){
        echo 'success';
        $_SESSION['user_session'] = $user_id;
    }else{
        echo 'fail';
    }
    
}else{
    echo 'fail';
}


mysqli_close($connect)

?>