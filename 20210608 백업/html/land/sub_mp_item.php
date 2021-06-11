<?php
//마이 페이지 - 토지목록 - 전체
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {

    $qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
    $qry_user = mysqli_query($connect, $qry_string_user);
    $row_user = mysqli_fetch_array($qry_user);
    $total_row_user = mysqli_num_rows($qry_user);

    //토지 아이디로 정보 조회
    $land_id = $_GET['land_id'];
    $qry_string_land = "SELECT * FROM land_information where land_id='$land_id'";
    $qry_land = mysqli_query($connect, $qry_string_land);
    $row_land = mysqli_fetch_array($qry_land);
    //차트 정보 조회
    $qry_string_chart = "SELECT * FROM chart_information where land_id='$land_id'";
    $qry_chart = mysqli_query($connect, $qry_string_chart);
    $row_chart = mysqli_fetch_array($qry_chart);

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
        <meta property="og:image" content="../../images/common/icon_logo01.png">
        <meta property="og:title" content="랜드마킹">
        <meta property="og:site_name" content="랜드마킹">
        <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
        <meta property="og:locale" content="ko_KR">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>랜드마킹</title>
        <!-- FAVICON-->

        <!-- STYLE LINK-->
        <link rel="stylesheet" href="../../css/default.css">
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="../../css/common.css">
        <link rel="stylesheet" href="../../css/main.css">
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
        <!-- SCRIPT -->
        <script src="../../js/lib/jquery-3.6.0.min.js"></script>
        <!--[if lte IE 9]>
        <script src="../../js/lib/IE9.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="../../js/lib/html5shiv.min.js"></script>
        <script src="../../js/lib/jqPIE.js"></script>
        <script src="../../js/lib/PIE.js"></script>
        <![endif]-->
        <script type="text/javascript"
                src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ewzw7q7mjs&submodules=geocoder"></script>
        <!-- iamport.payment.js -->
        <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    </head>
    <body>
    <div class="popup popup-service small" data-popup="service_an_small">
        <div class="dim"></div>
        <div class="container service-box bx-round_m">
            <div class="inner">
                <div class="title-wrap">
                    <h2 class="title">전문 분석</h2>
                    <p class="desc">
                        등록된 토지를 중심으로 전문적인 분석을 받고 싶은 분들에게
                        <br>
                        국내 최고의 토지 전문가들이 1:1 상담을 해 드립니다.
                    </p>
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
                        <a class="btn btn_pay bx-round_s bg_v" onclick="an_tel()">구매하기</a>
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
                        <a  class="btn btn_pay bx-round_s bg_v" onclick="an_visit()">구매하기</a>
                    </article>
                </section>
                <p class="warn">
                    <i class="icon"></i>
                    등록 또는 분석이 불가능하다고 판단되는 경우, 개별 안내 후 환불 처리 됩니다.
                </p>
            </div>
            <button type="button" class="btn btn_close"></button>
        </div>
    </div>
    <div class="popup popup-inform" data-popup="inform_use">
        <div class="dim"></div>
        <div class="container bx-round_m">
            <div class="inner">
                <div class="title-wrap">
                    <h2 class="title">토지 이용 계획 열람</h2>
                    <p class="desc">
                        -토지이용계획은 특정 필지의 지역지구 지정현황, 행위제한내용(관련 법령)을 열람하실 수 있습니다.
                        <br>
                        -또한 복잡한 토지이용규제 내용을 분석하여 보기 편리하게 구축한 [행위제한내용 분석결과] 서비스가 있습니다.
                    </p>
                </div>
                <div class="inform-wrap">
                    <h3><i>1</i>열람하고자 하는 필지의 지번 조회</h3>
                    <div class="wrap clear">
                        <p class="txt l-fleft">
                            -필지의 지번 또는 도로명 검색
                            <br>
                            -대상 필지의 지번을 선택하여 입력
                            <br>
                            -지도를 확인하면 조회대상 필지 선택
                        </p>
                        <img class="l-fright" src="/images/sub/img_use_inform01.png" alt="지번조회이미지">
                    </div>
                </div>
                <div class="inform-wrap">
                    <h3><i>2</i>필지 기본 정보 및 지역, 지구 지정 현황</h3>
                    <div class="wrap clear">
                        <p class="txt l-fleft">
                            - 필지의 지목, 면적 및 공시지가 조회
                            <br>
                            - 지역·지구 지정현황 조회
                            <br>
                            - 10년간 개별공시지가 변동 내역 조회
                        </p>
                        <img class="l-fright" src="/images/sub/img_use_inform02.png" alt="필지정보이미지">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn_close"></button>
        </div>
    </div>
    <div class="popup popup-zoom hide" data-popup="zoomSlide">
        <div class="dim"></div>
        <div class="container">
            <div class="inner">
                <div class="slide-container">
                    <ul class="slide-wrap clear">
                        <li class="slide">
                            <img src="<?php echo $row_land['land_main_image'] ?>" alt="토지">
                            <span class="slide-num bg_v bx-round_l"></span>
                        </li>
                        <?php if ($row_land['land_sub_image_list'] == null) {

                        } else { ?>
                            <?php $land_sub_image_list_array = json_decode($row_land['land_sub_image_list']);

                            for ($i = 0; $i < count($land_sub_image_list_array); $i++) {
                                ?>
                                <li class="slide">
                                    <img src="<?php echo $land_sub_image_list_array[$i] ?>" alt="토지">
                                    <span class="slide-num bg_v bx-round_l">
                                <em class="num"></em>&nbsp;/&nbsp;<em class="nums"></em>
                            </span>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
                <?php if ($row_land['land_sub_image_list'] == null) {

                } else { ?>
                    <button class="btn btn_prev" type="button"></button>
                    <button class="btn btn_next" type="button"></button>
                <?php } ?>

                <button class="btn btn_close"></button>
            </div>
        </div>
    </div>
    <div id="popup"></div>
    <div id="wrap" class="sub mp-item">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_user bx-round_l bg_n"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <span class="tit ft_b">마이 페이지</span>
                                <span class="tit ft_b">내 토지</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <a href="/html/land/sub_mp_list_all.php" class="btn btn_prev ft_m_l">목록으로 돌아가기</a>
                        <div class="an-card">
                            <div class="row01 clear">
                                <div class="thumbnail l-inline bx-round_l">
                                    <img src="<?php echo $row_land['land_main_image'] ?>" class="img_f" alt="썸네일">
                                    <?php if ($row_land['land_free_analysis_status'] == 0) { ?>
                                    <span class="btn status_b bx-round_l bg_w">
                                            <span class="ft_m_m">무료 분석 대기중</span>
                                         <?php } else if ($row_land['land_free_analysis_status'] == 1) { ?>
                                             <span class="btn status_b bx-round_l bg_w">
                                             <span class="ft_m_m">무료 분석 진행중</span>
                                         <?php } else if ($row_land['land_free_analysis_status'] == 2) { ?>
                                             <span class="btn status_p bx-round_l bg_w">
                                             <span class="ft_m_m">무료 분석 완료</span>
                                        <?php } ?>
                                    </span>
                                    <a class="zoom btn_pop" href="#none" data-popup="zoomSlide"><span>확대보기</span></a>
                                </div>
                                <div class="info l-inline">
                                    <div class="info-btns clear">
                                        <?php if ($row_land['land_cost_analysis_status'] == 0) { ?>
                                            <a href="#none" class="btn btn_pro btn_pop bx-round_l ft_m_m"
                                               data-popup="service_an_small">전문 분석 요청하기</a>
                                        <?php } else if ($row_land['land_cost_analysis_status'] == 1) { ?>
                                            <a href="#none" class="btn btn_pro btn_pop bx-round_l ft_m_m">전문 분석 진행 중</a>
                                        <?php } else if ($row_land['land_cost_analysis_status'] == 2) { ?>
                                            <i class="icon_pro bx-round_l"></i>
                                            <span class="btn btn_pro bx-round_l ft_m_m">전문 분석을 받았습니다!</span>
                                        <?php } ?>

                                        <?php if ($row_land['land_cost_analysis_status'] == 0) { ?>
                                            <?php if ($row_land['land_free_analysis_status'] == 0) { ?>
                                                <a href="/html/land/sub_rg_form_modify.php?land_id=<?php echo $row_land['land_id'] ?>"
                                                   class="btn btn_md bx-round_l ft_m_m">수정하기</a>
                                            <?php } else if ($row_land['land_free_analysis_status'] == 1) { ?>
                                                <span class="status ft_m_m">무료분석 중입니다.</span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <h3 class="info-tit">
                                        <span><?php echo $row_land['land_register_title'] ?></span>
                                    </h3>
                                    <ul class="info-meta">
                                        <li class="addr">
                                            <span class="wrap">
                                                <em class="tit icon_nav">지번주소</em>
                                                <em class="value"><?php echo $row_land['land_address'] ?></em>
                                            </span>
                                        <li>
                                        <li class="size">
                                            <span class="wrap">
                                                <em class="tit icon_corner">면적</em>
                                                <em class="value"><?php echo number_format($row_land['land_register_area']) ?><i
                                                            class="unit">&nbsp;m<sup>2</sup></i></em>
                                            </span>
                                        <li>
<!--                                        <li class="price">-->
<!--                                            <span class="wrap">-->
<!--                                                <em class="tit icon_tag">공시지가</em>-->
<!--                                                <em class="value"><i-->
<!--                                                            class="unit">&#8361;&nbsp;</i>--><?php //echo number_format($row_land['land_register_price']) ?><!--</em>-->
<!--                                            </span>-->
<!--                                        </li>-->
                                        <li class="tel">
                                            <span class="wrap">
                                                <em class="tit icon_chat">연락처</em>
                                                <em class="value"><?php
                                                    //전화번호 양식
                                                    function format_phone($phone)
                                                    {
                                                        $phone = preg_replace("/[^0-9]/", "", $phone);
                                                        $length = strlen($phone);

                                                        switch ($length) {
                                                            case 11 :
                                                                return preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $phone);
                                                                break;
                                                            case 10:
                                                                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
                                                                break;
                                                            default :
                                                                return $phone;
                                                                break;
                                                        }
                                                    }

                                                    echo $row_land['land_register_name'] . " " . format_phone($row_land['land_register_phone']) ?></em>
                                            </span>
                                        </li>
                                        <li class="date">
                                            <span class="wrap">
                                                <em class="tit icon_calendar">작성일시</em>
                                                <em class="value"><?php echo date('Y년 m월 d일', strtotime($row_land['land_register_date'])) ?></em>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <?php if ($row_land['land_sub_image_list'] == null) {

                            } else { ?>
                                <div class="row02">
                                    <div class="imgs">
                                        <ul class="slide-wrap">

                                            <?php $land_sub_image_list_array = json_decode($row_land['land_sub_image_list']);

                                            for ($i = 0; $i < count($land_sub_image_list_array); $i++) {
                                                ?>
                                                <li class="slide l-inline bx-round_l">
                                                    <img src="<?php echo $land_sub_image_list_array[$i] ?>"
                                                         class="img_f" alt="토지이미지">
                                                    <a class="zoom btn_pop" href="#none"
                                                       data-popup="zoomSlide"><span>확대보기</span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!--  무료 토지 분석 완료 -->
                        <?php if ($row_land['land_free_analysis_status'] == 2) { ?>
                            <section class="an-charts">
                                <div class="inform clea bx-round_l bg_n">
                                    <span class="tit">랜드마킹의 무료분석을 확인해보세요</span>
                                    <div class="wrap l-fright">
                                        <span class="bx-round_xs">숫자가 높을 수록 좋습니다</span>
                                        <span class="bx-round_xs">숫자가 높을 수록 좋습니다</span>
                                        <span class="bx-round_xs">숫자가 높을 수록 좋습니다</span>
                                    </div>
                                </div>
                                <div class="charts claer">
                                    <article class="chart chart01 l-inline bx-round_l bg_n">
                                        <div class="inner">
                                            <h3 class="title bx-round_s bg_ch">가치분석</h3>
                                            <div class="canvas">
                                                <canvas id="chart01"></canvas>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="chart chart02 l-inline l-fright bx-round_l bg_n">
                                        <div class="inner">
                                            <h3 class="title bx-round_s bg_ch">개발축 분석</h3>
                                            <div class="canvas">
                                                <canvas id="chart02"></canvas>
                                            </div>
                                            <ul class="labels claer">
                                                <li class="label">
                                                    <div class="top clar">
                                                        <span class="bx-round_s bg_ch">기간</span>
                                                        <span class="bx-round_s bg_ch">수익</span>
                                                    </div>
                                                    <div class="btm">
                                                        <span class="tit bx-round_s">개발축</span>
                                                        <span class="meta bx-round_s"><strong>개발축이란?</strong>개발축은 -을 의미합니다</span>
                                                    </div>
                                                </li>
                                                <li class="label">
                                                    <div class="top clar">
                                                        <span class="bx-round_s bg_ch">기간</span>
                                                        <span class="bx-round_s bg_ch">수익</span>
                                                    </div>
                                                    <div class="btm bx-round_s">
                                                        <span class="tit  bx-round_s">보조축</span>
                                                        <span class="meta  bx-round_s"><strong>개발축이란?</strong>개발축은 -을 의미합니다</span>
                                                    </div>
                                                </li>
                                                <li class="label">
                                                    <div class="top clear">
                                                        <span class="bx-round_s bg_ch">기간</span>
                                                        <span class="bx-round_s bg_ch">수익</span>
                                                    </div>
                                                    <div class="btm bx-round_s">
                                                        <span class="tit bx-round_s">보전축</span>
                                                        <span class="meta  bx-round_s"><strong>개발축이란?</strong>개발축은 -을 의미합니다</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </article>
                                </div>
                            </section>
                            <section class="rg-datas">
                                <div id="map" class="map bx-round_l bg_g" style="width: 100%; height: 500px;">
                                    map 영역입니다.
                                </div>
                                <div class="txt-wrap">
                                    <p class="txt">
                                        <?php echo $row_land['land_register_content']?>
                                    </p>
                                </div>
                            </section>
                            <script src="../../js/chart.js"></script>
                            <!--  무료 토지 분석 대기, 진행중 -->
                        <?php }else{ ?>
                            <div class="an-inform bx-round_l bg_g">
                                <div class="wrap">
                                    <i class="icon"></i>
                                    <p class="pc">무료 등록 중입니다. 무료 등록은 관리자가 순차적으로 해 드립니다.</p>
                                    <p class="mobile">관리자가 순차적으로 무료 분석을 해 드립니다.</p>
                                </div>
                            </div>
                            <section class="rg-datas">
                                <div id="map" class="map bx-round_l bg_g" style="width: 100%; height: 500px;">
                                    map 영역입니다.
                                </div>
                                <div class="link-wrap clear">
                                    <a href="https://www.eum.go.kr/web/am/amMain.jsp" class="btn_link l-fleft bx-round_l bg_g">토지 이음 바로 가기</a>
                                    <a href="#none" class="btn_more btn_pop l-fright bx-round_l bg_g" data-popup="inform_use">토지 이음에서 봐야 하는 정보 자세히 보기</a>
                                </div>
                                <div class="txt-wrap">
                                    <p class="txt">
                                        <?php echo $row_land['land_register_content']?>
                                    </p>
                                </div>
                            </section>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </main>
        <footer id="footer"></footer>
    </div>
    <!-- script -->
    <script src="/js/main.js"></script>
    <!-- 팝업,헤더,푸터 삽입 스크립트 -->
    <script>
        $("#header").load("/html/_header.php");
        $("#footer").load("/html/_footer.php");
        $("#popup").load("/html/_popup.php");
    </script>


    <script>

        IMP.init('imp33197231');

        var pg_radio = 'card';
        var merchant_uid = '';
        var service_type = '';
        var service_price = '';
        var user_email = '<?php echo $row_user['user_email']?>';
        var user_name = '<?php echo $row_user['user_name']?>';
        var user_phone = '<?php echo $row_user['user_phone']?>';
        var user_phone_dash = user_phone.substr(0, 3) + "-" + user_phone.substr(3, 4) + "-" + user_phone.substr(7,4);
        var land_address = '<?php echo $row_land['land_address']?>';
        var land_id = '<?php echo $row_land['land_id']?>';


        function an_tel() {

            merchant_uid = 'merchant_an_tel' + new Date().getTime();
            service_type = '1';
            service_price = 30000;

            IMP.request_pay({
                pg : 'inicis', //ActiveX 결제창은 inicis를 사용
                pay_method : pg_radio, //card(신용카드), trans(실시간계좌이체), vbank(가상계좌), phone(휴대폰소액결제)
                merchant_uid : merchant_uid, //상점에서 관리하시는 고유 주문번호를 전달
                name : '랜드마킹 : 전화분석',
                amount : service_price,
                buyer_email : user_email,
                buyer_name : user_name,
                buyer_tel : user_phone_dash, //누락되면 이니시스 결제창에서 오류
                m_redirect_url: "https://landmarking.co.kr/server/pay_server_mobile.php?pg_pay_id="+merchant_uid+"&pg_service_type="+service_type+"&pg_pay_type="+pg_radio
                    +"&pg_service_price="+service_price+"&pg_user_email="+user_email+"&pg_user_name="+user_name+"&pg_user_phone="+user_phone+"&pg_land_id="+land_id
                    +"&pg_land_address="+land_address
            }, function(rsp) {
                if ( rsp.success ) {

                    var msg = '결제가 완료되었습니다.';
                    msg += '\n고유ID : ' + rsp.imp_uid;
                    msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                    msg += '\n결제 금액 : ' + rsp.paid_amount+'원';
                    alert(msg);

                    $.ajax({
                        type: "POST"
                        ,url: "/server/pay_server.php"
                        ,data: {pg_pay_id:merchant_uid,pg_service_type:service_type,pg_pay_type:pg_radio,pg_service_price:service_price,pg_user_email:user_email
                            ,pg_user_name:user_name,pg_user_phone:user_phone,pg_land_id:land_id,pg_land_address:land_address}
                        ,success:function(result){
                            if(result=='success'){
                                location.href="https://landmarking.co.kr/html/sub_mp_paid.php?merchant_uid="+merchant_uid;
                            }else{
                                alert("결제 상품 요청에 실패하였습니다, 환불 요청 문의해주세요");
                            }
                        }
                        ,error:function(){
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });


                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;

                    alert(msg);
                }
            });

        }

        function an_visit() {

            merchant_uid = 'merchant_an_visit' + new Date().getTime();
            service_type = '2';
            service_price = 200000;

            IMP.request_pay({
                pg : 'inicis', //ActiveX 결제창은 inicis를 사용
                pay_method : pg_radio, //card(신용카드), trans(실시간계좌이체), vbank(가상계좌), phone(휴대폰소액결제)
                merchant_uid : merchant_uid, //상점에서 관리하시는 고유 주문번호를 전달
                name : '랜드마킹 : 방문분석',
                amount : service_price,
                buyer_email : user_email,
                buyer_name : user_name,
                buyer_tel : user_phone_dash, //누락되면 이니시스 결제창에서 오류
                m_redirect_url: "https://landmarking.co.kr/server/pay_server_mobile.php?pg_pay_id="+merchant_uid+"&pg_service_type="+service_type+"&pg_pay_type="+pg_radio
                    +"&pg_service_price="+service_price+"&pg_user_email="+user_email+"&pg_user_name="+user_name+"&pg_user_phone="+user_phone+"&pg_land_id="+land_id
                    +"&pg_land_address="+land_address
            }, function(rsp) {
                if ( rsp.success ) {

                    var msg = '결제가 완료되었습니다.';
                    msg += '\n고유ID : ' + rsp.imp_uid;
                    msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                    msg += '\n결제 금액 : ' + rsp.paid_amount+'원';
                    alert(msg);

                    $.ajax({
                        type: "POST"
                        ,url: "/server/pay_server.php"
                        ,data: {pg_pay_id:merchant_uid,pg_service_type:service_type,pg_pay_type:pg_radio,pg_service_price:service_price,pg_user_email:user_email
                            ,pg_user_name:user_name,pg_user_phone:user_phone,pg_land_id:land_id,pg_land_address:land_address}
                        ,success:function(result){
                            if(result=='success'){
                                location.href="https://landmarking.co.kr/html/sub_mp_paid.php?merchant_uid="+merchant_uid;
                            }else{
                                alert("결제 상품 요청에 실패하였습니다, 환불 요청 문의해주세요");
                            }
                        }
                        ,error:function(){
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });


                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;

                    alert(msg);
                }
            });

        }

    </script>
    
    <!-- 네이버 지도 API 자바스크립트-->
    <script>
        var latlng_x = '<?php echo $row_land['land_x']?>';
        var latlng_y = '<?php echo $row_land['land_y']?>';

        var map = new naver.maps.Map('map', {
            useStyleMap: true,
            zoom: 18,
            center: new naver.maps.LatLng(latlng_y, latlng_x),
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: naver.maps.MapTypeControlStyle.DROPDOWN
            }
        });

        function startCadastralLayer() {
            var cadastralLayer = new naver.maps.CadastralLayer({useStyleMap: true});

            var btn = $('#cadastral');

            naver.maps.Event.addListener(map, 'cadastralLayer_changed', function (cadastralLayer) {
                if (cadastralLayer.getMap()) {
                    btn.addClass('control-on').val('지적도 끄기');
                } else {
                    btn.removeClass('control-on').val('지적도 켜기');
                }
            });

            cadastralLayer.setMap(map);

            btn.on('click', function (e) {
                e.preventDefault();

                if (cadastralLayer.getMap()) {
                    cadastralLayer.setMap(null);
                    btn.removeClass('control-on').val('지적도 켜기');
                } else {
                    cadastralLayer.setMap(map);
                    btn.addClass('control-on').val('지적도 끄기');
                }
            });
        }

        naver.maps.Event.once(map, 'init_stylemap', startCadastralLayer);
    </script>

    <script>
        ////입력 데이터 샘플
        //var dataSet = {
        //    가치분석 : {
        //        '개발가능성': <?php //echo $row_chart['value_1']?>//,
        //        '경사완만': <?php //echo $row_chart['value_2']?>//,
        //        '인구유입률': <?php //echo $row_chart['value_3']?>//,
        //        '개발호재': <?php //echo $row_chart['value_4']?>//,
        //        '도로유무': <?php //echo $row_chart['value_5']?>
        //    },
        //    개발축: {
        //        '기간': <?php //echo $row_chart['dev_1']?>//,
        //        '수익': <?php //echo $row_chart['dev_2']?>
        //    },
        //    보조축: {
        //        '기간': <?php //echo $row_chart['sub_1']?>//,
        //        '수익': <?php //echo $row_chart['sub_2']?>
        //    },
        //    보전축: {
        //        '기간': <?php //echo $row_chart['pre_1']?>//,
        //        '수익': <?php //echo $row_chart['pre_2']?>
        //    }
        //};
        //
        ////가치분석 데이터 고르기
        //var setData01 = function(dataSet){
        //    var dataSet = dataSet;
        //    var values = [];
        //    var key = '가치분석';
        //    var value = 0;
        //
        //    var target = dataSet[key];
        //    for( item in target){
        //        value = target[item];
        //        values.push(value);
        //    };
        //    return values;
        //};
        //
        ////축분석 데이터 고르기
        //var setData02 = function(dataSet){
        //    var dataSet = dataSet;
        //    var labeledValues = {
        //        '기간': [],
        //        '수익': []
        //    };
        //    var keys = ['개발축', '보조축', '보전축'];
        //    var labels = ['기간', '수익'];
        //
        //    keys.forEach(function(item){
        //        var target = dataSet[item];
        //        labels.forEach(function(label, idx){
        //            if(idx === 0) labeledValues[label].push(target[label]);
        //            else labeledValues[label].push(target[label]);
        //        })
        //    })
        //
        //    return labeledValues;
        //};
        //
        //var initChart01 = function(datas){
        //    var data = datas;
        //
        //    var pointRadius = $(window).innerWidth() > 480 ? 18 : 10;
        //    var pointFontSize = $(window).innerWidth() > 480 ? 15 : 13;
        //    var labelFontSize = $(window).innerWidth() > 480 ? 20 : 15;
        //
        //    var config = {
        //        type: 'radar',
        //        data : {
        //            labels: ['개발가능성', '경사완만', '인구유입률', '개발호재', '도로유무'],
        //            datasets: [{
        //                label: '점수',
        //                data: data,
        //                fill: true,
        //                backgroundColor: 'rgba(120, 104, 230, 0.5)',
        //                borderColor: '#7868e6',
        //                borderWidth: 4,
        //                pointBackgroundColor: '#7868e6',
        //                pointBorderColor: '#7868e6',
        //                pointRadius: pointRadius,
        //                pointHoverRadius: 18,
        //                pointHoverBorderColor: '#7868e6',
        //                datalabels: {
        //                    color: '#fff',
        //                    labels: {
        //                        title: {
        //                            font: {
        //                                size: pointFontSize,
        //                                weight: '800'
        //                            }
        //                        }
        //                    }
        //                }
        //            }]
        //        },
        //        options: {
        //            responsive: true,
        //            maintainAspectRatio: false,
        //            scale: {
        //                ticks: {
        //                    min: 0,
        //                    max: 11,
        //                    stepSize: 1,
        //                    backdropColor: 'transparent',
        //                    fontColor: 'rgba(255,255,255,.7)',
        //                    fontSize: 0,
        //                    padding: 0,
        //                },
        //                angleLines: {
        //                    color: 'transparent'
        //                },
        //                gridLines: {
        //                    color: ['rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
        //                        ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
        //                        ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
        //                        ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
        //                        ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
        //                        ,'transparent']
        //                },
        //                pointLabels: {
        //                    fontColor: '#fff',
        //                    fontSize: labelFontSize,
        //                    fontFamily: 'GmarketSansMedium',
        //                    borderWidth: 10,
        //                }
        //            },
        //            legend: {
        //                display: false,
        //            },
        //        }
        //    };
        //    var chart01 =   new Chart(document.getElementById('chart01'), config);
        //};
        //
        //var initChart02 = function(datas){
        //    var data = datas;
        //
        //    var borderWidth = $(window).innerWidth() > 480 ? 12 : 4;
        //    var barPercentage = ( $(window).innerWidth() <= 980 && $(window).innerWidth() > 480)? 0.1 : 0.15;
        //
        //    var config = {
        //        type: 'bar',
        //        data: {
        //            labels: ['개발축', '보조축', '보전축'],
        //            borderColor: '#fff',
        //            datasets: [
        //                {
        //                    labels: '기간',
        //                    data: data['기간'],
        //                    backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
        //                    datalabels: {
        //                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
        //                        borderColor: ['#7868e6','#23dc7a','#ff5555']
        //                    },
        //                },
        //                {
        //                    labels: '수익',
        //                    data: data['수익'],
        //                    backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
        //                    datalabels: {
        //                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
        //                        borderColor: ['#7868e6','#23dc7a','#ff5555']
        //                    }
        //                }
        //            ],
        //
        //        },
        //        options: {
        //            responsive: true,
        //            maintainAspectRatio: false,
        //            layout: {
        //                padding: {
        //                    left: -180 //y축 tick hide
        //                }
        //            },
        //            scales: {
        //                xAxes: [
        //                    {
        //                        display: false,
        //                        categoryPercentage: 1.0,
        //                        barPercentage: barPercentage
        //                    }
        //                ],
        //                yAxes:[
        //                    {   //display: false,
        //                        ticks: {
        //                            min: 0,
        //                            max: 13,
        //                            stepSize: 1,
        //                            fontSize: 0,
        //                            mirror: true
        //                        },
        //
        //                    },{
        //                        gridLines:{
        //                            color: ['rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
        //                                ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
        //                                ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
        //                                ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
        //                                ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
        //                                ,'transparent', 'transparent', 'transparent']
        //                        }
        //                    }
        //                ],
        //
        //            },
        //            legend: {
        //                display: false,
        //            },
        //            plugins: {
        //                datalabels: {
        //                    display: true,
        //                    anchor: 'end',
        //                    align: 'end',
        //                    offset: -2,
        //                    borderWidth: borderWidth,
        //                    formatter: function(value, context){
        //                        //박스 스타일 조정위해 공백 삽입
        //                        if(value<10) return ' ' + value + ' ';
        //                    },
        //                    borderRadius: 30,
        //                    color: '#fff',
        //                    font: {
        //                        size: 15,
        //                        weight: '600',
        //                        lineHeight: '14px'
        //                    }
        //                }
        //            }
        //        }
        //    };
        //    var chart02 = new Chart(document.getElementById('chart02'), config);
        //};
        //
        //
        //$(window).on('load', function(event) {
        //    event.preventDefault();
        //    //차트 생성
        //    initChart01(setData01(dataSet));
        //    initChart02(setData02(dataSet));
        //});

    </script>
    </body>
    </html>
<?php } ?>