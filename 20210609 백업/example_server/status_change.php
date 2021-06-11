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
$status = $_POST['status'];
$email = $_POST['email'];
$settlement_no = $_POST['settlement_no'];
$password='password1234';
$password_hash=hash("sha256", $password);
$date = date( 'YmdHis', time());


if($type=='user_status'){

    $qry_string = "UPDATE user_information set user_status='$status' where user_email='$email'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

}else if($type=='dosa_status'){

    $qry_string = "UPDATE dosa_information set dosa_status='$status' where dosa_email='$email'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

} else if($type=='dosa_penalty_status'){

    $qry_string = "UPDATE dosa_information set dosa_penalty='$status' where dosa_email='$email'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

} else if($type=='password_reset'){

    $qry_string = "UPDATE dosa_information set dosa_password='$password_hash' where dosa_email='$email'";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

} else if($type=='deposit_status'){

    if($status=='0'){ // 정산 완료 취소

        $qry_string = "UPDATE settlement_request set deposit_status='$status',deposit_date=null where no='$settlement_no'";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){

            $qry_string_counsel = "select dosa_email,counsel_code_list,commission_price_after from settlement_request where no='$settlement_no'";
            $qry_counsel = mysqli_query($connect, $qry_string_counsel);
            $row_counsel = mysqli_fetch_array($qry_counsel);


            //정산신청한 상담 리스트
            $counsel_code_list = $row_counsel['counsel_code_list'];
            $counsel_code_list= str_replace ("[", "", $counsel_code_list);
            $counsel_code_list= str_replace ("]", "", $counsel_code_list);

            $qry_string_settlement = "update counsel_code SET settlement_complete_status='0' where counsel_code IN ($counsel_code_list)";
            $qry_settlement = mysqli_query($connect, $qry_string_settlement);


            $dosa_email= $row_counsel['dosa_email'];
            $commission_price_after= $row_counsel['commission_price_after'];

            $qry_string_dosa = "update dosa_information SET dosa_settlement_price=dosa_settlement_price-$commission_price_after where dosa_email='$dosa_email'";
            $qry_dosa = mysqli_query($connect, $qry_string_dosa);

            if($qry_settlement){
                echo 'success';
            }else{
                echo 'fail';
            }

        }else{
            echo 'fail';
        }

    }else{ // 정산 완료


        $qry_string = "UPDATE settlement_request set deposit_status='$status',deposit_date='$date' where no='$settlement_no'";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){

            $qry_string_counsel = "select dosa_email,counsel_code_list,commission_price_after from settlement_request where no='$settlement_no'";
            $qry_counsel = mysqli_query($connect, $qry_string_counsel);
            $row_counsel = mysqli_fetch_array($qry_counsel);

            //정산신청한 상담 리스트
            $counsel_code_list = $row_counsel['counsel_code_list'];
            $counsel_code_list= str_replace ("[", "", $counsel_code_list);
            $counsel_code_list= str_replace ("]", "", $counsel_code_list);

            $qry_string_settlement = "update counsel_code SET settlement_complete_status='1' where counsel_code IN ($counsel_code_list)";
            $qry_settlement = mysqli_query($connect, $qry_string_settlement);


            $dosa_email= $row_counsel['dosa_email'];
            $commission_price_after= $row_counsel['commission_price_after'];

            $qry_string_dosa = "update dosa_information SET dosa_settlement_price=dosa_settlement_price+$commission_price_after where dosa_email='$dosa_email'";
            $qry_dosa = mysqli_query($connect, $qry_string_dosa);


            if($qry_settlement){
                echo 'success';
            }else{
                echo 'fail';
            }

        }else{




            echo 'fail';
        }

    }



}

else{
    echo 'fail';
}


mysqli_close($connect)

?>