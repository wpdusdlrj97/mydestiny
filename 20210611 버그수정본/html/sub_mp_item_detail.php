<?php
//상세 페이지 - 토지
session_start();
$user_session = $_SESSION['user_session'];

$ip_address = $_SERVER["REMOTE_ADDR"];
$ip_address = str_replace(".", "", $ip_address);


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";

$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

//토지 아이디로 정보 조회
$land_id = $_GET['land_id'];

//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {


//조회수 카운트를 위한 IP 주소 조회
    $ip_address = $_SERVER["REMOTE_ADDR"];
    $ip_address = str_replace(".", "", $ip_address);
    $cookie_key = $ip_address . "_" . $land_id;

//해당 IP로 처음 조회한 경우 (랜드아이디.아이피) 조회수 +1 (30일 기준)
    if (!isset($_COOKIE[$cookie_key])) {
        $qry_string_click = "UPDATE land_information set land_click=land_click+1 where land_id='$land_id'";
        $qry_click = mysqli_query($connect, $qry_string_click);
        setcookie($cookie_key, $cookie_key, time() + (86400 * 30), "/");
    }

    $qry_string_land = "SELECT * FROM land_information where land_id='$land_id'";
    $qry_land = mysqli_query($connect, $qry_string_land);
    $row_land = mysqli_fetch_array($qry_land);

    //차트 정보 조회
    $qry_string_chart = "SELECT * FROM chart_information where land_id='$land_id'";
    $qry_chart = mysqli_query($connect, $qry_string_chart);
    $row_chart = mysqli_fetch_array($qry_chart);

    //본인이 등록한 토지일 경우 -> 마이페이지-내토지로 이동시키기
    if ($row_land['land_register_id'] == $user_session) {
        $my_land_url = $land_url . "/html/land/sub_mp_item.php?land_id=" . $land_id;
        echo "<meta http-equiv='refresh' content='0; url=$my_land_url'>";
    } else {

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
        </head>
        <body>
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
                                <i class="tit-icon icon_globeStand bx-round_l bg_n"></i>
                                <h2 class="tit-wrap l-inlinebox">
                                    <span class="tit ft_b">등록 토지</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <div class="container">
                        <div class="inner">
                            <a onclick="history.back();" class="btn btn_prev ft_m_l">목록으로 돌아가기</a>
                            <div class="an-card">
                                <div class="row01 clear">
                                    <div class="thumbnail l-inline bx-round_l">
                                        <img src="<?php echo $row_land['land_main_image'] ?>" class="img_f" alt="썸네일">
                                        <a class="zoom btn_pop" href="#none"
                                           data-popup="zoomSlide"><span>확대보기</span></a>
                                    </div>
                                    <div class="info l-inline">
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
<!--                                            <li class="price">-->
<!--                                            <span class="wrap">-->
<!--                                                <em class="tit icon_tag">공시지가</em>-->
<!--                                                <em class="value"><i-->
<!--                                                            class="unit">&#8361;&nbsp;</i>--><?php //echo number_format($row_land['land_register_price']) ?><!--</em>-->
<!--                                            </span>-->
<!--                                            </li>-->
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
                                    <div style="position : relative;width: 100%; height: 500px;">
                                        <div id="map" class="map bx-round_l bg_g"
                                             style="position: absolute;width: 100%; height: 500px;"></div>
                                        <div style="position: absolute; width: 10%; height: 500px; float: left;">
                                            <input id="cadastral" type="button" value="지적도" class="control-btn"
                                                   style="margin:12px;background-color:#7868E6; color: white; width: 120px; height: 30px;font-weight: bolder;font-family:'GmarketSansMedium';"/>
                                            <button style="margin-left:12px;background-color:#7868E6; color: white; width: 120px; height: 30px;font-weight: bolder;font-family:'GmarketSansMedium';"
                                                    onclick="full_map()">전체화면 보기
                                            </button>
                                        </div>
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
                                <!--토지 분석 차트-->
                                <script>
                                    //입력 데이터 샘플
                                    var dataSet = {
                                        가치분석 : {
                                            '개발가능성': <?php echo $row_chart['value_1']?>,
                                            '경사완만': <?php echo $row_chart['value_2']?>,
                                            '인구유입률': <?php echo $row_chart['value_3']?>,
                                            '개발호재': <?php echo $row_chart['value_4']?>,
                                            '도로유무': <?php echo $row_chart['value_5']?>
                                        },
                                        개발축: {
                                            '기간': <?php echo $row_chart['dev_1']?>,
                                            '수익': <?php echo $row_chart['dev_2']?>
                                        },
                                        보조축: {
                                            '기간': <?php echo $row_chart['sub_1']?>,
                                            '수익': <?php echo $row_chart['sub_2']?>
                                        },
                                        보전축: {
                                            '기간': <?php echo $row_chart['pre_1']?>,
                                            '수익': <?php echo $row_chart['pre_2']?>
                                        }
                                    };

                                    //가치분석 데이터 고르기
                                    var setData01 = function(dataSet){
                                        var dataSet = dataSet;
                                        var values = [];
                                        var key = '가치분석';
                                        var value = 0;

                                        var target = dataSet[key];
                                        for( item in target){
                                            value = target[item];
                                            values.push(value);
                                        };
                                        return values;
                                    };

                                    //축분석 데이터 고르기
                                    var setData02 = function(dataSet){
                                        var dataSet = dataSet;
                                        var labeledValues = {
                                            '기간': [],
                                            '수익': []
                                        };
                                        var keys = ['개발축', '보조축', '보전축'];
                                        var labels = ['기간', '수익'];

                                        keys.forEach(function(item){
                                            var target = dataSet[item];
                                            labels.forEach(function(label, idx){
                                                if(idx === 0) labeledValues[label].push(target[label]);
                                                else labeledValues[label].push(target[label]);
                                            })
                                        })

                                        return labeledValues;
                                    };

                                    var initChart01 = function(datas){
                                        var data = datas;

                                        var pointRadius = $(window).innerWidth() > 480 ? 18 : 10;
                                        var pointFontSize = $(window).innerWidth() > 480 ? 15 : 13;
                                        var labelFontSize = $(window).innerWidth() > 480 ? 20 : 15;

                                        var config = {
                                            type: 'radar',
                                            data : {
                                                labels: ['개발가능성', '경사완만', '인구유입률', '개발호재', '도로유무'],
                                                datasets: [{
                                                    label: '점수',
                                                    data: data,
                                                    fill: true,
                                                    backgroundColor: 'rgba(120, 104, 230, 0.5)',
                                                    borderColor: '#7868e6',
                                                    borderWidth: 4,
                                                    pointBackgroundColor: '#7868e6',
                                                    pointBorderColor: '#7868e6',
                                                    pointRadius: pointRadius,
                                                    pointHoverRadius: 18,
                                                    pointHoverBorderColor: '#7868e6',
                                                    datalabels: {
                                                        color: '#fff',
                                                        labels: {
                                                            title: {
                                                                font: {
                                                                    size: pointFontSize,
                                                                    weight: '800'
                                                                }
                                                            }
                                                        }
                                                    }
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                scale: {
                                                    ticks: {
                                                        min: 0,
                                                        max: 11,
                                                        stepSize: 1,
                                                        backdropColor: 'transparent',
                                                        fontColor: 'rgba(255,255,255,.7)',
                                                        fontSize: 0,
                                                        padding: 0,
                                                    },
                                                    angleLines: {
                                                        color: 'transparent'
                                                    },
                                                    gridLines: {
                                                        color: ['rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                                            ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                                            ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                                            ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                                            ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                                            ,'transparent']
                                                    },
                                                    pointLabels: {
                                                        fontColor: '#fff',
                                                        fontSize: labelFontSize,
                                                        fontFamily: 'GmarketSansMedium',
                                                        borderWidth: 10,
                                                    }
                                                },
                                                legend: {
                                                    display: false,
                                                },
                                            }
                                        };
                                        var chart01 =   new Chart(document.getElementById('chart01'), config);
                                    };

                                    var initChart02 = function(datas){
                                        var data = datas;

                                        var borderWidth = $(window).innerWidth() > 480 ? 12 : 4;
                                        var barPercentage = ( $(window).innerWidth() <= 980 && $(window).innerWidth() > 480)? 0.1 : 0.15;

                                        var config = {
                                            type: 'bar',
                                            data: {
                                                labels: ['개발축', '보조축', '보전축'],
                                                borderColor: '#fff',
                                                datasets: [
                                                    {
                                                        labels: '기간',
                                                        data: data['기간'],
                                                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                                                        datalabels: {
                                                            backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                                                            borderColor: ['#7868e6','#23dc7a','#ff5555']
                                                        },
                                                    },
                                                    {
                                                        labels: '수익',
                                                        data: data['수익'],
                                                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                                                        datalabels: {
                                                            backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                                                            borderColor: ['#7868e6','#23dc7a','#ff5555']
                                                        }
                                                    }
                                                ],

                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                layout: {
                                                    padding: {
                                                        left: -180 //y축 tick hide
                                                    }
                                                },
                                                scales: {
                                                    xAxes: [
                                                        {
                                                            display: false,
                                                            categoryPercentage: 1.0,
                                                            barPercentage: barPercentage
                                                        }
                                                    ],
                                                    yAxes:[
                                                        {   //display: false,
                                                            ticks: {
                                                                min: 0,
                                                                max: 13,
                                                                stepSize: 1,
                                                                fontSize: 0,
                                                                mirror: true
                                                            },

                                                        },{
                                                            gridLines:{
                                                                color: ['rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                                                    ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                                                    ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                                                    ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                                                    ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                                                    ,'transparent', 'transparent', 'transparent']
                                                            }
                                                        }
                                                    ],

                                                },
                                                legend: {
                                                    display: false,
                                                },
                                                plugins: {
                                                    datalabels: {
                                                        display: true,
                                                        anchor: 'end',
                                                        align: 'end',
                                                        offset: -2,
                                                        borderWidth: borderWidth,
                                                        formatter: function(value, context){
                                                            //박스 스타일 조정위해 공백 삽입
                                                            if(value<10) return ' ' + value + ' ';
                                                        },
                                                        borderRadius: 30,
                                                        color: '#fff',
                                                        font: {
                                                            size: 15,
                                                            weight: '600',
                                                            lineHeight: '14px'
                                                        }
                                                    }
                                                }
                                            }
                                        };
                                        var chart02 = new Chart(document.getElementById('chart02'), config);
                                    };


                                    $(window).on('load', function(event) {
                                        event.preventDefault();
                                        //차트 생성
                                        initChart01(setData01(dataSet));
                                        initChart02(setData02(dataSet));
                                    });

                                </script>
                                <!--  무료 토지 분석 대기, 진행중 -->
                            <?php } else { ?>
                                <div class="an-inform bx-round_l bg_g">
                                    <div class="wrap">
                                        <i class="icon"></i>
                                        <p class="pc">무료 분석 중입니다. 무료 분석은 관리자가 순차적으로 해 드립니다.</p>
                                        <p class="mobile">관리자가 순차적으로 무료 분석을 해 드립니다.</p>
                                    </div>
                                </div>
                                <section class="rg-datas">
                                    <div style="position : relative;width: 100%; height: 500px;">
                                        <div id="map" class="map bx-round_l bg_g"
                                             style="position: absolute;width: 100%; height: 500px;"></div>
                                        <div style="position: absolute; width: 10%; height: 500px; float: left;">
                                            <input id="cadastral" type="button" value="지적도" class="control-btn"
                                                   style="margin:12px;background-color:#7868E6; color: white; width: 120px; height: 30px;font-weight: bolder;font-family:'GmarketSansMedium';"/>
                                            <button style="margin-left:12px;background-color:#7868E6; color: white; width: 120px; height: 30px;font-weight: bolder;font-family:'GmarketSansMedium';"
                                                    onclick="full_map()">전체화면 보기
                                            </button>
                                        </div>
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
            function full_map() {
                window.open("https://landmarking.co.kr/html/map.php?id=<?php echo $land_id?>");
            }
        </script>

        </body>
        </html>
    <?php }
}?>