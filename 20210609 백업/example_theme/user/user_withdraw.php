<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

$page = $_GET['page'];
if (!$page) { $page = 0; }
$order = $_GET['order'];
if (!$order) { $order = 'user_withdraw_date';}
$search = $_GET['search'];
$option = $_GET['option'];

$qry_string = "SELECT * FROM user_information where user_status=2";


if ($search) {
    $search_array = explode(" ", $search);
    $slash_search_zero = addslashes($search_array[0]);
    if ($option == "user_name") {
        $qry_string = $qry_string . " &&  (user_name LIKE '%$slash_search_zero%')";
    }elseif ($option == "user_nickname") {
        $qry_string = $qry_string . " &&  (user_nickname LIKE '%$slash_search_zero%')";
    } elseif ($option == "user_email") {
        $qry_string = $qry_string . " &&  (user_email LIKE '%$slash_search_zero%')";
    }
    for ($x = 1; $x < count($search_array); $x++) {
        $slash_search_array = $search_array[$x];
        if ($option == "user_name") {
            $qry_string = $qry_string . " && (user_name LIKE '%$slash_search_array%')";
        }elseif ($option == "user_nickname") {
            $qry_string = $qry_string . " && (user_nickname LIKE '%$slash_search_array%')";
        } elseif ($option == "user_email") {
            $qry_string = $qry_string . " && (user_email LIKE '%$slash_search_array%')";
        }
    }
    $qry_string = $qry_string . " ORDER BY $order DESC";
} else {
    $qry_string = $qry_string . " ORDER BY $order DESC";
}


$qry = mysqli_query($connect, $qry_string);
$all_count = mysqli_num_rows($qry);

//페이징을 위한 페이지 수 계산
$page_count = (int)($all_count / 15);
//현재 페이지에서 나열할 글 수
$count = 0;

if ($all_count - ($page * 15) >= 15) {
    $count = 15;
} else {
    $count = $all_count - ($page * 15);
}


if ($all_count % 15 > 0) {
    $page_count++;
}

$qry_string = $qry_string . " LIMIT " . ($page * 15) . ", 15";
$qry = mysqli_query($connect, $qry_string);


$user_email = array();
$user_name = array();
$user_nickname = array();
$user_phone = array();
$user_counsel_count = array();
$user_total_point = array();
$user_withdraw_date= array();
$user_withdraw_reason= array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($user_email, $row['user_email']);
    array_push($user_name, $row['user_name']);
    array_push($user_nickname, $row['user_nickname']);
    array_push($user_phone, $row['user_phone']);
    array_push($user_counsel_count, $row['user_counsel_count']);
    array_push($user_total_point, $row['user_total_point']);
    array_push($user_withdraw_date, date('Y.m.d', strtotime($row['user_withdraw_date'])));
    array_push($user_withdraw_reason, $row['user_withdraw_reason']);
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <meta charset="UTF-8">
    <title>내팔자야 - 관리자 페이지</title>
    <meta name="title" content="내팔자야 - 관리자 페이지"/>
    <meta name="description" content="재미로 보는 12가지 운세부터 신점/사주/타로 관련 '영상,음성 상담'까지 내팔자야"/>
    <meta name="og:locale" content="ko_KR"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://www.myluck.kr/"/>
    <meta property="og:locale" content="ko_KR"/>
    <!-- 홈페이지 아이콘 -->
    <link rel="shortcut icon" href="https://www.myluck.kr/admin/image/web_icon.png">
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body{ padding:0; margin:0; overflow:auto; }
        #global_layout{ float:left; }
        #contents_box{ float:left; width:calc(100% - 314px); min-height:calc(100vh - 55px); margin-top:55px; margin-left:314px; background-color:#FFFFFF; }
        #main_contents_box{ float:left; width:100%; height:100%; text-align:center; }
        #main_contents_box_place{ margin-left: 50px; width:1420px; }
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; color:#2C3B5F;font-size: 20px; font-weight: bold; text-align: left; }
        #main_contents_box_place_title_line {margin-bottom: 21.5px; width: 100%; height: 3px;  background-color: #2C3B5F;}

        /*검색 창*/
        #main_contents_box_place_search_box {margin-bottom:20px; width: 100%; height: 40px; display: inline-block;}
        #main_contents_box_place_search_select { width: 157px; height: 36px; border: 2px solid #d0d2d5; float: left; }
        #main_contents_box_place_search_select_input {width: 1088px; height: 36px; border-top: 2px solid #d0d2d5; border-right: 2px solid #d0d2d5; border-bottom: 2px solid #d0d2d5; float: left;}
        #main_contents_box_place_search_select_button {margin-left:40px; width: 127px; height: 40px;float: left; background-color: #2C3B5F; font-weight: bold; font-size: 14px; color: white; text-align: center; line-height: 40px;}
        .search_select {width: 150px;padding: 9px;background: url(https://farm1.staticflickr.com/379/19928272501_4ef877c265_t.jpg) no-repeat 95% 50%;-webkit-appearance: none;-moz-appearance: none;appearance: none;border: none;font-size: 14px;}
        .search_select::-ms-expand {display: none;}
        input[type=text] {width: 90%;height: 34px;margin-left: 20px;border: none; float: left; font-size: 14px;}
        /*정렬*/
        #main_contents_box_place_order_select {margin-bottom:20px; width: 200px; height: 36px; border: 2px solid #d0d2d5; float: right; }
        .order_select {width: 190px;padding: 9px;background: url(https://farm1.staticflickr.com/379/19928272501_4ef877c265_t.jpg) no-repeat 95% 50%;-webkit-appearance: none;-moz-appearance: none;appearance: none;border: none;font-size: 14px;}
        .order_select::-ms-expand {display: none;}




        /*테이블*/
        #main_contents_box_place_table {margin-bottom:20px; width: 100%; }
        #destiny_table {border-collapse: collapse;width: 100%; font-size: 14px;}
        #destiny_table td, #destiny_table th {border: 1px solid #d0d2d5;padding: 8px;}
        #destiny_table th {padding-top: 8px;padding-bottom: 8px;text-align: center;background-color: #f2f3f5;color: black;}
        #main_contents_box_place_pagination {margin-bottom:20px; width: 100%; height: 30px;  float: left;}
        #none_data_table {width: 100%; padding-top: 40px;  padding-bottom: 40px; border-left: 1px solid #d0d2d5; border-right: 1px solid #d0d2d5; border-bottom: 1px solid #d0d2d5;}
        #none_data_table_span {font-size: 14px; font-weight: bold;}
        #withdraw_reason_detail {font-size: 14px; font-weight: bold; border-bottom: 1px solid black;cursor: pointer;}
        #destiny_table_move_detail {cursor: pointer; }
        #destiny_table_move_detail:hover {font-weight: bolder;}
        #destiny_click_table{ cursor: pointer;}
        #destiny_click_table:hover { background-color: #f7f7f7;}
        /*페이징*/
        #user_withdraw_table_pagination_before, #user_withdraw_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .user_withdraw_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color: #000000;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
        .pagination_selected {border: solid 2px red;color: red;font-weight: bolder;}



        /* 모달 */
        .modal {display:none;position: fixed;z-index: 1;padding-top: 300px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 300px;}
        .close {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close:hover,
        .close:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_content_name{margin-top: 10px;display: inline-block;}
        #modal_content_email_span{width:100%; margin: 20px; font-size: 12px; font-weight: bold;}
        #modal_content_reason{width:70%; margin: 15px; padding:15px; display: inline-block; border: 1px solid #ddd;}
        #modal_content_reason_span{width:100%; margin: 20px; font-size: 12px;}

        input:focus {outline:none; font-family: 'Malgun Gothic';}
        textarea:focus {outline:none; font-family: 'Malgun Gothic';}
        select:focus {outline:none; font-family: 'Malgun Gothic';}
    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">

            <div id="main_contents_box_place_title">탈퇴 유저 리스트</div>
            <div id="main_contents_box_place_title_line"></div>
            <div id="main_contents_box_place_search_box">
                <div id="main_contents_box_place_search_select">
                    <select id="user_withdraw_search" class="search_select">
                        <?php if($option=='user_email'){  ?>
                            <option>이름</option>
                            <option>닉네임</option>
                            <option selected>이메일</option>

                        <?php   }else if($option=='user_nickname'){  ?>
                            <option>이름</option>
                            <option selected>닉네임</option>
                            <option>이메일</option>

                        <?php   }else{  ?>
                            <option selected>이름</option>
                            <option>닉네임</option>
                            <option>이메일</option>
                        <?php   } ?>
                    </select>
                </div>
                <div id="main_contents_box_place_search_select_input">
                    <input type="text" id="user_search_input" name="user_search_input" size="20" value="<?php echo $search?>"  placeholder="내용을 입력해주세요">
                </div>
                <div id="main_contents_box_place_search_select_button" onclick="search()">
                    검색
                </div>

            </div>
            <div id="main_contents_box_place_order_select">

                <select id="user_withdraw_order" class="order_select" onchange="order()">
                    <?php if($order=='user_counsel_count'){  ?>
                        <option>탈퇴 날짜순</option>
                        <option>구매 포인트순</option>
                        <option selected>상담 건수순</option>
                    <?php    }else if($order=='user_total_point'){  ?>
                        <option>탈퇴 날짜순</option>
                        <option selected>구매 포인트순</option>
                        <option>상담 건수순</option>
                    <?php   }else{  ?>
                        <option selected>탈퇴 날짜순</option>
                        <option>구매 포인트순</option>
                        <option>상담 건수순</option>
                    <?php   } ?>
                </select>
            </div>

            <div id="main_contents_box_place_table">
                <?php if($count==0) { ?>
                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="15%">이메일</th>
                            <th width="10%">이름</th>
                            <th width="10%">닉네임</th>
                            <th width="10%">전화번호</th>
                            <th width="10%">총 상담 건수</th>
                            <th width="10%">총 구매 포인트</th>
                            <th width="5%">탈퇴 일시</th>
                            <th width="10%">탈퇴 사유</th>
                        </tr>
                    </table>
                    <div id="none_data_table"><span id="none_data_table_span">검색한 데이터가 존재하지 않습니다</span></div>
                <?php }else{ ?>
                <table id="destiny_table">
                    <tr>
                        <th width="3%">NO</th>
                        <th width="15%">이메일</th>
                        <th width="10%">이름</th>
                        <th width="10%">닉네임</th>
                        <th width="10%">전화번호</th>
                        <th width="10%">총 상담 건수</th>
                        <th width="10%">총 구매 포인트</th>
                        <th width="5%">탈퇴 일시</th>
                        <th width="10%">탈퇴 사유</th>
                    </tr>
                    <?php for ($x = 0; $x < $count; $x++) { ?>
                        <tr id='destiny_click_table'>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $x+$page*15+1 ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $user_email[$x] ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $user_name[$x] ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $user_nickname[$x] ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $user_phone[$x] ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo number_format($user_counsel_count[$x]).'건' ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo number_format($user_total_point[$x]).'P' ?></td>
                            <td onclick="location.href='user_detail.php?user_email=<?php echo $user_email[$x]?>'"><?php echo $user_withdraw_date[$x] ?></td>
                            <td><span id="withdraw_reason_detail" onclick="withdraw_reason_click('<?php echo $user_email[$x] ?>'
                                        ,'<?php $user_withdraw_reason[$x] = str_replace("[", "",  $user_withdraw_reason[$x]);$user_withdraw_reason[$x] = str_replace("]", "",  $user_withdraw_reason[$x]); echo $user_withdraw_reason[$x] ?>')">자세히보기</span></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { // 1페이지가 아닐 경우
                    if ($option) { ?>
                        <img id="user_withdraw_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="user_withdraw_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="user_withdraw_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page - 1 ?>'">
                    <?php }
                }

                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) {
                            if ($option) { ?>
                                <div class="user_withdraw_table_pagination_page pagination_selected"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="user_withdraw_table_pagination_page pagination_selected"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="user_withdraw_table_pagination_page pagination_selected"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }

                        } else {
                            if ($option) { ?>
                                <div class="user_withdraw_table_pagination_page"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="user_withdraw_table_pagination_page"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="user_withdraw_table_pagination_page"
                                     onclick="location.href='user_withdraw.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }
                        }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ( $page + 1 != $page_count && $page_count > 0) {

                    if ($option) { ?>
                        <img id="user_withdraw_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="user_withdraw_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="user_withdraw_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='user_withdraw.php?page=<?php echo $page + 1 ?>'">

                    <?php }

                } ?>
            </div>


            <div id="myModal" class="modal">
                <div class="modal_content">
                    <div id="modal_content_head">
                        <span id="modal_content_head_span" >탈퇴 사유</span> <span class="close">&times;</span>
                    </div>
                    <div id="modal_content_name">
                        <span id="modal_content_email_span"></span>
                    </div>
                    <br>
                    <div id="modal_content_reason" >
                        <span id="modal_content_reason_span"></span>
                    </div>
                </div>

            </div>




        </div>
    </div>
</div>
<div id="footer_contents"></div>
</body>

<script>
    /* 공통 레이아웃 load */
    $("#global_layout").load("/admin/theme/_layout.php");
    $("#footer_contents").load("/admin/theme/_footer.php");


    window.onload = function(){
        change_layout_design();
    };

    // 유저리스트 검색 함수
    function search(){

        var user_withdraw_search = document.getElementById("user_withdraw_search");
        //검색 옵션
        var select_search = user_withdraw_search.options[user_withdraw_search.selectedIndex].text;
        //검색어
        var user_search_input = document.getElementById("user_search_input").value;

        if(select_search=='이메일'){
            location.href = "user_withdraw.php?option=user_email&search="+user_search_input;
        }else if(select_search=='닉네임'){
            location.href = "user_withdraw.php?option=user_nickname&search="+user_search_input;
        }else{ //이름
            location.href = "user_withdraw.php?option=user_name&search="+user_search_input;
        }


    }



    // 유저리스트 정렬 함수
    function order(){
        var user_withdraw_order = document.getElementById("user_withdraw_order");
        var select_order = user_withdraw_order.options[user_withdraw_order.selectedIndex].text;

        if(select_order=='상담 건수순'){
            location.href = "user_withdraw.php?order=user_counsel_count";
        }else if(select_order=='구매 포인트순'){
            location.href = "user_withdraw.php?order=user_total_point";
        }else{ //탈퇴 일자
            location.href = "user_withdraw.php?order=user_withdraw_date";
        }

    }


    /* 탈퇴 사유 모달*/
    function withdraw_reason_click(user_email,withdraw_reason) {
        document.getElementById('modal_content_email_span').innerHTML=user_email+'님의 사유';
        document.getElementById('modal_content_reason_span').innerHTML=withdraw_reason;
        modal.style.display = "block";
    }
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_user_menu_withdraw");
            if(text){
                text.style.color="#f80000";
                text.style.fontWeight="bold";
            }else{
                change_layout_design();
            }
        }, 10);
    }


</script>

</html>