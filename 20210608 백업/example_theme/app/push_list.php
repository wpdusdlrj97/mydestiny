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


$qry_string = "SELECT * FROM push ORDER BY push_date DESC";



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


$push_number = array();
$push_target = array();
$push_title  = array();
$push_content  = array();
$push_date= array();
$push_time= array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($push_number, $row['push_number']);
    array_push($push_target, $row['push_target']);
    array_push($push_title, $row['push_title']);
    array_push($push_content, $row['push_content']);
    array_push($push_date, date('Y.m.d', strtotime($row['push_date'])));
    array_push($push_time, date('H:i:s', strtotime($row['push_date'])));
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
        #destiny_table th {padding-top: 8px;padding-bottom: 8px;text-align: center;background-color: #f2f3f5; color:  #2C3B5F;}
        #main_contents_box_place_pagination {margin-bottom:20px; width: 100%; height: 30px;  float: left;}
        #none_data_table {width: 100%; padding-top: 40px;  padding-bottom: 40px; border-left: 1px solid #d0d2d5; border-right: 1px solid #d0d2d5; border-bottom: 1px solid #d0d2d5;}
        #none_data_table_span {font-size: 14px; font-weight: bold;}
        #destiny_click_table {cursor: pointer; }
        #destiny_click_table:hover { background-color: #f7f7f7;}

        /*페이징*/
        #push_list_table_pagination_before, #push_list_table_pagination_next {display: inline-block;vertical-align: middle;width: 10px;height: 20px;padding: 6px 11px;margin: 0 10px;cursor: pointer;}
        .push_list_table_pagination_page {display: inline-block;vertical-align: middle;width: 30px;height: 30px;border: solid 1px #D0D2D5;text-align: center;line-height: 30px;color:  #2C3B5F;font-size: 16px;margin: 0 10px;cursor: pointer;background-color: #FFFFFF;}
        .pagination_selected {border: solid 2px red;color: red;font-weight: bolder;}

        /* 버튼*/
        .write_button {float: right;margin-right:10px; width: 107px; height: 32px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 14px; color:  #2C3B5F; text-align: center; line-height: 32px; cursor: pointer;}
        .write_button:hover{background-color: #2C3B5F; color: white; }


        /* 모달 */
        .modal {display:none;position: fixed;z-index: 1;padding-top: 200px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 500px; height: 480px;}
        .close {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close:hover,
        .close:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_content_left{margin-top:30px; width: 120px; height: 300px; float: left; text-align: left;}
        #modal_content_left_title{margin-top:10px;margin-left:30px; width: 80px; height: 40px;  font-size: 14px; display: inline-block;float: left;}
        #modal_content_left_type{margin-top:10px;margin-left:30px; width: 80px; height: 40px; font-size: 14px;display: inline-block;float: left;}
        #modal_content_left_content{margin-top:10px;margin-left:30px; width: 80px; height: 160px;  font-size: 14px;display: inline-block;float: left;}
        #modal_content_left_date{margin-top:10px;margin-left:30px; width: 80px; height: 40px; font-size: 14px;display: inline-block;float: left;}
        #modal_content_right{margin-top:30px;width: 380px; height: 300px;  font-size: 14px;  float: left;}
        #modal_content_right_title{margin-top:5px; width: 330px; height: 18px; padding: 5px; border: 1px solid #ddd; display: inline-block;float: left;}
        #modal_content_right_type{margin-top:20px; width: 100px; height: 28px; border: 1px solid #ddd; display: inline-block;float: left;}
        #modal_content_right_content{margin-top:20px; width: 330px; height: 138px; padding: 5px; border: 1px solid #ddd; display: inline-block;float: left;}
        #modal_content_right_date{margin-top:20px; width: 340px; height: 18px; padding: 5px; border: 1px solid #ddd; display: inline-block;float: left;}

        #modal_content_full{margin-top:50px;width: 500px; height: 50px;  font-size: 14px;  float: left;}
        #modal_content_full_send_button{float: right;margin-right:40px; width: 60px; height: 25px;background-color: #2C3B5F; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color: white; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_content_full_cancel_button{float: right;margin-right:10px; width: 60px; height: 25px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 25px; cursor: pointer;}



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

            <div id="main_contents_box_place_title">푸시 알림</div>
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
                            <th width="5%">전송일자</th>
                            <th width="5%">전송시각</th>
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
                            <th width="5%">전송일자</th>
                            <th width="5%">전송시각</th>
                        </tr>
                        <?php for ($x = 0; $x < $count; $x++) { ?>
                            <tr id='destiny_click_table' onclick="location.href='push_detail.php?push_number=<?php echo $push_number[$x]?>'">
                                <td><?php echo $x+$page*15+1 ?></td>
                                <td><?php
                                    if($push_target[$x]==0){
                                        echo '전체';
                                    }else if($push_target[$x]==1){
                                        echo '사용자';
                                    }else{
                                        echo '상담가';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //내용의 길이
                                    $push_title_short=$push_title[$x];
                                    $push_title_length= mb_strlen($push_title[$x],'utf-8');
                                    if($push_title_length>20){ // 공지사항의 내용이 20자보다 길 경우
                                        $push_title_long = mb_substr($push_title[$x], 0, 19,'utf-8');
                                        echo $push_title_long.'...';
                                    }else{ // 공지사항의 내용이 20자보다 짧을 경우
                                        echo $push_title_short;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                    //내용의 길이
                                    $push_content_short=$push_content[$x];
                                    $push_content_length= mb_strlen($push_content[$x],'utf-8');
                                    if($push_content_length>40){ // 공지사항의 내용이 40자보다 길 경우
                                        $push_content_long = mb_substr($push_content[$x], 0, 39,'utf-8');
                                        echo $push_content_long.'...';
                                    }else{ // 공지사항의 내용이 20자보다 짧을 경우
                                        echo $push_content_short;
                                    }
                                    ?>
                                </td>
                                <td>관리자</td>
                                <td><?php echo $push_date[$x] ?></td>
                                <td><?php echo $push_time[$x] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>

            <div id="main_contents_box_place_pagination">
                <?php if ($page > 0) { ?>

                    <img id="push_list_table_pagination_before"
                         src="/admin/image/index_before.png"
                         onclick="location.href='push_list.php?page=<?php echo $page - 1 ?>'">

                <?php }


                if ($all_count > 0) {
                    for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                        if ($x == $page) { ?>

                            <div class="push_list_table_pagination_page pagination_selected"
                                 onclick="location.href='push_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>


                        <?php } else {  ?>

                            <div class="push_list_table_pagination_page"
                                 onclick="location.href='push_list.php?page=<?php echo $x ?>'"><?php echo $x + 1 ?></div>

                        <?php }
                        if ($x + 1 == $page_count) {
                            break;
                        }
                    }
                }
                if ($page + 1 != $page_count && $page_count > 0) { ?>

                    <img id="push_list_table_pagination_next"
                         src="/admin/image/index_next.png"
                         onclick="location.href='push_list.php?page=<?php echo $page + 1 ?>'">


                <?php  } ?>


                <div class="write_button" onclick="send_push()">푸시 알림 전송</div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal_content">
                    <div id="modal_content_head">
                        <span id="modal_content_head_span">푸시 알림 전송</span> <span class="close">&times;</span>
                    </div>
                    <div id='modal_content_left'>
                        <span id='modal_content_left_title'>제목</span>
                        <span id='modal_content_left_type'>분류</span>
                        <span id='modal_content_left_content'>내용</span>
                        <span id='modal_content_left_date'>날짜/시간</span>
                    </div>

                    <div id='modal_content_right'>
                        <input id='modal_content_right_title' type="text" maxlength="20" placeholder="20자 이내로 작성해주세요">
                        <select id='modal_content_right_type' >
                            <option>전체</option>
                            <option>사용자</option>
                            <option>상담가</option>
                        </select>
                        <textarea id='modal_content_right_content' maxlength="100" ></textarea>
                        <input id='modal_content_right_date' type="datetime-local" style="font-family: 'Malgun Gothic';">

                    </div>
                    <div id='modal_content_full'>
                        <div id='modal_content_full_send_button'  onclick="send_push_okay()">전송</div>
                        <div id='modal_content_full_cancel_button'  onclick="send_push_cancel()">취소</div>
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



    function send_push(){
        modal.style.display = "block";
    }


    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
        window.location.reload();
    }


    function send_push_okay(){
        var modal_content_right_title= $("#modal_content_right_title").val();
        var modal_content_right_type = $("#modal_content_right_type option:selected").text();
        if(modal_content_right_type=='전체'){
            modal_content_right_type='all'
        }else if(modal_content_right_type=='사용자'){
            modal_content_right_type='user'
        }else if(modal_content_right_type=='상담가'){
            modal_content_right_type='dosa'
        }
        var modal_content_right_content = $("#modal_content_right_content").val();
        var modal_content_right_date = $("#modal_content_right_date").val();


        var now_date = '<?php echo date( 'YmdHi', time()); ?>';
        now_date = Number(now_date);
        var push_date = modal_content_right_date.replace(/-/g, '');
        push_date = push_date.replace('T', '');
        push_date = push_date.replace(':', '');
        push_date = Number(push_date);






        if(modal_content_right_title==''){
            alert('제목을 입력해주세요')
        }else if(modal_content_right_content==''){
            alert('내용을 입력해주세요')
        }else if(modal_content_right_date==''){
            alert('날짜/기간을 입력해주세요')
        }else if(now_date >= push_date){
            alert('푸시 알림은 현재 시간 이후부터 예약전송이 가능합니다')
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/push_server.php"
                ,data: {target:modal_content_right_type,title:modal_content_right_title,content:modal_content_right_content,push_time:push_date}
                ,success:function(result){
                    console.log(result);
                    if(result=='fail'){
                        alert("푸시알림 예약에 실패하였습니다. 다시한번 시도해주세요");
                    }else{
                        alert("푸시알림이 예약되었습니다");
                        location.href='/admin/theme/app/push_list.php';
                    }

                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
            //alert(modal_content_right_title+' / '+ modal_content_right_type+' / '+modal_content_right_content+' / '+push_date)
        }


    }
    function send_push_cancel(){
        modal.style.display = "none";
        window.location.reload();
    }


    window.onload = function(){
        change_layout_design();
    };



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_app_menu_push");
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