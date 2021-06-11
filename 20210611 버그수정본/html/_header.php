<?php
//헤더페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//사용자 정보 조회
$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

?>

<div class="conatiner">
    <div class="inner clear">
        <h1 class="logo-wrap l-inline">
            <a href="/html/index.php" class="logo l-box">
                <img class="logo_img logo_s" src="/images/common/icon_logo_s.png" alt="랜드마킹">
                <img class="logo_img logo_m" src="/images/common/icon_logo_m.png" alt="랜드마킹">
                <img class="logo_img logo_mb" src="/images/common/icon_logo_mobile.png" alt="랜드마킹">
            </a>
        </h1>
        <button id="navBtn" class="btn"></button>
        <div class="menu-wrap Clear l-inline">
            <?php if ($user_session) { ?>
                <div class="util signined l-inline">
                    <div class="util-item util-user l-inline">
                        <span><a href="/html/mypage/sub_mp_menu.php"><?php echo $row_user['user_name'] ?>&nbsp;</a>님,&nbsp;안녕하세요!</span>
                        <ul class="menu_dp2 bx-round_xl bg_w">
                            <li class="item"><a class="bx-round_m" href="/html/mypage/sub_mp_menu.php">마이 메뉴</a>
                            </li>
                            <li class="item"><a class="bx-round_m" href="/html/land/sub_mp_list_all.php">내 토지
                                    분석</a></li>
                            <li class="item"><a class="bx-round_m"
                                                href="/html/mypage/sub_mp_faq_all.php">문의하기</a></li>
                            <li class="item"><a class="bx-round_m" href="/server/logout_server.php">로그아웃</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div class="util l-inline">
                    <span class="util-item"><a href="/html/account/sub_acc_login.php">로그인</a></span>
                    <span class="util-item"><a href="/html/account/sub_acc_join.php">회원가입</a></span>
                </div>
            <?php } ?>
            <nav class="gnb l-inline">
                        <span class="gnb-item gnb-item_dp service l-inline">
                                <a href="#none">서비스 소개</a>
                                <ul class="menu_dp2 bx-round_xl bg_w">
                                    <li class="item">
                                        <i class="icon icon_handWaving"></i>
                                        <a class="bx-round_m" href="/html/sub_service.php">서비스 소개</a>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon_mapPin"></i>
                                        <a class="bx-round_m" href="/html/sub_service_map.php">오시는 길</a>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon_megaphone"></i>
                                        <a class="bx-round_m" href="/html/mypage/sub_notice.php">공지사항</a>
                                    </li>
                                </ul>
                            </span>
                <div class="gnb-item gnb-item_dp l-inline">
                    <a href="#none" class="">토지</a>
                    <ul class="menu_dp2 bx-round_xl bg_w">
                        <li class="item tit">목록</li>
                        <li class="item">
                            <i class="icon icon_medal"></i>
                            <a class="bx-round_m" href="/html/sub_list_master.php">마스터 추천 토지</a>
                        </li>
                        <li class="item">
                            <i class="icon icon_globe"></i>
                            <a class="bx-round_m" href="/html/sub_list.php">등록된 토지</a>
                        </li>
                        <li class="item tit">등록</li>
                        <li class="item">
                            <i class="icon icon_pointing"></i>
                            <a class="btn_pop bx-round_m"  data-popup="inform_register">토지 직접 등록</a>
                        </li>
                        <li class="item">
                            <i class="icon icon_card"></i>
                            <a class="bx-round_m btn_pop" data-popup="service_rg01">토지 등록 대행</a>
                        </li>
                        <li class="item tit">분석</li>
                        <li class="item">
                            <i class="icon icon_heart"></i>
                            <a class="btn_pop bx-round_m" data-popup="inform_analysis">토지 무료 분석</a>
                        </li>
                        <li class="item">
                            <i class="icon icon_card"></i>
                            <a class="bx-round_m btn_pop"  data-popup="service_an01">토지 전문 분석</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<script>
    function headerFn(){
        var $header = $('#header'),
            $hHeader = $('.home #header'),
            $gnb = $header.find('.menu-wrap'),
            $gnbBtn = $('#header #navBtn');

        // 모바일 모드 전환
        $(window).on('load resize', function (event){
            event.preventDefault();
            if($(window).innerWidth() <= 890){
                if(!$header.hasClass('mobile')) $header.addClass('mobile');
            }else {
                if($header.hasClass('mobile')) $header.removeClass('mobile');

                if($gnb.hasClass('on')) $gnb.removeClass('on');
                if($gnbBtn.hasClass('on')) $gnbBtn.removeClass('on');
            };
        });

        // [홈 헤더] 스크롤
        $(window).scroll(function(event){
            event.preventDefault();
            if($(this).scrollTop() >= 200) $hHeader.addClass('scroll');
            else $hHeader.removeClass('scroll');
        });

        // depth메뉴 보기
        $gnbBtn.on('click', function (event){
            event.preventDefault();
            $(this).toggleClass('on');
            $gnb.toggleClass('on');
            console.log('aaaa')
        });

    }headerFn();

</script>
<!-- 팝업 스크립트 -->
<script>
    function popupFn(){
        var $popBtn = $('.btn_pop'),
            $popup = $('.popup'),
            $closeBtn = $popup.find('.btn_close, .btn_accept .btn_cancel'); //아이디,비번 체크 팝업창

        $popBtn.on('click',function(event){
            event.preventDefault();
            //팝업 열기
            var $targetData = $(this).data("popup");
            var $targetPop = $(`.popup[data-popup=${$targetData}]`);
            $targetPop.addClass('on');
            //배경 처리
            var $contentHeight = $targetPop.find('.container').outerHeight();
            if($contentHeight > $(window).innerHeight()) $targetPop.find('.dim').css('height', $contentHeight + 80);
            //팝업 position
            $popup.css({'top' : ($(window).height() - $popup.outerHeight()) / 2 + $(window).scrollTop() +"px"});
            //스크롤 방지
            var $wraps = document.querySelectorAll('html, body');
            $wraps.forEach(function(el){
                el.setAttribute('style', 'overflow: hidden; height: 100%;');
                el.addEventListener('scroll touchmove mousewheel', function(event){
                    event.preventDefault();
                }, {passive:false} );
            });
        });

        $closeBtn.on('click', function(event){
            event.preventDefault();
            $popup.removeClass('on');
            var $wraps = document.querySelectorAll('html, body');
            $wraps.forEach(function(el){
                el.setAttribute('style', 'overflow: auto; height: auto;');
                el.removeEventListener('scroll touchmove mousewheel', function(event){
                    event.preventDefault();
                });
            });
        });

    }popupFn();
</script>
