<?php
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");




$qna_id = $_POST['qna_id'];
$qna_reply_content = $_POST['qna_reply_content'];
$original_file_status = $_POST['original_file_status'];

$reply_date = date( 'YmdHis', time());
//테이블 값 삽입 시 예외처리 (, ; ' ")
$qna_title = addslashes($qna_title);
$qna_reply_content  = addslashes($qna_reply_content );



if ($_FILES['qna_file']['name']) { // 첨부파일를 등록한 경우

    //첨부파일 서버에 업로드
    $filename = $_FILES['qna_file']['name'];
    $filename = $reply_date."_&문의&_".$filename;
    $path = '/home/client/web/upload/' . $filename;
    move_uploaded_file($_FILES['qna_file']['tmp_name'], $path);
    $qna_file='https://www.landmarking.co.kr/upload/'.$filename;
    $qry_string = "update qna_information set reply_status='1', reply_content='$qna_reply_content',reply_date='$reply_date', reply_file='$qna_file' where qna_id='$qna_id'";
    $qry = mysqli_query($connect, $qry_string);


    if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우
        echo 'success';
    }else{ //해당 쿼리문이 실패했을 경우
        echo 'fail';
    }

} else {  // 첨부파일를 등록하지 않은 경우


    if($original_file_status=='0'){ // 첩부파일 그대로

        $qry_string = "update qna_information set reply_status='1', reply_content='$qna_reply_content',reply_date='$reply_date'where qna_id='$qna_id'";
        $qry = mysqli_query($connect, $qry_string);


        if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우
            echo 'success';
        }else{ //해당 쿼리문이 실패했을 경우
            echo 'fail';
        }

    }else{ // 첩부파일 삭제

        $qry_string = "update qna_information set reply_status='1', reply_content='$qna_reply_content',reply_date='$reply_date', reply_file='' where qna_id='$qna_id'";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우
            echo 'success';
        }else{ //해당 쿼리문이 실패했을 경우
            echo 'fail';
        }
    }




}


mysqli_close($connect)
?>