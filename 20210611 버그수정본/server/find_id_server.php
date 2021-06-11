<?php
session_start();
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$user_name = $_POST['name'];
$user_phone = $_POST['phone'];



$qry_string = "select * from user_information where user_name='$user_name' and user_phone='$user_phone'";
$qry = mysqli_query($connect, $qry_string);
$row = mysqli_fetch_array($qry);
$total_row = mysqli_num_rows($qry);

if($total_row>0){
    echo $row['user_email'];

}else{
    echo 'fail';
}


mysqli_close($connect)

?>