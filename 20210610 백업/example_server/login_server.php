<?php
session_start();
error_reporting(0);


//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

$admin_id = $_POST['id'];
$admin_password = $_POST['password'];
$admin_password_hash = hash("sha256", $admin_password);


$qry_string = "select * from admin_information where admin_id='$admin_id' and admin_password='$admin_password_hash'";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);

if($total_row>0){
    echo 'success';
    $_SESSION['ADMIN'] = $admin_id;

}else{
    echo 'fail';
}


mysqli_close($connect)

?>