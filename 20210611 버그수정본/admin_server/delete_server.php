<?php
//삭제 백엔드
session_start();
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//삭제 타입, 삭제할 리스트
$delete_type = $_POST['delete_type'];
$delete_list = $_POST['delete_list'];


if($delete_type=='user'){

    $qry_string = "delete from user_information where user_email in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }


}else if($delete_type=='admin'){

    $qry_string = "delete from admin_information where admin_email in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else if($delete_type=='notice'){

    $qry_string = "delete from notice_information where notice_id in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else if($delete_type=='qna'){

    $qry_string = "delete from qna_information where qna_id in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else if($delete_type=='service'){

    $qry_string = "delete from service_information where service_id in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else if($delete_type=='pay'){

    $qry_string = "delete from pay_information where pay_id in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else if($delete_type=='land'){

    $qry_string = "delete from land_information where land_id in ($delete_list);";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}





mysqli_close($connect)

?>