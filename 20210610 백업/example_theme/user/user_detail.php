<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}

//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

/* 유저 정보*/
$user_email = $_GET['user_email'];

$qry_string_user = "SELECT * FROM user_information where user_email='$user_email'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);

/* 유저 상담목록 */
$page = $_GET['page'];
if (!$page) {
    $page = 0;
}

$qry_string = "SELECT * FROM counsel_code where user_email='$user_email' ORDER BY counsel_date DESC";

$qry = mysqli_query($connect, $qry_string);
$all_count = mysqli_num_rows($qry);

//페이징을 위한 페이지 수 계산
$page_count = (int)($all_count / 10);
//현재 페이지에서 나열할 글 수
$count = 0;

if ($all_count - ($page * 10) >= 10) {
    $count = 10;
} else {
    $count = $all_count - ($page * 10);
}


if ($all_count % 10 > 0) {
    $page_count++;
}

$qry_string = $qry_string . " LIMIT " . ($page * 10) . ", 10";
$qry = mysqli_query($connect, $qry_string);


$counsel_code = array();
$counsel_product_type = array();
$dosa_nickname = array();
$dosa_email = array();
$product_name = array();
$product_time = array();
$product_point = array();
$extension_count = array();
$counsel_date = array();
$counsel_status = array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($counsel_code, $row['counsel_code']);
    array_push($counsel_product_type, $row['counsel_product_type']);
    array_push($dosa_nickname, $row['dosa_nickname']);
    array_push($dosa_email, $row['dosa_email']);
    array_push($product_name, $row['product_name']);
    array_push($product_time, $row['product_time']);
    array_push($product_point, $row['product_point']);
    array_push($extension_count, $row['extension_count']);
    array_push($counsel_date, date('Y.m.d', strtotime($row['counsel_date'])));
    array_push($counsel_status, $row['counsel_status']);
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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap"
          rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
            overflow: auto;
        }

        #global_layout {
            float: left;
        }

        #contents_box {
            float: left;
            width: calc(100% - 314px);
            min-height: calc(100vh - 55px);
            margin-top: 55px;
            margin-left: 314px;
            background-color: #FFFFFF;
        }

        #main_contents_box {
            float: left;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        #main_contents_box_place {
            margin-left: 50px;
            width: 1420px;
        }

        #main_contents_box_place_title {
            width: 100%;
            height: 30px;
            margin-top: 30px;
            margin-bottom: 14.5px;
            font-size: 20px;
            font-weight: bold;
            text-align: left;
            color: #2C3B5F;
        }

        #main_contents_box_place_title_line {
            margin-bottom: 30px;
            width: 100%;
            height: 3px;
            background-color: #2C3B5F;
            display: inline-block;
        }

        #main_contents_box_place_title_thin_line {
            margin-bottom: 30px;
            width: 100%;
            height: 2px;
            background-color: #2C3B5F;
            display: inline-block;
        }

        /* 좌측 네이밍*/
        #main_contents_box_place_content_left {
            margin-left: 20px;
            width: calc(10% - 20px);
            height: 500px;
            float: left;
        }

        #main_contents_box_place_content_left_name {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_status {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_phone {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_birth {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_address {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_join {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_nickname {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_email {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_lunar {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_counsel {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_retention_point {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_total_point {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        /* 우측 입력박스*/
        #main_contents_box_place_content_right {
            margin-left: 20px;
            width: calc(40% - 20px);
            height: 500px;
            float: left;
        }

        #main_contents_box_place_content_right_name_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_name_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_status_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_status_input {
            width: 120px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_phone_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_phone_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_birth_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_birth_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_join_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_join_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_address_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_address_input {
            width: 450px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_nickname_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_nickname_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_email_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_email_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_lunar_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_lunar_input {
            width: 100px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_counsel_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_counsel_input {
            width: 100px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_retention_point_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_retention_point_input {
            width: 150px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #refund_button {
            margin-top: 5px;
            margin-left: 15px;
            float: left;
            background-color: #2C3B5F;
            color: white;
            font-size: 14px;
            padding: 5px;
            cursor: pointer;
        }

        #main_contents_box_place_content_right_total_point_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_total_point_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }


        /*테이블*/
        #main_contents_box_place_table {
            margin-bottom: 20px;
            width: 100%;
        }

        #destiny_table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        #destiny_table td, #destiny_table th {
            border: 1px solid #d0d2d5;
            padding: 8px;
        }

        #destiny_table th {
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: center;
            background-color: #f2f3f5;
            color: black;
        }

        #main_contents_box_place_pagination {
            margin-bottom: 80px;
            width: 100%;
            height: 30px;
            float: left;
        }

        #none_data_table {
            width: 100%;
            padding-top: 40px;
            padding-bottom: 40px;
            border-left: 1px solid #d0d2d5;
            border-right: 1px solid #d0d2d5;
            border-bottom: 1px solid #d0d2d5;
        }

        #none_data_table_span {
            font-size: 14px;
            font-weight: bold;
        }

        #destiny_table_move_detail {
            cursor: pointer;
        }

        #destiny_table_move_detail:hover {
            font-weight: bolder;
        }
        #destiny_click_table {cursor: pointer; }
        #destiny_click_table:hover { background-color: #f7f7f7;}

        /*페이징*/
        #user_detail_table_pagination_before, #user_detail_table_pagination_next {
            display: inline-block;
            vertical-align: middle;
            width: 10px;
            height: 20px;
            padding: 6px 11px;
            margin: 0 10px;
            cursor: pointer;
        }

        .user_detail_table_pagination_page {
            display: inline-block;
            vertical-align: middle;
            width: 30px;
            height: 30px;
            border: solid 1px #D0D2D5;
            text-align: center;
            line-height: 30px;
            color: #000000;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
            background-color: #FFFFFF;
        }

        .pagination_selected {
            border: solid 2px red;
            color: red;
            font-weight: bolder;
        }

        /* 버튼*/
        .white_button {
            float: right;
            margin-right: 10px;
            margin-bottom: 50px;
            width: 107px;
            height: 32px;
            background-color: white;
            border: 1px solid #2C3B5F;
            font-weight: bold;
            font-size: 14px;
            color: #2C3B5F;
            text-align: center;
            line-height: 32px;
            cursor: pointer;
            display: inline-block;
        }

        .white_button:hover {
            background-color: #2C3B5F;
            color: white;
        }

        .black_button {
            float: left;
            margin-left: 160px;
            margin-bottom: 50px;
            margin-right: 10px;
            width: 107px;
            height: 32px;
            background-color: #2C3B5F;
            border: 1px solid #2C3B5F;
            font-weight: bold;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 32px;
            cursor: pointer;
            display: inline-block;
        }

        .black_button:hover {
            background-color: white;
            color: #2C3B5F;
        }

        .black_button_hide {
            display: none;
            float: right;
            margin-left: 140px;
            margin-right: 10px;
            width: 107px;
            height: 32px;
            background-color: #2C3B5F;
            border: 1px solid #2C3B5F;
            font-weight: bold;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 32px;
            cursor: pointer;
        }

        .black_button_hide:hover {
            background-color: white;
            color: #2C3B5F;
        }


        /* 모달 */
        .modal {display:none;position: fixed;z-index: 1;padding-top: 300px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 300px;}
        .close {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close:hover,
        .close:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_content_full_change_button{float: right;margin-right:25px; width: 60px; height: 25px;background-color: #2C3B5F; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color: white; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_content_full_cancel_button{float: right;margin-right:10px; width: 60px; height: 25px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 25px; cursor: pointer;}


        input:focus {
            outline: none;
            font-family: 'Malgun Gothic';
        }

        textarea:focus {
            outline: none;
            font-family: 'Malgun Gothic';
        }

        select:focus {
            outline: none;
            font-family: 'Malgun Gothic';
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">

            <div id="main_contents_box_place_title">유저 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if ($total_row_user == 0) { ?>
                해당 유저가 존재하지 않습니다
            <?php } else { ?>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_name">이름</div>
                    <div id="main_contents_box_place_content_left_email">이메일</div>
                    <div id="main_contents_box_place_content_left_birth">생년월일</div>
                    <div id="main_contents_box_place_content_left_address">주소정보</div>
                    <div id="main_contents_box_place_content_left_join">가입날짜</div>
                    <div id="main_contents_box_place_content_left_retention_point">보유포인트</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_name_box">
                        <input type="text" id="main_contents_box_place_content_right_name_input"
                               value="<?php echo $row_user['user_name']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_email_box">
                        <input type="text" id="main_contents_box_place_content_right_email_input"
                               value="<?php echo $row_user['user_email']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_birth_box">
                        <input type="text" id="main_contents_box_place_content_right_birth_input"
                               value="<?php echo $row_user['user_year'] . '년 ' . $row_user['user_month'] . '월 ' . $row_user['user_day'] . '일 '; ?>"
                               readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_address_box">
                        <input type="text" id="main_contents_box_place_content_right_address_input"
                               value="<?php echo $row_user['user_address_full']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_join_box">
                        <input type="text" id="main_contents_box_place_content_right_join_input"
                               value="<?php echo date('Y년 m월 d일', strtotime($row_user['user_join_date'])); ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_retention_point_box">
                        <input type="text" id="main_contents_box_place_content_right_retention_point_input"
                               value="<?php echo number_format($row_user['user_retention_point']) . ' P'; ?>" readonly>

                        <span id='refund_button' onclick="refund();"> 포인트 충전</span>
                    </div>
                </div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_status">상태정보</div>
                    <div id="main_contents_box_place_content_left_nickname">닉네임</div>
                    <div id="main_contents_box_place_content_left_phone">연락처</div>
                    <div id="main_contents_box_place_content_left_lunar">양력/음력</div>
                    <div id="main_contents_box_place_content_left_counsel">상담횟수</div>
                    <div id="main_contents_box_place_content_left_total_point">총 구매포인트</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_status_box">


                        <select id="main_contents_box_place_content_right_status_input" class="order_select"
                                onchange="status_change()">
                            <?php if ($row_user['user_status'] == '0') { ?>
                                <option selected>사용가능</option>
                                <option>사용제한</option>
                                <option>탈퇴처리</option>
                            <?php } else if ($row_user['user_status'] == '1') { ?>
                                <option>사용가능</option>
                                <option selected>사용제한</option>
                                <option>탈퇴처리</option>
                            <?php } else { ?>
                                <option>사용가능</option>
                                <option>사용제한</option>
                                <option selected>탈퇴처리</option>
                            <?php } ?>
                        </select>

                    </div>
                    <div id="main_contents_box_place_content_right_nickname_box">
                        <input type="text" id="main_contents_box_place_content_right_nickname_input"
                               value="<?php echo $row_user['user_nickname']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_phone_box">
                        <input type="text" id="main_contents_box_place_content_right_phone_input"
                               value="<?php echo $row_user['user_phone']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_lunar_box">
                        <input type="text" id="main_contents_box_place_content_right_lunar_input"
                               value="<?php if ($row_user['user_lunar'] == 'solar') {
                                   echo '양력';
                               } else {
                                   echo '음력';
                               } ?>" readonly>
                    </div>

                    <div id="main_contents_box_place_content_right_counsel_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_input"
                               value="<?php echo $row_user['user_counsel_count'] . ' 건'; ?>" readonly>
                    </div>

                    <div id="main_contents_box_place_content_right_total_point_box">
                        <input type="text" id="main_contents_box_place_content_right_total_point_input"
                               value="<?php echo number_format($row_user['user_total_point']) . ' P'; ?>" readonly>
                    </div>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if ($count == 0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="3%">NO</th>
                                <th width="5%">상담코드</th>
                                <th width="7%">상담유형</th>
                                <th width="10%">상담사 닉네임</th>
                                <th width="20%">상담 상품명</th>
                                <th width="5%">상담 시간</th>
                                <th width="5%">상담 포인트</th>
                                <th width="5%">연장횟수</th>
                                <th width="5%">상담일자</th>
                                <th width="5%">상담상태</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">상담 데이터가 존재하지 않습니다</span></div>
                    <?php } else { ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="3%">NO</th>
                                <th width="5%">상담코드</th>
                                <th width="7%">상담유형</th>
                                <th width="10%">상담사 닉네임</th>
                                <th width="20%">상담 상품명</th>
                                <th width="5%">상담 시간</th>
                                <th width="5%">상담 포인트</th>
                                <th width="5%">연장횟수</th>
                                <th width="5%">상담일자</th>
                                <th width="5%">상담상태</th>
                            </tr>
                            <?php for ($x = 0; $x < $count; $x++) { ?>
                                <tr id='destiny_click_table' onclick="location.href='/admin/theme/app/counsel_data_detail.php?counsel_code=<?php echo $counsel_code[$x]?>'">
                                    <td><?php echo $x + $page * 10 + 1 ?></td>
                                    <td> <?php echo $counsel_code[$x] ?></td>
                                    <?php if ($counsel_product_type[$x] == '0') { ?>
                                        <td>5분 예약상담</td>
                                    <?php } else if ($counsel_product_type[$x] == '1') { ?>
                                        <td>음성상담</td>
                                    <?php } else { ?>
                                        <td>화상상담</td>
                                    <?php } ?>
                                    <td><?php echo $dosa_nickname[$x] ?> </td>
                                    <td><?php echo $product_name[$x] ?></td>
                                    <td><?php echo $product_time[$x] . '분' ?></td>
                                    <td><?php echo number_format($product_point[$x]) . 'P' ?></td>
                                    <td><?php 
                                        if($extension_count[$x]==null){
                                            echo '0회' ;
                                        }else{
                                            echo $extension_count[$x] . '회' ;
                                        }

                                        ?></td>
                                    <td><?php echo $counsel_date[$x] ?></td>
                                    <?php
                                    if ($counsel_status[$x] == null) { ?>
                                        <td style="color: red; font-weight: bold">미연결</td>
                                    <?php } else if ($counsel_status[$x] == 0) { ?>
                                        <td style="color: red; font-weight: bold">실패</td>
                                    <?php } else if ($counsel_status[$x] == 1) { ?>
                                        <td style="color: black; font-weight: bold">성공</td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>

                <div id="main_contents_box_place_pagination">
                    <?php if ($page > 0) { ?>

                        <img id="user_detail_table_pagination_before"
                             src="/admin/image/index_before.png"
                             onclick="location.href='user_detail.php?page=<?php echo $page - 1 ?>&user_email=<?php echo $user_email; ?>'">

                    <?php }


                    if ($all_count > 0) {
                        for ($x = ((int)($page / 5) * 5); $x < ((int)($page / 5) * 5) + 5; $x++) {
                            if ($x == $page) { ?>

                                <div class="user_detail_table_pagination_page pagination_selected"
                                     onclick="location.href='user_detail.php?page=<?php echo $x ?>&user_email=<?php echo $user_email; ?>'"><?php echo $x + 1 ?></div>


                            <?php } else { ?>

                                <div class="user_detail_table_pagination_page"
                                     onclick="location.href='user_detail.php?page=<?php echo $x ?>&user_email=<?php echo $user_email; ?>'"><?php echo $x + 1 ?></div>

                            <?php }
                            if ($x + 1 == $page_count) {
                                break;
                            }
                        }
                    }
                    if ($page + 1 != $page_count && $page_count > 0) { ?>

                        <img id="user_detail_table_pagination_next"
                             src="/admin/image/index_next.png"
                             onclick="location.href='user_detail.php?page=<?php echo $page + 1 ?>&user_email=<?php echo $user_email; ?>'">


                    <?php } ?>

                </div>

            <?php } ?>

            <div id="myModal" class="modal">
                <div class="modal_content">
                    <div id="modal_content_head">
                        <span id="modal_content_head_span">포인트 충전</span> <span class="close">&times;</span>
                    </div>
                    <div style="width: 100%; height: 70px;">
                        <div style="width: 25%; height: 70px;float: left;">
                            <span style="margin-top:25px;font-size: 14px; font-weight: bold; display: inline-block;">충전</span>
                        </div>
                        <div style="width:75%; height: 70px;float: left;">
                            <input id='refund_input' type=number placeholder="충전할 포인트를 입력하세요" style="margin-top:17px; padding:5px;width: 190px; height: 21px;display: inline-block;float: left; text-align:left;border: 1px solid #ddd;">
                        </div>
                    </div>
                    <div style="width: 100%; height: 40px;">
                        <div id='modal_content_full_change_button' onclick="refund_okay()">충전</div>
                        <div id='modal_content_full_cancel_button' onclick="refund_cancel()">취소</div>
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


    // 유저 상태 변경
    function status_change() {
        var user_status = document.getElementById("main_contents_box_place_content_right_status_input");
        var select_user_status = user_status.options[user_status.selectedIndex].text;
        var user_status_change;
        var user_email = '<?php echo $user_email ?>';

        if (select_user_status == '사용가능') {
            user_status_change='0';
        } else if (select_user_status == '사용제한') {
            user_status_change='1';
        } else {
            user_status_change='2';
        }

        var confirm_test = confirm("해당 사용자의 상태를 변경하시겠습니까?");
        if (confirm_test == true ) {
            $.ajax({
                type: "POST"
                ,url: "/admin/server/status_change.php"
                ,data: {type:'user_status', status:user_status_change, email:user_email}
                ,success:function(result){
                    if(result=='success'){
                        alert('유저 상태 변경을 완료했습니다');
                        location.reload();
                    }else{
                        alert("유저 상태 변경에 실패하였습니다. 다시한번 시도해주세요");
                        location.reload();
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }else{
           return;
        }
    }

    
    
    




    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
        location.reload();
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            location.reload();
        }
    }

    //수동 충전
    function refund() {
        modal.style.display = "block";
    }
    
    function refund_okay(){
        var refund_input = $("#refund_input").val();
        var user_email = '<?php echo $user_email; ?>'
        // alert(refund_input+'/'+user_email)
        $.ajax({
            type: "POST"
            ,url: "/admin/server/refund.php"
            ,data: {refund:refund_input,user_email:user_email}
            ,success:function(result){
                if(result=='success'){
                    alert('포인트 충전을 완료했습니다');
                    location.reload();
                }else{
                    alert("포인트 충전에 실패하였습니다. 다시한번 시도해주세요");
                    location.reload();
                }
            }
            ,error:function(){
                alert("잠시 후에 다시 시도해주세요");
            }
        });
        
    }

    function refund_cancel(){
        modal.style.display = "none";
        location.reload();
    }
    
    
    
    
    
    window.onload = function () {
        change_layout_design();
    };


    function change_layout_design() {
        setTimeout(function () {
            var text = document.getElementById("layout_left_user_menu_list");
            if (text) {
                text.style.color = "#f80000";
                text.style.fontWeight = "bold";
            } else {
                change_layout_design();
            }
        }, 10);
    }


</script>

</html>