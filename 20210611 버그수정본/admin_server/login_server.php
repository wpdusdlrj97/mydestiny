<?php
//로그인 백엔드
session_start();
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$admin_id = $_POST['id'];
$admin_password = $_POST['password'];
$admin_password_hash = hash("sha256", $admin_password);
$admin_latest_date = date( 'YmdHis', time());

$qry_string = "select * from admin_information where admin_email='$admin_id' and admin_password='$admin_password_hash'";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);

if($total_row>0){

    $qry_update = "update admin_information set admin_latest_date='$admin_latest_date' where admin_email='$admin_id'";
    $qry_update = mysqli_query($connect, $qry_update);

    if($qry_update){
        echo 'success';
        $_SESSION['admin_session'] = $admin_id;
    }else{
        echo 'fail';
    }

}else{
    echo 'fail';
}


mysqli_close($connect)

?>