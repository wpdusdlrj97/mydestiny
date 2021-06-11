<?php
session_start();

$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}

$target = $_POST['target'];          // 사용자 : user , 도사 : dosa , 전체 : all
$title = $_POST['title'];            // 제목
$content = $_POST['content'];        // 내용
$push_time = $_POST['push_time'];    //시간단위까지 설정해야함 ( 년도 + 월 + 일 + 시간 + 분 )

$success = true;

$tokens = array();

if($target&&$title&&$content&&$push_time){

    $push_target = "";

    $push_time = $push_time."00";

    //데이터베이스 연결
    include_once("/home/mydestiny/html/private/private_resource.php");

    $url = "https://fcm.googleapis.com/fcm/send";
    $qry = "";
    if($target == "dosa"){
        $push_target = "2";
        $qry = "SELECT * FROM dosa_information WHERE dosa_push_token is not NULL and dosa_event_push='1'";
        $send = mysqli_query($connect, $qry);
        while($row = mysqli_fetch_array($send)){
            array_push($tokens, $row['dosa_push_token']);
        }
    }elseif($target == "user"){
        $push_target = "1";
        $qry = "SELECT * FROM user_information WHERE user_push_token is not NULL and user_event_push='1'";
        $send = mysqli_query($connect, $qry);
        while($row = mysqli_fetch_array($send)){
            array_push($tokens, $row['user_push_token']);
        }
    }elseif($target == "all") {
        $push_target = "0";
        $qry = "SELECT * FROM dosa_information WHERE dosa_push_token is not NULL and dosa_event_push='1'";
        $send = mysqli_query($connect, $qry);
        while ($row = mysqli_fetch_array($send)) {
            array_push($tokens, $row['dosa_push_token']);
        }

        $qry = "SELECT * FROM user_information WHERE user_push_token is not NULL and user_event_push='1'";
        $send = mysqli_query($connect, $qry);
        while ($row = mysqli_fetch_array($send)) {
            array_push($tokens, $row['user_push_token']);
        }
    }

    $data = array();
    $data['title'] = "\"".$title."\"";
    $data['content'] = "\"".$content."\"";
    $data['push_time'] = "\"".$push_time."\"";
    $data['push'] = "\"yes\"";

    $serverKey = 'AAAAbzusDfw:APA91bHdiTDU5AcB2_GxF4NoHRsN52JwKVK8foUojbBHeHshB0kxPkj9z0zX0F_nBaPxY1EPMNkb8LqOJ8Igt_n3niY2FJl8fzIIt9VEKibaI9d1jlQjTlp18hkHgWOWNiSojp8bcQqL';



    $send_tokens = array();
    if(count($tokens) < 1000){

        $arrayToSend = array('registration_ids' => $tokens, 'data' => $data);
        $json = json_encode($arrayToSend, JSON_UNESCAPED_UNICODE);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Send the request
        $response = curl_exec($ch);
        if ($response === FALSE) {
            echo curl_error($ch);
            $success = false;
        }

        curl_close($ch);
//        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }else{
        for($x=0;$x<count($tokens);$x++){
            array_push($send_tokens, $tokens[$x]);
            if($x/999 == 0){

                $arrayToSend = array('registration_ids' => $send_tokens, 'data' => $data);
                $json = json_encode($arrayToSend, JSON_UNESCAPED_UNICODE);

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key=' . $serverKey;


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                //Send the request
                $response = curl_exec($ch);
                if ($response === FALSE) {
                    echo curl_error($ch);
                    $success = false;
                }

                curl_close($ch);
//                echo json_encode($data, JSON_UNESCAPED_UNICODE);

                $send_tokens = array();
            }
        }
    }
    if($success){
        mysqli_query($connect, "INSERT INTO push (push_target, push_title, push_content, push_date) VALUES('$push_target', '$title', '$content', $push_time)");
    }
}else{
    echo "fail";
}

exit();