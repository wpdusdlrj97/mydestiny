<?php
date_default_timezone_set('Asia/Seoul');

function get_resource($number){
    $host = "localhost";
    $dbu_id = "client";
    $dbu_pw = "*@DT20210430uC!~";
    $use_db = "land";
    if($number == 0){
        return $host;
    }elseif($number == 1){
        return $dbu_id;
    }elseif($number == 2){
        return $dbu_pw;
    }elseif($number == 3){
        return $use_db;
    }else{
        return "fail";
    }
}

$connect = mysqli_connect(get_resource(0),get_resource(1),get_resource(2),get_resource(3));
?>
