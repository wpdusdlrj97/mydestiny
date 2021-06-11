<?php
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");



//지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용
$land_id = $_POST['land_id'];
$land_email = $_POST['land_email'];
$land_name = $_POST['land_name'];
$land_phone = $_POST['land_phone'];
$land_title = $_POST['land_title'];
$land_area = $_POST['land_area'];
$land_price = $_POST['land_price'];
$land_content = $_POST['land_content'];
$sub_image_count = $_POST['sub_image_count'];
$land_date = date( 'YmdHis', time());
$land_master_recommend = $_POST['land_master_recommend'];
$land_free_analysis_status = $_POST['land_free_analysis_status'];
//기존 이미지 (참고)
$old_sub_image_list_array = $_POST['old_sub_image_list_array'];


//토지 평가 요소
$value_1 = $_POST['value_1'];
$value_2 = $_POST['value_2'];
$value_3 = $_POST['value_3'];
$value_4 = $_POST['value_4'];
$value_5 = $_POST['value_5'];
$dev_1 = $_POST['dev_1'];
$dev_2 = $_POST['dev_2'];
$sub_1 = $_POST['sub_1'];
$sub_2 = $_POST['sub_2'];
$pre_1 = $_POST['pre_1'];
$pre_2 = $_POST['pre_2'];


//테이블 값 삽입 시 예외처리 (, ; ' ")
$land_name =addslashes($land_name);
$land_phone =addslashes($land_phone);
$land_title =addslashes($land_title);
$land_area =addslashes($land_area);
$land_price =addslashes($land_price);
$land_content =addslashes($land_content);
$land_content = nl2br($land_content);


if($old_sub_image_list_array=='' || $old_sub_image_list_array=="null"){ //기존이미지를 모두 삭제한 경우, 기존 이미지가 없는 경우
    $land_sub_image_list_array=array();
    //echo'기존 이미지 삭제 O : '.$old_sub_image_list_array;
}else{ //기존이미지를 모두 삭제하지 않은 경우
    $land_sub_image_list_array = explode( ',', $old_sub_image_list_array );
    //echo'기존 이미지 삭제 X : '.$old_sub_image_list_array;
}





if ($_FILES['thumbnail']['name']) { // 대표 이미지를 등록한 경우

    //대표 이미지 서버에 업로드
    $filename = $_FILES['thumbnail']['name'];
    $file_explode = explode(".", $filename);
    $exploded_file_1 = $file_explode[count($file_explode) - 1];
    $filename = $land_email."_".'land_main_image'."_".$land_date ."." . $exploded_file_1;
    $path = '/home/client/web/land_image/' . $filename;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    $land_main_image='https://www.landmarking.co.kr/land_image/'.$filename;
    //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
    $qry_string="update land_information set land_register_id='$land_email',land_register_name='$land_name', land_register_phone='$land_phone', land_register_title='$land_title',
                 land_register_area='$land_area',land_register_price='$land_price',land_register_content='$land_content',land_main_image='$land_main_image'
                 , land_master_recommend='$land_master_recommend', land_free_analysis_status='$land_free_analysis_status' where land_id='$land_id'";
    $qry = mysqli_query($connect, $qry_string);




    if($qry){//해당 쿼리문이 성공적으로 실행되었을 경우

        //참고 이미지들 업로드
        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $land_email."_".'land_sub_image'.$a."_".$land_date.".".$exploded_file;
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

            if($qry_update){

                $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
                $qry_chart = mysqli_query($connect, $qry_string_chart);



                if($qry_chart){
                    echo 'success';
                }else{
                    echo 'fail';
                }


            }else{
                echo 'fail';
            }

        }else{  //참고 이미지룰 추가하지 않은 경우


            if($old_sub_image_list_array==''){ //기존 이미지도 모두 삭제한 경우

                $qry_string_update_old="update land_information set land_sub_image_list=null where land_id='$land_id'";
                $qry_update_old = mysqli_query($connect, $qry_string_update_old);

                if($qry_string_update_old){

                    $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
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

                $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
                $qry_chart = mysqli_query($connect, $qry_string_chart);

                if($qry_chart){
                    echo 'success';
                }else{
                    echo 'fail';
                }

            }



        }

    }else{ //해당 쿼리문이 실패했을 경우
        echo 'fail';
    }

} else {  // 대표 이미지를 등록하지 않은 경우

    $qry_string="update land_information set land_register_id='$land_email',land_register_name='$land_name', land_register_phone='$land_phone', land_register_title='$land_title',
                 land_register_area='$land_area',land_register_price='$land_price',land_register_content='$land_content'
                 , land_master_recommend='$land_master_recommend', land_free_analysis_status='$land_free_analysis_status' where land_id='$land_id'";
    $qry = mysqli_query($connect, $qry_string);




    if($qry){

        for($a=0;$a<$sub_image_count;$a++){
            //참고이미지 업로드
            $filename = $_FILES['sub_files']['name'][$a];
            $file_explode = explode(".", $filename);
            $exploded_file = $file_explode[count($file_explode) - 1];
            $filename = $land_email."_".'land_sub_image'.$a."_".$land_date.".".$exploded_file;
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

            if($qry_update){
                $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
                $qry_chart = mysqli_query($connect, $qry_string_chart);

                if($qry_chart){
                    echo 'success';
                }else{
                    echo 'fail';
                }
            }else{
                echo 'fail';
            }

        }else{ //참고 이미지룰 추가하지 않은 경우

            if($old_sub_image_list_array==''){ //기존 이미지도 모두 삭제한 경우

                $qry_string_update_old="update land_information set land_sub_image_list=null where land_id='$land_id'";
                $qry_update_old = mysqli_query($connect, $qry_string_update_old);

                if($qry_string_update_old){

                    $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
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

                $qry_string_chart="update chart_information set value_1='$value_1', value_2='$value_2', value_3='$value_3', value_4='$value_4', value_5='$value_5'
                                    ,dev_1='$dev_1',dev_2='$dev_2',sub_1='$sub_1',sub_2='$sub_2',pre_1='$pre_1',pre_2='$pre_2' where land_id='$land_id' ";
                $qry_chart = mysqli_query($connect, $qry_string_chart);

                if($qry_chart){
                    echo 'success';
                }else{
                    echo 'fail';
                }

            }


        }

    }else{
        echo 'fail';
    }


}




mysqli_close($connect)
?>