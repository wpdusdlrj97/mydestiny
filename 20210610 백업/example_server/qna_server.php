<?php
error_reporting(0);
session_start();

$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}

//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

$type = $_POST['type'];
$reply = $_POST['reply'];
$number = $_POST['number'];
$date = date( 'YmdHis', time());


$reply = addslashes($reply);


if($type=='answer'){

    $qry_string = "UPDATE qna set qna_reply_status='1', qna_reply_content='$reply', qna_reply_date='$date' where qna_number='$number'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

} else if($type=='modify'){
    $qry_string = "UPDATE qna set qna_reply_status='1', qna_reply_content='$reply', qna_reply_date='$date' where qna_number='$number'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }
}else{
    echo 'fail';
}


mysqli_close($connect)

?>