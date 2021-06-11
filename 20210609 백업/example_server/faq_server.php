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

$type = $_POST['type'];
$title = $_POST['title'];
$target = $_POST['target'];
$content = $_POST['content'];
$number = $_POST['number'];
$date = date( 'YmdHis', time());


if($target=='전체'){
    $target='0';
}elseif($target=='사용자'){
    $target='1';
}else{
    $target='2';
}
$title =addslashes($title);
$content =addslashes($content);


if($type=='write'){

    $qry_string = "INSERT INTO faq (faq_target, faq_title, faq_content, faq_date) VALUES ('$target','$title','$content','$date')";
    $qry = mysqli_query($connect, $qry_string);

    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }

}else if($type=='modify'){

    $qry_string = "UPDATE faq set faq_target='$target', faq_title='$title', faq_content='$content', faq_date='$date' where faq_number='$number'";
    $qry = mysqli_query($connect, $qry_string);


    if($qry){
        echo 'success';
    }else{
        echo 'fail';
    }


}else if($type=='delete'){

    $qry_string = "DELETE FROM faq WHERE faq_number='$number'";
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