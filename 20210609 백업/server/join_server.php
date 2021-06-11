<?php
error_reporting(0);

session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (이름, 닉네임, 아이디, 번호, 비밀번호)
$user_name = $_POST['name'];
$user_nickname = $_POST['nickname'];
$user_id = $_POST['id'];
$user_phone = $_POST['phone'];
$user_password = $_POST['password'];
$user_join_date = date( 'YmdHis', time());

//테이블 값 삽입 시 예외처리 (, ; ' ")
$user_name =addslashes($user_name);
$user_nickname =addslashes($user_nickname);
$user_id =addslashes($user_id);
$user_phone =addslashes($user_phone);
$user_password =addslashes($user_password);

//비밀번호 sha 256 암호화
$user_password_hash = hash("sha256", $user_password);


//해당 이메일이 존재하는지 중복확인 (서버 검토)
$query_email = "SELECT * FROM user_information where user_email='$user_id'";
$result_email = mysqli_query($connect, $query_email);
$total_rows_email = mysqli_num_rows($result_email);


if($total_rows_email>0){
    echo 'overlap';
}else{
    $qry_string = "INSERT INTO user_information (user_email, user_password, user_name, user_nickname, user_phone, user_join_date, user_latest_date) VALUES ('$user_id','$user_password_hash','$user_name','$user_nickname','$user_phone','$user_join_date','$user_join_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
        $_SESSION['user_session'] = $user_id;
    }else{
        echo 'fail';
    }

}




mysqli_close($connect)

?>