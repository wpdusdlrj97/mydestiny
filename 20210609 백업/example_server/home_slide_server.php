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

$number = $_POST['number'];
$type = $_POST['type'];
$content = $_POST['content'];
$date = date( 'YmdHis', time());


if($type=='image'){
    $type='1';
}elseif($type=='video'){
    $type='2';
}else{
    $type='0';
}
$content =addslashes($content);


if($type=='0'){

    $qry_string = "UPDATE home_slide set slide_type='0', slide_content='', slide_date='$date' where slide_number='$number'";
    $qry = mysqli_query($connect, $qry_string);


    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }


}else if($type=='1'){



    if ($_FILES['upfile']['name']) { //파일이 유효할 경우

        //해당 사진들을 서버에 업로드시킨 후
        $filename = $date . "_" .$_FILES['upfile']['name'];
        $path = '/home/mydestiny/html/admin/slide_image/' .  $filename;
        move_uploaded_file($_FILES['upfile']['tmp_name'], $path);
        $image_file='https://myluck.kr/admin/slide_image/'.$filename;

        $qry_string = "UPDATE home_slide set slide_type='1', slide_content='$image_file', slide_date='$date' where slide_number='$number'";
        $qry = mysqli_query($connect, $qry_string);

    }else{ //파일이 유효하지 않거나 오류가 발생했을 경우

        echo "<script>alert('일시적인 오류 발생');history.back();</script>";
    }



    if($qry){
        $connect_url = '/admin/theme/app/home_slide.php';
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
    }else{
        $connect_url = 'https://www.naver.com/';
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
    }


}else if($type=='2'){




    $qry_string = "UPDATE home_slide set slide_type='$type', slide_content='$content', slide_date='$date' where slide_number='$number'";
    $qry = mysqli_query($connect, $qry_string);


    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }


}
else{
    echo 'fail';
}


mysqli_close($connect)

?>