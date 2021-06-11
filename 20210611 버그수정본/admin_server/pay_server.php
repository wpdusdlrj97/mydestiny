<?php
//결제 내역 백엔드
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");


//POST 값 전달 받기
$type = $_POST['type'];
$pay_id= $_POST['pay_id'];
$pay_status = $_POST['pay_status'];


$qry_string = "UPDATE pay_information SET pay_status ='$pay_status' WHERE pay_id = '$pay_id';";
$qry = mysqli_query($connect, $qry_string);

if ($qry) {
    echo 'success';
} else {
    echo 'fail';
}


mysqli_close($connect)

?>