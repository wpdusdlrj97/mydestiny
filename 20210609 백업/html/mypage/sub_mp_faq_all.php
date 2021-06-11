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

    $qry_string = "SELECT * FROM qna_information where qna_writer_email='$user_session' ORDER BY qna_date DESC";


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


    $qna_title = array();
    $qna_content = array();
    $qna_date = array();
    $qna_main_image = array();
    $qna_sub_image_list = array();
    $reply_status = array();
    $reply_content = array();
    $reply_file = array();
    $reply_date = array();
    while ($row = mysqli_fetch_array($qry)) {
        array_push($qna_title, $row['qna_title']);
        array_push($qna_content, $row['qna_content']);
        array_push($qna_date, date('Y년 m월 d일', strtotime($row['qna_date'])));
        array_push($qna_main_image, $row['qna_main_image']);
        array_push($qna_sub_image_list, $row['qna_sub_image_list']);
        array_push($reply_status, $row['reply_status']);
        array_push($reply_content, $row['reply_content']);
        array_push($reply_file, $row['reply_file']);
        array_push($reply_date, date('Y년 m월 d일 H:i', strtotime($row['reply_date'])));

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
    <div id="wrap" class="sub mp_faq">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit clear">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <a href="/html/mypage/sub_mp_menu.php" class="tit ft_b">마이 페이지</a>
                                <a href="#" class="tit ft_b">문의</a>
                            </h2>
                            <a href="./sub_mp_faqForm.php" class="btn btn_more bg_v bx-round_l ft_b">문의<span class="pc">등록하기</span></a>
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
                                <a class="tit_txt" href="./sub_mp_faq_answered.php">답변 받음</a>
                                <span class="tit_cnt"><?php echo $all_count . '건' ?></span>
                            </div>
                        </div>
                        <?php if ($count > 0) { ?>

                            <ul class="mylist">
                                <?php for ($x = 0; $x < $count; $x++) {

                                    if ($qna_main_image[$x] == null) {

                                        if ($reply_status[$x] == '0') { ?>
                                            <li class="bx-round_l nonImg">
                                                <div class="inner">
                                                    <div class="wrap ">
                                                        <div class="item thumbnail bx-round_s"></div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">답변 대기중</span>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $qna_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                        <span class="wrap">
                                                            <span class="date"><span class="tit">등록</span><span
                                                                        class="value"><?php echo $qna_date[$x] ?></span></span>
                                                        </span>
                                                                </div>
                                                                <div class="forms">
                                                                    <div class="imgs"></div>
                                                                    <form class="quest" onsubmit="return false;">
                                                        <textarea readonly name="quest" cols="30"
                                                                  rows="10"><?php echo $qna_content[$x] ?></textarea>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } else { ?>
                                            <li class="bx-round_l answered nonImg">
                                                <div class="inner">
                                                    <div class="wrap ">
                                                        <div class="item thumbnail bx-round_s"></div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">답변 등록됨</span>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $qna_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                        <span class="wrap">
                                                            <span class="date"><span class="tit">등록</span><span
                                                                        class="value"><?php echo $qna_date[$x] ?></span></span>
                                                        </span>
                                                                </div>
                                                                <div class="forms">
                                                                    <div class="imgs"></div>
                                                                    <form class="quest" onsubmit="return false;">
                                                        <textarea readonly name="quest" cols="30"
                                                                  rows="10"><?php echo $qna_content[$x] ?></textarea>
                                                                    </form>
                                                                    <form class="answer bg_w" onsubmit="return false;">

                                                                        <span style="padding:5px;background-color:#7868E6; color: white; display: inline-block;">랜드마킹 답변</span>
                                                                        <span style="padding:5px; color: #7868E6; display: inline-block; font-size: 12px;"><?php echo $reply_date[$x];?></span>
                                                        <textarea readonly cols="30"
                                                                  rows="10"><?php echo strip_tags($reply_content[$x]) ?></textarea>
                                                                    </form>

                                                                    <?php if ($reply_file[$x]==null || $reply_file[$x]=='') { ?>

                                                                    <?php } else { ?>

                                                                        <ul class="file-wrap">
                                                                            <li class="tit">첨부 파일</li>
                                                                            <li class="file"><a onclick="location.href='<?php echo $reply_file[$x];?>'"  download> <?php
                                                                                    $reply_file_array = explode( '_&문의&_', $reply_file[$x]);
                                                                                    echo $reply_file_array[1];
                                                                                    ?></a></li>
                                                                        </ul>
                                                                    <?php } ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } else {
                                        if ($reply_status[$x] == '0') { ?>
                                            <li class="bx-round_l">
                                                <div class="inner">
                                                    <div class="wrap">
                                                        <div class="item thumbnail bx-round_s">
                                                            <img src="<?php echo $qna_main_image[$x] ?>"
                                                                 alt="land image"
                                                                 class="img_f">
                                                        </div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">답변 대기중</span>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $qna_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                        <span class="wrap">
                                                            <span class="date"><span class="tit">등록</span><span
                                                                        class="value"><?php echo $qna_date[$x] ?></span></span>
                                                        </span>
                                                                </div>
                                                                <div class="forms">
                                                                    <div class="imgs">
                                                                        <?php

                                                                        $qna_sub_image_list_array = json_decode($qna_sub_image_list[$x]);

                                                                        for ($i = 0; $i < count($qna_sub_image_list_array); $i++) { ?>
                                                                            <img class="l-inlinebox bx-round_l"
                                                                                 src="<?php echo $qna_sub_image_list_array[$i] ?>"
                                                                                 alt="land image">

                                                                        <?php } ?>
                                                                    </div>
                                                                    <form class="quest" onsubmit="return false;">
                                                        <textarea readonly name="quest" cols="30"
                                                                  rows="10"><?php echo $qna_content[$x] ?></textarea>
                                                                    </form>
                                                                    <form class="answer bg_w" onsubmit="return false;">
                                                        <textarea readonly name="answer" cols="30"
                                                                  rows="10">답변 내용</textarea>
                                                                        <div class="ans-info l-box">
                                                                            <span class="btn l-inlinebox bx-round_l bg_v">랜드마킹 답변</span>
                                                                            <p class="ans-date"><span
                                                                                        class="tit"><?php echo $reply_content[$x] ?></span><span
                                                                                        class="value"><?php echo $reply_date[$x] ?></span>
                                                                            </p>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } else { ?>
                                            <li class="bx-round_l answered">
                                                <div class="inner">
                                                    <div class="wrap">
                                                        <div class="item thumbnail bx-round_s">
                                                            <img src="<?php echo $qna_main_image[$x] ?>"
                                                                 alt="land image"
                                                                 class="img_f">
                                                        </div>
                                                        <div class="item btns l-inlinebox">
                                                            <span class="btn status l-inlinebox bx-round_l bg_n">답변 등록됨</span>
                                                        </div>
                                                        <div class="item content l-inlinebox">
                                                            <div class="wrap">
                                                                <p class="title">
                                                                    <span><?php echo $qna_title[$x] ?></span>
                                                                </p>
                                                                <div class="infos">
                                                        <span class="wrap">
                                                            <span class="date"><span class="tit">등록</span><span
                                                                        class="value"><?php echo $qna_date[$x] ?></span></span>
                                                        </span>
                                                                </div>
                                                                <div class="forms">
                                                                    <div class="imgs">
                                                                        <?php

                                                                        $qna_sub_image_list_array = json_decode($qna_sub_image_list[$x]);

                                                                        for ($i = 0; $i < count($qna_sub_image_list_array); $i++) { ?>
                                                                            <img class="l-inlinebox bx-round_l"
                                                                                 src="<?php echo $qna_sub_image_list_array[$i] ?>"
                                                                                 alt="land image">

                                                                        <?php } ?>
                                                                    </div>
                                                                    <form class="quest" onsubmit="return false;">
                                                        <textarea readonly cols="30"
                                                                  rows="10"><?php echo $qna_content[$x] ?></textarea>
                                                                    </form>

                                                                    <form class="answer bg_w" onsubmit="return false;">


                                                                        <span style="padding:5px;background-color:#7868E6; color: white; display: inline-block;">랜드마킹 답변</span>
                                                                        <span style="padding:5px; color: #7868E6; display: inline-block; font-size: 12px;"><?php echo $reply_date[$x];?></span>
                                                        <textarea readonly cols="30"
                                                                  rows="10"><?php echo strip_tags($reply_content[$x]) ?></textarea>
                                                                    </form>

                                                                    <?php if ($reply_file[$x]==null || $reply_file[$x]=='') { ?>

                                                                    <?php } else { ?>

                                                                        <ul class="file-wrap">
                                                                            <li class="tit">첨부 파일</li>
                                                                            <li class="file"><a onclick="location.href='<?php echo $reply_file[$x];?>'"  download> <?php
                                                                                    $reply_file_array = explode( '_&문의&_', $reply_file[$x]);
                                                                                    echo $reply_file_array[1];
                                                                                    ?></a></li>
                                                                        </ul>
                                                                    <?php } ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php }
                                } ?>

                            </ul>
                        <?php } else { ?>
                            <div style="margin-top:300px;width: 100%; height: 500px; font-size: 18px; text-align: center;">
                                문의한 내역이 없습니다
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
                                        onclick="location.href='sub_mp_faq_all.php?page=<?php echo $page - 1 ?>'"></button>
                            <?php } ?>
                            <div class="wrap">
                                <?php
                                if ($all_count > 0) {
                                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                        if ($x == $page) { ?>
                                            <a class="btn bx-round_xs page_num on"
                                               onclick="location.href='sub_mp_faq_all.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php } else { ?>
                                            <a class="btn bx-round_xs page_num"
                                               onclick="location.href='sub_mp_faq_all.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                        <?php }
                                        if ($x + 1 == $page_count) {
                                            break;
                                        }
                                    }
                                } ?>
                            </div>
                            <?php if ($page + 1 != $page_count && $page_count > 0) { ?>
                                <button class="btn btn_next" type="button"
                                        onclick="location.href='sub_mp_faq_all.php?page=<?php echo $page + 1 ?>'"></button>
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