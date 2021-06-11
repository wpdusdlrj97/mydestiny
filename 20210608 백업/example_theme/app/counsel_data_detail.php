
<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");


$counsel_code = $_GET['counsel_code'];

$qry_string = "SELECT * FROM counsel_code where counsel_code='$counsel_code'";
$qry = mysqli_query($connect, $qry_string);
$row = mysqli_fetch_array($qry);
$total_row = mysqli_num_rows($qry);




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
        body{ padding:0; margin:0; overflow:auto; font-family: 'Malgun Gothic'; }
        #global_layout{ float:left; }
        #contents_box{ float:left; width:calc(100% - 314px); min-height:calc(100vh - 55px); margin-top:55px; margin-left:314px; background-color:#FFFFFF; }
        #main_contents_box{ float:left; width:100%; height:100%; text-align:center; }
        #main_contents_box_place{ margin-left: 50px; width:1420px; }
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 30px; width: 100%; height: 3px; background-color: #2C3B5F; display: inline-block;}
        #main_contents_box_place_title_thin_line {margin-bottom: 30px; width: 100%; height: 2px; background-color:#ddd; display: inline-block;}

        /* 좌측 네이밍 1*/
        #main_contents_box_place_content_left{margin-left:20px; width:calc(10% - 20px);height: 230px; float: left;}
        #main_contents_box_place_content_left_counsel_code{width: 100%;margin-top: 12.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_counsel_product_type{width: 100%;margin-top: 12.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_dosa_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_dosa_nickname{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_dosa_email{width: 100%;margin-top: 82.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_user_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_user_nickname{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_user_email{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}


        /* 좌측 네이밍 2*/
        #main_contents_box_place_content_left_counsel_status{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_product_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_counsel_date{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_extension_count{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_product_time{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_counsel_start_time{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_product_point{width: 100%;margin-top: 82.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_counsel_finish_time{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}

        /* 좌측 네이밍 3*/
        #main_contents_box_place_content_left_refund_point{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_settlement_request_status{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_final_point{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_settlement_complete_status{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}



        /* 우측 입력박스1*/
        #main_contents_box_place_content_right{margin-left:20px; width:calc(23% - 20px); height:230px; float: left; }
        #main_contents_box_place_content_right_counsel_code_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_code_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_counsel_product_type_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_product_type_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_dosa_name_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_dosa_name_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_dosa_nickname_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_dosa_nickname_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_dosa_email_box{width: 100%; height:40px;margin-top: 73px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_dosa_email_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_user_name_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_user_name_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_user_nickname_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_user_nickname_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_user_email_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_user_email_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}

        /* 우측 입력박스2*/
        #main_contents_box_place_content_right_counsel_status_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_status_input{width: 100px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-weight: bold; color: red}
        #main_contents_box_place_content_right_product_name_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_product_name_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_counsel_date_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_date_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_extension_count_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_extension_count_input{width: 100px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_product_time_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_product_time_input{width: 100px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_counsel_start_time_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_start_time_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_product_point_box{width: 100%; height:40px;margin-top: 73px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_product_point_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_counsel_finish_time_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_counsel_finish_time_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}

        /* 우측 입력박스3*/
        #main_contents_box_place_content_right_refund_point_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_refund_point_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_settlement_request_status_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_settlement_request_status_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_final_point_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_final_point_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_settlement_complete_status_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_settlement_complete_status_input{width: 150px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}


        #refund_button {
            margin-top: 2px;
            margin-left: 15px;
            float: left;
            background-color: #2C3B5F;
            color: white;
            font-size: 14px;
            padding: 7px;
            cursor: pointer;
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


        input:focus {outline:none; font-family: 'Malgun Gothic';}
        textarea:focus {outline:none; font-family: 'Malgun Gothic';}
        select:focus {outline:none; font-family: 'Malgun Gothic';}


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

            <div id="main_contents_box_place_title">상담 데이터 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if($total_row == 0) {?>
                해당 글이 존재하지 않습니다
            <?php }else { ?>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_counsel_code">상담코드</div>
                    <div id="main_contents_box_place_content_left_dosa_name">상담사 이름</div>
                    <div id="main_contents_box_place_content_left_user_name">유저 이름</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_counsel_code_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_code_input"
                               value="<?php echo $row['counsel_code']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_dosa_name_box">
                        <input type="text" id="main_contents_box_place_content_right_dosa_name_input"
                               value="<?php echo $row['dosa_name']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_user_name_box">
                        <input type="text" id="main_contents_box_place_content_right_user_name_input"
                               value="<?php echo $row['user_name']; ?>" readonly>
                    </div>
                </div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_counsel_product_type">상담유형</div>
                    <div id="main_contents_box_place_content_left_dosa_nickname">상담사 닉네임</div>
                    <div id="main_contents_box_place_content_left_user_nickname">유저 닉네임</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_counsel_product_type_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_product_type_input"
                               value="<?php

                               if($row['counsel_product_type']==0){
                                   echo '5분 예약상담';
                               }else if($row['counsel_product_type']==1){
                                   echo '일반 음성상담';
                               }else{
                                   echo '일반 영상상담';
                               }

                               ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_dosa_nickname_box">
                        <input type="text" id="main_contents_box_place_content_right_dosa_nickname_input"
                               value="<?php echo $row['dosa_nickname']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_user_nickname_box">
                        <input type="text" id="main_contents_box_place_content_right_user_nickname_input"
                               value="<?php echo $row['user_nickname']; ?>" readonly>
                    </div>
                </div>



                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_dosa_email">상담사 이메일</div>
                    <div id="main_contents_box_place_content_left_user_email">유저 이메일</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_dosa_email_box">
                        <input type="text" id="main_contents_box_place_content_right_dosa_email_input"
                               value="<?php echo $row['dosa_email']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_user_email_box">
                        <input type="text" id="main_contents_box_place_content_right_user_email_input"
                               value="<?php echo $row['user_email']; ?>" readonly>
                    </div>

                </div>


                <div id="main_contents_box_place_title_thin_line"></div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_counsel_status">상담 여부</div>
                    <div id="main_contents_box_place_content_left_product_name">상담 상품명</div>
                    <div id="main_contents_box_place_content_left_counsel_date">상담 날짜</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_counsel_status_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_status_input"
                               value="<?php

                               if($row['counsel_status']==null){
                                   echo '연결 안됨';
                               }elseif($row['counsel_status']=='0'){
                                   echo '상담 실패';
                               }else{
                                   echo '상담 성공';
                               }

                               ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_product_name_box">
                        <input type="text" id="main_contents_box_place_content_right_product_name_input"
                               value="<?php echo $row['product_name']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_counsel_date_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_date_input"
                               value="<?php echo date('Y년 m월 d일', strtotime($row['counsel_date'])); ?>" readonly>
                    </div>
                </div>


                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_extension_count">연장 횟수</div>
                    <div id="main_contents_box_place_content_left_product_time">상담 시간</div>
                    <div id="main_contents_box_place_content_left_counsel_start_time">상담 시작시간</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_extension_count_box">
                        <input type="text" id="main_contents_box_place_content_right_extension_count_input"
                               value="<?php echo number_format($row['extension_count']).'회'; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_product_time_box">
                        <input type="text" id="main_contents_box_place_content_right_product_time_input"
                               value="<?php echo $row['product_time'].'분'; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_counsel_start_time_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_start_time_input"
                               value="<?php

                               if($row['counsel_start_time']==null){
                                   echo '상담 실패';
                               }else{
                                   echo date('Y년 m월 d일  H시 i분 s초', strtotime($row['counsel_start_time']));
                               }


                               ?>" readonly>


                    </div>
                </div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_product_point">상담 포인트</div>
                    <div id="main_contents_box_place_content_left_counsel_finish_time">상담 종료시간</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_product_point_box">
                        <input type="text" id="main_contents_box_place_content_right_product_point_input"
                               value="<?php echo number_format($row['product_point']).'P'; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_counsel_finish_time_box">
                        <input type="text" id="main_contents_box_place_content_right_counsel_finish_time_input"
                               value="<?php

                               if($row['counsel_finish_time']==null){
                                   echo '상담 실패';
                               }else{
                                   echo date('Y년 m월 d일  H시 i분 s초', strtotime($row['counsel_finish_time']));
                               }


                                ?>" readonly>
                    </div>

                </div>



                <div id="main_contents_box_place_title_thin_line"></div>


                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_refund_point">환불 포인트</div>
                    <div id="main_contents_box_place_content_left_settlement_request_status">정산 신청여부</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_refund_point_box">
                        <input type="text" id="main_contents_box_place_content_right_refund_point_input"
                               value="<?php echo number_format($row['refund_point']).'P'; ?>" readonly>
                        <?php

                        //환불가능 날짜
                        $refund_date = date("YmdHis", strtotime("-1 week"));

                        if($row['final_point']<=0){ // 결제포인트가 0원일 경우 수정불가

                        }else if($row['counsel_date']<$refund_date){ //상담날짜로부터 1주일이 지난경우 수정불가 (상담날짜  < 오늘날짜-7 )

                        }else{ ?>
                            <span id='refund_button' onclick="counsel_refund();"> 환불처리</span>
                         <?php }?>
                    </div>
                    <div id="main_contents_box_place_content_right_settlement_request_status_box">
                        <input type="text" id="main_contents_box_place_content_right_settlement_request_status_input"
                               value="<?php

                               if($row['counsel_product_type']==0) {
                                       echo '정산불가';
                               }elseif($row['counsel_status']==null){
                                       echo '정산불가';
                               }elseif($row['counsel_status']=='0') {
                                       echo '정산불가';
                               }else if($row['settlement_request_status']=='0'){
                                       echo '신청 전';
                               }else{
                                       echo '신청 완료';
                               }


                               ?>" readonly>
                    </div>
                </div>


                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_final_point">사용 포인트</div>
                    <div id="main_contents_box_place_content_left_settlement_complete_status">정산 완료여부</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_final_point_box">
                        <input type="text" id="main_contents_box_place_content_right_final_point_input"
                               value="<?php echo number_format($row['final_point']).'P'; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_settlement_complete_status_box">
                        <input type="text" id="main_contents_box_place_content_right_settlement_complete_status_input"
                               value="<?php
                               if($row['counsel_product_type']==0) {
                                   echo '정산불가';
                               }elseif($row['counsel_status']==null){
                                   echo '정산불가';
                               }elseif($row['counsel_status']=='0') {
                                   echo '정산불가';
                               }else if($row['settlement_complete_status']=='0'){
                                   echo '정산 처리중';
                               }else{
                                   echo '정산 완료';
                               }
                               ?>" readonly>
                    </div>
                </div>


            <?php } ?>


            <div id="myModal" class="modal">
                <div class="modal_content">
                    <div id="modal_content_head">
                        <span id="modal_content_head_span">포인트 환불처리</span> <span class="close">&times;</span>
                    </div>
                    <div style="width: 100%; height: 70px;">
                        <div style="width: 25%; height: 70px;float: left;">
                            <span style="margin-top:25px;font-size: 14px; font-weight: bold; display: inline-block;">환불</span>
                        </div>
                        <div style="width:75%; height: 70px;float: left;">
                            <input id='refund_input' type=number placeholder="환불할 포인트를 입력하세요" style="margin-top:17px; padding:5px;width: 190px; height: 21px;display: inline-block;float: left; text-align:left;border: 1px solid #ddd;">
                        </div>
                    </div>
                    <div style="width: 100%; height: 40px;">
                        <div id='modal_content_full_change_button' onclick="refund_okay()">환불</div>
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



    window.onload = function(){
        change_layout_design();
    };



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_app_menu_counsel_data");
            if(text){
                text.style.color="#f80000";
                text.style.fontWeight="bold";
            }else{
                change_layout_design();
            }
        }, 10);
    }



    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
        location.reload();
    }

    //수동 충전
    function counsel_refund() {
        modal.style.display = "block";

    }


    function refund_okay(){
        var counsel_refund_input = $("#refund_input").val();
        var counsel_code = '<?php echo $counsel_code; ?>'
        var counsel_final_point = '<?php echo $row['final_point']; ?>'
        var dosa_email = '<?php echo $row['dosa_email']; ?>'


        if(parseInt(counsel_final_point)<parseInt(counsel_refund_input)){ // 환불되는 금액이 사용된 포인트보다 클경우 -> 환불 불가
            alert("환불처리 금액이 결제금액보다 큽니다. 다시 한번 확인해주세요");
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/counsel_refund.php"
                ,data: {counsel_refund:counsel_refund_input,counsel_code:counsel_code,dosa_email:dosa_email}
                ,success:function(result){
                    if(result=='success'){
                        alert('환불처리를 완료했습니다');
                        location.reload();
                    }else{
                        alert("환불처리에 실패하였습니다. 다시한번 시도해주세요");
                        location.reload();
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }




    }

    function refund_cancel(){
        modal.style.display = "none";
        location.reload();
    }


</script>

</html>