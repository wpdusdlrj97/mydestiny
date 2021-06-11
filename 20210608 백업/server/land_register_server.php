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

//지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용
$land_address = $_POST['land_address'];
$land_x = $_POST['land_x'];
$land_y = $_POST['land_y'];
$land_name = $_POST['land_name'];
$land_phone = $_POST['land_phone'];
$land_title = $_POST['land_title'];
$land_area = $_POST['land_area'];
$land_price = $_POST['land_price'];
$land_content = $_POST['land_content'];
$sub_image_count = $_POST['sub_image_count'];
$land_date = date( 'YmdHis', time());
//테이블 값 삽입 시 예외처리 (, ; ' ")
$land_name =addslashes($land_name);
$land_phone =addslashes($land_phone);
$land_title =addslashes($land_title);
$land_area =addslashes($land_area);
$land_price =addslashes($land_price);
$land_content =addslashes($land_content);
$land_content = nl2br($land_content);

//문의 참고이미지들 배열 생성
$land_sub_image_list_array=array();



//랜드 아이디 생성 (임의의 알파벳 8자리)
$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$pass = array(); //remember to declare $pass as an array
$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
for ($i = 0; $i < 8; $i++) {
    $n = rand(0, $alphaLength);
    $pass[] = $alphabet[$n];
}
$land_id =implode($pass);

if ($_FILES['thumbnail']['name']) { // 대표 이미지를 등록한 경우

    //대표 이미지 서버에 업로드
    $filename = $_FILES['thumbnail']['name'];
    $file_explode = explode(".", $filename);
    $exploded_file_1 = $file_explode[count($file_explode) - 1];
    $filename = $user_session."_".'land_main_image'."_".$land_date ."." . $exploded_file_1;
    $path = '/home/client/web/land_image/' . $filename;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    $land_main_image='https://www.landmarking.co.kr/land_image/'.$filename;
    //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
    $qry_string = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date)
                 VALUES ('$land_id','$land_address','$land_x','$land_y','$user_session','$land_name','$land_phone','$land_title','$land_area'
                    ,'$land_price','$land_content','$land_main_image','$land_date')";
    $qry = mysqli_query($connect, $qry_string);


    if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우

        //참고 이미지들 업로드
        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $user_session."_".'land_sub_image'.$a."_".$land_date.".".$exploded_file;
            $path = '/home/client/web/land_image/' . $filename;
            move_uploaded_file($_FILES['sub_files']['tmp_name'][$a], $path);
            $land_sub_image='https://www.landmarking.co.kr/land_image/'.$filename;

            array_push($land_sub_image_list_array,$land_sub_image);
        }

        //참고 이미지가 하나 이상일 경우 -> 참고이미지 배열 UPDATE
        if(count($land_sub_image_list_array)>0){
            $land_sub_image_list =  json_encode($land_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update land_information set land_sub_image_list='$land_sub_image_list' where land_id='$land_id'";
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

    $qry_string = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date)
                 VALUES ('$land_id','$land_address','$land_x','$land_y','$user_session','$land_name','$land_phone','$land_title','$land_area'
                    ,'$land_price','$land_content','https://landmarking.co.kr/land_image/land_default.png','$land_date')";
    $qry = mysqli_query($connect, $qry_string);




    if($qry){

        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $user_session."_".'land_sub_image'.$a."_".$land_date.".".$exploded_file;
            $path = '/home/client/web/land_image/' . $filename;
            move_uploaded_file($_FILES['sub_files']['tmp_name'][$a], $path);
            $land_sub_image='https://www.landmarking.co.kr/land_image/'.$filename;
            //참고 이미지 배열에 각각의 이미지 추가
            array_push($land_sub_image_list_array,$land_sub_image);
        }


        //참고 이미지가 하나 이상일 경우 -> 참고이미지 배열 UPDATE
        if(count($land_sub_image_list_array)>0){
            $land_sub_image_list =  json_encode($land_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update land_information set land_sub_image_list='$land_sub_image_list' where land_id='$land_id'";
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