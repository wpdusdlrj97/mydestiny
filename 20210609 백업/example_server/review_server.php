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
$counsel_code = $_POST['counsel_code'];



if($type=='delete'){

    $qry_string = "delete from review where counsel_code='$counsel_code'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

} else{
    echo 'fail';
}


mysqli_close($connect)

?>