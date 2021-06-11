<?php
session_start();
$user_session = $_SESSION['user_session'];
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");

$qna_id = $_POST['id'];


$qry_string = "delete from qna_information where qna_id ='$qna_id';";
$qry = mysqli_query($connect, $qry_string);

if($qry){
    echo 'success';
}else{
    echo 'fail';
}



mysqli_close($connect)

?>