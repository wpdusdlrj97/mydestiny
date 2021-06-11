<?php
session_start();
error_reporting(0);

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//메일 전송 파일
include_once('./mailer.lib.php');

$user_id = $_POST['id'];
$user_name = $_POST['name'];
$user_phone = $_POST['phone'];

$qry_string = "select * from user_information where user_name='$user_name' and user_phone='$user_phone' and user_email='$user_id'";
$qry = mysqli_query($connect, $qry_string);
$row = mysqli_fetch_array($qry);
$total_row = mysqli_num_rows($qry);

if($total_row>0){

    //임시비밀번호 생성
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    //임시 비밀번호
    $temporary_pw =implode($pass);

    //DB의 유저 비밀번호 해당 임시비밀번호의 해시값으로 변경
    $temporary_pw_hash = hash("sha256", $temporary_pw);
    $qry_string = "UPDATE user_information SET user_password='$temporary_pw_hash' WHERE user_email='$user_id'";
    $qry = mysqli_query($connect, $qry_string);


    //그 후 메일로 임시비밀번호 발금하기
    mailer("랜드마킹", "dea04060@naver.com", $user_id, "[랜드마킹] 임시비밀번호 발급 안내", $user_name."님의 임시 비밀번호입니다. 로그인 후 비밀번호를 변경해주세요<br><br>임시 비밀번호 : ".$temporary_pw, 1);


}else{
    echo 'fail';
}


mysqli_close($connect)

?>