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
if (!$order) { $order = 'dosa_join_date';}
$search = $_GET['search'];
$search =  addslashes($search);
$option = $_GET['option'];

$qry_string = "SELECT * FROM dosa_information where (dosa_status=0 or dosa_status=1) ";


if ($search) {
    $search_array = explode(" ", $search);
    $slash_search_zero = addslashes($search_array[0]);
    if ($option == "dosa_name") {
        $qry_string = $qry_string . " && (dosa_name LIKE '%$slash_search_zero%')";
    }elseif ($option == "dosa_nickname") {
        $qry_string = $qry_string . " && (dosa_nickname LIKE '%$slash_search_zero%')";
    } elseif ($option == "dosa_email") {
        $qry_string = $qry_string . " && (dosa_email LIKE '%$slash_search_zero%')";
    }
    for ($x = 1; $x < count($search_array); $x++) {
        $slash_search_array = $search_array[$x];
        if ($option == "dosa_name") {
            $qry_string = $qry_string . " && (dosa_name LIKE '%$slash_search_array%')";
        }elseif ($option == "dosa_nickname") {
            $qry_string = $qry_string . " && (dosa_nickname LIKE '%$slash_search_array%')";
        } elseif ($option == "dosa_email") {
            $qry_string = $qry_string . " && (dosa_email LIKE '%$slash_search_array%')";
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


$dosa_email = array();
$dosa_name = array();
$dosa_nickname = array();
$dosa_phone = array();
$dosa_counsel_count = array();
$dosa_counsel_price = array();
$dosa_join_date= array();
$dosa_status= array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($dosa_email, $row['dosa_email']);
    array_push($dosa_name, $row['dosa_name']);
    array_push($dosa_nickname, $row['dosa_nickname']);
    array_push($dosa_phone, $row['dosa_phone']);
    array_push($dosa_counsel_count, $row['dosa_counsel_count']);
    array_push($dosa_counsel_price, $row['dosa_counsel_price']);
    array_push($dosa_join_date, date('Y.m.d', strtotime($row['dosa_join_date'])));
    array_push($dosa_status, $row['dosa_status']);
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
        #destiny_click_table {cursor: pointer; }
        #destiny_click_table:hover { background-color: #f7f7f7;}

        /*페이징*/
        #dosa_list_table_pagination_before, #dosa_list_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .dosa_list_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color: #000000;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
        .pagination_selected {border: solid 2px red;color: red;font-weight: bolder;}


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

            <div id="main_contents_box_place_title">상담가 리스트</div>
            <div id="main_contents_box_place_title_line"></div>
            <div id="main_contents_box_place_search_box">
                <div id="main_contents_box_place_search_select">
                    <select id="dosa_list_search" class="search_select">
                        <?php if($option=='dosa_email'){  ?>
                            <option>이름</option>
                            <option>닉네임</option>
                            <option selected>이메일</option>

                        <?php   }else if($option=='dosa_nickname'){  ?>
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

                <select id="dosa_list_order" class="order_select" onchange="order()">
                    <?php if($order=='dosa_counsel_count'){  ?>
                        <option>최근 가입순</option>
                        <option>상담 누적 금액순</option>
                        <option selected>상담 건수순</option>
                    <?php    }else if($order=='dosa_counsel_price'){  ?>
                        <option>최근 가입순</option>
                        <option selected>상담 누적 금액순</option>
                        <option>상담 건수순</option>
                    <?php   }else{  ?>
                        <option selected>최근 가입순</option>
                        <option>상담 누적 금액순</option>
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
                            <th width="10%">상담 누적 금액</th>
                            <th width="5%">가입 일시</th>
                            <th width="10%">상태</th>

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
                            <th width="10%">상담 누적 금액</th>
                            <th width="5%">가입 일시</th>
                            <th width="10%">상태</th>
                        </tr>

                        <?php for ($x = 0; $x < $count; $x++) { ?>
                            <tr id='destiny_click_table'  onclick="location.href='dosa_detail.php?dosa_email=<?php echo $dosa_email[$x]?>'">
                                <td><?php echo $x + $page * 15 + 1 ?></td>
                                <td><?php echo $dosa_email[$x] ?></td>
                                <td><?php echo $dosa_name[$x] ?></td>
                                <td><?php echo $dosa_nickname[$x] ?></td>
                                <td><?php echo $dosa_phone[$x] ?></td>
                                <td><?php echo number_format($dosa_counsel_count[$x]) . '건' ?></td>
                                <td><?php echo number_format($dosa_counsel_price[$x]) . '원' ?></td>
                                <td><?php echo $dosa_join_date[$x] ?></td>
                                <?php if ($dosa_status[$x] == 0) { ?>
                                    <td style="color: black; font-weight: bold">사용가능</td>
                                <?php } else if ($dosa_status[$x] == 1) { ?>
                                    <td style="color: red; font-weight: bold">사용제한</td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>

            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { // 1페이지가 아닐 경우
                    if ($option) { ?>
                        <img id="dosa_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="dosa_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="dosa_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page - 1 ?>'">
                    <?php }
                }


                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) {
                            if ($option) { ?>
                                <div class="dosa_list_table_pagination_page pagination_selected"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="dosa_list_table_pagination_page pagination_selected"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="dosa_list_table_pagination_page pagination_selected"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }

                        } else {
                            if ($option) { ?>
                                <div class="dosa_list_table_pagination_page"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="dosa_list_table_pagination_page"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="dosa_list_table_pagination_page"
                                     onclick="location.href='dosa_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }
                        }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ($page + 1 != $page_count && $page_count > 0) {

                    if ($option) { ?>
                        <img id="dosa_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="dosa_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="dosa_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='dosa_list.php?page=<?php echo $page + 1 ?>'">

                    <?php }

                } ?>
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

    // 상담가리스트 검색 함수
    function search(){

        var dosa_list_search = document.getElementById("dosa_list_search");
        //검색 옵션
        var select_search = dosa_list_search.options[dosa_list_search.selectedIndex].text;
        //검색어
        var user_search_input = document.getElementById("user_search_input").value;

        if(select_search=='이메일'){
            location.href = "dosa_list.php?option=dosa_email&search="+user_search_input;
        }else if(select_search=='닉네임'){
            location.href = "dosa_list.php?option=dosa_nickname&search="+user_search_input;
        }else{ //이름
            location.href = "dosa_list.php?option=dosa_name&search="+user_search_input;
        }


    }



    // 상담가리스트 정렬 함수
    function order(){
        var dosa_list_order = document.getElementById("dosa_list_order");
        var select_order = dosa_list_order.options[dosa_list_order.selectedIndex].text;

        if(select_order=='상담 건수순'){
            location.href = "dosa_list.php?order=dosa_counsel_count";
        }else if(select_order=='상담 누적 금액순'){
            location.href = "dosa_list.php?order=dosa_counsel_price";
        }else{ //가입
            location.href = "dosa_list.php?order=dosa_join_date";
        }

    }




    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_dosa_menu_list");
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