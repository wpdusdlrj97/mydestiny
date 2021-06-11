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


    $qry_string = "SELECT * FROM service_information where service_id is not null";


    if ($search) {
        $search_array = explode(" ", $search);
        $slash_search_zero = addslashes($search_array[0]);
        if ($option == "service_name") {
            $qry_string = $qry_string . " && (service_name LIKE '%$slash_search_zero%')";
        } elseif ($option == "service_price") {
            $qry_string = $qry_string . " && (service_price LIKE '%$slash_search_zero%')";
        }
        for ($x = 1; $x < count($search_array); $x++) {
            $slash_search_array = $search_array[$x];
            if ($option == "service_name") {
                $qry_string = $qry_string . " && (service_name LIKE '%$slash_search_array%')";
            } elseif ($option == "service_price") {
                $qry_string = $qry_string . " && (service_price LIKE '%$slash_search_array%')";
            }
        }
        $qry_string = $qry_string . " ORDER BY service_id DESC";
    } else {
        $qry_string = $qry_string . " ORDER BY service_id DESC";
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


    $service_id = array();
    $service_name = array();
    $service_price = array();
    $service_date = array();


    while ($row = mysqli_fetch_array($qry)) {

        array_push($service_id, $row['service_id']);
        array_push($service_name, $row['service_name']);
        array_push($service_price, $row['service_price']);
        array_push($service_date, date('Y.m.d', strtotime($row['service_date'])));


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
        <link rel="stylesheet" href="../../css/default.css">
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="../../css/style.css">

        <!-- SCRIPT -->
        <!--[if lte IE 9]>
        <script src="../../js/lib/IE9.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="../../js/lib/html5shiv.min.js"></script>
        <script src="../../js/lib/jqPIE.js"></script>
        <script src="../../js/lib/PIE.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
    <div class="modal">
        <div class="wrap">
            <span class="txt">삭제하시겠습니까?</span>
            <button class="btn btn_cancel">취소</button>
            <button class="btn btn_confirm">확인</button>
        </div>
    </div>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">결제상품 리스트</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form onsubmit="return false;">
                                <fieldset class="select-box">
                                    <?php if ($option == 'service_price') { ?>
                                        <input type="text" class="select" value="결제금액" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option" data-option="결제상품명">결제상품명</span>
                                            <span class="option is-selected" data-option="결제금액">결제금액</span>
                                        </div>
                                    <?php } else { ?>
                                        <input type="text" class="select" value="결제상품명" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option is-selected" data-option="결제상품명">결제상품명</span>
                                            <span class="option" data-option="결제금액">결제금액</span>
                                        </div>
                                    <?php } ?>
                                </fieldset>
                                <input type="text" class="input keywords" id="service_search_input"
                                       name="service_search_input" size="20" value="<?php echo $search ?>"
                                       placeholder="검색어를 입력해주세요">
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
                                        <div class="check-wrap"><input type="checkbox" class="check" name="service_list"
                                                                       value="<?php echo $service_id[$x] ?>"></div>
                                    <?php } ?>
                                    <button class="btn btn_del btn_modal" onclick="service_delete()">삭제</button>
                                </form>
                            </div>
                            <div class="table-area l-fright">
                                <table class="table">
                                    <thead class="thead">
                                    <tr class= "tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-name">결제상품명</th>
                                        <th class="th t-price">결제금액</th>
                                        <th class="th t-date">등록일</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <tr class="tr has-link"  onClick="window.open('/admin/html/payment/popup_pay.php?id=<?php echo $service_id[$x]?>','pop','width=768, height=596, top=200, left=200');">
                                            <td class="td t-num"><span class="value"><?php echo $x + $page * 5 + 1 ?></span></td>
                                            <td class="td t-name"><span class="value"><?php echo $service_name[$x] ?></span></td>
                                            <td class="td t-price"><span class="value"><?php echo number_format($service_price[$x]) ?></span>원</td>
                                            <td class="td t-date"><span class="value"><?php echo $service_date[$x] ?></span></td>
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
                                                onclick="location.href='pay_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='pay_list.php?page=<?php echo $page - 1 ?>'"></button>
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
                                                   onclick="location.href='pay_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num on"
                                                   onclick="location.href='pay_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                            <?php }

                                        } else {
                                            if ($option) { ?>
                                                <a class="num"
                                                   onclick="location.href='pay_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num"
                                                   onclick="location.href='pay_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
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
                                                onclick="location.href='pay_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='pay_list.php?page=<?php echo $page + 1 ?>'"></button>

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
    <script src="../../js/script.js"></script>
    <script>
        $("#header").load("/admin/html/_header.php");
    </script>

    <script>
        // 공지사항 검색 함수
        function search() {

            //검색필터
            var select_search = $(".is-selected").text();
            //검색어
            var service_search_input = document.getElementById("service_search_input").value;


            if (select_search == '결제상품명') {
                location.href = "pay_list.php?option=service_name&search=" + service_search_input;
            } else { //결제상품금액
                location.href = "pay_list.php?option=service_price&search=" + service_search_input;
            }


        }
    </script>


    <script>
        var service_list_delete_string = '';

        function service_delete() {
            var obj_length = document.getElementsByName("service_list").length;

            for (var i = 0; i < obj_length; i++) {

                if (document.getElementsByName("service_list")[i].checked == true) {

                    if (service_list_delete_string == '') {
                        service_list_delete_string = service_list_delete_string + "'" + document.getElementsByName("service_list")[i].value + "'";
                    } else {
                        service_list_delete_string = service_list_delete_string + "," + "'" + document.getElementsByName("service_list")[i].value + "'";
                    }
                }
            }

            if (service_list_delete_string == '') {
                alert('삭제할 서비스 상품을 선택해주세요');
            } else {

                if (confirm("선택하신 항목을 삭제하시겠습니까?")) { //예 클릭시
                    
                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/delete_server.php"
                        , data: {delete_type:'service', delete_list: service_list_delete_string}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("선택 항목을 삭제하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/payment/pay_list.php";
                            } else {
                                alert("선택 항목 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });

                } else {  //아니오 클릭시
                    service_list_delete_string = '';
                }
            }

        }
    </script>


    </body>
    </html>
<?php } ?>