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


$qry_string = "SELECT * FROM notice ORDER BY notice_date DESC";



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


$notice_number = array();
$notice_target = array();
$notice_title  = array();
$notice_content  = array();
$notice_date= array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($notice_number, $row['notice_number']);
    array_push($notice_target, $row['notice_target']);
    array_push($notice_title, $row['notice_title']);
    array_push($notice_content, $row['notice_content']);
    array_push($notice_date, date('Y.m.d', strtotime($row['notice_date'])));
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
        #notice_list_table_pagination_before, #notice_list_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .notice_list_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color:  #2C3B5F;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
        .pagination_selected {border: solid 2px red;color: red;font-weight: bolder;}

        /* 버튼*/
        .write_button {float: right;margin-right:10px; width: 107px; height: 32px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 14px; color:  #2C3B5F; text-align: center; line-height: 32px; cursor: pointer;}
        .write_button:hover{background-color: #2C3B5F; color: white; }
        
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

            <div id="main_contents_box_place_title">공지사항</div>
            <div id="main_contents_box_place_title_line"></div>
            <div id="main_contents_box_place_table">

                <?php if($count==0) { ?>
                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="5%">분류</th>
                            <th width="15%">제목</th>
                            <th width="30%">내용</th>
                            <th width="5%">작성자</th>
                            <th width="5%">작성일자</th>
                        </tr>
                    </table>
                    <div id="none_data_table"><span id="none_data_table_span">검색한 데이터가 존재하지 않습니다</span></div>
                <?php }else{ ?>

                    <table id="destiny_table">
                        <tr>
                            <th width="3%">NO</th>
                            <th width="5%">분류</th>
                            <th width="15%">제목</th>
                            <th width="30%">내용</th>
                            <th width="5%">작성자</th>
                            <th width="5%">작성일자</th>
                        </tr>
                        <?php for ($x = 0; $x < $count; $x++) { ?>
                            <tr id='destiny_click_table' onclick="location.href='notice_detail.php?notice_number=<?php echo $notice_number[$x]?>'">
                                <td><?php echo $x+$page*15+1 ?></td>
                                <td><?php
                                    if($notice_target[$x]==0){
                                        echo '전체';
                                    }else if($notice_target[$x]==1){
                                        echo '사용자';
                                    }else{
                                        echo '상담가';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //내용의 길이
                                    $notice_title_short=$notice_title[$x];
                                    $notice_title_length= mb_strlen($notice_title[$x],'utf-8');
                                    if($notice_title_length>20){ // 공지사항의 내용이 20자보다 길 경우
                                        $notice_title_long = mb_substr($notice_title[$x], 0, 19,'utf-8');
                                        echo $notice_title_long.'...';
                                    }else{ // 공지사항의 내용이 20자보다 짧을 경우
                                        echo $notice_title_short;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                    //내용의 길이
                                    $notice_content_short=$notice_content[$x];
                                    $notice_content_length= mb_strlen($notice_content[$x],'utf-8');
                                    if($notice_content_length>40){ // 공지사항의 내용이 40자보다 길 경우
                                        $notice_content_long = mb_substr($notice_content[$x], 0, 39,'utf-8');
                                        echo $notice_content_long.'...';
                                    }else{ // 공지사항의 내용이 20자보다 짧을 경우
                                        echo $notice_content_short;
                                    }
                                    ?>
                                </td>
                                <td>관리자</td>
                                <td><?php echo $notice_date[$x] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { ?>

                        <img id="notice_list_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='notice_list.php?page=<?php echo $page - 1 ?>'">

                <?php }


                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) { ?>

                                <div class="notice_list_table_pagination_page pagination_selected"
                                     onclick="location.href='notice_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>


                         <?php } else {  ?>

                                <div class="notice_list_table_pagination_page"
                                     onclick="location.href='notice_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>

                        <?php }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ($page + 1 != $page_count && $page_count > 0) { ?>

                    <img id="notice_list_table_pagination_next"
                         src="/admin/image/index_next.png"
                         onclick="location.href='notice_list.php?page=<?php echo $page + 1 ?>'">


                <?php  } ?>


                <div class="write_button" onclick="location.href='notice_write.php'">작성하기</div>
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



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_cs_menu_notice");
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