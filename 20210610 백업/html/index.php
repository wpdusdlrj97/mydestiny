<?php
//메인 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//사용자 정보 조회
$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);
//토지 정보 조회 (등록 대행 X or 완료된 토지만)
$qry_string_master = "SELECT * FROM land_information where land_master_recommend='1' and land_agent_status not in ('1') ORDER BY land_register_date DESC limit 0,8";
$qry_master = mysqli_query($connect, $qry_string_master);
$qry_string_new = "SELECT * FROM land_information where land_agent_status not in ('1') ORDER BY land_register_date DESC limit 0,8";
$qry_new = mysqli_query($connect, $qry_string_new);

$land_id_master = array();
$land_address_master = array();
$land_register_title_master = array();
$land_register_area_master = array();
$land_register_price_master = array();
$land_click_master = array();
$land_main_image_master = array();


$land_id_new = array();
$land_address_new = array();
$land_register_title_new = array();
$land_register_area_new = array();
$land_register_price_new = array();
$land_click_new = array();
$land_main_image_new = array();

while ($row_master = mysqli_fetch_array($qry_master)) {
    array_push($land_id_master, $row_master['land_id']);
    array_push($land_address_master, $row_master['land_address']);
    array_push($land_register_title_master, $row_master['land_register_title']);
    array_push($land_register_area_master, $row_master['land_register_area']);
    array_push($land_register_price_master, $row_master['land_register_price']);
    array_push($land_click_master, $row_master['land_click']);
    array_push($land_main_image_master, $row_master['land_main_image']);

}
while ($row_new = mysqli_fetch_array($qry_new)) {
    array_push($land_id_new, $row_new['land_id']);
    array_push($land_address_new, $row_new['land_address']);
    array_push($land_register_title_new, $row_new['land_register_title']);
    array_push($land_register_area_new, $row_new['land_register_area']);
    array_push($land_register_price_new, $row_new['land_register_price']);
    array_push($land_click_new, $row_new['land_click']);
    array_push($land_main_image_new, $row_new['land_main_image']);
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="토지 중개 플랫폼 랜드마킹입니다.">
    <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
    <meta name="author" content="랜드마킹">
    <meta property="og:type" content="website">
    <meta property="og:url" content="url">
    <meta property="og:image" content="/images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹">
    <meta property="og:site_name" content="랜드마킹">
    <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
    <meta property="og:locale" content="ko_KR">
    <title>랜드마킹</title>
    <!-- FAVICON-->

    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/main.css">

    <!-- SCRIPT -->
    <script src="../js/lib/jquery-3.6.0.min.js"></script>
    <!--[if lte IE 9]>
    <script src="../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../js/lib/html5shiv.min.js"></script>
    <script src="../js/lib/jqPIE.js"></script>
    <script src="../js/lib/PIE.js"></script>
    <![endif]-->
    <!--네이버 지도 API 이용-->
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=egcozauon9&submodules=geocoder"></script>
</head>
<body>
<div id="skipNav">
    <a href="#hSection01">마스터 추천 토지 가기</a>
    <a href="#hSection02">홈 메뉴 가기</a>
    <a href="#hSection03">등록된 토지 가기</a>
</div>
<div class="popup popup-inform" data-popup="inform_analysis">
    <div class="dim"></div>
    <div class="container bx-round_m">
        <div class="inner">
            <div class="title-wrap">
                <h2 class="title">토지 무료 분석</h2>
                <p class="desc">
                    등록된 토지를 중심으로 전문적인 분석을 받고 싶은 분들에게
                    <br>
                    국내 최고의 토지 전문가들이 1:1 상담을 해드립니다.
                </p>
            </div>
            <div class="inform-wrap">
                <h3><i>1</i>내가 등록한 토지 확인</h3>
                <div class="wrap clear">
                    <p class="txt">
                        -회원님이 등록한 내용은 전문 컨설턴트 확인
                        <br>
                        -가치 분석, 개발측 분석 진행
                        <br>
                        -토지 컨설턴트 의견 반영
                    </p>
                </div>
            </div>
            <div class="inform-wrap img-over">
                <h3><i>2</i>전문 분석 요청</h3>
                <div class="wrap">
                    <p class="txt">
                        -세분화된 전문 분석 요청
                        <br>
                        -토지에 대한 가치를 세분화된 내용을
                        <br>
                        분석하고 방문, 전화 상담의견을 전달
                    </p>
                    <img src="/images/sub/img_inform_an01.png" alt="토지 분석 이미지">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn_close"></button>
    </div>
</div>
<div class="popup popup-inform" data-popup="inform_register">
    <div class="dim"></div>
    <div class="container bx-round_m">
        <div class="inner">
            <div class="title-wrap">
                <h2 class="title">토지 직접 등록</h2>
                <p class="desc">
                    분석 받고 싶은 토지를
                    <br>
                    자세한 분석을 받기 위한 방법을 모르는 분들에게 최적의 콘텐츠로 등록해 드립니다.
                </p>
            </div>
            <div class="inform-wrap">
                <h3><i>1</i>메인 페이지 내 주소 입력</h3>
                <div class="wrap clear">
                    <p class="txt l-fleft">
                        -회원 가입 및 로그인
                        <br>
                        -메인 페이지 내 원하는 주소 입력
                        <br>
                        -입력된 주소를 확인하고 검색 버튼 클릭
                    </p>
                    <img class="l-fright" src="/images/sub/img_inform_rg01.png" alt="토지 등록 이미지">
                </div>
            </div>
            <div class="inform-wrap">
                <h3><i>2</i>등록 토지 위치 확인</h3>
                <div class="wrap clear">
                    <p class="txt l-fleft">
                    </p>
                    <img class="l-fright" src="/images/sub/img_inform_rg02.png" alt="토지 등록 이미지">
                </div>
            </div>
            <div class="inform-wrap">
                <h3><i>3</i>등록 토지 작성</h3>
                <div class="wrap clear">
                    <p class="txt l-fleft">
                        - 등록자 개인정보 입력
                        <br>
                        - 등록 토지정보 입력
                        <br>
                        - 참고 이미지 등록
                    </p>
                    <img class="l-fright" src="/images/sub/img_inform_rg03.png" alt="필지정보이미지">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn_close"></button>
    </div>
</div>
<div class="popup popup-service" data-popup="service_an01">
    <div class="dim"></div>
    <div class="container service-box bx-round_m">
        <div class="inner">
            <div class="title-wrap">
                <h2 class="title">전문 분석 대행</h2>
                <p class="desc">
                    등록된 토지를 중심으로 전문적인 분석을 받고 싶은 분들에게
                    <br>
                    국내 최고의 토지 전문가들이 1:1 상담을 해 드립니다.
                </p>
                <div class="img_area">
                    <img src="/images/sub/img_service04.png" alt="전문분석대행">
                </div>
            </div>
            <section class="pr-card-wrap clear">
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">전화 분석</h3>
                        <span class="price l-fright">30,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info">주소지 만으로 토지 등록</li>
                        <li class="info">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info on">전화를 통한 토지 전문 분석</li>
                        <li class="info">방문을 통한 심층 상담</li>
                        <li class="info">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_an_tel.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">방문 분석</h3>
                        <i class="tip-icon"></i>
                        <span class="tip">방문 분석시 최고의 분석 서비스를 제공합니다.</span>
                        <span class="price l-fright">200,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info">주소지 만으로 토지 등록</li>
                        <li class="info">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info">전화를 통한 토지 전문 분석</li>
                        <li class="info on">방문을 통한 심층 상담</li>
                        <li class="info on">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_an_visit.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">등록 + 전화 분석</h3>
                        <i class="tip-icon"></i>
                        <span class="tip">전화 분석시 최고의 분석 서비스를 제공합니다.</span>
                        <span class="price l-fright">160,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info on">주소지 만으로 토지 등록</li>
                        <li class="info on">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info on">전화를 통한 토지 전문 분석</li>
                        <li class="info">방문을 통한 심층 상담</li>
                        <li class="info">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_rg_tel.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">등록 + 방문 분석</h3>
                        <i class="tip-icon"></i>
                        <span class="tip">방문 분석시 최고의 분석 서비스를 제공합니다.</span>
                        <span class="price l-fright">320,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info on">주소지 만으로 토지 등록</li>
                        <li class="info on">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info on">전화를 통한 토지 전문 분석</li>
                        <li class="info on">방문을 통한 심층 상담</li>
                        <li class="info on">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_rg_visit.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
            </section>
            <p class="warn">
                <i class="icon"></i>
                모든 서비스는 업무일 기준 7일 이내에 처리 되며, 등록 또는 분석이 불가능하다고 판단되면 개별 안내 후 환불 처리 됩니다.
            </p>
        </div>
        <button type="button" class="btn btn_close"></button>
    </div>
</div>
<div class="popup popup-service" data-popup="service_rg01">
    <div class="dim"></div>
    <div class="container service-box bx-round_m">
        <div class="inner">
            <div class="title-wrap">
                <h2 class="title">등록 대행</h2>
                <p class="desc">
                    분석 받고 싶은 토지를
                    <br>
                    자세한 분석을 받기 위한 방법을 모르는 분들에게 최적의 콘텐츠로 등록해 드립니다.
                </p>
                <div class="img_area">
                    <img src="/images/sub/img_service02.png" alt="전문분석대행">
                </div>
            </div>
            <section class="pr-card-wrap clear">
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">등록</h3>
                        <span class="price l-fright">150,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info on">주소지만으로 토지 등록</li>
                        <li class="info on">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info">전화를 통한 토지 전문 분석</li>
                        <li class="info">방문을 통한 심층 상담</li>
                        <li class="info">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_rg.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">등록 + 전화 분석</h3>
                        <i class="tip-icon"></i>
                        <span class="tip">전화 분석시 최고의 분석 서비스를 제공합니다.</span>
                        <span class="price l-fright">160,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info on">주소지만으로 토지 등록</li>
                        <li class="info on">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info on">전화를 통한 토지 전문 분석</li>
                        <li class="info">방문을 통한 심층 상담</li>
                        <li class="info">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_rg_tel.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
                <article class="pr-card bx-round_s">
                    <div class="top clear">
                        <h3 class="tit l-fleft">기본 + 방문 분석</h3>
                        <i class="tip-icon"></i>
                        <span class="tip">방문 분석시 최고의 분석 서비스를 제공합니다.</span>
                        <span class="price l-fright">320,000원</span>
                    </div>
                    <ul class="info-wrap">
                        <li class="info on">주소지만으로 토지 등록</li>
                        <li class="info on">직접 등록 시 놓칠 수 있는 정보 등록</li>
                        <li class="info on">전화를 통한 토지 전문 분석</li>
                        <li class="info on">방문을 통한 심층 상담</li>
                        <li class="info on">현장에 대한 구체적인 정보 전달</li>
                    </ul>
                    <a href="/html/service/sub_pay_rg_visit.php" class="btn btn_pay bx-round_s bg_v">구매하기</a>
                </article>
            </section>
            <p class="warn">
                <i class="icon"></i>
                모든 서비스는 업무일 기준 7일 이내에 처리 되며, 등록 또는 분석이 불가능하다고 판단되면 개별 안내 후 환불 처리 됩니다.
            </p>
        </div>
        <button type="button" class="btn btn_close"></button>
    </div>
</div>
<div id="wrap" class="home">
    <header id="header" class="mobile">
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
                                    <a class="btn_pop bx-round_m" href="#none" data-popup="inform_register">토지 직접 등록</a>
                                </li>
                                <li class="item">
                                    <i class="icon icon_card"></i>
                                    <a class="bx-round_m btn_pop" href="#none" data-popup="service_rg01">토지 등록 대행</a>
                                </li>
                                <li class="item tit">분석</li>
                                <li class="item">
                                    <i class="icon icon_heart"></i>
                                    <a class="btn_pop bx-round_m" href="#none" data-popup="inform_analysis">토지 무료 분석</a>
                                </li>
                                <li class="item">
                                    <i class="icon icon_card"></i>
                                    <a class="bx-round_m btn_pop" href="#none" data-popup="service_an01">토지 전문 분석</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="main-visual">
            <div class="inner">
                <div class="slide-area">
                    <div class="slide-container l-box">
                        <ul class="slide-wrap center">
                            <li class="slide l-inline">
                                <a class="l-box bx-round_m" href="#">
                                    <img src="../upload/img_visual01.png" alt="추천토지" class="img_f">
                                    <span class="slide-num">
                                            <em class="num">4</em>
                                            <em class="nums">5</em>
                                        </span>
                                </a>
                            </li>
                            <li class="slide l-inline">
                                <a class="l-box bx-round_m" href="#">
                                    <img src="../upload/img_visual01.png" alt="추천토지" class="img_f">
                                    <span class="slide-num">
                                            <em class="num">5</em>
                                            <em class="nums">5</em>
                                        </span>
                                </a>
                            </li>
                            <li class="slide l-inline">
                                <a class="l-box bx-round_m" href="#">
                                    <img src="../upload/img_visual01.png" alt="추천토지" class="img_f">
                                    <span class="slide-num">
                                            <em class="num">1</em>
                                            <em class="nums">5</em>
                                        </span>
                                </a>
                            </li>
                            <li class="slide l-inline">
                                <a class="l-box bx-round_m" href="#">
                                    <img src="../upload/img_visual01.png" alt="추천토지" class="img_f">
                                    <span class="slide-num">
                                            <em class="num">2</em>
                                            <em class="nums">5</em>
                                        </span>
                                </a>
                            </li>
                            <li class="slide l-inline">
                                <a class="l-box bx-round_m" href="#">
                                    <img src="../upload/img_visual01.png" alt="추천토지" class="img_f">
                                    <span class="slide-num">
                                            <em class="num">3</em>
                                            <em class="nums">5</em>
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn_prev" type="button"></button>
                    <button class="btn btn_next" type="button"></button>
                </div>
                <div class="search-area">
                    <form  class="search-wrap ft_m_l" onsubmit="return false;">
                        <label for="addr" class="l-box">주소 입력만으로 토지를 등록해보세요!</label>
                        <div class="input-wrap l-inline bx-round_m">
                            <input type="text" id="rg_addr"  placeholder="도로명 또는 주소를 입력해보세요">
                        </div>
                        <button class="btn bx-round_m bg_v"  onclick="rg_search()">
                            <img class="icon" src="/images/main/icon_quicksearch_pencil.svg" alt="검색">
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="inner">
                    <section id="hSection01" class="mn-row01">
                        <div class="mn-title">
                            <h3 class="tit ft_m_l "><span class="mobile">마스터 추천 토지를 </span>확인해 보세요</h3>
                            <a href="/html/sub_list_master.php" class="btn btn_more">+ 더보기</a>
                        </div>
                        <div class="slide-wrap">
                            <div class="recomm-wrap clear">
                                <?php for ($x = 0; $x < 8; $x++) { ?>
                                    <div class="recomm-card mn-card bx-round_m">
                                        <a class="l-box"
                                           href="/html/sub_mp_item_detail.php?land_id=<?php echo $land_id_master[$x] ?>">
                                            <div class="card-img bx-round_m">
                                                <img src="<?php echo $land_main_image_master[$x] ?>" alt="토지">
                                                <div class="label-wrap img-label-wrap">
                                                    <span class="label label_01 l-inline bx-round_xs">마스터 추천</span>
                                                    <span class="label label_01 l-inline bx-round_xs">NEW</span>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <?php
                                                $land_address_master_array = explode(" ", $land_address_master[$x]);
                                                ?>
                                                <div class="label-wrap info-label-wrap">
                                                    <span class="label info-label  l-inline bx-round_xs"><?php echo $land_address_master_array[0] ?></span>
                                                    <span class="label info-label l-inline bx-round_xs"><?php echo $land_address_master_array[1] ?></span>
                                                </div>
<!--                                                <span class="info-price l-inline">-->
<!--                                        <em class="value">--><?php //echo number_format($land_register_price_master[$x]) ?><!--</em>-->
                                    </span>
                                                <span class="info-tit l-box"><?php echo mb_strimwidth($land_register_title_master[$x], '0', '50', '..', 'utf-8'); ?></span>
                                                <div class="info-wrap clear">
                                        <span class="info-size l-inline l-fleft">
                                            <em class="value"><?php echo number_format($land_register_area_master[$x]) ?></em>
                                            <em class="unit"> m<sup>2</sup></em>
                                        </span>
                                                    <span class="info-views l-inline l-fright">
                                            <em class="value"><?php echo number_format($land_click_master[$x]) ?></em>
                                        </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                    <section id="hSection02" class="mn-row02">
                        <h2 style="display: none">메인메뉴</h2>
                        <div class="menu-wrap clear">
                            <div class="col col01">
                                <div class="col-item col01-item bx-round_m bg_n">
                                    <span class="wrap l-box">
                                        <img src="/images/main/icon_hm_pencil.svg" alt="토지등록" class="icon">
                                        <span class="tit">토지 등록</span>
                                    </span>
                                </div>
                                <div class="col-item col01-item bx-round_m bg_n">
                                    <span class="wrap l-box">
                                        <img src="/images/main/icon_hm_magnifyGlass.svg" alt="토지분석" class="icon">
                                        <span class="tit">토지 분석</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col col02">
                                <div class="col-item col02-item">
                                    <div class="mn-menu bx-round_m">
                                        <a class="wrap l-box btn_pop" href="#none" data-popup="inform_register">
                                            <span class="tit">토지 직접 등록</span>
                                        </a>
                                    </div>
                                    <div class="mn-menu bx-round_m clear">
                                        <span class="wrap l-box">
                                           <span class="tit">토지 등록 대행</span>
                                           <a class="btn btn_pop bx-round_xs bg_v ft_m_s" href="#none" data-popup="service_rg01"><span class="pc">토지 등록 대행 </span>가격 보기</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-item col02-item">
                                    <div class="mn-menu bx-round_m">
                                        <a class="wrap l-box btn_pop" href="#none" data-popup="inform_analysis">
                                            <span class="tit">토지 무료 분석</span>
                                        </a>
                                    </div>
                                    <div class="mn-menu bx-round_m clear">
                                        <span class="wrap l-box">
                                           <span class="tit">토지 전문 분석</span>
                                           <a class="btn btn_pop bx-round_xs bg_v ft_m_s" href="#none" data-popup="service_an01"><span class="pc">토지 전문 분석 </span>가격 보기</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="hSection03" class="mn-row03">
                        <div class="mn-title">
                            <h3 class="tit  ft_m_l "><span class="mobile">새롭게 등록된 토지들을 </span>확인해 보세요</h3>
                            <a href="/html/sub_list.php" class="btn btn_more">+ 더보기</a>
                        </div>
                        <div class="latest-wrap clear">
                            <?php for ($x = 0; $x < 8; $x++) { ?>
                                <div class="latest-card mn-card bx-round_m">
                                    <a class="l-box"
                                       href="/html/sub_mp_item_detail.php?land_id=<?php echo $land_id_new[$x] ?>">
                                        <div class="card-img bx-round_m">
                                            <img src="<?php echo $land_main_image_new[$x] ?>" alt="토지">
                                            <div class="label-wrap img-label-wrap">
                                                <span class="label label_01 l-inline bx-round_xs">NEW</span>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <div class="label-wrap info-label-wrap">
                                                <?php
                                                $land_address_new_array = explode(" ", $land_address_new[$x]);
                                                ?>
                                                <span class="label info-label  l-inline bx-round_xs"><?php echo $land_address_new_array[0] ?></span>
                                                <span class="label info-label l-inline bx-round_xs"><?php echo $land_address_new_array[1] ?></span>
                                            </div>
<!--                                            <span class="info-price l-inline">-->
<!--                                        <em class="value">--><?php //echo number_format($land_register_price_new[$x]) ?><!--</em>-->
                                    </span>
                                            <span class="info-tit l-box"><?php echo mb_strimwidth($land_register_title_new[$x], '0', '50', '..', 'utf-8'); ?></span>
                                            <div class="info-wrap clear">
                                        <span class="info-size l-inline l-fleft">
                                            <em class="value"><?php echo number_format($land_register_area_new[$x]) ?></em>
                                            <em class="unit"> m<sup>2</sup></em>
                                        </span>
                                                <span class="info-views l-inline l-fright">
                                            <em class="value"><?php echo number_format($land_click_new[$x]) ?></em>
                                        </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <footer id="footer">
        <div class="container">
            <div class="inner">
                <div class="f-top">
                    <div class="inner">
                        <p class="row01 ft_b_s">최고의 토지 거래를 원하시나요?</p>
                        <p class="row02">랜드마킹의 토지 분석은<br>전국 최고 수준입니다.</p>
                        <a href="/html/land/sub_rg_search.php" class="row03 l-box bg_w bx-round_xs">토지 등록하기</a>
                    </div>
                </div>
                <div class="f-mid l-inline clear">
                    <div class="col02 l-inline">
                        <div class="f-util-wrap l-inline">
                            <p class="f-tit ft_b_s">서비스 소개</p>
                            <div class="l-slide-wrap">
                                <ul>

                                    <li><a class="btn_pop" href="#none"  data-popup="inform_register">토지 직접 등록</a></li>
                                    <li><a class="btn_pop" href="#none"  data-popup="service_rg01">토지 등록 대행</a></li>
                                    <li><a class="btn_pop" href="#none"  data-popup="inform_analysis">무료 분석</a></li>
                                    <li><a class="btn_pop" href="#none"  data-popup="service_an01">전문 분석</a></li>
                                    <li><a href="/html/sub_service.php#sTotal">종합 분석</a></li>
                                    <li><a href="/html/sub_service_map.php">오시는 길</a></li>
                                    <li><a href="/html/mypage/sub_notice.php">공지사항</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="f-util-wrap l-inline">
                            <p class="f-tit ft_b_s">토지</p>
                            <div class="l-slide-wrap">
                                <ul>
                                    <li><a href="/html/sub_list_master.php">마스터 추천 토지</a></li>
                                    <li><a href="/html/sub_list.php">등록된 토지</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="f-util-wrap l-inline">
                            <p class="f-tit ft_b_s">약관</p>
                            <div class="l-slide-wrap">
                                <ul>
                                    <li><a href="/html/sub_term.php">이용약관</a></li>
                                    <li><a href="../html/sub_privacy.php">개인정보처리방침</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f-btm">
                    <div class="inner">
                        <div class="info-wrap ft_m_m">
                            <p class="f-tit ft_b_s">주식회사 알에이에스</p>
                            <ul>
                                <li class="f-info">대표 : 최영준</li>
                                <li class="f-info l-inline">사업자등록번호 : 809-86-01924</li>
                                <li class="f-info l-inline bar">통신판매업 신고번호 : 제 2021-대구중구-0434 호</li>
                                <li class="f-info">주소 : (41951)대구광역시 중구 달구벌대로 2204, 2층 (대봉동)</li>
                                <li class="f-info l-inline">고객센터 : 053-269-5094</li>
                                <li class="f-info l-inline bar">contact@landmaster.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="f-copy-wrap clear">
                    <span class="copyright">&copy;LANDMARKING</span>
                    <span class="f-logo"><img src="/images/common/icon_foot_logo.svg" alt="토지"></span>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- SCRIPT -->
<!-- 메인 스크립트 삽입 -->
<script src="/js/main.js"></script>


<!-- 토지 등록 시 작동하는 네이버 지도 API 스크립트 -->
<script>
    //중단 검색 함수
    function rg_search() {
        var rg_addr = $("#rg_addr").val();
        if (rg_addr == '') {
            alert('도로명 또는 지번 주소를 입력해보세요');
        } else {
            searchAddressToCoordinate(rg_addr);
        }
    }

    //해당 지번 주소 검증 스크립트
    function searchAddressToCoordinate(address) {
        //랜드마킹 주소
        var land_url = '<?php echo $land_url;?>';
        naver.maps.Service.geocode({
            query: address
        }, function (status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                if (!address) {
                    return alert('Geocode Error, Please check address');
                }
                return alert('Geocode Error, address:' + address);
            }
            var htmlAddresses = [],
                item = response.v2.addresses[0];
            if (item) {
                point = new naver.maps.Point(item.x, item.y);
            }

            if (response.v2.meta.totalCount === 0) {
                return alert('도로명이나 지번주소를 정확히 입력해주세요');
            } else {
                //return alert(item.x+'/'+item.y);
                //지번주소로 get 전송

                if (item.jibunAddress) {
                    location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.jibunAddress + '&x=' + item.x + '&y=' + item.y;
                } else if (item.roadAddress) {
                    location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.roadAddress + '&x=' + item.x + '&y=' + item.y;
                } else {
                    alert('도로명이나 지번주소를 정확히 입력해주세요');
                }
                // if (item.englishAddress) {
                //     alert('도로명이나 지번주소를 정확히 입력해주세요');
                //     //htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
                // }
            }
        });
    }
</script>

</body>
</html>