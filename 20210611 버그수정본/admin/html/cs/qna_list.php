<?php
//문의내역 리스트 페이지
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


    $qry_string = "SELECT * FROM qna_information where qna_id is not null";


    if ($search) {
        $search_array = explode(" ", $search);
        $slash_search_zero = addslashes($search_array[0]);
        if ($option == "qna_writer_email") {
            $qry_string = $qry_string . " && (qna_writer_email LIKE '%$slash_search_zero%')";
        } elseif ($option == "qna_writer_name") {
            $qry_string = $qry_string . " && (qna_writer_name LIKE '%$slash_search_zero%')";
        } elseif ($option == "qna_date") {
            $qry_string = $qry_string . " && (qna_date LIKE '%$slash_search_zero%')";
        }
        for ($x = 1; $x < count($search_array); $x++) {
            $slash_search_array = $search_array[$x];
            if ($option == "qna_writer_email") {
                $qry_string = $qry_string . " && (qna_writer_email LIKE '%$slash_search_array%')";
            } elseif ($option == "qna_writer_name") {
                $qry_string = $qry_string . " && (qna_writer_name LIKE '%$slash_search_array%')";
            }elseif ($option == "qna_date") {
                $qry_string = $qry_string . " && (qna_date LIKE '%$slash_search_array%')";
            }
        }
        $qry_string = $qry_string . " ORDER BY qna_date DESC";
    } else {
        $qry_string = $qry_string . " ORDER BY qna_date DESC";
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


    $qna_id = array();
    $qna_writer_email = array();
    $qna_writer_name = array();
    $qna_title = array();
    $qna_date = array();


    while ($row = mysqli_fetch_array($qry)) {

        array_push($qna_id, $row['qna_id']);
        array_push($qna_writer_email, $row['qna_writer_email']);
        array_push($qna_writer_name, $row['qna_writer_name']);
        array_push($qna_title, $row['qna_title']);
        array_push($qna_date, date('Y.m.d', strtotime($row['qna_date'])));


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
                    <h2 class="title">문의내역</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form onsubmit="return false;">
                                <fieldset class="select-box is-id">
                                    <?php if ($option == 'qna_date') { ?>
                                        <input type="text" class="select" value="문의날짜" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option is-selected" data-option="문의날짜">문의날짜</span>
                                        </div>
                                    <?php }else if($option == 'qna_writer_name'){ ?>
                                        <input type="text" class="select" value="실명" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option is-selected" data-option="실명">실명</span>
                                            <span class="option" data-option="문의날짜">문의날짜</span>
                                        </div>
                                    <?php } else { ?>
                                        <input type="text" class="select" value="아이디" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option is-selected" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option" data-option="문의날짜">문의날짜</span>
                                        </div>
                                    <?php } ?>
                                </fieldset>
                                <input type="text" class="input keywords" id="qna_search_input"
                                       name="qna_search_input" size="20" value="<?php echo $search ?>"
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
                                        <div class="check-wrap"><input type="checkbox" class="check" name="qna_list"
                                                                       value="<?php echo $qna_id[$x] ?>"></div>
                                    <?php } ?>
                                    <button class="btn btn_del btn_modal" onclick="qna_delete()">삭제</button>
                                </form>
                            </div>
                            <div class="table-area l-fright">
                                <table class="table">
                                    <thead class="thead">
                                    <tr class= "tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-id">아이디</th>
                                        <th class="th t-name">실명</th>
                                        <th class="th t-title">제목</th>
                                        <th class="th t-date">문의날짜</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <tr class="tr has-link" onClick="location.href='https://landmarking.co.kr/admin/html/cs/qna_detail.php?id=<?php echo $qna_id[$x]?>'">

                                            <td class="td t-num"><span class="value"><?php echo $x + $page * 5 + 1 ?></span></td>
                                            <td class="td t-id"><span class="value"><?php echo $qna_writer_email[$x] ?></span></td>
                                            <td class="td t-name"><span class="value"><?php echo $qna_writer_name[$x] ?></span></td>
                                            <td class="td t-title"><span class="value"><?php echo $qna_title[$x] ?></span></td>
                                            <td class="td t-date"><span class="value"><?php echo $qna_date[$x] ?></span></td>
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
                                                onclick="location.href='qna_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='qna_list.php?page=<?php echo $page - 1 ?>'"></button>
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
                                                   onclick="location.href='qna_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num on"
                                                   onclick="location.href='qna_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                            <?php }

                                        } else {
                                            if ($option) { ?>
                                                <a class="num"
                                                   onclick="location.href='qna_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num"
                                                   onclick="location.href='qna_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
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
                                                onclick="location.href='qna_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='qna_list.php?page=<?php echo $page + 1 ?>'"></button>

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
            var qna_search_input = document.getElementById("qna_search_input").value;


            if (select_search == '아이디') { //문의자 아이디
                location.href = "qna_list.php?option=qna_writer_email&search=" + qna_search_input;
            } else if(select_search == '실명'){ //문의자 실명
                location.href = "qna_list.php?option=qna_writer_name&search=" + qna_search_input;
            } else { //문의날짜
                location.href = "qna_list.php?option=qna_date&search=" + qna_search_input;
            }


        }
    </script>


    <script>
        var qna_list_delete_string = '';

        function qna_delete() {
            var obj_length = document.getElementsByName("qna_list").length;

            for (var i = 0; i < obj_length; i++) {

                if (document.getElementsByName("qna_list")[i].checked == true) {

                    if (qna_list_delete_string == '') {
                        qna_list_delete_string = qna_list_delete_string + "'" + document.getElementsByName("qna_list")[i].value + "'";
                    } else {
                        qna_list_delete_string = qna_list_delete_string + "," + "'" + document.getElementsByName("qna_list")[i].value + "'";
                    }
                }
            }

            if (qna_list_delete_string == '') {
                alert('삭제할 문의사항을 선택해주세요');
            } else {

                if (confirm("선택하신 항목을 삭제하시겠습니까?")) { //예 클릭시

                    //alert(qna_list_delete_string);

                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/delete_server.php"
                        , data: {delete_type:'qna', delete_list: qna_list_delete_string}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("선택 항목을 삭제하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/cs/qna_list.php";
                            } else {
                                alert("선택 항목 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });

                } else {  //아니오 클릭시
                    qna_list_delete_string = '';
                }
            }

        }
    </script>


    </body>
    </html>
<?php } ?>