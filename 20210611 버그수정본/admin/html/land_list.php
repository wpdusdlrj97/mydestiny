<?php
//토지 매물 리스트 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";
//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {

    $qry_string_admin = "SELECT * FROM admin_information where admin_email='$admin_session'";
    $qry_admin = mysqli_query($connect, $qry_string_admin);
    $row_admin = mysqli_fetch_array($qry_admin);
    $total_row_admin = mysqli_num_rows($qry_admin);

    $page = $_GET['page'];
    if (!$page) {
        $page = 0;
    }


    $search = $_GET['search'];
    $search = addslashes($search);
    $option = $_GET['option'];





    //결제 상황
    $filter_master_status = $_GET['filter_master_status'];
    if (!$filter_master_status) {
        $filter_master_status = 'all';
    }
    //상품 이름
    $filter_analysis = $_GET['filter_analysis'];
    if (!$filter_analysis) {
        $filter_analysis = 'all';
    }


    //$qry_string = "SELECT * FROM pay_information where pay_id is not null and pay_type='trans'";


    //마스터 추천 여부
    if($filter_master_status=='common'){ // 마스터 추천
        $qry_string = "SELECT * FROM land_information where land_master_recommend='0'";

    }else if($filter_master_status=='master'){ // 일반
        $qry_string = "SELECT * FROM land_information where land_master_recommend='1'";

    }else{ //전체
        $qry_string = "SELECT * FROM land_information where land_id is not null";
    }


    //분석 진행 여부
    if($filter_analysis=='wait'){ // 무료분석 대기중
        $qry_string = $qry_string ." and land_free_analysis_status='0'";

    }else if($filter_analysis=='ing'){ // 무료분석 진행중
        $qry_string = $qry_string ." and land_free_analysis_status='1'";

    }else if($filter_analysis=='complete'){ // 무료분석 완료
        $qry_string = $qry_string ." and land_free_analysis_status='2'";

    }else{ //전체

    }



    //검색 필터
    if ($search) {

        $search_array = explode(" ", $search);
        $slash_search_zero = addslashes($search_array[0]);
        if ($option == "land_register_id") {
            $qry_string = $qry_string . " && (land_register_id LIKE '%$slash_search_zero%')";
        } elseif ($option == "land_register_name") {
            $qry_string = $qry_string . " && (land_register_name LIKE '%$slash_search_zero%')";
        } elseif ($option == "land_address") {
            $qry_string = $qry_string . " && (land_address LIKE '%$slash_search_zero%')";
        }
        for ($x = 1; $x < count($search_array); $x++) {
            $slash_search_array = $search_array[$x];
            if ($option == "land_register_id") {
                $qry_string = $qry_string . " && (land_register_id LIKE '%$slash_search_array%')";
            } elseif ($option == "land_register_name") {
                $qry_string = $qry_string . " && (land_register_name LIKE '%$slash_search_array%')";
            } elseif ($option == "land_address") {
                $qry_string = $qry_string . " && (land_address LIKE '%$slash_search_array%')";
            }
        }
        $qry_string = $qry_string . " ORDER BY land_register_date DESC";



    } else {


        $qry_string = $qry_string . " ORDER BY land_register_date DESC";


    }



    $qry = mysqli_query($connect, $qry_string);
    $all_count = mysqli_num_rows($qry);

    //페이징을 위한 페이지 수 계산
    $page_count = (int)($all_count / 5);
    //현재 페이지에서 나열할 글 수
    $count = 0;

    if ($all_count - ($page * 5) >= 5) {
        $count = 5;
    } else {
        $count = $all_count - ($page * 5);
    }


    if ($all_count % 5 > 0) {
        $page_count++;
    }

    $qry_string = $qry_string . " LIMIT " . ($page * 5) . ", 5";
    $qry = mysqli_query($connect, $qry_string);


    $land_id = array();
    $land_register_id = array();
    $land_register_name = array();
    $land_register_title = array();
    $land_address = array();
    $land_register_area = array();
    $land_register_price = array();
    $land_master_recommend = array();
    $land_click= array();
    $land_free_analysis_status= array();
    $land_register_date = array();


    while ($row = mysqli_fetch_array($qry)) {

        array_push($land_id, $row['land_id']);
        array_push($land_register_id, $row['land_register_id']);
        array_push($land_register_name, $row['land_register_name']);
        array_push($land_register_title, $row['land_register_title']);
        array_push($land_address, $row['land_address']);
        array_push($land_register_area, $row['land_register_area']);
        array_push($land_register_price, $row['land_register_price']);
        array_push($land_master_recommend, $row['land_master_recommend']);
        array_push($land_click, $row['land_click']);
        array_push($land_free_analysis_status, $row['land_free_analysis_status']);
        array_push($land_register_date, date('Y.m.d H:i', strtotime($row['land_register_date'])));


    }

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
    </head>
    <body>

    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">토지 매물</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form onsubmit="return false;">
                                <fieldset class="select-box is-id">
                                    <?php if ($option == 'land_address') { ?>
                                        <input type="text" class="select" value="주소" onfocus="this.blur();" readonly/>
                                        <div class="options" id="search_option">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option is-selected" data-option="주소">주소</span>
                                        </div>
                                    <?php } elseif ($option == 'land_register_name') { ?>
                                        <input type="text" class="select" value="실명" onfocus="this.blur();" readonly/>
                                        <div class="options" id="search_option">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option is-selected" data-option="실명">실명</span>
                                            <span class="option" data-option="주소">주소</span>
                                        </div>
                                    <?php } else { ?>

                                        <input type="text" class="select" value="아이디" onfocus="this.blur();" readonly/>
                                        <div class="options" id="search_option">
                                            <span class="option is-selected" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option" data-option="주소">주소</span>
                                        </div>
                                    <?php } ?>
                                </fieldset>
                                <input type="text" class="input keywords" id="land_search_input"
                                       name="land_search_input" size="20" value="<?php echo $search ?>"
                                       placeholder="검색어를 입력해주세요">



                                <span class="label label_r">매물종류</span>
                                <fieldset class="select-box">
                                    <?php if ($filter_master_status=='common') { ?>
                                        <input type="text" class="select" value="일반매물" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="master_status_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option is-selected" data-option="일반매물">일반매물</span>
                                            <span class="option" data-option="마스터매물">마스터매물</span>
                                        </div>

                                    <?php } elseif ($filter_master_status=='master') { ?>
                                        <input type="text" class="select" value="마스터매물" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="master_status_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="일반매물">일반매물</span>
                                            <span class="option is-selected" data-option="마스터매물">마스터매물</span>
                                        </div>

                                    <?php }  else { ?>

                                        <input type="text" class="select" value="전체" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="master_status_option">
                                            <span class="option is-selected" data-option="전체">전체</span>
                                            <span class="option" data-option="일반매물">일반매물</span>
                                            <span class="option" data-option="마스터매물">마스터매물</span>
                                        </div>

                                    <?php } ?>

                                </fieldset>


                                <span class="label label_r">분석상황</span>
                                <fieldset class="select-box">
                                    <?php if ($filter_analysis=='wait') { ?>
                                        <input type="text" class="select" value="대기중" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option is-selected" data-option="대기중">대기중</span>
                                            <span class="option" data-option="진행중">진행중</span>
                                            <span class="option" data-option="완료">완료</span>
                                        </div>

                                    <?php } elseif ($filter_analysis=='ing') { ?>
                                        <input type="text" class="select" value="진행중" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="대기중">대기중</span>
                                            <span class="option is-selected" data-option="진행중">진행중</span>
                                            <span class="option" data-option="완료">완료</span>
                                        </div>

                                    <?php } elseif ($filter_analysis=='complete') { ?>
                                        <input type="text" class="select" value="완료" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="대기중">대기중</span>
                                            <span class="option" data-option="진행중">진행중</span>
                                            <span class="option is-selected" data-option="완료">완료</span>
                                        </div>

                                    <?php } else { ?>

                                        <input type="text" class="select" value="전체" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="analysis_option">
                                            <span class="option is-selected" data-option="전체">전체</span>
                                            <span class="option" data-option="대기중">대기중</span>
                                            <span class="option" data-option="진행중">진행중</span>
                                            <span class="option" data-option="완료">완료</span>
                                        </div>

                                    <?php } ?>

                                </fieldset>


                                <button type="submit" class="btn btn_sm" onclick="search()">검색</button>
                            </form>
                        </div>
                        <?php if ($count == 0) { ?>
                            <div style="margin-top:150px;margin-bottom:150px;width: 100%; text-align: center;">
                                <span>조회한 데이터가 존재하지 않습니다</span>
                            </div>
                        <?php } else { ?>
                            <div class="check-area l-fleft">
                                <form onsubmit="return false;">
                                    <div class="check-wrap"><input type="checkbox" class="check-all"></div>
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <div class="check-wrap"><input type="checkbox" class="check" name="land_list"
                                                                       value="<?php echo $land_id[$x] ?>"></div>
                                    <?php } ?>
                                    <button class="btn btn_del btn_modal" onclick="pay_delete()">삭제</button>
                                </form>
                            </div>
                            <div class="table-area l-fright">
                                <table class="table">
                                    <thead class="thead">
                                    <tr class= "tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-id">아이디</th>
                                        <th class="th t-title">제목</th>
                                        <th class="th t-addr">주소</th>
                                        <th class="th t-size">면적</th>
                                        <th class="th t-price">매매가</th>
                                        <th class="th t-sort">매물종류</th>
                                        <th class="th t-views">조회수</th>
                                        <th class="th t-status">분석상황</th>
                                        <th class="th t-date">매물등록일</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <tr class="tr has-link" onClick="location.href='/admin/html/land_detail.php?id=<?php echo $land_id[$x]?>'">
                                            <td class="td t-num"><span class="value"><?php echo $x + $page * 5 + 1 ?></span></td>
                                            <td class="td t-id"><span class="value"><?php echo $land_register_id[$x] ?></span></td>
                                            <td class="td t-title"><span class="value"><?php echo mb_strimwidth($land_register_title[$x], '0', '30', '...', 'utf-8'); ?></span></td>
                                            <td class="td t-addr"><span class="value"><?php echo mb_strimwidth($land_address[$x], '0', '30', '...', 'utf-8'); ?></span></td>
                                            <td class="td t-size"><span class="value"><?php echo number_format($land_register_area[$x]) ?></span>&nbsp;m²</td>
                                            <td class="td t-price"><span class="value"><?php echo number_format($land_register_price[$x]) ?></span>&nbsp;원</td>
                                            <td class="td t-sort">
                                                <span class="value">
                                                    <?php if($land_master_recommend[$x]=='0'){ ?>
                                                        일반매물
                                                    <?php }else{ ?>
                                                        마스터매물
                                                    <?php } ?>
                                                </span>
                                            </td>
                                            <td class="td t-views"><span class="value"><?php echo number_format($land_click[$x]) ?></span></td>
                                            <td class="td t-status">
                                                <span class="value">
                                                    <?php if($land_free_analysis_status[$x]=='0'){ ?>
                                                        대기중
                                                    <?php }else if($land_free_analysis_status[$x]=='1'){ ?>
                                                        진행중
                                                    <?php }else{ ?>
                                                        완료
                                                    <?php } ?>
                                                </span></td>
                                            <td class="td t-date"><span class="value"><?php echo $land_register_date[$x] ?></span></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>

                    </div>
                    <?php if ($count == 0) { ?>

                    <?php } else { ?>
                        <div class="pagenation">
                            <div class="wrap">

                                <?php if ($page > 0) { ?>

                                    <?php if ($option) { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='land_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='land_list.php?page=<?php echo $page - 1 ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"></button>
                                    <?php } ?>

                                <?php } else { ?>
                                    <button class="btn btn_prev"></button>
                                <?php } ?>


                                <?php
                                if ($all_count > 0) {
                                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                                        if ($x == $page) {

                                            if ($option) { ?>
                                                <a class="num on"
                                                   onclick="location.href='land_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num on"
                                                   onclick="location.href='land_list.php?page=<?php echo $x ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"><?php echo $x + 1 ?></a>
                                            <?php }

                                        } else {
                                            if ($option) { ?>
                                                <a class="num"
                                                   onclick="location.href='land_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num"
                                                   onclick="location.href='land_list.php?page=<?php echo $x ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"><?php echo $x + 1 ?></a>
                                            <?php }
                                        }
                                        if ($x + 1 == $page_count) {
                                            break;
                                        }
                                    }
                                } ?>


                                <?php if ($page + 1 != $page_count && $page_count > 0) {
                                    if ($option) { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='land_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='land_list.php?page=<?php echo $page + 1 ?>&filter_master_status=<?php echo $filter_master_status?>&filter_analysis=<?php echo $filter_analysis?>'"></button>

                                    <?php }
                                } else { ?>
                                    <button class="btn btn_next"></button>
                                <?php } ?>


                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </main>
    </div>
    <script src="../js/script.js"></script>
    <script>
        $("#header").load("/admin/html/_header.php");
    </script>

    <script>
        // 토지 매물 검색 함수
        function search() {

            //검색필터
            var select_search = $('#search_option').children(".is-selected").text();
            //검색어
            var land_search_input = document.getElementById("land_search_input").value;



            //마스터 추천 여부
            var master_status_search =  $('#master_status_option').children(".is-selected").text();
            var master_status;
            if(master_status_search=='일반매물'){
                master_status='common';
            }else if(master_status_search=='마스터매물'){
                master_status='master';
            }else{
                master_status='all';
            }


            //분석 상황
            var analysis_search =  $('#analysis_option').children(".is-selected").text();
            var analysis;
            if(analysis_search=='대기중'){
                analysis='wait';
            }else if(analysis_search=='진행중'){
                analysis='ing';
            }else if(analysis_search=='완료'){
                analysis='complete';
            }else{
                analysis='all';
            }




            if (select_search == '아이디') {
                location.href = "land_list.php?option=land_register_id&search=" + land_search_input+"&filter_master_status="+ master_status+"&filter_analysis="+ analysis;
            } else if (select_search == '실명') {
                location.href = "land_list.php?option=land_register_name&search=" + land_search_input+"&filter_master_status="+ master_status+"&filter_analysis="+ analysis;
            } else { //주소
                location.href = "land_list.php?option=land_address&search=" + land_search_input+"&filter_master_status="+ master_status+"&filter_analysis="+ analysis;
            }




        }
    </script>


    <script>
        var land_list_delete_string = '';

        function pay_delete() {
            var obj_length = document.getElementsByName("land_list").length;

            for (var i = 0; i < obj_length; i++) {

                if (document.getElementsByName("land_list")[i].checked == true) {

                    if (land_list_delete_string == '') {
                        land_list_delete_string = land_list_delete_string + "'" + document.getElementsByName("land_list")[i].value + "'";
                    } else {
                        land_list_delete_string = land_list_delete_string + "," + "'" + document.getElementsByName("land_list")[i].value + "'";
                    }
                }
            }

            if (land_list_delete_string == '') {
                alert('삭제할 토지를 선택해주세요');
            } else {

                if (confirm("선택하신 항목을 삭제하시겠습니까?")) { //예 클릭시

                    //alert(land_list_delete_string);

                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/delete_server.php"
                        , data: {delete_type:'land', delete_list: land_list_delete_string}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("선택 항목을 삭제하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/land_list.php";
                            } else {
                                alert("선택 항목 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });

                } else {  //아니오 클릭시
                    land_list_delete_string = '';
                }
            }

        }
    </script>


    </body>
    </html>
<?php } ?>