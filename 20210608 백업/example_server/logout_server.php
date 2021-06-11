<?php
session_start();
session_destroy();
//메인 페이지로 이동
echo '<script>alert("로그아웃 되었습니다")</script>';
$logout_url="https://www.myluck.kr/login.php";
echo "<meta http-equiv='refresh' content='0; url=$logout_url'>";
exit();
?>