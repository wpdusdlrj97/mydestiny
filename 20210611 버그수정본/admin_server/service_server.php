<?php
//결제 상품 관련 백엔드
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");



//POST 값 전달 받기 (변경할 이름, 값)
$type = $_POST['type'];
$service_name = $_POST['name'];
$service_price= $_POST['price'];
$service_id= $_POST['id'];


$qry_string = "UPDATE service_information SET service_name ='$service_name', service_price ='$service_price' WHERE service_id = '$service_id';";
$qry = mysqli_query($connect, $qry_string);

if ($qry) {
    echo 'success';
} else {
    echo 'fail';
}


mysqli_close($connect)

?>