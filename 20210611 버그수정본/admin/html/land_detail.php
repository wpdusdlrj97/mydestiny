<?php
//토지 상세보기 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";

//토지 정보 조회
$land_id = $_GET['id'];

//토지 정보 조회
$qry_string_land = "SELECT * FROM land_information where land_id='$land_id'";
$qry_land = mysqli_query($connect, $qry_string_land);
$row_land = mysqli_fetch_array($qry_land);
$total_row_land = mysqli_num_rows($qry_land);
//토지 차트 조회
$qry_string_chart = "SELECT * FROM chart_information where land_id='$land_id'";
$qry_chart = mysqli_query($connect, $qry_string_chart);
$row_chart = mysqli_fetch_array($qry_chart);
$total_row_chart = mysqli_num_rows($qry_chart);


//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {


    ?>
    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="description" content="랜드마킹 관리자 페이지입니다.">
        <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
        <meta name="author" content="랜드마킹">
        <meta property="og:type" content="website">
        <meta property="og:url" content="url">
        <meta property="og:image" content="/images/common/icon_logo01.png">
        <meta property="og:title" content="랜드마킹 ADMIN">
        <meta property="og:site_name" content="랜드마킹 ADMIN">
        <meta property="og:description" content="랜드마킹 관리자 페이지">
        <meta property="og:locale" content="ko_KR">
        <title>관리자페이지</title>nt="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,
        user-scalable=no">
        <title>관리자페이지</title>
        <!-- STYLE LINK-->
        <link rel="stylesheet" href="../css/default.css">
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/style.css">

        <!-- SCRIPT -->
        <!--[if lte IE 9]>
        <script src="../js/lib/IE9.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="../js/lib/html5shiv.min.js"></script>
        <script src="../js/lib/jqPIE.js"></script>
        <script src="../js/lib/PIE.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            /*input number 화살표 제거*/
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
            }
        </style>
    </head>
    <body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main" class="rg-form rg-details">
            <div class="container">
                <div class="inner">
                    <h2 class="title">토지매물 상세페이지</h2>
                    <div class="contents">
                        <div class="form-wrap wide">
                            <form onsubmit="return false;">
                                <fieldset>
                                    <legend class="legend">등록 정보</legend>
                                    <div class="wrap">
                                        <label for="userId">아이디</label>
                                        <input type="text" id="land_register_email"
                                               value="<?php echo $row_land['land_register_id'] ?>">
                                    </div>
                                    <div class="wrap">
                                        <label for="userName">성명</label>
                                        <input type="text" id="land_register_name"
                                               value="<?php echo $row_land['land_register_name'] ?>">
                                    </div>
                                    <div class="wrap">
                                        <label for="userTel">전화번호</label>
                                        <input type="tel" id="land_register_phone"
                                               value="<?php echo $row_land['land_register_phone'] ?>">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 정보</legend>
                                    <div class="wrap">
                                        <label for="landTitle">제목</label>
                                        <input type="text" id="land_register_title" placeholder="50자까지만 입력 가능합니다."
                                               maxlength="50" value="<?php echo $row_land['land_register_title'] ?>">
                                    </div>
                                    <div class="wrap">
                                        <label for="landSize">면적</label>
                                        <input class="has-unit" type="number" id="land_register_area"
                                               placeholder="m2단위로 입력해 주세요"
                                               value="<?php echo $row_land['land_register_area'] ?>">
                                        <i class="unit">m<sup>2</sup></i>
                                    </div>
                                    <div class="wrap">
                                        <label for="landAddr">주소</label>
                                        <input type="text" id="land_address" placeholder="입력필수"
                                               value="<?php echo $row_land['land_address'] ?>" readonly>
                                        <input type="text" id="land_x" style="display: none;"
                                               value="<?php echo $row_land['land_x'] ?>" readonly>
                                        <input type="text" id="land_y" style="display: none;"
                                               value="<?php echo $row_land['land_y'] ?>" readonly>
                                    </div>
                                    <div class="wrap">
                                        <label for="landPrice">가격</label>
                                        <input class="has-unit" type="number" id="land_register_price"
                                               value="<?php echo $row_land['land_register_price'] ?>"
                                               placeholder="원 단위로 입력해 주세요">
                                        <i class="unit">원</i>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 내용</legend>
                                    <textarea name="text" cols="50" rows="10" id="land_register_content"
                                              required><?php echo strip_tags($row_land['land_register_content']) ?></textarea>
                                </fieldset>



                                <fieldset class="has-files">
                                    <legend class="legend">기존 대표 이미지</legend>
                                    <div id="old_main_image">
                                        <img src="<?php echo $row_land['land_main_image'] ?>" style="width: 100px; height: 100px; margin-right: 20px; border: 4px solid #7868E6">
                                    </div>
                                </fieldset>

                                <fieldset class="has-files">
                                    <legend class="legend">기존 참고 이미지</legend>
                                    <?php

                                    $land_sub_image_list_array = json_decode($row_land['land_sub_image_list']);

                                    if (count($land_sub_image_list_array) == 0 ) { ?>

                                        <span> 기존에 업로드한 이미지가 없습니다 </span>

                                    <?php } else { ?>
                                        <div>
                                            <?php

                                            for ($i = 0; $i < count($land_sub_image_list_array); $i++) {
                                                ?>
                                                <div style="position : relative; margin-right:15px;width: 100px;height: 100px;float: left;">
                                                    <img src="<?php echo $land_sub_image_list_array[$i] ?>" width="100" height="100" />
                                                    <button class="sub_image_delete" style="position: absolute; left:80px; background-color:#7868E6; color: white; width: 20px; height: 20px;" type="button">x</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                </fieldset>


                                <br> <br>


                                <fieldset class="has-files">
                                    <legend class="legend">대표 이미지</legend>
                                    <label class="btn_file" for="thumbnail">이미지 변경</label>
                                    <input type="file" name="thumbnail" id="thumbnail" accept=".jpg, .jpeg, .png">
                                    <div class="uploaded">
                                    </div>
                                </fieldset>


                                <fieldset class="has-files">
                                    <legend class="legend">참고 이미지</legend>
                                    <label class="btn_file" for="images">파일 올리기</label>
                                    <input type="file" name="imgList[]" id="images" accept=".jpg, .jpeg, .png" multiple>
                                    <div class="uploaded sub_image_uploaded">
                                    </div>
                                </fieldset>


                                <fieldset class="is-master clear">
                                    <legend class="legend">마스터 추천 하기</legend>
                                    <?php if ($row_land['land_master_recommend'] == '0') { ?>
                                        <input type="checkbox" name="master_recommend" id="master_recommend"
                                               class="l-fleft" value="master">
                                    <?php } else { ?>
                                        <input type="checkbox" name="master_recommend" id="master_recommend"
                                               class="l-fleft" value="master" checked>
                                    <?php } ?>

                                    <label for="master l-frignt">
                                        마스터 추천하기 체크시 메인 페이지와 마스터 추천 매물 패이지의 목록에 노출되며<br>매물 이미지 상단에 마스터 추천 태그가 추가됩니다.
                                    </label>
                                </fieldset>

                                <?php if ($total_row_chart > 0) { // 차트 기록이 있는 경우 ?>

                                    <fieldset class="has-checks">
                                        <legend class="legend">가치 분석 / 개발축 분석</legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발가능성</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['value_1']) { ?>
                                                        <input class="check" type="radio" name="value_1"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="value_1"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clera">
                                            <label class="label l-fleft">경사완만</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['value_2']) { ?>
                                                        <input class="check" type="radio" name="value_2"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="value_2"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">인구유입률</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['value_3']) { ?>
                                                        <input class="check" type="radio" name="value_3"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="value_3"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발호재</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['value_4']) { ?>
                                                        <input class="check" type="radio" name="value_4"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="value_4"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">도로유무</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['value_5']) { ?>
                                                        <input class="check" type="radio" name="value_5"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="value_5"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['dev_1']) { ?>
                                                        <input class="check" type="radio" name="dev_1"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="dev_1"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['dev_1']) { ?>
                                                        <input class="check" type="radio" name="dev_2"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="dev_2"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">보조축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['sub_1']) { ?>
                                                        <input class="check" type="radio" name="sub_1"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="sub_1"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['sub_2']) { ?>
                                                        <input class="check" type="radio" name="sub_2"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="sub_2"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">보전축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['pre_1']) { ?>
                                                        <input class="check" type="radio" name="pre_1"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="pre_1"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <?php
                                                for ($i = 1; $i < 11; $i++) {

                                                    if ($i == (int)$row_chart['pre_2']) { ?>
                                                        <input class="check" type="radio" name="pre_2"
                                                               value="<?php echo $i ?>" checked><?php echo $i ?>
                                                    <?php } else { ?>
                                                        <input class="check" type="radio" name="pre_2"
                                                               value="<?php echo $i ?>"><?php echo $i ?>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </fieldset>

                                <?php } else { // 차트 기록이 없는 경우 ?>

                                    <fieldset class="has-checks">
                                        <legend class="legend">가치 분석 / 개발축 분석</legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발가능성</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="value_1" value="1">1
                                                <input class="check" type="radio" name="value_1" value="2">2
                                                <input class="check" type="radio" name="value_1" value="3">3
                                                <input class="check" type="radio" name="value_1" value="4">4
                                                <input class="check" type="radio" name="value_1" value="5" checked>5
                                                <input class="check" type="radio" name="value_1" value="6">6
                                                <input class="check" type="radio" name="value_1" value="7">7
                                                <input class="check" type="radio" name="value_1" value="8">8
                                                <input class="check" type="radio" name="value_1" value="9">9
                                                <input class="check" type="radio" name="value_1" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clera">
                                            <label class="label l-fleft">경사완만</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="value_2" value="1">1
                                                <input class="check" type="radio" name="value_2" value="2">2
                                                <input class="check" type="radio" name="value_2" value="3">3
                                                <input class="check" type="radio" name="value_2" value="4">4
                                                <input class="check" type="radio" name="value_2" value="5" checked>5
                                                <input class="check" type="radio" name="value_2" value="6">6
                                                <input class="check" type="radio" name="value_2" value="7">7
                                                <input class="check" type="radio" name="value_2" value="8">8
                                                <input class="check" type="radio" name="value_2" value="9">9
                                                <input class="check" type="radio" name="value_2" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">인구유입률</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="value_3" value="1">1
                                                <input class="check" type="radio" name="value_3" value="2">2
                                                <input class="check" type="radio" name="value_3" value="3">3
                                                <input class="check" type="radio" name="value_3" value="4">4
                                                <input class="check" type="radio" name="value_3" value="5" checked>5
                                                <input class="check" type="radio" name="value_3" value="6">6
                                                <input class="check" type="radio" name="value_3" value="7">7
                                                <input class="check" type="radio" name="value_3" value="8">8
                                                <input class="check" type="radio" name="value_3" value="9"> 9
                                                <input class="check" type="radio" name="value_3" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발호재</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="value_4" value="1">1
                                                <input class="check" type="radio" name="value_4" value="2">2
                                                <input class="check" type="radio" name="value_4" value="3">3
                                                <input class="check" type="radio" name="value_4" value="4">4
                                                <input class="check" type="radio" name="value_4" value="5" checked>5
                                                <input class="check" type="radio" name="value_4" value="6">6
                                                <input class="check" type="radio" name="value_4" value="7">7
                                                <input class="check" type="radio" name="value_4" value="8">8
                                                <input class="check" type="radio" name="value_4" value="9">9
                                                <input class="check" type="radio" name="value_4" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">도로유무</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="value_5" value="1">1
                                                <input class="check" type="radio" name="value_5" value="2">2
                                                <input class="check" type="radio" name="value_5" value="3">3
                                                <input class="check" type="radio" name="value_5" value="4">4
                                                <input class="check" type="radio" name="value_5" value="5" checked>5
                                                <input class="check" type="radio" name="value_5" value="6">6
                                                <input class="check" type="radio" name="value_5" value="7">7
                                                <input class="check" type="radio" name="value_5" value="8">8
                                                <input class="check" type="radio" name="value_5" value="9">9
                                                <input class="check" type="radio" name="value_5" value="10">10
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">개발축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="dev_1" value="1">1
                                                <input class="check" type="radio" name="dev_1" value="2">2
                                                <input class="check" type="radio" name="dev_1" value="3">3
                                                <input class="check" type="radio" name="dev_1" value="4">4
                                                <input class="check" type="radio" name="dev_1" value="5" checked>5
                                                <input class="check" type="radio" name="dev_1" value="6">6
                                                <input class="check" type="radio" name="dev_1" value="7">7
                                                <input class="check" type="radio" name="dev_1" value="8">8
                                                <input class="check" type="radio" name="dev_1" value="9">9
                                                <input class="check" type="radio" name="dev_1" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="dev_2" value="1">1
                                                <input class="check" type="radio" name="dev_2" value="2">2
                                                <input class="check" type="radio" name="dev_2" value="3">3
                                                <input class="check" type="radio" name="dev_2" value="4">4
                                                <input class="check" type="radio" name="dev_2" value="5" checked>5
                                                <input class="check" type="radio" name="dev_2" value="6">6
                                                <input class="check" type="radio" name="dev_2" value="7">7
                                                <input class="check" type="radio" name="dev_2" value="8">8
                                                <input class="check" type="radio" name="dev_2" value="9">9
                                                <input class="check" type="radio" name="dev_2" value="10">10
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">보조축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="sub_1" value="1">1
                                                <input class="check" type="radio" name="sub_1" value="2">2
                                                <input class="check" type="radio" name="sub_1" value="3">3
                                                <input class="check" type="radio" name="sub_1" value="4">4
                                                <input class="check" type="radio" name="sub_1" value="5" checked>5
                                                <input class="check" type="radio" name="sub_1" value="6">6
                                                <input class="check" type="radio" name="sub_1" value="7">7
                                                <input class="check" type="radio" name="sub_1" value="8">8
                                                <input class="check" type="radio" name="sub_1" value="9">9
                                                <input class="check" type="radio" name="sub_1" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="sub_2" value="1">1
                                                <input class="check" type="radio" name="sub_2" value="2">2
                                                <input class="check" type="radio" name="sub_2" value="3">3
                                                <input class="check" type="radio" name="sub_2" value="4">4
                                                <input class="check" type="radio" name="sub_2" value="5" checked>5
                                                <input class="check" type="radio" name="sub_2" value="6">6
                                                <input class="check" type="radio" name="sub_2" value="7">7
                                                <input class="check" type="radio" name="sub_2" value="8">8
                                                <input class="check" type="radio" name="sub_2" value="9">9
                                                <input class="check" type="radio" name="sub_2" value="10">10
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="has-checks">
                                        <legend class="legend no-letter"></legend>
                                        <div class="wrap clear">
                                            <label class="label l-fleft">보전축 기간</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="pre_1" value="1">1
                                                <input class="check" type="radio" name="pre_1" value="2">2
                                                <input class="check" type="radio" name="pre_1" value="3">3
                                                <input class="check" type="radio" name="pre_1" value="4">4
                                                <input class="check" type="radio" name="pre_1" value="5" checked>5
                                                <input class="check" type="radio" name="pre_1" value="6">6
                                                <input class="check" type="radio" name="pre_1" value="7">7
                                                <input class="check" type="radio" name="pre_1" value="8">8
                                                <input class="check" type="radio" name="pre_1" value="9">9
                                                <input class="check" type="radio" name="pre_1" value="10">10
                                            </div>
                                        </div>
                                        <div class="wrap clear">
                                            <label class="label has-space l-fleft">수익</label>
                                            <div class="check-wrap l-fright">
                                                <input class="check" type="radio" name="pre_2" value="1">1
                                                <input class="check" type="radio" name="pre_2" value="2">2
                                                <input class="check" type="radio" name="pre_2" value="3">3
                                                <input class="check" type="radio" name="pre_2" value="4">4
                                                <input class="check" type="radio" name="pre_2" value="5" checked>5
                                                <input class="check" type="radio" name="pre_2" value="6">6
                                                <input class="check" type="radio" name="pre_2" value="7">7
                                                <input class="check" type="radio" name="pre_2" value="8">8
                                                <input class="check" type="radio" name="pre_2" value="9">9
                                                <input class="check" type="radio" name="pre_2" value="10">10
                                            </div>
                                        </div>
                                    </fieldset>

                                <?php } ?>

                                
                                <fieldset class="select-box">

                                    <?php if ($row_land['land_free_analysis_status'] == '0') { ?>
                                        <input type="text" class="select" value="무료분석 대기중" onfocus="this.blur();"
                                               readonly
                                               placeholder="분석상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option is-selected" data-option="무료분석 대기중">무료분석 대기중</span>
                                            <span class="option" data-option="무료분석 진행중">무료분석 진행중</span>
                                            <span class="option" data-option="무료분석 완료">무료분석 완료</span>
                                        </div>
                                    <?php } elseif ($row_land['land_free_analysis_status'] == '1') { ?>
                                        <input type="text" class="select" value="무료분석 진행중" onfocus="this.blur();"
                                               readonly
                                               placeholder="분석상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option" data-option="무료분석 대기중">무료분석 대기중</span>
                                            <span class="option is-selected" data-option="무료분석 진행중">무료분석 진행중</span>
                                            <span class="option" data-option="무료분석 완료">무료분석 완료</span>
                                        </div>
                                    <?php } else { ?>
                                        <input type="text" class="select" value="무료분석 완료" onfocus="this.blur();"
                                               readonly
                                               placeholder="분석상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option" data-option="무료분석 대기중">무료분석 대기중</span>
                                            <span class="option" data-option="무료분석 진행중">무료분석 진행중</span>
                                            <span class="option is-selected" data-option="무료분석 완료">무료분석 완료</span>
                                        </div>
                                    <?php } ?>


                                </fieldset>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel" onclick="history.back()">취소</button>
                                    <button type="button" class="btn btn_sm" onclick="land_modify()">수정 등록하기</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/script.js"></script>
    <script>
        $("#header").load("../html/_header.php");
    </script>
    <!-- 기존 참고이미지 삭제 스크립트-->
    <script>

        var old_sub_image_list_array = <?php echo json_encode($land_sub_image_list_array); ?>;

        // if(old_sub_image_list_array=null){
        //     old_sub_image_list_array='';
        // }


        //서브 이미지 삭제
        $(function() {
            $(".sub_image_delete").click(function() {
                var img_src= $(this).prev().attr("src");
                console.log(img_src);
                $(this).parent().remove();

                while(true){
                    var search = old_sub_image_list_array.indexOf(img_src);
                    if(search!=-1){
                        old_sub_image_list_array.splice(search,1);
                    }else{
                        break;
                    }
                }
                console.log(old_sub_image_list_array);
            });
        });
    </script>

    <!-- 대표이미지, 참고이미지 업로드 스크립트-->
    <script>
        var $fileInput = $('.form-wrap'),
            $thumbInput = $fileInput.find('#thumbnail'),
            $imgsInput = $fileInput.find('#images'),
            // $imgFileWrap = $fileInput.find('.file-wrap'),
            thumbImg = {}, //대표 이미지
            imgList = []; //참고 이미지 배열

        /* ====== [토지 변경] 이미지 파일 업로드 ======= */
        function registerFormFileFn(){
            //대표 이미지
            $thumbInput.on('change', function(event){

                var $thumbHtml =['<div class="wrap"><span class="tit">'
                    ,'</span><span class="file">'
                    ,'</span><button class="btn btn_del"></button></div>'];

                thumbImg = event.target.files[0];
                var uploaded = event.target.nextElementSibling;
                uploaded.innerHTML= $thumbHtml[0] + '대표이미지' + $thumbHtml[1] + thumbImg.name + $thumbHtml[2];


                $('#thumbnail').next().find('.btn_del').click(function (event) {
                    event.preventDefault();
                    $('#thumbnail').val('');
                    thumbImg = {};
                    $(this).parent().remove();
                })

            });

            //참고 이미지
            $imgsInput.on('change', function(event){
                var stop = false;

                const target = document.getElementsByName('imgList[]');

                $.each(target[0].files, function(index, file){
                    if($(".sub_image").children("div").length > 10){
                        if(!stop){
                            alert("최대 등록 파일은 10개 입니다.");
                            stop = true;
                        }
                    }else{
                        if(!stop){
                            const fileName = file.name;
                            const fileEx = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length).toLowerCase();
                            if(fileEx != "jpg" && fileEx != "png" && fileEx != "jpeg"){
                                alert("파일은 (jpg, png, jpeg) 형식만 등록 가능합니다.");
                                return false;
                            }else{


                                var $imgsHtml =['<div class="wrap sub_image"><span class="tit">참고 이미지</span><span class="file">'
                                    ,'</span><button class="btn btn_del" data-index="'
                                    ,'"></button></div>'];

                                imgList.push(file);
                                $imgsInput.next().append($imgsHtml[0] + fileName + $imgsHtml[1] + (imgList.length - 1) + $imgsHtml[2]);

                            }
                        }
                    }
                });
                $(target).val("");

                //파일 삭제
                $('#images').next().find('.btn_del').off('click').on('click', function(event){
                    event.preventDefault();
                    var delNum = $(this).data('index');
                    var $fileWrap = $(this).parents('.sub_image_uploaded');
                    //파일 태그 삭제
                    $fileWrap.children('.sub_image').eq(delNum).remove();
                    //이미지 리스트 업데이트
                    var imgArr = imgList.slice(delNum+1);
                    imgList = imgList.slice(0, delNum).concat(imgArr);
                    //태그 속성 업데이트
                    for(var idx = delNum; idx < imgArr.length + delNum; idx++){
                        $fileWrap.find('.btn_del').eq(idx).data('index', idx);
                    };


                });
            });
        }registerFormFileFn();

    </script>


    <!-- 토지 변경 버튼 클릭 시 스크립트-->
    <script>
        function land_modify(){



            //토지 변경 기본 정보
            var rg_land_id='<?php echo $land_id?>';
            var rg_land_register_email = $("#land_register_email").val();
            var rg_land_register_name = $("#land_register_name").val();
            var rg_land_register_phone = $("#land_register_phone").val();

            var rg_land_register_title = $("#land_register_title").val();
            var rg_land_register_area = $("#land_register_area").val();
            var rg_land_address = $("#land_address").val();
            var rg_land_x = $("#land_x").val();
            var rg_land_y = $("#land_y").val();
            var rg_land_register_price = $("#land_register_price").val();
            var rg_land_register_content = $("#land_register_content").val();
            var rg_land_master_recommend = '';

            var rg_land_register_area_number = Number(rg_land_register_area);
            var rg_land_register_price_number =  Number(rg_land_register_price);

            //마스터 추천여부
            if($('#master_recommend').is(":checked")==true){
                rg_land_master_recommend='1';
            }else{
                rg_land_master_recommend='0';
            }
            //토지 평가
            var rg_value_1 = $("input[name='value_1']:checked").val();
            var rg_value_2 = $("input[name='value_2']:checked").val();
            var rg_value_3 = $("input[name='value_3']:checked").val();
            var rg_value_4 = $("input[name='value_4']:checked").val();
            var rg_value_5 = $("input[name='value_5']:checked").val();
            var rg_dev_1 = $("input[name='dev_1']:checked").val();
            var rg_dev_2 = $("input[name='dev_2']:checked").val();
            var rg_sub_1 = $("input[name='sub_1']:checked").val();
            var rg_sub_2 = $("input[name='sub_2']:checked").val();
            var rg_pre_1 = $("input[name='pre_1']:checked").val();
            var rg_pre_2 = $("input[name='pre_2']:checked").val();


            //무료분석상황
            //분석 상황
            var free_analysis_search =  $('#analysis_option').children(".is-selected").text();
            var rg_free_analysis_status;
            if(free_analysis_search=='무료분석 대기중'){
                rg_free_analysis_status='0';
            }else if(free_analysis_search=='무료분석 진행중'){
                rg_free_analysis_status='1';
            }else if(free_analysis_search=='무료분석 완료'){
                rg_free_analysis_status='2';
            }


            var thumbnail = document.querySelector("#thumbnail");
            var formData = new FormData();


            if (rg_land_register_email == '') {
                alert('아이디를 입력해주세요')
            } else if (rg_land_register_name == '') {
                alert('전화번호를 입력해주세요')
            }else if (rg_land_register_phone == '') {
                alert('전화번호를 입력해주세요')
            } else if (rg_land_register_phone.length!=11) {
                alert('전화번호 11자리를 정확히 입력해주세요')
            }else if (rg_land_register_title == '') {
                alert('토지 제목을 입력해주세요')
            }else if (rg_land_register_area == '') {
                alert('토지 면적을 입력해주세요')
            }else if (rg_land_register_area_number > 90000000 || rg_land_register_area_number < 1) {
                alert('토지 면적을 정확히 입력해주세요')
            }else if (rg_land_register_price == '') {
                alert('토지 가격을 입력해주세요')
            }else if (rg_land_register_price_number > 9000000000000 || rg_land_register_price_number < 1) {
                alert('토지 가격을 정확히 입력해주세요')
            }else if (rg_land_address == '') {
                alert('토지 주소를 입력해주세요')
            }else if (rg_land_register_content == '') {
                alert('토지 내용을 입력해주세요')
            }else if (imgList.length >10) {
                alert("최대 등록 파일은 10개 입니다.");
            }else {

                // alert(rg_land_register_email+"/"+rg_land_register_name+"/"+rg_land_register_phone+"/"+rg_land_register_title+"/"+
                //     rg_land_register_area+"/"+rg_land_address+"/"+rg_land_x+"/"+rg_land_y+"/"+
                //     rg_land_register_price+"/"+rg_land_register_content+"/"+rg_land_master_recommend
                //     +"/"+rg_value_1+"/"+rg_value_2+"/"+free_analysis_status);

                if(imgList.length>0){
                    for(var i=0;i<imgList.length; i++) {
                        console.log(imgList[i]);
                        console.log(i);
                        formData.append("sub_files[]", imgList[i]);
                    }
                }

                if (thumbnail.files[0]) { // 대표 이미지를 변경한 경우

                }else{  // 대표 이미지를 변경하지 않은 경우
                    console.log(thumbnail.files[0]);
                }

                console.log(imgList.length.toString());




                //토지 변경 데이터
                formData.append("land_id", rg_land_id);
                formData.append("land_email", rg_land_register_email);
                formData.append("land_name", rg_land_register_name);
                formData.append("land_phone", rg_land_register_phone);
                formData.append("land_title", rg_land_register_title);
                formData.append("land_area", rg_land_register_area);
                formData.append("land_price", rg_land_register_price);
                formData.append("land_content", rg_land_register_content);
                formData.append("land_master_recommend", rg_land_master_recommend);
                formData.append("land_free_analysis_status", rg_free_analysis_status);

                formData.append("old_sub_image_list_array", old_sub_image_list_array);
                //토지 파일 데이터
                formData.append("thumbnail",thumbnail.files[0]);
                formData.append("sub_image_count",imgList.length.toString());

                //토지 평가 데이터
                formData.append("value_1", rg_value_1);
                formData.append("value_2", rg_value_2);
                formData.append("value_3", rg_value_3);
                formData.append("value_4", rg_value_4);
                formData.append("value_5", rg_value_5);
                formData.append("dev_1", rg_dev_1);
                formData.append("dev_2", rg_dev_2);
                formData.append("sub_1", rg_sub_1);
                formData.append("sub_2", rg_sub_2);
                formData.append("pre_1", rg_pre_1);
                formData.append("pre_2", rg_pre_2);



                $.ajax({
                    type:"POST",
                    url:"/admin_server/land_modify_server.php",
                    data:formData,
                    cache:false,
                    contentType:false,
                    processData:false,
                    dataType:"text",
                    success:function(result){
                        console.log(result);
                        if(result=='success'){
                            alert("토지 수정을 완료했습니다");
                            location.href='https://landmarking.co.kr/admin/html/land_detail.php?id=<?php echo $land_id?>';
                        }else{
                            alert("토지 수정에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                        alert(errorThrown);
                    }
                });

            }


        }

    </script>

    </body>
    </html>
<?php } ?>