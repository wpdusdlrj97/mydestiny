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


    $page = $_GET['page'];
    if (!$page) {
        $page = 0;
    }

    $qry_string = "SELECT * FROM land_information where land_register_id='$user_session' ORDER BY land_register_date DESC";


    $qry = mysqli_query($connect, $qry_string);
    $all_count = mysqli_num_rows($qry);

    //페이징을 위한 페이지 수 계산
    $page_count = (int)($all_count / 10);
    //현재 페이지에서 나열할 글 수
    $count = 0;

    if ($all_count - ($page * 10) >= 10) {
        $count = 10;
    } else {
        $count = $all_count - ($page * 10);
    }


    if ($all_count % 10 > 0) {
        $page_count++;
    }

    $qry_string = $qry_string . " LIMIT " . ($page * 10) . ", 10";
    $qry = mysqli_query($connect, $qry_string);


    $land_id = array();
    $land_address = array();
    $land_register_title = array();
    $land_register_date = array();
    $land_main_image = array();
    $land_free_analysis_status = array();
    $land_cost_analysis_status = array();

    while ($row = mysqli_fetch_array($qry)) {
        array_push($land_id, $row['land_id']);
        array_push($land_address, $row['land_address']);
        array_push($land_register_title, $row['land_register_title']);
        array_push($land_register_date, date('Y년 m월 d일', strtotime($row['land_register_date'])));
        array_push($land_main_image, $row['land_main_image']);
        array_push($land_free_analysis_status, $row['land_free_analysis_status']);
        array_push($land_cost_analysis_status, $row['land_cost_analysis_status']);


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
        <meta property="og:image" content="../../images/common/icon_logo01.png">
        <meta property="og:title" content="랜드마킹">
        <meta property="og:site_name" content="랜드마킹">
        <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
        <meta property="og:locale" content="ko_KR">
        <title>랜드마킹</title>
        <!-- FAVICON-->

        <!-- STYLE LINK-->
        <link rel="stylesheet" href="../../css/default.css">
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="../../css/common.css">
        <link rel="stylesheet" href="../../css/main.css">

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
        <!-- iamport.payment.js -->
        <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    </head>
    <body>
    <div class="popup popup-service small" id="service_an_small_popup">
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
                        <a class="btn btn_pay bx-round_s bg_v" onclick="an_visit()">구매하기</a>
                    </article>
                </section>
                <p class="warn">
                    <i class="icon"></i>
                    등록 또는 분석이 불가능하다고 판단되는 경우, 개별 안내 후 환불 처리 됩니다.
                </p>
            </div>
            <button type="button" class="btn btn_close" onclick="service_an_small_popup_close()"></button>
        </div>
    </div>
    <div id="popup"></div>
    <div id="wrap" class="sub mp_land">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <a href="/html/mypage/sub_mp_menu.php" class="tit ft_b">마이 페이지</a>
                                <a href="#" class="tit ft_b">내 토지</a>
                            </h2>
                            <a href="./sub_rg_search.php" class="btn btn_more bg_v bx-round_l">토지 등록하기</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="mylist-tab">
                            <div class="wrap clear">
                                <a class="tit_txt on" href="#">전체</a>
                                <a class="tit_txt" href="./sub_mp_list_free.php">무료 분석 완료</a>
                                <a class="tit_txt" href="./sub_mp_list_cost.php">전문 분석 완료</a>
                                <a class="tit_txt" href="./sub_mp_list_agent.php">등록 대행</a>
                                <span class="tit_cnt"></span>
                            </div>
                        </div>
                        <?php if ($count > 0) { ?>
                            <ul class="mylist">
                                <?php for ($x = 0; $x < $count; $x++) {

                                    if ($land_cost_analysis_status[$x] == '0') { // 전문분석을 신청하지 않은 경우

                                        if ($land_free_analysis_status[$x] == '0') { ?>
                                            <li class="bx-round_l">
                                                <a href="./sub_mp_item.php?land_id=<?php echo $land_id[$x];?>" class="inner">
                                                    <div class="wrap ">
                                                        <div class="item thumbnail bx-round_s">
                                                            <img src="<?php echo $land_main_image[$x] ?>"
                                                                 alt="land image"
                                                                 class="img_f">
                                                        </div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n"
                                                                  >무료 분석 대기중</span>
                                                            <i class="btn btn_more btn_pop bx-round_l bg_v"
                                                               onclick="service_an_small_popup('<?php echo $land_id[$x];?>','<?php echo $land_address[$x];?>')">전문
                                                                분석 요청하기</i>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $land_register_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                                    <div class="wrap">
                                                                <span class="addr"><span class="tit">주소지</span><span
                                                                            class="value"><?php echo $land_address[$x] ?></span></span>
                                                                    </div>
                                                                    <div class="wrap">
                                                                <span class="date"><span class="tit">등록</span><span
                                                                            class="value"><?php echo $land_register_date[$x] ?></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } else if ($land_free_analysis_status[$x] == '1') { ?>
                                            <li class="bx-round_l">
                                                <a href="./sub_mp_item.php?land_id=<?php echo $land_id[$x];?>" class="inner">
                                                    <div class="wrap ">
                                                        <div class="item thumbnail bx-round_s">
                                                            <img src="<?php echo $land_main_image[$x] ?>"
                                                                 alt="land image"
                                                                 class="img_f">
                                                        </div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">무료 분석 진행중</span>
                                                            <i class="btn btn_more btn_pop bx-round_l bg_v"
                                                               onclick="service_an_small_popup('<?php echo $land_id[$x];?>','<?php echo $land_address[$x];?>')">전문
                                                                분석 요청하기</i>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $land_register_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                                    <div class="wrap">
                                                                <span class="addr"><span class="tit">주소지</span><span
                                                                            class="value"><?php echo $land_address[$x] ?></span></span>
                                                                    </div>
                                                                    <div class="wrap">
                                                                <span class="date"><span class="tit">등록</span><span
                                                                            class="value"><?php echo $land_register_date[$x] ?></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } else if ($land_free_analysis_status[$x] == '2') { ?>
                                            <li class="bx-round_l analysized">
                                                <a href="./sub_mp_item.php?land_id=<?php echo $land_id[$x];?>" class="inner">
                                                    <div class="wrap ">
                                                        <div class="item thumbnail bx-round_s">
                                                            <img src="<?php echo $land_main_image[$x] ?>"
                                                                 alt="land image" class="img_f">
                                                        </div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">무료 분석 완료</span>
                                                            <i class="btn btn_more btn_pop bx-round_l bg_v"
                                                               onclick="service_an_small_popup('<?php echo $land_id[$x];?>','<?php echo $land_address[$x];?>')">전문
                                                                분석 요청하기</i>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $land_register_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                    <span class="wrap">
                                                        <span class="addr"><span class="tit">주소지</span><span
                                                                    class="value"><?php echo $land_address[$x] ?></span></span>
                                                    </span>
                                                                    <span class="wrap">
                                                        <span class="date"><span class="tit">등록</span><span
                                                                    class="value"><?php echo $land_register_date[$x] ?></span></span>
                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php }

                                    } else if($land_cost_analysis_status[$x] == '1'){ ?>
                                        <!-- 전문 분석 진행중 경우-->
                                        <li class="bx-round_l pro-analysized">
                                            <a href="./sub_mp_item.php?land_id=<?php echo $land_id[$x];?>" class="inner">
                                                <div class="wrap ">
                                                    <div class="item thumbnail bx-round_s">
                                                        <img src="<?php echo $land_main_image[$x] ?>" alt="land image"
                                                             class="img_f">
                                                    </div>
                                                    <div class="item btns l-inlinebox">
                                                        <span class="btn status l-inlinebox bx-round_l bg_n"></span>
                                                        <i class="btn btn_more bx-round_l bg_v" style="background-color: #0000001A">전문 분석 진행중입니다!</i>
                                                    </div>
                                                    <div class="item content l-inlinebox">
                                                        <div class="wrap">
                                                            <p class="title">
                                                                <span><?php echo $land_register_title[$x] ?></span>
                                                            </p>
                                                            <div class="infos">
                                                    <span class="wrap">
                                                        <span class="addr"><span class="tit">주소지</span><span
                                                                class="value"><?php echo $land_address[$x] ?></span></span>
                                                    </span>
                                                                <span class="wrap">
                                                        <span class="date"><span class="tit">등록</span><span
                                                                class="value"><?php echo $land_register_date[$x] ?></span></span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    <?php }else { ?>
                                        <!-- 전문 분석이 완료된 경우-->
                                        <li class="bx-round_l pro-analysized">
                                            <a href="./sub_mp_item.php?land_id=<?php echo $land_id[$x];?>" class="inner">
                                                <div class="wrap ">
                                                    <div class="item thumbnail bx-round_s">
                                                        <img src="<?php echo $land_main_image[$x] ?>" alt="land image"
                                                             class="img_f">
                                                    </div>
                                                    <div class="item btns l-inlinebox">
                                                        <span class="btn status l-inlinebox bx-round_l bg_n"></span>
                                                        <i class="btn btn_more bx-round_l bg_v">전문 분석을 받았습니다!</i>
                                                    </div>
                                                    <div class="item content l-inlinebox">
                                                        <div class="wrap">
                                                            <p class="title">
                                                                <span><?php echo $land_register_title[$x] ?></span>
                                                            </p>
                                                            <div class="infos">
                                                    <span class="wrap">
                                                        <span class="addr"><span class="tit">주소지</span><span
                                                                    class="value"><?php echo $land_address[$x] ?></span></span>
                                                    </span>
                                                                <span class="wrap">
                                                        <span class="date"><span class="tit">등록</span><span
                                                                    class="value"><?php echo $land_register_date[$x] ?></span></span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        <?php } else { ?>
                            <div style="margin-top:300px;width: 100%; height: 500px; font-size: 18px; text-align: center;">
                                등록한 토지가 없습니다
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="main-bottom">
                <div class="container">
                    <div class="inner clear">
                        <div class="pagination l-fleft">
                            <?php if ($page > 0) { ?>
                                <button class="btn btn_prev" type="button"
                                        onclick="location.href='sub_mp_list_all.php?page=<?php echo $page - 1 ?>'"></button>
                            <?php } ?>
                            <div class="wrap">
                                <?php
                                if ($all_count > 0) {
                                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                        if ($x == $page) { ?>
                                            <a class="btn bx-round_xs page_num on"
                                               onclick="location.href='sub_mp_list_all.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php } else { ?>
                                            <a class="btn bx-round_xs page_num"
                                               onclick="location.href='sub_mp_list_all.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php }
                                        if ($x + 1 == $page_count) {
                                            break;
                                        }
                                    }
                                } ?>
                            </div>
                            <?php if ($page + 1 != $page_count && $page_count > 0) { ?>
                                <button class="btn btn_next" type="button"
                                        onclick="location.href='sub_mp_list_all.php?page=<?php echo $page + 1 ?>'"></button>
                            <?php } ?>
                        </div>
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
        var land_address = '';
        var land_id = '';

        function service_an_small_popup(get_land_id,get_land_address) {
            land_id = get_land_id;
            land_address = get_land_address;
            $('#service_an_small_popup').css('display', 'block');
        }

        function service_an_small_popup_close() {
            $('#service_an_small_popup').css('display', 'none');
        }


        function an_tel() {

            //alert(land_id+"/"+land_address)

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

            //alert(land_id+"/"+land_address)

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


    </body>
    </html>
<?php } ?>