<?php
//토지 목록 - 마스터 추천
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");




$page = $_GET['page'];
if (!$page) {
    $page = 0;
}

//토지 정보 조회
$qry_string = "SELECT * FROM land_information where land_master_recommend='1' and land_agent_status not in ('1','2') ORDER BY land_register_date DESC";


$qry = mysqli_query($connect, $qry_string);
$all_count = mysqli_num_rows($qry);

//페이징을 위한 페이지 수 계산
$page_count = (int)($all_count / 25);
//현재 페이지에서 나열할 글 수
$count = 0;

if ($all_count - ($page * 25) >= 25) {
    $count = 25;
} else {
    $count = $all_count - ($page * 25);
}


if ($all_count % 25 > 0) {
    $page_count++;
}

$qry_string = $qry_string . " LIMIT " . ($page * 25) . ", 25";
$qry = mysqli_query($connect, $qry_string);


$land_id_master = array();
$land_address_master = array();
$land_register_title_master = array();
$land_register_area_master = array();
$land_register_price_master = array();
$land_click_master = array();
$land_main_image_master = array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($land_id_master, $row['land_id']);
    array_push($land_address_master, $row['land_address']);
    array_push($land_register_title_master, $row['land_register_title']);
    array_push($land_register_area_master, $row['land_register_area']);
    array_push($land_register_price_master, $row['land_register_price']);
    array_push($land_click_master, $row['land_click']);
    array_push($land_main_image_master, $row['land_main_image']);
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
    <meta property="og:image" content="../images/common/icon_logo01.png">
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
    <link rel="stylesheet" href="../css/main.css" >

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
</head>
<body>
<div id="popup"></div>
<div id="wrap" class="sub sub-list master" data-tab="master">
    <header id="header"></header>
    <main id="main">
        <div class="main-title">
            <div class="container">
                <div class="inner">
                    <div class="tit" data-tab="master">
                        <i class="tit-icon icon_thumbUp bx-round_l"></i>
                        <h2 class="tit-wrap l-inlinebox">
                            <span class="tit ft_b">마스터 추천 토지</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="inner">
                    <h3 class="mn-title ft_m_l" data-tab="master">
                        <span class="mobile">마스터가 추천하는 </span>토지들을 확인해보세요.
                    </h3>
                    <?php if($count>0){ ?>
                        <div class="card-wrap col05 clear">
                            <?php for ($x = 0; $x < $count; $x++) {?>
                            <div class="mn-card bx-round_m">
                                <a class="l-box" href="/html/sub_mp_item_detail.php?land_id=<?php echo $land_id_master[$x]?>">
                                    <div class="card-img bx-round_m">
                                        <img src="<?php echo $land_main_image_master[$x]?>" alt="토지">
                                        <div class="label-wrap img-label-wrap">
                                            <span class="label label_01 l-inline bx-round_xs">마스터 추천</span>
                                        </div>
                                    </div>
                                    <div class="card-info">
                                        <?php
                                        $land_address_master_array = explode(" ", $land_address_master[$x]);
                                        ?>
                                        <div class="label-wrap info-label-wrap">
                                            <span class="label info-label  l-inline bx-round_xs"><?php echo $land_address_master_array[0]?></span>
                                            <span class="label info-label l-inline bx-round_xs"><?php echo $land_address_master_array[1]?></span>
                                        </div>
<!--                                        <span class="info-price l-inline">-->
<!--                                            <em class="value">--><?php //echo number_format($land_register_price_master[$x])?><!--</em>-->
<!--                                        </span>-->
                                        <span class="info-tit l-box"><?php echo mb_strimwidth($land_register_title_master[$x], '0', '50', '..', 'utf-8');?></span>
                                        <div class="info-wrap clear">
                                            <span class="info-size l-inline l-fleft">
                                                <em class="value"><?php echo number_format($land_register_area_master[$x])?></em>
                                                <em class="unit"> m<sup>2</sup></em>
                                            </span>
                                            <span class="info-views l-inline l-fright">
                                                <em class="value"><?php echo number_format($land_click_master[$x])?></em>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                    <?php }else{  ?>
                        <div style="margin-top:300px;width: 100%; height: 500px; font-size: 18px; text-align: center;">마스터 추천 매물이 없습니다</div>
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
                                    onclick="location.href='sub_list_master.php?page=<?php echo $page - 1 ?>'"></button>
                        <?php } ?>
                        <div class="wrap">
                            <?php
                            if ($all_count > 0) {
                                for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                    if ($x == $page) { ?>
                                        <a class="btn bx-round_xs page_num on"
                                           onclick="location.href='sub_list_master.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                    <?php } else { ?>
                                        <a class="btn bx-round_xs page_num"
                                           onclick="location.href='sub_list_master.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                    <?php }
                                    if ($x + 1 == $page_count) {
                                        break;
                                    }
                                }
                            } ?>
                        </div>
                        <?php if ($page + 1 != $page_count && $page_count > 0) { ?>
                            <button class="btn btn_next" type="button"
                                    onclick="location.href='sub_list_master.php?page=<?php echo $page + 1 ?>'"></button>
                        <?php } ?>
                    </div>
                    <div class="tab l-fright">
                        <a href="/html/sub_list.php" class="btn tabBtn common" >전체토지</a>
                        <a href="#" class="btn tabBtn master" >마스터 추천 토지</a>
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
    $("#popup").load("/html/_popup.php");
    $("#header").load("/html/_header.php");
    $("#footer").load("/html/_footer.php");
</script>
</body>
</html>