<?php
//로그아웃 백엔드
session_start();
session_destroy();

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//메인 페이지로 이동
//echo '<script>alert("로그아웃 되었습니다")</script>';
$logout_url= "https://landmarking.co.kr/admin/html/login.php";
echo "<meta http-equiv='refresh' content='0; url=$logout_url'>";
exit();
?>