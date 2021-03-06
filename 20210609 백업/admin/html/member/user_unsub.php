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


    $qry_string = "SELECT * FROM user_information where user_status='1'";


    if ($search) {
        $search_array = explode(" ", $search);
        $slash_search_zero = addslashes($search_array[0]);
        if ($option == "user_name") {
            $qry_string = $qry_string . " && (user_name LIKE '%$slash_search_zero%')";
        } elseif ($option == "user_phone") {
            $qry_string = $qry_string . " && (user_phone LIKE '%$slash_search_zero%')";
        } elseif ($option == "user_email") {
            $qry_string = $qry_string . " && (user_email LIKE '%$slash_search_zero%')";
        }
        for ($x = 1; $x < count($search_array); $x++) {
            $slash_search_array = $search_array[$x];
            if ($option == "user_name") {
                $qry_string = $qry_string . " && (user_name LIKE '%$slash_search_array%')";
            } elseif ($option == "user_phone") {
                $qry_string = $qry_string . " && (user_phone LIKE '%$slash_search_array%')";
            } elseif ($option == "user_email") {
                $qry_string = $qry_string . " && (user_email LIKE '%$slash_search_array%')";
            }
        }
        $qry_string = $qry_string . " ORDER BY user_join_date DESC";
    } else {
        $qry_string = $qry_string . " ORDER BY user_join_date DESC";
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


    $user_email = array();
    $user_name = array();
    $user_phone = array();
    $user_join_date = array();
    $user_withdraw_date = array();
    while ($row = mysqli_fetch_array($qry)) {
        array_push($user_email, $row['user_email']);
        array_push($user_name, $row['user_name']);
        array_push($user_phone, $row['user_phone']);
        array_push($user_join_date, date('Y.m.d', strtotime($row['user_join_date'])));
        array_push($user_withdraw_date, date('Y.m.d', strtotime($row['user_withdraw_date'])));

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
                    <h2 class="title">탈퇴회원</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form onsubmit="return false;">
                                <fieldset class="select-box is-id">
                                    <?php if ($option == 'user_phone') { ?>
                                        <input type="text" class="select" value="전화번호" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option is-selected" data-option="전화번호">전화번호</span>
                                        </div>
                                    <?php } else if ($option == 'user_name') { ?>
                                        <input type="text" class="select" value="실명" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option" data-option="아이디">아이디</span>
                                            <span class="option is-selected" data-option="실명">실명</span>
                                            <span class="option" data-option="전화번호">전화번호</span>
                                        </div>
                                    <?php } else { ?>
                                        <input type="text" class="select" value="아이디" onfocus="this.blur();" readonly/>
                                        <div class="options">
                                            <span class="option is-selected" data-option="아이디">아이디</span>
                                            <span class="option" data-option="실명">실명</span>
                                            <span class="option" data-option="전화번호">전화번호</span>
                                        </div>
                                    <?php } ?>
                                </fieldset>
                                <input type="text" class="input keywords" id="user_search_input"
                                       name="user_search_input" size="20" value="<?php echo $search ?>"
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
                                        <div class="check-wrap"><input type="checkbox" class="check" name="user_list"
                                                                       value="<?php echo $user_email[$x] ?>"></div>
                                    <?php } ?>
                                    <button class="btn btn_del btn_modal" onclick="user_delete()">삭제</button>
                                </form>
                            </div>
                            <div class="table-area l-fright">
                                <table class="table">
                                    <thead class="thead">
                                    <tr class="tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-id">아이디</th>
                                        <th class="th t-name">실명</th>
                                        <th class="th t-tel">휴대폰</th>
                                        <th class="th t-date t-date_latest">회원가입일</th>
                                        <th class="th t-date t-date_join">탈퇴일</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php for ($x = 0; $x < $count; $x++) { ?>
                                        <tr class="tr">
                                            <td class="td t-num"><span
                                                        class="value"><?php echo $x + $page * 5 + 1 ?></span>
                                            </td>
                                            <td class="td t-id"><span class="value"><?php echo $user_email[$x] ?></span>
                                            </td>
                                            <td class="td t-name"><span
                                                        class="value"><?php echo $user_name[$x] ?></span>
                                            </td>
                                            <td class="td t-tel"><span
                                                        class="value"><?php echo format_phone($user_phone[$x]) ?></span>
                                            </td>
                                            <td class="td t-date t-date_latest"><span class="value"><?php echo $user_join_date[$x] ?></span>
                                            </td>
                                            <td class="td t-date t-date_join"><span
                                                        class="value"><?php echo $user_withdraw_date[$x] ?></span></td>
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
                                                onclick="location.href='user_unsub.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_prev"
                                                onclick="location.href='user_unsub.php?page=<?php echo $page - 1 ?>'"></button>
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
                                                   onclick="location.href='user_unsub.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num on"
                                                   onclick="location.href='user_unsub.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
                                            <?php }

                                        } else {
                                            if ($option) { ?>
                                                <a class="num"
                                                   onclick="location.href='user_unsub.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></a>
                                            <?php } else { ?>
                                                <a class="num"
                                                   onclick="location.href='user_unsub.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></a>
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
                                                onclick="location.href='user_unsub.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"></button>
                                    <?php } else { ?>
                                        <button class="btn btn_next"
                                                onclick="location.href='user_unsub.php?page=<?php echo $page + 1 ?>'"></button>

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
        // 유저리스트 검색 함수
        function search() {


            //검색필터
            var select_search = $(".is-selected").text();
            //검색어
            var user_search_input = document.getElementById("user_search_input").value;

            //alert(select_search+'/'+user_search_input);


            if (select_search == '아이디') {
                location.href = "user_unsub.php?option=user_email&search=" + user_search_input;
            } else if (select_search == '실명') {
                location.href = "user_unsub.php?option=user_name&search=" + user_search_input;
            } else { //전화번호
                location.href = "user_unsub.php?option=user_phone&search=" + user_search_input;
            }


        }
    </script>

    <script>
        var user_list_delete_string = '';

        function user_delete() {
            var obj_length = document.getElementsByName("user_list").length;

            for (var i = 0; i < obj_length; i++) {

                if (document.getElementsByName("user_list")[i].checked == true) {

                    if (user_list_delete_string == '') {
                        user_list_delete_string = user_list_delete_string + "'" +document.getElementsByName("user_list")[i].value+ "'";
                    } else {
                        user_list_delete_string = user_list_delete_string + "," + "'" +document.getElementsByName("user_list")[i].value+ "'";
                    }
                }
            }

            if (user_list_delete_string == '') {
                alert('삭제할 유저를 선택해주세요');
            } else {

                if (confirm("선택하신 항목을 삭제하시겠습니까?")) { //예 클릭시

                    $.ajax({
                        type: "POST"
                        , url: "/admin_server/delete_server.php"
                        , data: {delete_type:'user',delete_list: user_list_delete_string}
                        , success: function (result) {

                            if (result == 'success') {
                                alert("선택 항목을 삭제하였습니다");
                                location.href = "https://landmarking.co.kr/admin/html/member/user_unsub.php";
                            } else {
                                alert("선택 항목 삭제에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                            }
                        }
                        , error: function () {
                            alert("잠시 후에 다시 시도해주세요");
                        }
                    });

                } else {  //아니오 클릭시
                    user_list_delete_string = '';
                }
            }

        }
    </script>


    </body>
    </html>
<?php } ?>