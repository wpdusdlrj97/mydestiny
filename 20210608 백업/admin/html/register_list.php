<?php
//개인정보 변경
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
    $filter_service_status = $_GET['filter_service_status'];
    if (!$filter_service_status) {
        $filter_service_status = 'all';
    }
    //상품 이름
    $filter_service = $_GET['filter_service'];
    if (!$filter_service) {
        $filter_service = 'all';
    }


    //$qry_string = "SELECT * FROM pay_information where pay_id is not null and pay_type='trans'";


    //진행 상황
    if($filter_service_status=='1'){ //대기중
        $qry_string = "SELECT * FROM pay_information where service_type NOT IN ('1','2') and service_status='1'";

    }else if($filter_service_status=='2'){ //진행중
        $qry_string = "SELECT * FROM pay_information where service_type NOT IN ('1','2') and service_status='2'";

    }else if($filter_service_status=='3'){  //완료
        $qry_string = "SELECT * FROM pay_information where service_type NOT IN ('1','2') and service_status='3'";

    }else{ //전체
        $qry_string = "SELECT * FROM pay_information where service_type NOT IN ('1','2')";
    }


    //결제 상품
    if($filter_service=='rg'){ // 등록 대행
        $qry_string = $qry_string ." and service_type='0'";

    }else if($filter_service=='rg_tel'){ // 등록+전화
        $qry_string = $qry_string ." and service_type='3'";

    }else if($filter_service=='rg_visit'){ // 등록+방문
        $qry_string = $qry_string ." and service_type='4'";

    }else{ //전체

    }



    //검색 필터
    if ($search) {

        $search_array = explode(" ", $search);
        $slash_search_zero = addslashes($search_array[0]);
        if ($option == "buyer_id") {
            $qry_string = $qry_string . " && (buyer_id LIKE '%$slash_search_zero%')";
        } elseif ($option == "buyer_name") {
            $qry_string = $qry_string . " && (buyer_name LIKE '%$slash_search_zero%')";
        } elseif ($option == "land_address") {
            $qry_string = $qry_string . " && (land_address LIKE '%$slash_search_zero%')";
        }
        for ($x = 1; $x < count($search_array); $x++) {
            $slash_search_array = $search_array[$x];
            if ($option == "buyer_id") {
                $qry_string = $qry_string . " && (buyer_id LIKE '%$slash_search_array%')";
            } elseif ($option == "buyer_name") {
                $qry_string = $qry_string . " && (buyer_name LIKE '%$slash_search_array%')";
            } elseif ($option == "land_address") {
                $qry_string = $qry_string . " && (land_address LIKE '%$slash_search_array%')";
            }
        }
        $qry_string = $qry_string . " ORDER BY pay_date DESC";



    } else {


        $qry_string = $qry_string . " ORDER BY pay_date DESC";


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


    $pay_id = array();
    $buyer_id = array();
    $buyer_name = array();
    $buyer_phone = array();
    $land_address = array();
    $pay_type = array();
    $pay_price = array();
    $service_type = array();
    $service_status = array();
    $pay_date = array();

    while ($row = mysqli_fetch_array($qry)) {

        array_push($pay_id, $row['pay_id']);
        array_push($buyer_id, $row['buyer_id']);
        array_push($buyer_name, $row['buyer_name']);
        array_push($buyer_phone, $row['buyer_phone']);
        array_push($land_address, $row['land_address']);
        array_push($pay_type, $row['pay_type']);
        array_push($pay_price, $row['pay_price']);
        array_push($service_type, $row['service_type']);
        array_push($service_status, $row['service_status']);
        array_push($pay_date, date('Y.m.d H:i', strtotime($row['pay_date'])));


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
                    <h2 class="title">등록 대행 요청함</h2>
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
                                    <?php } elseif ($option == 'buyer_name') { ?>
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
                                <input type="text" class="input keywords" id="pay_search_input"
                                       name="pay_search_input" size="20" value="<?php echo $search ?>"
                                       placeholder="검색어를 입력해주세요">



                                <span class="label label_r">상품종류</span>
                                <fieldset class="select-box is-sort">

                                    <?php if ($filter_service == 'rg') { ?>
                                        <input type="text" class="select" value="등록 대행" readonly Placeholder="상품종류">
                                        <div class="options" id="service_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option is-selected" data-option="등록 대행">등록 대행</span>
                                            <span class="option" data-option="등록 + 전화 분석">등록 + 전화 분석</span>
                                            <span class="option" data-option="등록 + 방문 분석">등록 + 방문 분석</span>
                                        </div>

                                    <?php } elseif ($filter_service == 'rg_tel') { ?>
                                        <input type="text" class="select" value="등록 + 전화 분석" readonly Placeholder="상품종류">
                                        <div class="options" id="service_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="등록 대행">등록 대행</span>
                                            <span class="option is-selected" data-option="등록 + 전화 분석">등록 + 전화 분석</span>
                                            <span class="option" data-option="등록 + 방문 분석">등록 + 방문 분석</span>
                                        </div>

                                    <?php }elseif ($filter_service == 'rg_visit') { ?>
                                        <input type="text" class="select" value="등록 + 방문 분석" readonly Placeholder="상품종류">
                                        <div class="options" id="service_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="등록 대행">등록 대행</span>
                                            <span class="option" data-option="등록 + 전화 분석">등록 + 전화 분석</span>
                                            <span class="option is-selected" data-option="등록 + 방문 분석">등록 + 방문 분석</span>
                                        </div>

                                    <?php }else { ?>

                                        <input type="text" class="select" value="전체" readonly Placeholder="상품종류">
                                        <div class="options" id="service_option">
                                            <span class="option is-selected" data-option="전체">전체</span>
                                            <span class="option" data-option="등록 대행">등록 대행</span>
                                            <span class="option" data-option="등록 + 전화 분석">등록 + 전화 분석</span>
                                            <span class="option" data-option="등록 + 방문 분석">등록 + 방문 분석</span>
                                        </div>

                                    <?php } ?>
                                </fieldset>

                                <span class="label label_r">진행상황</span>
                                <fieldset class="select-box">
                                    <?php if ($filter_service_status=='1') { ?>
                                        <input type="text" class="select" value="대기중" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="service_status_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option is-selected" data-option="대기중">대기중</span>
                                            <span class="option" data-option="진행중">진행중</span>
                                            <span class="option" data-option="완료">완료</span>
                                        </div>

                                    <?php } elseif ($filter_service_status=='2') { ?>
                                        <input type="text" class="select" value="진행중" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="service_status_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="대기중">대기중</span>
                                            <span class="option is-selected" data-option="진행중">진행중</span>
                                            <span class="option" data-option="완료">완료</span>
                                        </div>

                                    <?php } elseif ($filter_service_status=='3') { ?>
                                        <input type="text" class="select" value="완료" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="service_status_option">
                                            <span class="option" data-option="전체">전체</span>
                                            <span class="option" data-option="대기중">대기중</span>
                                            <span class="option" data-option="진행중">진행중</span>
                                            <span class="option is-selected" data-option="완료">완료</span>
                                        </div>

                                    <?php } else { ?>

                                        <input type="text" class="select" value="전체" onfocus="this.blur();" readonly placeholder="진행상황">
                                        <div class="options" id="service_status_option">
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
                            <div style="margin-top:150px;margin-bottom:150px;width: 100%;   text-align: center;">
                                <span>조회한 데이터가 존재하지 않습니다</span>
                            </div>
                        <?php } else { ?>
                            <div class="check-area l-fleft">
                                <form onsubmit="return false;">
                                    <div class="check-wrap"><input type="checkbox" class="check-all"></div>
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <div class="check-wrap"><input type="checkbox" class="check" name="pay_list"
                                                                       value="<?php echo $pay_id[$x] ?>"></div>
                                    <?php } ?>
                                    <button class="btn btn_del btn_modal" onclick="pay_delete()">삭제</button>
                                </form>
                            </div>
                            <div class="table-area l-fright">
                                <table class="table">
                                    <thead class="thead">
                                    <tr class="tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-id">아이디</th>
                                        <th class="th t-name">실명</th>
                                        <th class="th t-call">전화번호</th>
                                        <th class="th t-addr">주소</th>
                                        <th class="th t-sort">상품종류</th>
                                        <th class="th t-price">결제금액</th>
                                        <th class="th t-status has-btn">분석진행상황</th>
                                        <th class="th t-date">요청일</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <tr class="tr has-link" onClick="alert('관리자 창')">
                                            <td class="td t-num"><span class="value"><?php echo $x + $page * 5 + 1 ?></span></td>
                                            <td class="td t-id"><span class="value"><?php echo $buyer_id[$x] ?></span></td>
                                            <td class="td t-name"><span class="value"><?php echo $buyer_name[$x] ?></span></td>
                                            <td class="td t-call"><span class="value"><?php echo format_phone($buyer_phone[$x]) ?></span></td>
                                            <td class="td t-addr"><span class="value"><?php echo $land_address[$x] ?></span></td>
                                            <td class="td t-sort"><span class="value">

                                                    <?php if($service_type[$x] == '0') { ?>
                                                        등록 대행
                                                    <?php }  else if($service_type[$x] == '3') { ?>
                                                        등록 + 전화 분석
                                                    <?php }  else if($service_type[$x] == '4') { ?>
                                                        등록 + 방문 분석
                                                    <?php } ?></span></td>
                                            <td class="td t-price"><span class="value"><?php echo number_format($pay_price[$x]) . '원' ?></span></td>
                                            <td class="td t-status"><span class="value">
                                                    <?php if ($service_status[$x] == '1') { ?>
                                                        대기중
                                                    <?php } else if($service_status[$x] == '2') { ?>
                                                        진행중
                                                    <?php }  else if($service_status[$x] == '3') { ?>
                                                        완료
                                                    <?php } ?></span></td>
                                            <td class="td t-date"><span class="value"><?php echo $pay_date[$x] ?></span></td>
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
                                                onclick="location.href='register_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='register_list.php?page=<?php echo $page - 1 ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"></button>
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
                                                   onclick="location.href='register_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num on"
                                                   onclick="location.href='register_list.php?page=<?php echo $x ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"><?php echo $x + 1 ?></a>
                                            <?php }

                                        } else {
                                            if ($option) { ?>
                                                <a class="num"
                                                   onclick="location.href='register_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num"
                                                   onclick="location.href='register_list.php?page=<?php echo $x ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"><?php echo $x + 1 ?></a>
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
                                                onclick="location.href='register_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='register_list.php?page=<?php echo $page + 1 ?>&filter_service_status=<?php echo $filter_service_status?>&filter_service=<?php echo $filter_service?>'"></button>

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
        // 공지사항 검색 함수
        function search() {

            //검색필터
            var select_search = $('#search_option').children(".is-selected").text();
            //검색어
            var pay_search_input = document.getElementById("pay_search_input").value;



            //진행 상황
            var service_status_search =  $('#service_status_option').children(".is-selected").text();
            var service_status;
            if(service_status_search=='대기중'){
                service_status='1';
            }else if(service_status_search=='진행중'){
                service_status='2';
            }else if(service_status_search=='완료'){
                service_status='3';
            }else{
                service_status='all';
            }


            //결제 상품
            var service_search =  $('#service_option').children(".is-selected").text();
            var service;
            if(service_search=='등록 대행'){
                service='rg';
            }else if(service_search=='등록 + 전화 분석'){
                service='rg_tel';
            }else if(service_search=='등록 + 방문 분석'){
                service='rg_visit';
            }else{
                service='all';
            }




            if (select_search == '아이디') {
                location.href = "register_list.php?option=buyer_id&search=" + pay_search_input+"&filter_service_status="+ service_status+"&filter_service="+ service;
            } else if (select_search == '실명') {
                location.href = "register_list.php?option=buyer_name&search=" + pay_search_input+"&filter_service_status="+ service_status+"&filter_service="+ service;
            } else { //주소
                location.href = "register_list.php?option=land_address&search=" + pay_search_input+"&filter_service_status="+ service_status+"&filter_service="+ service;
            }




        }
    </script>


    <script>
        var pay_list_delete_string = '';

        function pay_delete() {
            var obj_length = document.getElementsByName("pay_list").length;

            for (var i = 0; i < obj_length; i++) {

                if (document.getElementsByName("pay_list")[i].checked == true) {

                    if (pay_list_delete_string == '') {
                        pay_list_delete_string = pay_list_delete_string + "'" + document.getElementsByName("pay_list")[i].value + "'";
                    } else {
                        pay_list_delete_string = pay_list_delete_string + "," + "'" + document.getElementsByName("pay_list")[i].value + "'";
                    }
                }
            }

            if (pay_list_delete_string == '') {
                alert('삭제할 결제내역을 선택해주세요');
            } else {

                if (confirm("선택하신 항목을 삭제하시겠습니까?")) { //예 클릭시

                    //alert(pay_list_delete_string);

                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/pay_delete_server.php"
                        , data: {delete_type:'pay', delete_list: pay_list_delete_string}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("선택 항목을 삭제하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/register_list.php";
                            } else {
                                alert("선택 항목 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });

                } else {  //아니오 클릭시
                    pay_list_delete_string = '';
                }
            }

        }
    </script>


    </body>
    </html>
<?php } ?>