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
$settlement_no = $_GET['settlement_no'];

$qry_string_settlement = "SELECT * FROM settlement_request where no='$settlement_no'";
$qry_settlement = mysqli_query($connect, $qry_string_settlement);
$row_settlement = mysqli_fetch_array($qry_settlement);
$total_row_settlement = mysqli_num_rows($qry_settlement);

//정산 신청한 상담 목록
$counsel_code_list=$row_settlement['counsel_code_list'];
$counsel_code_list= str_replace ("[", "", $counsel_code_list);
$counsel_code_list= str_replace ("]", "", $counsel_code_list);






$qry_string = "SELECT * FROM counsel_code where counsel_code IN ($counsel_code_list) ORDER BY counsel_date DESC";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);


$counsel_code = array();
$counsel_product_type = array();
$dosa_nickname = array();
$dosa_email = array();
$product_name = array();
$product_time = array();
$final_point = array();
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
    array_push($final_point, $row['final_point']);
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

        #main_contents_box_place_content_left_account_holder {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_account_bank {
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

        #main_contents_box_place_content_left_payment {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_request_date {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_account_number {
            width: 100%;
            margin-top: 12.5px;
            margin-bottom: 40px;
            color: #2C3B5F;
            font-size: 14px;
            font-weight: bold;
            float: left;
            text-align: left;
        }

        #main_contents_box_place_content_left_deposit_date {
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

        #main_contents_box_place_content_right_account_bank_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_account_bank_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_account_holder_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_account_holder_input {
            width: 250px;
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

        #main_contents_box_place_content_right_payment_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_payment_input {
            width: 100px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_request_date_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_request_date_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }

        #main_contents_box_place_content_right_account_number_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_account_number_input {
            width: 250px;
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

        #main_contents_box_place_content_right_deposit_date_box {
            width: 100%;
            height: 40px;
            margin-top: 3px;
            margin-bottom: 27px;
            float: left;
        }

        #main_contents_box_place_content_right_deposit_date_input {
            width: 250px;
            height: 34px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 14px;
            float: left;
        }


        /*테이블*/
        #main_contents_box_place_table {
            margin-bottom: 80px;
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
        #settlement_detail_table_pagination_before, #settlement_detail_table_pagination_next {
            display: inline-block;
            vertical-align: middle;
            width: 10px;
            height: 20px;
            padding: 6px 11px;
            margin: 0 10px;
            cursor: pointer;
        }

        .settlement_detail_table_pagination_page {
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
    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">

            <div id="main_contents_box_place_title">정산신청 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if ($total_row_settlement == 0) { ?>
                관련된 정산 신청 내역이 존재하지 않습니다
            <?php } else { ?>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_name">상담가 이름</div>
                    <div id="main_contents_box_place_content_left_email">상담가 이메일</div>
                    <div id="main_contents_box_place_content_left_phone">상담가 전화번호</div>
                    <div id="main_contents_box_place_content_left_account_holder">계좌 예금주</div>
                    <div id="main_contents_box_place_content_left_account_bank">계좌 은행</div>
                    <div id="main_contents_box_place_content_left_account_number">계좌번호</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_name_box">
                        <input type="text" id="main_contents_box_place_content_right_name_input"
                               value="<?php echo $row_settlement['dosa_name']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_email_box">
                        <input type="text" id="main_contents_box_place_content_right_email_input" value="<?php echo $row_settlement['dosa_email']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_phone_box">
                        <input type="text" id="main_contents_box_place_content_right_phone_input" value="<?php echo $row_settlement['dosa_phone']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_account_holder_box">
                        <input type="text" id="main_contents_box_place_content_right_account_holder_input" value="<?php echo $row_settlement['dosa_account_holder']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_account_bank_box">
                        <input type="text" id="main_contents_box_place_content_right_account_bank_input" value="<?php echo $row_settlement['dosa_account_bank']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_account_number_box">
                        <input type="text" id="main_contents_box_place_content_right_account_number_input" value="<?php echo $row_settlement['dosa_account_number']?>" readonly>
                    </div>
                </div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_status">정산상태</div>
                    <div id="main_contents_box_place_content_left_nickname">상담가 닉네임</div>
                    <div id="main_contents_box_place_content_left_payment">정산 요청포인트</div>
                    <div id="main_contents_box_place_content_left_payment">최종 정산금액</div>
                    <div id="main_contents_box_place_content_left_request_date">정산 요청날짜</div>
                    <div id="main_contents_box_place_content_left_deposit_date">정산 완료날짜</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_status_box">
                        <select id="main_contents_box_place_content_right_status_input" class="order_select"
                                onchange="status_change()">
                            <?php if ($row_settlement['deposit_status'] == '0') { ?>
                                <option selected>정산 전</option>
                                <option>정산완료</option>
                            <?php } else { ?>
                                <option>정산 전</option>
                                <option selected>정산완료</option>
                            <?php } ?>
                        </select>

                    </div>
                    <div id="main_contents_box_place_content_right_nickname_box">
                        <input type="text" id="main_contents_box_place_content_right_nickname_input" value="<?php echo $row_settlement['dosa_nickname']?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_payment_box">
                        <input type="text" id="main_contents_box_place_content_right_payment_input" value="<?php echo number_format($row_settlement['commission_price_before']).'P';?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_payment_box">
                        <input type="text" id="main_contents_box_place_content_right_payment_input" value="<?php echo number_format($row_settlement['commission_price_after']).'원';?>" readonly>
                    </div>

                    <div id="main_contents_box_place_content_right_request_date_box">
                        <input type="text" id="main_contents_box_place_content_right_request_date_input" value="<?php echo date('Y.m.d', strtotime($row_settlement['request_date'])) ?>" readonly>
                    </div>

                    <div id="main_contents_box_place_content_right_deposit_date_box">
                        <input type="text" id="main_contents_box_place_content_right_deposit_date_input"
                               value="<?php

                               if($row_settlement['deposit_date']==null){
                                   echo '정산 전';
                               }else{
                                   echo date('Y.m.d', strtotime($row_settlement['deposit_date']));
                               } ?>"
                               readonly>
                    </div>
                </div>

                <div id="main_contents_box_place_table">
                    <div style="width: 500px; height: 40px; text-align: left; display: inline-block; float: left;">
                        <span style="margin-left:10px; font-size: 18px; font-weight: bold; color: #2C3B5F;"> 정산 신청 상담목록</span>
                    </div>
                    <?php if ($total_row == 0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="3%">NO</th>
                                <th width="5%">상담코드</th>
                                <th width="5%">상담유형</th>
                                <th width="10%">상담사 닉네임</th>
                                <th width="20%">상담 상품명</th>
                                <th width="5%">상담 시간</th>
                                <th width="5%">연장횟수</th>
                                <th width="5%">상담 포인트</th>
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
                                <th width="5%">상담유형</th>
                                <th width="10%">상담사 닉네임</th>
                                <th width="20%">상담 상품명</th>
                                <th width="5%">상담 시간</th>
                                <th width="5%">연장횟수</th>
                                <th width="5%">사용 포인트</th>
                                <th width="5%">상담일자</th>
                                <th width="5%">상담상태</th>
                            </tr>
                            <?php for ($x = 0; $x < $total_row; $x++) { ?>
                                <?php if($counsel_product_type[$x]==0){

                                }else{ ?>

                                    <tr id='destiny_click_table' onclick="location.href='/admin/theme/app/counsel_data_detail.php?counsel_code=<?php echo $counsel_code[$x]?>'">
                                        <td><?php echo $x  + 1 ?></td>
                                        <td><?php echo $counsel_code[$x] ?> </td>
                                        <?php if ($counsel_product_type[$x] == '0') { ?>
                                            <td>예약상담</td>
                                        <?php } else if ($counsel_product_type[$x] == '1') { ?>
                                            <td>음성상담</td>
                                        <?php } else { ?>
                                            <td>화상상담</td>
                                        <?php } ?>
                                        <td><?php echo $dosa_nickname[$x] ?></td>
                                        <td><?php echo $product_name[$x] ?></td>
                                        <td><?php echo $product_time[$x] . '분' ?></td>
                                        <td><?php echo $extension_count[$x] . '회' ?></td>
                                        <td><?php echo number_format($final_point[$x]) . 'P' ?></td>
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

                                <?php }?>


                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>


            <?php } ?>
        </div>

    </div>

</div>
<div id="footer_contents"></div>
</body>

<script>
    /* 공통 레이아웃 load */
    $("#global_layout").load("/admin/theme/_layout.php");
    $("#footer_contents").load("/admin/theme/_footer.php");


    function payment(){
        alert('입금하시겠습니까?')
    }

    // 정산 상태 변경
    function status_change(){
        var deposit_status= document.getElementById("main_contents_box_place_content_right_status_input");
        var select_deposit_status = deposit_status.options[deposit_status.selectedIndex].text;
        var deposit_status_change;
        var settlement_no = '<?php echo $settlement_no ?>';

        if(select_deposit_status=='정산 전'){
            deposit_status_change = '0';
            // alert('정산 전으로 변경')

            var confirm_test = confirm("정산처리를 취소하시겠습니까?");
            if (confirm_test == true ) {
                $.ajax({
                    type: "POST"
                    ,url: "/admin/server/status_change.php"
                    ,data: {type:'deposit_status', status:deposit_status_change, settlement_no: settlement_no}
                    ,success:function(result){
                        if(result=='success'){
                            alert('정산 취소 처리를 완료했습니다');
                            location.reload();
                        }else{
                            alert("정산 취소 처리에 실패하였습니다. 다시한번 시도해주세요");
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


        }else if(select_deposit_status=='정산완료'){
            deposit_status_change = '1';
            // alert('정산완료로 변경')


            var confirm_test = confirm("정산 신청에 관한 입금 처리를 완료하셨습니까?");
            if (confirm_test == true ) {
                $.ajax({
                    type: "POST"
                    ,url: "/admin/server/status_change.php"
                    ,data: {type:'deposit_status', status:deposit_status_change, settlement_no: settlement_no}
                    ,success:function(result){
                        if(result=='success'){
                            alert('정산 상태 완료로 변경했습니다');
                            location.reload();
                        }else{
                            alert("정산 상태 완료에 실패하였습니다. 다시한번 시도해주세요");
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




    }


    window.onload = function () {
        change_layout_design();
    };




    function change_layout_design() {
        setTimeout(function () {
            var text = document.getElementById("layout_left_statistic_menu_settlement");
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