<?php
error_reporting(0);

session_start();

$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}

//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

//개인정보
$dosa_profile_image = 'https://myluck.kr/admin/image/dosa_profile_image_default.png';
$dosa_nickname = $_POST['dosa_nickname'];
$dosa_name = $_POST['dosa_name'];
$dosa_phone = $_POST['dosa_phone'];
//계정정보
$dosa_email = $_POST['dosa_email'];
$dosa_password = $_POST['dosa_password'];
//사업자정보
$dosa_business_number = $_POST['dosa_business_number']; //선택
$dosa_account_holder = $_POST['dosa_account_holder'];
$dosa_account_bank = $_POST['dosa_account_bank'];
$dosa_account_number = $_POST['dosa_account_number'];
//등록날짜
$dosa_join_date = date( 'YmdHis', time());
//상담 정보
$counsel_field = $_POST['counsel_field'];
$counsel_field_detail_array = $_POST['counsel_field_detail_array'];
$counsel_type_array = $_POST['counsel_type_array'];
$counsel_field_detail_array_explode = explode( ',', $counsel_field_detail_array);
$counsel_field_detail_list =  json_encode($counsel_field_detail_array_explode,JSON_UNESCAPED_UNICODE);
$counsel_type_array_explode = explode( ',', $counsel_type_array);
$counsel_type_list =  json_encode($counsel_type_array_explode,JSON_UNESCAPED_UNICODE);
$dosa_title = $_POST['dosa_title'];
$dosa_information = $_POST['dosa_information'];
$dosa_address_full = $_POST['dosa_address_full'];      //선택
$dosa_address_detail = $_POST['dosa_address_detail'];  //선택
$dosa_address_full_explode = explode( ' ', $dosa_address_full);
$dosa_address1 = $dosa_address_full_explode[0];
$dosa_address2 = $dosa_address_full_explode[1];

$dosa_sub_image_list_array=array();



//테이블 값 삽입 시 예외처리 (, ; ' ")
$dosa_nickname =addslashes($dosa_nickname);
$dosa_name =addslashes($dosa_name);
$dosa_phone =addslashes($dosa_phone);
$dosa_email =addslashes($dosa_email);
$dosa_password =addslashes($dosa_password);
$dosa_business_number =addslashes($dosa_business_number);
$dosa_account_holder =addslashes($dosa_account_holder);
$dosa_account_bank =addslashes($dosa_account_bank);
$dosa_account_number =addslashes($dosa_account_number);
$dosa_title =addslashes($dosa_title);
$dosa_information =addslashes($dosa_information);
$dosa_address_full=addslashes($dosa_address_full);
$dosa_address_detail =addslashes($dosa_address_detail);

//비밀번호 sha 256 암호화
$dosa_password_hash = hash("sha256", $dosa_password);


$query_nickname = "SELECT * FROM dosa_information where dosa_nickname='$dosa_nickname'";
$result_nickname = mysqli_query($connect, $query_nickname);
$total_rows_nickname = mysqli_num_rows($result_nickname);

$query_email = "SELECT * FROM dosa_information where dosa_email='$dosa_email'";
$result_email = mysqli_query($connect, $query_email);
$total_rows_email = mysqli_num_rows($result_email);


if($total_rows_nickname>0 || $total_rows_email>0){
    echo '<script>alert("아이디 혹은 이메일이 중복되었습니다");history.back();</script>';
}else{

}



if ($_FILES['dosa_profile_image']['name']) { // 도사 프로필 이미지를 등록한 경우


    //해당 사진들을 서버에 업로드시킨 후
    $filename = $_FILES['dosa_profile_image']['name'];
    $file_explode = explode(".", $filename);
    $exploded_file_1 = $file_explode[count($file_explode) - 1];
    $filename = $dosa_email .'profile_image'.".".$exploded_file_1;
    $path = '/home/mydestiny/html/mobile/dosa_profile_images/' .  $filename;
    move_uploaded_file($_FILES['dosa_profile_image']['tmp_name'], $path);
    $dosa_profile_image='https://myluck.kr/mobile/dosa_profile_images/'.$filename;


    $qry_string = "INSERT INTO dosa_information (dosa_email, dosa_password, dosa_nickname, dosa_name, dosa_phone, counsel_field, counsel_field_detail_list, counsel_type_list,
                   dosa_profile_image, dosa_title, dosa_sub_image_list, dosa_information, dosa_address1, dosa_address2, dosa_address_full, dosa_address_detail,
                   dosa_business_number, dosa_account_holder, dosa_account_number, dosa_account_bank, dosa_join_date)
                   VALUES ('$dosa_email','$dosa_password_hash','$dosa_nickname','$dosa_name','$dosa_phone','$counsel_field','$counsel_field_detail_list','$counsel_type_list',
                   '$dosa_profile_image','$dosa_title','$dosa_sub_image_list','$dosa_information','$dosa_address1','$dosa_address2','$dosa_address_full','$dosa_address_detail',
                   '$dosa_business_number','$dosa_account_holder','$dosa_account_number','$dosa_account_bank','$dosa_join_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        //echo '이미지 등록, 성공';

        // 모든 데이터를 INSERT 시킨 후에 업데이트 시키는 방향
        for ($i = 1; $i < 7; $i++) {

            if ($_FILES['upfile'.$i]['name']) { //파일이 유효할 경우


                //해당 사진들을 서버에 업로드시킨 후
                $filename = $_FILES['upfile'.$i]['name'];
                $file_explode = explode(".", $filename);
                $exploded_file_1 = $file_explode[count($file_explode) - 1];
                $filename = $dosa_email .'_dosacompany_'.$i.".".$exploded_file_1;
                $path = '/home/mydestiny/html/mobile/dosa_company_info_images/' .  $filename;
                move_uploaded_file($_FILES['upfile'.$i]['tmp_name'], $path);
                $dosa_sub_image='https://myluck.kr/mobile/dosa_company_info_images/'.$filename;

                array_push($dosa_sub_image_list_array,$dosa_sub_image);

            }else{ //파일이 유효하지 않거나 오류가 발생했을 경우
                //echo '서브 이미지 업로드 실패'.$i;
            }

        }

        if(count($dosa_sub_image_list_array)>0){
            $dosa_sub_image_list =  json_encode($dosa_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update dosa_information set dosa_sub_image_list='$dosa_sub_image_list' where dosa_email='$dosa_email'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo '<script>alert("도사 등록이 완료되었습니다");location.href="https://www.myluck.kr/admin/theme/dosa/dosa_list.php"</script>';
            }else{
                echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
            }

        }else{
            array_push($dosa_sub_image_list_array,'https://myluck.kr/admin/image/dosa_sub_image_default.png');
            $dosa_sub_image_list =  json_encode($dosa_sub_image_list_array,JSON_UNESCAPED_UNICODE);

            $qry_string_update="update dosa_information set dosa_sub_image_list='$dosa_sub_image_list' where dosa_email='$dosa_email'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo '<script>alert("도사 등록이 완료되었습니다");location.href="https://www.myluck.kr/admin/theme/dosa/dosa_list.php"</script>';
            }else{
                echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
            }

        }





    }else{
        echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
    }



}else{  // 도사 프로필 이미지를 등록하지 않은 경우 -> 기본 이미지 등록 (https://myluck.kr/admin/image/dosa_profile_image_default.png) 이미지

    $qry_string = "INSERT INTO dosa_information (dosa_email, dosa_password, dosa_nickname, dosa_name, dosa_phone, counsel_field, counsel_field_detail_list, counsel_type_list,
                   dosa_profile_image, dosa_title, dosa_sub_image_list, dosa_information, dosa_address1, dosa_address2, dosa_address_full, dosa_address_detail,
                   dosa_business_number, dosa_account_holder, dosa_account_number, dosa_account_bank, dosa_join_date)
                   VALUES ('$dosa_email','$dosa_password_hash','$dosa_nickname','$dosa_name','$dosa_phone','$counsel_field','$counsel_field_detail_list','$counsel_type_list',
                   '$dosa_profile_image','$dosa_title','$dosa_sub_image_list','$dosa_information','$dosa_address1','$dosa_address2','$dosa_address_full','$dosa_address_detail',
                   '$dosa_business_number','$dosa_account_holder','$dosa_account_number','$dosa_account_bank','$dosa_join_date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        //echo '이미지 기본, 성공';

        // 모든 데이터를 INSERT 시킨 후에 업데이트 시키는 방향
        for ($i = 1; $i < 7; $i++) {

            if ($_FILES['upfile'.$i]['name']) { //파일이 유효할 경우
                
                //해당 사진들을 서버에 업로드시킨 후
                $filename = $_FILES['upfile'.$i]['name'];
                $file_explode = explode(".", $filename);
                $exploded_file_1 = $file_explode[count($file_explode) - 1];
                $filename = $dosa_email .'_dosacompany_'.$i.".".$exploded_file_1;
                $path = '/home/mydestiny/html/mobile/dosa_company_info_images/' .  $filename;
                move_uploaded_file($_FILES['upfile'.$i]['tmp_name'], $path);
                $dosa_sub_image='https://myluck.kr/mobile/dosa_company_info_images/'.$filename;

                array_push($dosa_sub_image_list_array,$dosa_sub_image);

            }else{ //파일이 유효하지 않거나 오류가 발생했을 경우
                //echo '서브 이미지 업로드 실패'.$i;
            }

        }

        if(count($dosa_sub_image_list_array)>0){
            $dosa_sub_image_list =  json_encode($dosa_sub_image_list_array,JSON_UNESCAPED_UNICODE);
            //echo $dosa_sub_image_list.'0보다 많이';

            $qry_string_update="update dosa_information set dosa_sub_image_list='$dosa_sub_image_list' where dosa_email='$dosa_email'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo '<script>alert("도사 등록이 완료되었습니다");location.href="https://www.myluck.kr/admin/theme/dosa/dosa_list.php"</script>';

            }else{
                echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
            }


        }else{
            array_push($dosa_sub_image_list_array,'https://myluck.kr/admin/image/dosa_sub_image_default.png');
            $dosa_sub_image_list =  json_encode($dosa_sub_image_list_array,JSON_UNESCAPED_UNICODE);
            //echo $dosa_sub_image_list.'0개';

            $qry_string_update="update dosa_information set dosa_sub_image_list='$dosa_sub_image_list' where dosa_email='$dosa_email'";
            $qry_update = mysqli_query($connect, $qry_string_update);

            if($qry_string_update){
                echo '<script>alert("도사 등록이 완료되었습니다");location.href="https://www.myluck.kr/admin/theme/dosa/dosa_list.php"</script>';
            }else{
                echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
            }

        }



    }else{
        echo '<script>alert("예기치 못한 오류가 발생되었습니다. 잠시 후에 다시 시도해주세요");history.back();</script>';
    }

}






mysqli_close($connect)

?>