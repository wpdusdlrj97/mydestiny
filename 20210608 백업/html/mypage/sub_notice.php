<?php
//공지사항 페이지

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");


$page = $_GET['page'];
if (!$page) {
    $page = 0;
}

$qry_string = "SELECT * FROM notice_information ORDER BY notice_date DESC";
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

$notice_title = array();
$notice_content = array();
$notice_date = array();
$notice_file = array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($notice_title, $row['notice_title']);
    array_push($notice_content, $row['notice_content']);
    array_push($notice_date, date('Y년 m월 d일', strtotime($row['notice_date'])));
    array_push($notice_file, $row['notice_file']);

}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    <link rel="stylesheet" href="../../css/main.css" >

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
    <div id="wrap" class="sub">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_newsPaper bx-round_l"></i>
                            <h2 class="tit-wrap l-inline ft_b">
                                <span class="tit">공지사항</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="notice terms">
                            <ul>
                                <?php for ($x = 0; $x < $count; $x++) { ?>
                                    <li class=" bx-round_l bg_g">
                                        <p class="tit"><?php echo $notice_title[$x]?></p>
                                        <div class="wrap">
                                            <p class="txt bg_w">
                                                <?php echo $notice_content[$x]?>
                                            </p>

                                            <?php if ($notice_file[$x]==null || $notice_file[$x]=='') { ?>

                                            <?php } else { ?>

                                                <ul class="file-wrap">
                                                    <li class="tit">첨부 파일</li>
                                                    <li class="file"><a href="<?php echo $notice_file[$x];?>" download> <?php
                                                            $notice_file_array = explode( '_&공지&_', $notice_file[$x]);
                                                            echo $notice_file_array[1];
                                                            ?></a></li>
                                                </ul>
                                            <?php } ?>


                                            <span class="date"><span>등록</span><span class="value"><?php echo $notice_date[$x]?></span></span>
                                        </div>
                                        <button type="button" class="btn bg_n bx-round_l">
                                            <span class="on">접기</span>
                                            <span class="off">펼쳐보기</span>
                                        </button>
                                    </li>
                                <?php } ?>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="main-bottom">
                        <div class="container">
                            <div class="inner clear">
                                <div class="pagination l-fleft">
                                    <?php if ($page > 0) { ?>
                                        <button class="btn btn_prev" type="button"
                                                onclick="location.href='sub_notice.php?page=<?php echo $page - 1 ?>'"></button>
                                    <?php } ?>
                                    <div class="wrap">
                                        <?php
                                        if ($all_count > 0) {
                                            for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                                if ($x == $page) { ?>
                                                    <a class="btn bx-round_xs page_num on"
                                                       onclick="location.href='sub_notice.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                                <?php } else { ?>
                                                    <a class="btn bx-round_xs page_num"
                                                       onclick="location.href='sub_notice.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                                <?php }
                                                if ($x + 1 == $page_count) {
                                                    break;
                                                }
                                            }
                                        } ?>
                                    </div>
                                    <?php if ($page + 1 != $page_count && $page_count > 0) { ?>
                                        <button class="btn btn_next" type="button"
                                                onclick="location.href='sub_notice.php?page=<?php echo $page + 1 ?>'"></button>
                                    <?php } ?>
                                </div>
                            </div>
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