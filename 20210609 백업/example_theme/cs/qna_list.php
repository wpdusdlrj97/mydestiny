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
$search = $_GET['search'];
$search =  addslashes($search);
$option = $_GET['option'];

$qry_string = "SELECT * FROM qna where qna_writer_email is not null";


if ($search) {
    $search_array = explode(" ", $search);
    $slash_search_zero = addslashes($search_array[0]);
    if ($option == "qna_writer_name") {
        $qry_string = $qry_string . " && (qna_writer_name LIKE '%$slash_search_zero%')";
    }elseif ($option == "qna_writer_nickname") {
        $qry_string = $qry_string . " && (qna_writer_nickname LIKE '%$slash_search_zero%')";
    }elseif ($option == "qna_writer_email") {
        $qry_string = $qry_string . " && (qna_writer_email LIKE '%$slash_search_zero%')";
    }
    for ($x = 1; $x < count($search_array); $x++) {
        $slash_search_array = $search_array[$x];
        if ($option == "qna_writer_name") {
            $qry_string = $qry_string . " && (qna_writer_name LIKE '%$slash_search_array%')";
        }elseif ($option == "qna_writer_nickname") {
            $qry_string = $qry_string . " && (qna_writer_nickname LIKE '%$slash_search_array%')";
        } elseif ($option == "qna_writer_email") {
            $qry_string = $qry_string . " && (qna_writer_email LIKE '%$slash_search_array%')";
        }
    }
    $qry_string = $qry_string . " ORDER BY qna_date DESC";
} else {
    $qry_string = $qry_string . " ORDER BY qna_date DESC";
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


$qna_number = array();
$qna_writer_email = array();
$qna_writer_name = array();
$qna_writer_nickname = array();
$qna_writer_type = array();
$qna_title = array();
$qna_content = array();
$qna_date = array();
$qna_reply_status = array();

while ($row = mysqli_fetch_array($qry)) {
    array_push($qna_number, $row['qna_number']);
    array_push($qna_writer_email, $row['qna_writer_email']);
    array_push($qna_writer_name, $row['qna_writer_name']);
    array_push($qna_writer_nickname, $row['qna_writer_nickname']);
    array_push($qna_writer_type, $row['qna_writer_type']);
    array_push($qna_title, $row['qna_title']);
    array_push($qna_content, $row['qna_content']);
    array_push($qna_date, date('Y.m.d', strtotime($row['qna_date'])));
    array_push($qna_reply_status, $row['qna_reply_status']);
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
        #qna_list_table_pagination_before, #qna_list_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .qna_list_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color: #2C3B5F;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
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

            <div id="main_contents_box_place_title">1대1 문의</div>
            <div id="main_contents_box_place_title_line"></div>
            <div id="main_contents_box_place_search_box">
                <div id="main_contents_box_place_search_select">
                    <select id="qna_list_search" class="search_select">
                        <?php if($option=='qna_writer_email'){  ?>
                            <option>이름</option>
                            <option>닉네임</option>
                            <option selected>이메일</option>

                        <?php   }else if($option=='qna_writer_nickname'){  ?>
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

            <div id="main_contents_box_place_table">

                <?php if($count==0) { ?>
                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="5%">분류</th>
                            <th width="20%">문의제목</th>
                            <th width="10%">이메일</th>
                            <th width="10%">이름</th>
                            <th width="10%">닉네임</th>
                            <th width="5%">문의 일시</th>
                            <th width="5%">답변 여부</th>
                        </tr>
                    </table>
                    <div id="none_data_table"><span id="none_data_table_span">검색한 데이터가 존재하지 않습니다</span></div>
                <?php }else{ ?>

                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="5%">분류</th>
                            <th width="20%">문의제목</th>
                            <th width="10%">이메일</th>
                            <th width="10%">이름</th>
                            <th width="10%">닉네임</th>
                            <th width="5%">문의 일시</th>
                            <th width="5%">답변 여부</th>
                        </tr>
                        <?php for ($x = 0; $x < $count; $x++) { ?>
                            <tr id='destiny_click_table' onclick="location.href='qna_detail.php?qna_number=<?php echo $qna_number[$x]?>'">
                                <td><?php echo $x+$page*15+1 ?></td>
                                <td><?php
                                    if($qna_writer_type[$x]==0){
                                        echo '사용자';
                                    }else{
                                        echo '상담가';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                    //내용의 길이
                                    $qna_title_short=$qna_title[$x];
                                    $qna_title_length= mb_strlen($qna_title[$x],'utf-8');
                                    if($qna_title_length>20){ // 공지사항의 내용이 20자보다 길 경우
                                        $qna_title_long = mb_substr($qna_title[$x], 0, 19,'utf-8');
                                        echo $qna_title_long.'...';
                                    }else{ // 공지사항의 내용이 20자보다 짧을 경우
                                        echo $qna_title_short;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $qna_writer_email[$x] ?></td>
                                <td><?php echo $qna_writer_name[$x] ?></td>
                                <td><?php echo $qna_writer_nickname[$x] ?></td>

                                <td><?php echo $qna_date[$x] ?></td>
                                <?php if($qna_reply_status[$x]==0){ ?>
                                    <td style="color: red; font-weight: bold">미답변</td>
                                <?php  }else if($qna_reply_status[$x]==1){ ?>
                                    <td style="color: #2C3B5F; font-weight: bold">답변완료</td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                    </table>

                <?php } ?>
            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { // 1페이지가 아닐 경우
                    if ($option) { ?>
                        <img id="qna_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='qna_list.php?page=<?php echo $page - 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php }  else { ?>
                        <img id="qna_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='qna_list.php?page=<?php echo $page - 1 ?>'">
                    <?php }
                }


                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) {
                            if ($option) { ?>
                                <div class="qna_list_table_pagination_page pagination_selected"
                                     onclick="location.href='qna_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php }  else { ?>
                                <div class="qna_list_table_pagination_page pagination_selected"
                                     onclick="location.href='qna_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }

                        } else {
                            if ($option) { ?>
                                <div class="qna_list_table_pagination_page"
                                     onclick="location.href='qna_list.php?page=<?php echo $x ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'"><?php echo $x + 1 ?></div>
                            <?php } else { ?>
                                <div class="qna_list_table_pagination_page"
                                     onclick="location.href='qna_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>
                            <?php }
                        }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ($page + 1 != $page_count && $page_count > 0) {

                    if ($option) { ?>
                        <img id="qna_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='qna_list.php?page=<?php echo $page + 1 ?>&option=<?php echo $option ?>&search=<?php echo $search ?>'">
                    <?php }  else { ?>
                        <img id="qna_list_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='qna_list.php?page=<?php echo $page + 1 ?>'">

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

        var qna_list_search = document.getElementById("qna_list_search");
        //검색 옵션
        var select_search = qna_list_search.options[qna_list_search.selectedIndex].text;
        //검색어
        var user_search_input = document.getElementById("user_search_input").value;

        if(select_search=='이메일'){
            location.href = "qna_list.php?option=qna_writer_email&search="+user_search_input;
        }else if(select_search=='닉네임'){
            location.href = "qna_list.php?option=qna_writer_nickname&search="+user_search_input;
        }else{ //이름
            location.href = "qna_list.php?option=qna_writer_name&search="+user_search_input;
        }


    }




    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_cs_menu_qna");
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