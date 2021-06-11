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

$counsel_refund = $_POST['counsel_refund'];
$counsel_code = $_POST['counsel_code'];
$dosa_email = $_POST['dosa_email'];


//$qry_string = "UPDATE user_information set user_retention_point=user_retention_point+$refund where user_email='$user_email'";
$qry_string = "UPDATE counsel_code set refund_point=refund_point+$counsel_refund, final_point=final_point-$counsel_refund where counsel_code='$counsel_code'";
$qry = mysqli_query($connect, $qry_string);
if($qry){


    $qry_dosa_string = "UPDATE dosa_information set dosa_counsel_price=dosa_counsel_price-$counsel_refund where dosa_email='$dosa_email'";
    $qry_dosa = mysqli_query($connect, $qry_dosa_string);

    if($qry_dosa){

        echo 'success';

    }else{

        echo 'fail';
    }



}else{
    echo 'fail';
}



mysqli_close($connect)

?>