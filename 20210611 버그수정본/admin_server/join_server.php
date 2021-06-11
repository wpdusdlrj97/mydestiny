<?php
//회원등록 백엔드
error_reporting(0);

session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (이름, 닉네임, 아이디, 번호, 비밀번호)

$join_type = $_POST['type'];
$join_name = $_POST['name'];
$join_nickname = $_POST['nickname'];
$join_id = $_POST['id'];
$join_phone = $_POST['phone'];
$join_password = $_POST['password'];
$join_join_date = date( 'YmdHis', time());

//테이블 값 삽입 시 예외처리 (, ; ' ")
$join_name =addslashes($join_name);
$join_nickname =addslashes($join_nickname);
$join_id =addslashes($join_id);
$join_phone =addslashes($join_phone);
$join_password =addslashes($join_password);

//비밀번호 sha 256 암호화
$join_password_hash = hash("sha256", $join_password);


if($join_type=='user'){ //일반 유저
    //해당 이메일이 존재하는지 중복확인 (서버 검토)
    $query_email = "SELECT * FROM user_information where user_email='$join_id'";
    $result_email = mysqli_query($connect, $query_email);
    $total_rows_email = mysqli_num_rows($result_email);


    if($total_rows_email>0){
        echo 'overlap';
    }else{
        $qry_string = "INSERT INTO user_information (user_email, user_password, user_name, user_nickname, user_phone, user_join_date) VALUES ('$join_id','$join_password_hash','$join_name','$join_nickname','$join_phone','$join_join_date')";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){
            echo 'success';

        }else{
            echo 'fail';
        }

    }

}else{ // 관리자
    //해당 이메일이 존재하는지 중복확인 (서버 검토)
    $query_email = "SELECT * FROM admin_information where admin_email='$join_id'";
    $result_email = mysqli_query($connect, $query_email);
    $total_rows_email = mysqli_num_rows($result_email);


    if($total_rows_email>0){
        echo 'overlap';
    }else{
        $qry_string = "INSERT INTO admin_information (admin_email, admin_password, admin_name, admin_nickname, admin_phone, admin_join_date) VALUES ('$join_id','$join_password_hash','$join_name','$join_nickname','$join_phone','$join_join_date')";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){
            echo 'success';

        }else{
            echo 'fail';
        }

    }

}






mysqli_close($connect)

?>