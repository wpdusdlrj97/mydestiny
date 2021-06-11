<?php
error_reporting(0);

session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//POST 값 전달 받기 (결제상품 ID, 결제상품 종류, 결제종류, 결제가격, 아이디, 이름, 전화번호, 토지아이디, 토지 주소)
$pg_pay_id = $_POST['pg_pay_id'];
$pg_service_type = $_POST['pg_service_type'];
$pg_pay_type = $_POST['pg_pay_type'];
$pg_service_price = $_POST['pg_service_price'];
$pg_user_email = $_POST['pg_user_email'];
$pg_user_name = $_POST['pg_user_name'];
$pg_user_phone = $_POST['pg_user_phone'];
$pg_land_id = $_POST['pg_land_id'];
$pg_land_address = $_POST['pg_land_address'];
$pg_land_x = $_POST['pg_land_x'];
$pg_land_y = $_POST['pg_land_y'];
$pg_pay_date = date( 'YmdHis', time());

//테이블 값 삽입 시 예외처리 (, ; ' ")
$pg_pay_id =addslashes($pg_pay_id);
$pg_service_type =addslashes($pg_service_type);
$pg_pay_type  =addslashes($pg_pay_type);
$pg_service_price =addslashes($pg_service_price);
$pg_user_email =addslashes($pg_user_email);
$pg_user_name =addslashes($pg_user_name);
$pg_user_phone =addslashes($pg_user_phone);
$pg_land_id =addslashes($pg_land_id);
$pg_land_address =addslashes($pg_land_address);
$pg_land_x = addslashes($pg_land_x);
$pg_land_y = addslashes($pg_land_y);



if($pg_service_type=='0'){ // 단순 등록대행

    //토지 등록 대행이므로 토지 아이디 생성 필요
    //토지 아이디 생성 (임의의 알파벳 8자리)
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    $pg_land_id =implode($pass);

    //결제 정보 테이블에 값 삽입
    $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date) 
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){

        //등록 대행 시 -> 토지 정보 테이블에도 토지 등록
        //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
        $qry_string_land = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date,land_agent_status)
                 VALUES ('$pg_land_id','$pg_land_address','$pg_land_x','$pg_land_y','$pg_user_email','$pg_user_name','$pg_user_phone'
                 ,'등록 대행','0','0','등록 대행','https://landmarking.co.kr/land_image/land_default.png','$pg_pay_date','1')";
        $qry_land = mysqli_query($connect, $qry_string_land);

        if($qry_land){


            $qry_string_chart="INSERT INTO chart_information (land_id, value_1,value_2,value_3,value_4,value_5,dev_1,dev_2,sub_1,sub_2,pre_1,pre_2)
                                VALUES ('$pg_land_id','5','5','5','5','5','5','5','5','5','5','5')";
            $qry_chart = mysqli_query($connect, $qry_string_chart);


            if($qry_chart){
                echo 'success';
            }else{
                echo 'fail';
            }



        }else{
            echo 'fail';
        }


    }else{
        echo 'fail';
    }

}else if($pg_service_type=='1' || $pg_service_type=='2'){ // 전화 분석 or 방문 분석 일 경우

    //결제 정보 테이블에 값 삽입
    $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date) 
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        //전화 분석 or 방문 분석일 경우 토지의 상태값도 변경 필요
        //해당 토지 아이디의 유료분석 상태값 변경
        $qry_string_land = "update land_information set land_cost_analysis_status='1' where land_id='$pg_land_id'";
        $qry_land = mysqli_query($connect, $qry_string_land);

        if($qry_land){
            echo 'success';
        }else{
            echo 'fail';

        }
    }else{
        echo 'fail';
    }

}else if($pg_service_type=='3' || $pg_service_type=='4'){ // 등록 + 전화 or 등록 + 방문  일경우

    //토지 등록 대행이므로 토지 아이디 생성 필요
    //토지 아이디 생성 (임의의 알파벳 8자리)
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    $pg_land_id =implode($pass);

    //결제 정보 테이블에 값 삽입
    $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date) 
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){

        //등록 대행 시 -> 토지 정보 테이블에도 토지 등록
        //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
        $qry_string_land = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date,land_agent_status)
                 VALUES ('$pg_land_id','$pg_land_address','$pg_land_x','$pg_land_y','$pg_user_email','$pg_user_name','$pg_user_phone'
                 ,'등록 대행','0','0','등록 대행','https://landmarking.co.kr/land_image/land_default.png','$pg_pay_date','1')";
        $qry_land = mysqli_query($connect, $qry_string_land);

        if($qry_land){

            //전화 분석 or 방문 분석일 경우 토지의 상태값도 변경 필요
            //해당 토지 아이디의 유료분석 상태값 변경
            $qry_string_land_update = "update land_information set land_cost_analysis_status='1' where land_id='$pg_land_id'";
            $qry_land_update = mysqli_query($connect, $qry_string_land_update);

            if($qry_land_update){

                $qry_string_chart="INSERT INTO chart_information (land_id, value_1,value_2,value_3,value_4,value_5,dev_1,dev_2,sub_1,sub_2,pre_1,pre_2)
                                VALUES ('$pg_land_id','5','5','5','5','5','5','5','5','5','5','5')";
                $qry_chart = mysqli_query($connect, $qry_string_chart);


                if($qry_chart){
                    echo 'success';
                }else{
                    echo 'fail';
                }

            }else{
                echo 'fail';

            }

        }else{
            echo 'fail';
        }


    }else{
        echo 'fail';
    }

}else{
    echo 'fail';
}










mysqli_close($connect)

?>