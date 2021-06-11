<?php

//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");


$date1 = "20200607000000";
$date2 = "20200915000000";
$new_date = date("YmdHis", strtotime("-1 day", strtotime($date1)));


while(true) //i가 10보다 작거나 같을 때 반복합니다
{
    $qry_string = "INSERT INTO dosa_test (dosa_test_date) VALUES ('$new_date')";
    $qry = mysqli_query($connect, $qry_string);

    $new_date = date("YmdHis", strtotime("+1 day", strtotime($new_date)));
    echo $new_date."<br>";

    if($new_date == $date2) break;


}

?>