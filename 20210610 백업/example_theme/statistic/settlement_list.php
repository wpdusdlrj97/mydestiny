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
if (!$order) { $order = 'request_date';}
$search = $_GET['search'];
$search =  addslashes($search);
$option = $_GET['option'];

$qry_string = "SELECT * FROM settlement_request where dosa_email is not null ";


if ($search) {
    $search_array = explode(" ", $search);
    $slash_search_zero = addslashes($search_array[0]);
    if ($option == "dosa_name") {
        $qry_string = $qry_string . " && (dosa_name LIKE '%$slash_search_zero%')";
    }elseif ($option == "dosa_nickname") {
        $qry_string = $qry_string . " && (dosa_nickname LIKE '%$slash_search_zero%')";
    }elseif ($option == "dosa_email") {
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

$settlement_no = array();
$dosa_email = array();
$dosa_nickname = array();
$dosa_name = array();
$dosa_account_bank = array();
$dosa_account_number = array();
$commission_price_before = array();
$commission_price_after = array();
$request_date = array();
$deposit_status= array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($settlement_no, $row['no']);
    array_push($dosa_email, $row['dosa_email']);
    array_push($dosa_name, $row['dosa_name']);
    array_push($dosa_nickname, $row['dosa_nickname']);
    array_push($dosa_account_bank, $row['dosa_account_bank']);
    array_push($dosa_account_number, $row['dosa_account_number']);
    array_push($commission_price_before, $row['commission_price_before']);
    array_push($commission_price_after, $row['commission_price_after']);
    array_push($request_date , date('Y.m.d', strtotime($row['request_date'])));
    array_push($deposit_status, $row['deposit_status']);
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 initial-scale=1.0,dosa-scalable=no,maximum-scale=1,width=device-width">
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
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 21.5px; width: 100%; height: 3px; background-color: #2C3B5F;}

        /*검색 창*/
        #main_contents_box_place_search_box {margin-bottom:20px; width: 100%; height: 40px; display: inline-block;}
        #main_contents_box_place_search_select { width: 157px; height: 36px; border: 2px solid #d0d2d5; float: left; }
        #main_contents_box_place_search_select_input { width: 1088px; height: 36px; border-top: 2px solid #d0d2d5; border-right: 2px solid #d0d2d5; border-bottom: 2px solid #d0d2d5; float: left;}
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
        #destiny_table th {padding-top: 8px;padding-bottom: 8px;text-align: center;background-color: #f2f3f5;}
        #main_contents_box_place_pagination {margin-bottom:20px; width: 100%; height: 30px;  float: left;}
        #none_data_table {width: 100%; padding-top: 40px;  padding-bottom: 40px; border-left: 1px solid #d0d2d5; border-right: 1px solid #d0d2d5; border-bottom: 1px solid #d0d2d5;}
        #none_data_table_span {font-size: 14px; font-weight: bold;}
        #destiny_table_move_detail {cursor: pointer; }
        #destiny_table_move_detail:hover {font-weight: bolder;}
        #destiny_click_table {cursor: pointer; }
        #destiny_click_table:hover { background-color: #f7f7f7;}

        /*페이징*/
        #settlement_list_table_pagination_before, #settlement_list_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .settlement_list_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color: #2C3B5F;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
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

            <div id="main_contents_box_place_title">정산 관리</div>
            <div id="main_contents_box_place_title_line"></div>
            <div id="main_contents_box_place_search_box">
                <div id="main_contents_box_place_search_select">
                    <select id="settlement_list_search" class="search_select">
                        <?php if($option=='dosa_email'){  ?>
                            <option>상담가 이름</option>
                            <option>상담가 닉네임</option>
                            <option selected>상담가 이메일</option>

                        <?php   }else if($option=='dosa_nickname'){  ?>
                            <option>상담가 이름</option>
                            <option selected>상담가 닉네임</option>
                            <option>상담가 이메일</option>

                        <?php   }else{  ?>
                            <option selected>상담가 이름</option>
                            <option>상담가 닉네임</option>
                            <option>상담가 이메일</option>
                        <?php   } ?>
                    </select>
                </div>
                <div id="main_contents_box_place_search_select_input">
                    <input type="text" id="dosa_search_input" name="dosa_search_input" size="20" value="<?php echo $search?>"  placeholder="내용을 입력해주세요">
                </div>
                <div id="main_contents_box_place_search_select_button" onclick="search()">
                    검색
                </div>

            </div>
            <div id="main_contents_box_place_order_select">

                <select id="settlement_list_order" class="order_select" onchange="order()">
                    <?php if($order=='commission_price_before'){  ?>
                        <option selected>요청 포인트순</optionselected>
                        <option>요청 날짜순</option>
                    <?php   }else{  ?>
                        <option>요청 포인트순</option>
                        <option selected>요청 날짜순</option>
                    <?php   } ?>
                </select>
            </div>

            <div id="main_contents_box_place_table">

                <?php if($count==0) { ?>
                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="7%">이름</th>
                            <th width="7%">이메일</th>
                            <th width="7%">닉네임</th>
                            <th width="7%">계좌 은행</th>
                            <th width="7%">계좌 번호</th>
                            <th width="6%">정산 요청금액</th>
                            <th width="6%">정산 요청일시</th>
                            <th width="6%">최종 정산금액</th>
                            <th width="5%">정산 상태</th>
                        </tr>
                    </table>
                    <div id="none_data_table"><span id="none_data_table_span">검색한 데이터가 존재하지 않습니다</span></div>
                <?php }else{ ?>

                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="7%">이름</th>
                            <th width="7%">이메일</th>
                            <th width="7%">닉네임</th>
                            <th width="7%">계좌 은행</th>
                            <th width="7%">계좌 번호</th>
                            <th width="6%">정산 요청포인트</th>
                            <th width="6%">정산 요청일시</th>
                            <th width="6%">최종 정산금액</th>
                            <th width="5%">정산 상태</th>
                        </tr>
                        <?php for ($x = 0; $x < $count; $x++) { ?>
                            <tr id='destiny_click_table' onclick="location.href='settlement_detail.php?settlement_no=<?php echo $settlement_no[$x] ?>'">
                                <td><?php echo $x+$page*15+1 ?></td>
                                <td><?php echo $dosa_name[$x] ?></td>
                                <td><?php echo $dosa_email[$x] ?></td>
                                <td><?php echo $dosa_nickname[$x] ?></td>
                                <td><?php echo $dosa_account_bank[$x] ?></td>
                                <td><?php echo $dosa_account_number[$x] ?></td>
                                <td><?php echo number_format($commission_price_before[$x]).'P' ?></td>
                                <td><?php echo $request_date[$x] ?></td>
                                <td><?php echo number_format($commission_price_after[$x]).'원' ?></td>
                                <?php if($deposit_status[$x]==0){ ?>
                                    <td style="color: red; font-weight: bold">정산 전</td>
                                <?php  }else if($deposit_status[$x]==1){ ?>
                                    <td style="color: #2C3B5F; font-weight: bold">정산완료</td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                    </table>

                <?php } ?>
            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { // 1페이지가 아닐 경우
                    if ($option) { ?>
                        <img id="settlement_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="settlement_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="settlement_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page - 1 ?>'">
                    <?php }
                }


                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) {
                            if ($option) { ?>
                                <div class="settlement_list_table_pagination_page pagination_selected"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="settlement_list_table_pagination_page pagination_selected"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="settlement_list_table_pagination_page pagination_selected"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }

                        } else {
                            if ($option) { ?>
                                <div class="settlement_list_table_pagination_page"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } elseif($order) { ?>
                                <div class="settlement_list_table_pagination_page"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>&order=<?php echo $order ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="settlement_list_table_pagination_page"
                                     onclick="location.href='settlement_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }
                        }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ($page + 1 != $page_count && $page_count > 0) {

                    if ($option) { ?>
                        <img id="settlement_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php } elseif($order) { ?>
                        <img id="settlement_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>'">
                    <?php } else { ?>
                        <img id="settlement_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='settlement_list.php?page=<?php echo $page + 1 ?>'">

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

    // 유저리스트 검색 함수
    function search(){

        var settlement_list_search = document.getElementById("settlement_list_search");
        //검색 옵션
        var select_search = settlement_list_search.options[settlement_list_search.selectedIndex].text;
        //검색어
        var dosa_search_input = document.getElementById("dosa_search_input").value;

        if(select_search=='상담가 이메일'){
            location.href = "settlement_list.php?option=dosa_email&search="+dosa_search_input;
        }else if(select_search=='상담가 닉네임'){
            location.href = "settlement_list.php?option=dosa_nickname&search="+dosa_search_input;
        }else{ //이름
            location.href = "settlement_list.php?option=dosa_name&search="+dosa_search_input;
        }


    }


    // 유저리스트 정렬 함수
    function order(){
        var settlement_list_order = document.getElementById("settlement_list_order");
        var select_order = settlement_list_order.options[settlement_list_order.selectedIndex].text;

        if(select_order=='요청 포인트순'){
            location.href = "settlement_list.php?order=commission_price_before";
        }else{ //작성 일자순
            location.href = "settlement_list.php?order=request_date";
        }

    }




    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_statistic_menu_settlement");
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