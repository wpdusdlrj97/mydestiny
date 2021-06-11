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
$content = $_POST['content'];


if($type=='nickname'){

    $query = "SELECT * FROM dosa_information where dosa_nickname='$content'";
    $result = mysqli_query($connect, $query);
    $total_rows = mysqli_num_rows($result);

    if($total_rows==0){
        echo 'success';
    }else{
        echo 'fail';
    }

}elseif($type=='email'){

    $query = "SELECT * FROM dosa_information where dosa_email='$content'";
    $result = mysqli_query($connect, $query);
    $total_rows = mysqli_num_rows($result);

    if($total_rows==0){
        echo 'success';
    }else{
        echo 'fail';
    }

}else{
    echo 'fail';
}




mysqli_close($connect)

?>