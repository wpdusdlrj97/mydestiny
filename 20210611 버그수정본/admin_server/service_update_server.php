<?php
//결제 상품 업데이트 백엔드
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");


//POST 값 전달 받기
$type = $_POST['type'];
$pay_id= $_POST['pay_id'];
$land_id= $_POST['land_id'];
$service_type = $_POST['service_type'];
$service_status = $_POST['service_status'];


//pay information 수정
$qry_string = "UPDATE pay_information SET service_status ='$service_status' WHERE pay_id = '$pay_id';";
$qry = mysqli_query($connect, $qry_string);

if ($qry) {


    if($service_type=='0'){ // 등록대행일 경우 -> cost_analysis 상태값 변경할 필요 x

        if($service_status=='1'){ // 대기중

            $qry_string_land = "UPDATE land_information SET land_agent_status ='0' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='2'){ // 진행중

            $qry_string_land = "UPDATE land_information SET land_agent_status ='1' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='3'){ // 완료

            $qry_string_land = "UPDATE land_information SET land_agent_status ='2' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }

    }else if($service_type=='1' || $service_type=='2'){ //전화 , 방문분석의 경우

        if($service_status=='1'){ // 전문분석 대기중

            $qry_string_land = "UPDATE land_information SET land_cost_analysis_status ='0' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='2'){ // 전문분석 진행중

            $qry_string_land = "UPDATE land_information SET land_cost_analysis_status ='1' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='3'){ // 전문분석 완료

            $qry_string_land = "UPDATE land_information SET land_cost_analysis_status ='2' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }


    }else if($service_type=='3' || $service_type=='4'){// 등록 + 분석의 경우



        if($service_status=='1'){ // 대기중

            $qry_string_land = "UPDATE land_information SET land_agent_status ='0', land_cost_analysis_status ='0' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='2'){ // 진행중

            $qry_string_land = "UPDATE land_information SET land_agent_status ='1', land_cost_analysis_status ='1' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }else if($service_status=='3'){ // 완료

            $qry_string_land = "UPDATE land_information SET land_agent_status ='2', land_cost_analysis_status ='2' WHERE land_id = '$land_id';";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if ($qry_land) {
                echo 'success';
            }else{
                echo 'fail';
            }

        }

    }




} else {

    echo 'fail';
}


mysqli_close($connect)

?>