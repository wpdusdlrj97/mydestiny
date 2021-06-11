<div class="container">
    <div class="inner">
        <h1 class="logo">
            <a href="#none">
                <img class="img_f" src="../images/icon_logo_large.png" alt="랜드마킹 관리자 페이지">
            </a>
        </h1>
<!--        <div class="login-wrap">-->
<!--                        <span class="status">-->
<!--                            관리자 로그인을 해 주세요.-->
<!--                        </span>-->
<!--            <button type="button" class="btn btn_login">로그인</button>-->
<!--        </div>-->
        <div class="login-wrap clear">
            <button type="button" class="btn l-fleft" onClick="window.open('../html/template/popup_mypage.php','pop','width=425, height=540, top=200, left=200');">마이페이지</button>
            <span class="status">
                            <em class="user">Admin</em>아이디로 접속되었습니다.
                        </span>
            <button type="button" class="btn">로그아웃</button>
        </div>
        <nav id="gnb">
            <a href="#none" class="menu has-depth">회원관리</a>
            <div class="wrap">
                <a href="../html/user_join.php" class="menu depth02">회원등록</a>
                <a href="../html/user_common.php" class="menu depth02">일반회원</a>
                <a href="../html/user_admin.php" class="menu depth02">관리자회원</a>
                <a href="../html/user_unsub.php" class="menu depth02">탈퇴회원</a>
            </div>
            <a href="#none" class="menu has-depth">매물관리</a>
            <div class="wrap">
                <a href="../html/land_list.php" class="menu depth02">토지매물</a>
                <a href="../html/land_form.php" class="menu depth02">토지등록</a>
            </div>
            <a href="../html/analysis_list.php" class="menu">토지분석요청함</a>
            <a href="../html/register_list.php" class="menu">등록대행요청함</a>
            <a href="#none" class="menu has-depth">결제관리</a>
            <div class="wrap">
                <a href="../html/pay_list_admin.php" class="menu depth02">결제관리</a>
                <a href="../html/pay_list.php" class="menu depth02">결제상품리스트</a>
            </div>
            <a href="#none" class="menu has-depth">고객센터</a>
            <div class="wrap">
                <a href="../html/notice_list.php" class="menu depth02">공지사항</a>
                <a href="../html/faq_list.php" class="menu depth02">문의내역</a>
            </div>
        </nav>
    </div>
</div>

<script src="../js/script.js"></script>

