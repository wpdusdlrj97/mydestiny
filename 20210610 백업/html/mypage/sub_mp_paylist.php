<?php
//마이 페이지 - 문의목록 - 전체
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

    $qry_string = "SELECT * FROM pay_information where buyer_id='$user_session' ORDER BY pay_date DESC";
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


    $pay_id = array();
    $land_id = array();
    $service_type = array();
    $pay_status = array();
    $pay_price = array();
    $land_address = array();
    $pay_date = array();

    while ($row = mysqli_fetch_array($qry)) {
        array_push($pay_id, $row['pay_id']);
        array_push($land_id, $row['land_id']);
        array_push($service_type, $row['service_type']);
        array_push($pay_status, $row['pay_status']);
        array_push($pay_price, $row['pay_price']);
        array_push($land_address, $row['land_address']);
        array_push($pay_date, date('Y년 m월 d일', strtotime($row['pay_date'])));
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
    </head>
    <body>
    <div id="popup"></div>
    <div id="wrap" class="sub mp_pay">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_receipt bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <a href="#" class="tit ft_b">결제내역</a>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <?php if ($count > 0) { ?>
                            <ul class="mylist">

                                <?php for ($x = 0;
                                           $x < $count;
                                           $x++) {


                                    if ($pay_status[$x] == 0) { //결제 완료  ?>
                                        <li class="bx-round_l paid">

                                    <?php } else if ($pay_status[$x] == 1) { //환불 요청 ?>
                                        <li class="bx-round_l">

                                    <?php } else if ($pay_status[$x] == 2) { //환불 완료 ?>
                                        <li class="bx-round_l">

                                    <?php } ?>
                                    <a href="/html/sub_mp_paid.php?merchant_uid=<?php echo $pay_id[$x]?>" class="inner">
                                        <div class="wrap ">
                                            <div class="item thumbnail bx-round_s">



                                                <img src="<?php

                                                $qry_string_land_image = "SELECT * FROM land_information where land_id='$land_id[$x]'";
                                                $qry_land_image = mysqli_query($connect, $qry_string_land_image);
                                                $row_land_image = mysqli_fetch_array($qry_land_image);

                                                echo $row_land_image['land_main_image'];

                                                ?>" alt="land image"
                                                     class="img_f">
                                            </div>
                                            <div class="item btns l-inlinebox">
                                                <?php if ($service_type[$x] == 0) { ?>
                                                    <span class="btn status l-inlinebox bx-round_l bg_n">토지 등록 대행</span>
                                                <?php } else if ($service_type[$x] == 1) { ?>
                                                    <span class="btn status l-inlinebox bx-round_l bg_n">전문 전화 분석</span>
                                                <?php } else if ($service_type[$x] == 2) { ?>
                                                    <span class="btn status l-inlinebox bx-round_l bg_n">전문 방문 분석</span>
                                                <?php } else if ($service_type[$x] == 3) { ?>
                                                    <span class="btn status l-inlinebox bx-round_l bg_n">등록 + 전화 분석</span>
                                                <?php } else if ($service_type[$x] == 4) { ?>
                                                    <span class="btn status l-inlinebox bx-round_l bg_n">등록 + 방문 분석</span>
                                                <?php } ?>

                                                <?php if ($pay_status[$x] == 0) { //결제 완료  ?>
                                                    <span class="btn paid l-inlinebox bx-round_l bg_n">결제완료</span>
                                                <?php } else if ($pay_status[$x] == 1) { //환불 요청 ?>
                                                    <span class="btn paid l-inlinebox bx-round_l bg_n">환불요청</span>
                                                <?php } else if ($pay_status[$x] == 2) { //환불 완료 ?>
                                                    <span class="btn paid l-inlinebox bx-round_l bg_n">환불완료</span>
                                                <?php } ?>


                                            </div>
                                            <div class="item content l-inlinebox">
                                                <div class="wrap">
                                                    <p class="title">
                                                        <span> <?php echo $land_address[$x] ?></span>
                                                    </p>
                                                    <div class="infos">
                                                        <div class="wrap">
                                                                <span class="addr"><em class="tit">결제금액</em><em
                                                                            class="value"> <?php echo number_format($pay_price[$x]) ?>원</em></span>
                                                        </div>
                                                        <div class="wrap">
                                                                <span class="date"><em class="tit">결제일시</em><em
                                                                            class="value"><?php echo $pay_date[$x] ?></em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <div style="margin-top:300px;width: 100%; height: 500px; font-size: 18px; text-align: center;">
                                결제한 내역이 없습니다
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
                                        onclick="location.href='sub_mp_paylist.php?page=<?php echo $page - 1 ?>'"></button>
                            <?php } ?>
                            <div class="wrap">
                                <?php
                                if ($all_count > 0) {
                                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                        if ($x == $page) { ?>
                                            <a class="btn bx-round_xs page_num on"
                                               onclick="location.href='sub_mp_paylist.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php } else { ?>
                                            <a class="btn bx-round_xs page_num"
                                               onclick="location.href='sub_mp_paylist.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php }
                                        if ($x + 1 == $page_count) {
                                            break;
                                        }
                                    }
                                } ?>
                            </div>
                            <?php if ($page + 1 != $page_count && $page_count > 0) { ?>
                                <button class="btn btn_next" type="button"
                                        onclick="location.href='sub_mp_paylist.php?page=<?php echo $page + 1 ?>'"></button>
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
    </body>
    </html>
<?php } ?>