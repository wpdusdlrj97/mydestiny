<?php
//메인 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//사용자 정보 조회
$qry_string_admin = "SELECT * FROM admin_information where admin_email='$admin_session'";
$qry_admin = mysqli_query($connect, $qry_string_admin);
$row_admin = mysqli_fetch_array($qry_admin);
$total_row_admin = mysqli_num_rows($qry_admin);

?>

<div class="container">
    <div class="inner">
        <h1 class="logo">
            <a href="#none">
                <img class="img_f" src="/admin/images/icon_logo_large.png" alt="랜드마킹 관리자 페이지">
            </a>
        </h1>
        <?php if($admin_session){?>
            <div class="login-wrap clear">
<!--                <button type="button" class="btn l-fleft">마이페이지</button>-->
                <span class="status">
                            <em class="user"><?php echo $admin_session?></em> 아이디로 접속되었습니다.
                        </span>
                <button type="button" class="btn" onclick="location.href='/admin_server/logout_server.php'">로그아웃</button>
            </div>
        <?php }else { ?>
                    <div class="login-wrap">
                                    <span class="status">
                                        관리자 로그인을 해 주세요.
                                    </span>
                        <button type="button" class="btn btn_login" onclick="location.href='/admin/html/login.php'">로그인</button>
                    </div>
        <?php } ?>
        <nav id="gnb">
            <a href="#none" class="menu has-depth">회원관리</a>
            <div class="wrap">
                <a href="/admin/html/member/user_common.php" class="menu depth02">일반회원</a>
                <a href="/admin/html/member/user_admin.php" class="menu depth02">관리자회원</a>
                <a href="/admin/html/member/user_unsub.php" class="menu depth02">탈퇴회원</a>
                <a href="/admin/html/member/user_join.php" class="menu depth02">회원등록 (일반)</a>
                <a href="/admin/html/member/admin_join.php" class="menu depth02">회원등록 (관리자)</a>
            </div>
            <a href="#none" class="menu has-depth">매물관리</a>
            <div class="wrap">
                <a href="/admin/html/land_list.php" class="menu depth02">토지매물</a>
                <a href="/admin/html/land_form.php" class="menu depth02">토지등록</a>
            </div>
            <a href="/admin/html/analysis_list.php" class="menu">유료서비스 요청함</a>
            <a href="/admin/html/register_list.php" class="menu">등록대행 요청함</a>
            <a href="#none" class="menu has-depth">결제관리</a>
            <div class="wrap">
                <a href="/admin/html/payment/pay_list_admin.php" class="menu depth02">결제관리</a>
                <a href="/admin/html/payment/pay_list.php" class="menu depth02">결제상품리스트</a>
            </div>
            <a href="#none" class="menu has-depth">고객센터</a>
            <div class="wrap">
                <a href="/admin/html/cs/notice_list.php" class="menu depth02">공지사항</a>
                <a href="/admin/html/cs/qna_list.php" class="menu depth02">문의내역</a>
            </div>
        </nav>
    </div>
</div>

<script src="/admin/js/script.js"></script>

