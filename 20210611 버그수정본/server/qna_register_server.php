<?php
error_reporting(0);
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";


//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}

//문의제목, 문의내용, 문의날짜, 참고 이미지 개수
$qna_title = $_POST['qna_title'];
$qna_content = $_POST['qna_content'];
$sub_image_count = $_POST['sub_image_count'];
$qna_date = date( 'YmdHis', time());
//테이블 값 삽입 시 예외처리 (, ; ' ")
$qna_title =addslashes($qna_title);
$qna_content =addslashes($qna_content);
//문의 참고이미지들 배열 생성
$qna_sub_image_list_array=array();

//문의자 실명
$qry_name_string = "select * from user_information where user_email='$user_session'";
$qry_name = mysqli_query($connect, $qry_name_string);
$row_name = mysqli_fetch_array($qry_name);
$qna_writer_name =  $row_name['user_name'];



if ($_FILES['thumbnail']['name']) { // 대표 이미지를 등록한 경우

    //대표 이미지 서버에 업로드
    $filename = $_FILES['thumbnail']['name'];
    $file_explode = explode(".", $filename);
    $exploded_file_1 = $file_explode[count($file_explode) - 1];
    $filename = $user_session."_".'qna_main_image'."_".$qna_date ."." . $exploded_file_1;
    $path = '/home/client/web/upload/' . $filename;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    $qna_main_image='https://www.landmarking.co.kr/upload/'.$filename;
    //qna_information 테이블에 문의제목, 문의내용, 문의날짜, 대표이미지 저장
    $qry_string = "INSERT INTO qna_information (qna_writer_email, qna_writer_name, qna_title, qna_content, qna_date, qna_main_image) VALUES ('$user_session', '$qna_writer_name ','$qna_title','$qna_content','$qna_date','$qna_main_image')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우

        //참고 이미지들 업로드
        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $user_session."_".'qna_sub_image'.$a."_".$qna_date.".".$exploded_file;
            $path = '/home/client/web/upload/' . $filename;
            move_uploaded_file($_FILES['sub_files']['tmp_name'][$a], $path);
            $qna_sub_image='https://www.landmarking.co.kr/upload/'.$filename;

            array_push($qna_sub_image_list_array,$qna_sub_image);
        }

        //참고 이미지가 하나 이상일 경우 -> 참고이미지 배열 UPDATE
        if(count($qna_sub_image_list_array)>0){
            $qna_sub_image_list =  json_encode($qna_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update qna_information set qna_sub_image_list='$qna_sub_image_list' where qna_date='$qna_date' and qna_writer_email='$user_session'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo 'success';
            }else{
                echo 'fail';
            }

        }else{
            echo 'success';
        }

    }else{ //해당 쿼리문이 실패했을 경우
        echo 'fail';
    }

} else {  // 대표 이미지를 등록하지 않은 경우

    $qry_string = "INSERT INTO qna_information (qna_writer_email, qna_writer_name, qna_title, qna_content, qna_date) VALUES ('$user_session','$qna_writer_name ','$qna_title','$qna_content','$qna_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){

        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $user_session."_".'qna_sub_image'.$a."_".$qna_date.".".$exploded_file;
            $path = '/home/client/web/upload/' . $filename;
            move_uploaded_file($_FILES['sub_files']['tmp_name'][$a], $path);
            $qna_sub_image='https://www.landmarking.co.kr/upload/'.$filename;
            //참고 이미지 배열에 각각의 이미지 추가
            array_push($qna_sub_image_list_array,$qna_sub_image);
        }


        //참고 이미지가 하나 이상일 경우 -> 참고이미지 배열 UPDATE
        if(count($qna_sub_image_list_array)>0){
            $qna_sub_image_list =  json_encode($qna_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update qna_information set qna_sub_image_list='$qna_sub_image_list' where qna_date='$qna_date' and qna_writer_email='$user_session'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo 'success';
            }else{
                echo 'fail';
            }

        }else{
            echo 'success';
        }

    }else{
        echo 'fail';
    }
}



mysqli_close($connect)
?>