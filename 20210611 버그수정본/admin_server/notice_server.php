<?php
//공지사항 백엔드
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");


//공지사항 아이디, 제목, 내용, 기존 파일 등
$notice_type = $_POST['type'];
$notice_id = $_POST['notice_id'];
$notice_title = $_POST['notice_title'];
$notice_content = $_POST['notice_content'];
$original_file_status = $_POST['original_file_status'];

$notice_date = date( 'YmdHis', time());
//테이블 값 삽입 시 예외처리 (, ; ' ")
$notice_title =addslashes($notice_title);
$notice_content =addslashes($notice_content);
$notice_content = nl2br($notice_content);



if($notice_type=='register'){ // 공지사항 등록

    if ($_FILES['notice_file']['name']) { // 첨부파일를 등록한 경우

        //첨부파일 서버에 업로드
        $filename = $_FILES['notice_file']['name'];
        $filename = $notice_date."_&공지&_".$filename;
        $path = '/home/client/web/upload/' . $filename;
        move_uploaded_file($_FILES['notice_file']['tmp_name'], $path);
        $notice_file='https://www.landmarking.co.kr/upload/'.$filename;
        $qry_string = "INSERT INTO notice_information (notice_title, notice_content, notice_date, notice_file) VALUES ('$notice_title','$notice_content','$notice_date','$notice_file')";
        $qry = mysqli_query($connect, $qry_string);


        if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우
            echo 'success';
        }else{ //해당 쿼리문이 실패했을 경우
            echo 'fail';
        }

    } else {  // 첨부파일를 등록하지 않은 경우

        $qry_string = "INSERT INTO notice_information (notice_title, notice_content, notice_date) VALUES ('$notice_title','$notice_content','$notice_date')";
        $qry = mysqli_query($connect, $qry_string);


        if($qry){
            echo 'success';
        }else{
            echo 'fail';
        }


    }

}else{ // 공지사항 수정


    if ($_FILES['notice_file']['name']) { // 첨부파일를 등록한 경우

        //첨부파일 서버에 업로드
        $filename = $_FILES['notice_file']['name'];
        $filename = $notice_date."_&공지&_".$filename;
        $path = '/home/client/web/upload/' . $filename;
        move_uploaded_file($_FILES['notice_file']['tmp_name'], $path);
        $notice_file='https://www.landmarking.co.kr/upload/'.$filename;
        $qry_string = "update notice_information set notice_title='$notice_title', notice_content='$notice_content', notice_file='$notice_file' where notice_id='$notice_id'";
        $qry = mysqli_query($connect, $qry_string);


        if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우
            echo 'success';
        }else{ //해당 쿼리문이 실패했을 경우
            echo 'fail';
        }

    } else {  // 첨부파일를 등록하지 않은 경우


        if($original_file_status=='0'){ // 첩부파일 그대로

            $qry_string = "update notice_information set notice_title='$notice_title', notice_content='$notice_content' where notice_id='$notice_id'";
            $qry = mysqli_query($connect, $qry_string);

            if($qry){
                echo 'success';
            }else{
                echo 'fail';
            }

        }else{ // 첩부파일 삭제

            $qry_string = "update notice_information set notice_title='$notice_title', notice_content='$notice_content', notice_file='' where notice_id='$notice_id'";
            $qry = mysqli_query($connect, $qry_string);

            if($qry){
                echo 'success';
            }else{
                echo 'fail';
            }
        }




    }


}


mysqli_close($connect)
?>