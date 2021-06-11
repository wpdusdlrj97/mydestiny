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
$dosa_email = $_GET['dosa_email'];

$qry_string_dosa = "SELECT * FROM dosa_information where dosa_email='$dosa_email'";
$qry_dosa = mysqli_query($connect, $qry_string_dosa);
$row_dosa = mysqli_fetch_array($qry_dosa);
$total_row_dosa = mysqli_num_rows($qry_dosa);




$qry_string = "SELECT * FROM dosa_product where dosa_email='$dosa_email'";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);

$product_code = array();
$product_name = array();
$product_time = array();
$product_point = array();
$product_extension_point = array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($product_code, $row['product_code']);
    array_push($product_name, $row['product_name']);
    array_push($product_time, $row['product_time']);
    array_push($product_point, $row['product_point']);
    array_push($product_extension_point, $row['product_extension_point']);
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
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <style>
        body{ padding:0; margin:0; overflow:auto; }
        #global_layout{ float:left; }
        #contents_box{ float:left; width:calc(100% - 314px); min-height:calc(100vh - 55px); margin-top:55px; margin-left:314px; background-color:#FFFFFF; }
        #main_contents_box{ margin-bottom:100px;float:left; width:100%;  text-align:center; }
        #main_contents_box_place{ margin-left: 50px; width:1420px; }
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 30px; width: 100%; height: 3px; background-color: #2C3B5F; display: inline-block;}


        .white_button {float: left; margin-top:6px;margin-left:10px;width: 57px; height: 22px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 22px; cursor: pointer; display: inline-block;}
        .white_button:hover{background-color:#2C3B5F; color:white; }
        .white_button_small {float: left; margin-top:6px;margin-left:10px;width: 27px; height: 22px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 22px; cursor: pointer; display: inline-block;}
        .white_button_small:hover{background-color:#2C3B5F; color:white; }


        /*테이블*/
        #main_contents_box_place_table {margin-left:10px; margin-bottom:20px; width: 1210px; }
        #destiny_table {border-collapse: collapse;width: 100%; font-size: 14px;}
        #destiny_table td, #destiny_table th {border: 1px solid #d0d2d5;padding: 8px;}
        #destiny_table th {padding-top: 8px;padding-bottom: 8px;text-align: center;background-color: #f2f3f5;color: black;}
        #main_contents_box_place_pagination {margin-bottom:80px; width: 100%; height: 30px;  float: left;}
        #none_data_table {width: 100%; padding-top: 40px;  padding-bottom: 40px; border-left: 1px solid #d0d2d5; border-right: 1px solid #d0d2d5; border-bottom: 1px solid #d0d2d5;}
        #none_data_table_span {font-size: 14px; font-weight: bold;}
        #destiny_table_move_detail {cursor: pointer; }
        #destiny_table_move_detail:hover {font-weight: bolder;}

        input:focus {outline:none; font-family: 'Malgun Gothic';}
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        textarea:focus {outline:none; font-family: 'Malgun Gothic';}
        select:focus {outline:none; font-family: 'Malgun Gothic';}

    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">


            <div id="main_contents_box_place_title">상담가 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>


            <?php if($total_row_dosa == 0) {?>
                해당 상담가가 존재하지 않습니다
            <?php }else { ?>

                <!-- 개인정보 -->
                <div style="margin-left:30px; float: left; width: calc(50% - 30px);">
                    <div style="width: 500px; height: 40px; text-align: left;">
                        <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 개인 정보</span>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 140px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 140px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 60px; font-size: 13px; font-weight: bold; display: inline-block;"> 프로필 이미지</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">
                            <div id="thumb-output" style="margin:20px;width: 100px; height: 100px; border: 1px solid #d0d2d5; text-align: center;">
                                <img style="max-width: 100px; height: 100%;" src="<?php echo $row_dosa['dosa_profile_image']?>">
                            </div>
                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 닉네임 </span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="text" id='dosa_nickname' name='dosa_nickname' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_nickname']?>" readonly>

                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 이름</span>

                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="text" id='dosa_name' name='dosa_name' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_name']?>" readonly>

                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 전화번호</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">
                            <input type="number" id='dosa_phone' name='dosa_phone' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_phone']?>" readonly>
                        </div>
                    </div>

                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 패널티 횟수 </span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <select id="dosa_penalty" style="margin-left:10px; margin-top:5px; width: 170px; height: 24px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" onchange="penalty_change()">

                                <?php if($row_dosa['dosa_penalty']=='0'){  ?>
                                    <option selected>0회</option>
                                    <option>1회</option>
                                    <option>2회</option>
                                    <option>3회</option>
                                <?php    }else if($row_dosa['dosa_penalty']=='1'){  ?>
                                    <option>0회</option>
                                    <option selected>1회</option>
                                    <option>2회</option>
                                    <option>3회</option>
                                <?php    }else if($row_dosa['dosa_penalty']=='2'){  ?>
                                    <option>0회</option>
                                    <option>1회</option>
                                    <option selected>2회</option>
                                    <option>3회</option>
                                <?php    }else if($row_dosa['dosa_penalty']=='3'){  ?>
                                    <option>0회</option>
                                    <option>1회</option>
                                    <option>2회</option>
                                    <option selected>3회</option>
                                <?php   } ?>
                            </select>

                            <span style="margin:7px;color: red; font-size: 12px; display: inline-block;">(변경 가능)</span>

                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 가입 날짜 </span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="text" id='dosa_join_date' name='dosa_join_date' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"
                                   value="<?php echo date('Y.m.d', strtotime($row_dosa['dosa_join_date'])) ?>" readonly>

                        </div>
                    </div>
                </div>




                <!-- 계정 정보 -->
                <div style="margin-left:30px; float: left; width: calc(50% - 30px);">
                    <div style="width: 500px; height: 40px; text-align: left">
                        <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 계정 정보</span>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 이메일</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="email" id='dosa_email' name='dosa_email'  style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_email']?>" readonly>


                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px;border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 비밀번호</span>
                        </div>

                        <div style="width: 349px; height: 35px;float: left;">
                            <input type="password" id='dosa_password' name='dosa_password'  value="password1234" style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"  readonly>
                            <div class="white_button" onclick="password_reset()">초기화</div>
                        </div>
                    </div>

                    <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계정상태</span>

                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <select id="dosa_status" style="margin-left:10px; margin-top:5px; width: 190px; height: 24px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" onchange="status_change()">
                                <?php if($row_dosa['dosa_status']=='0'){  ?>
                                    <option selected>사용가능</option>
                                    <option>사용제한</option>
                                    <option>탈퇴처리</option>
                                <?php    }else if($row_dosa['dosa_status']=='1'){  ?>
                                    <option>사용가능</option>
                                    <option selected>사용제한</option>
                                    <option>탈퇴처리</option>
                                <?php   }else{  ?>
                                    <option>사용가능</option>
                                    <option>사용제한</option>
                                    <option selected>탈퇴처리</option>
                                <?php   } ?>
                            </select>

                            <span style="margin:7px;color: red; font-size: 12px; display: inline-block;">(변경 가능)</span>

                        </div>
                    </div>
                </div>



                <div style="margin-top:30px; margin-left:30px; float: left; width: calc(50% - 30px);">
                    <div style="width: 500px; height: 40px; text-align: left;">
                        <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 사업자 정보</span>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 사업자 등록번호</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">
                            <input type="text" id='dosa_business_number' name='dosa_business_number'  style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_business_number']?>" readonly>
                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 예금주</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="text" id='dosa_account_holder' name='dosa_account_holder' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_account_holder']?>" readonly>

                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 은행</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">

                            <input type="text" id='dosa_account_bank' name='dosa_account_bank'  style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_account_bank']?>" readonly>

                        </div>
                    </div>
                    <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5;; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 번호</span>
                        </div>
                        <div style="width: 349px; height: 35px;float: left;">
                            <input type="text" id='dosa_account_number' name='dosa_account_number' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_account_number']?>" readonly>
                        </div>
                    </div>

                </div>


                <div style="margin-top:50px; margin-left:30px; float: left; width: calc(100% - 30px);">
                    <div style="width: 1210px; height: 40px; text-align: left;">
                        <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 상담 정보</span>
                    </div>
                    <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 업종</span>
                        </div>
                        <div style="width: 100px; height: 35px;float: left;  border-right: 1px solid #d0d2d5; ">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 50px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['counsel_field']?>" readonly>
                        </div>
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 분류</span>
                        </div>
                        <div style="width: 400px; height: 35px;float: left;  border-right: 1px solid #d0d2d5; ">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 360px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"
                                   value="<?php
                                   $counsel_field_detail_list_array = json_decode($row_dosa['counsel_field_detail_list'], true);
                                   $counsel_field_detail_list = implode( ',', $counsel_field_detail_list_array);
                                   echo $counsel_field_detail_list?>" readonly>
                        </div>
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 방식</span>
                        </div>
                        <div style="width: 210px; height: 35px;float: left;">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 200px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"
                                   value="<?php
                                   $counsel_type_list_array = json_decode($row_dosa['counsel_type_list'], true);
                                   $counsel_type_list = implode( ',', $counsel_type_list_array);
                                   echo $counsel_type_list?>" readonly>
                        </div>
                    </div>
                    <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 횟수</span>
                        </div>
                        <div style="width: 100px; height: 35px;float: left;  border-right: 1px solid #d0d2d5; ">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 50px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo number_format($row_dosa['dosa_counsel_count']).'회'?>" readonly>
                        </div>
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 포인트</span>
                        </div>
                        <div style="width: 400px; height: 35px;float: left;  border-right: 1px solid #d0d2d5; ">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 160px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"
                                   value="<?php echo number_format($row_dosa['dosa_counsel_price']).'P'?>" readonly>
                        </div>
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">정산 금액</span>
                        </div>
                        <div style="width: 210px; height: 35px;float: left;">
                            <input type="text" id='counsel_field' name='counsel_field' style="margin-left:10px; margin-top:5px; width: 160px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;"
                                   value="<?php echo number_format($row_dosa['dosa_settlement_price']).'원'?>" readonly>
                        </div>
                    </div>
                    <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 소개 제목</span>
                        </div>
                        <div style="width: 1000px; height: 35px;float: left;">
                            <input type="text" id="dosa_title" name="dosa_title"   style="margin-left:10px; margin-top:5px; width: 800px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_title']?>" readonly>
                        </div>
                    </div>

                    <div style="margin-left:10px;width: 1210px; height: 350px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 350px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 160px; font-size: 13px; font-weight: bold; display: inline-block;">상담 업체 정보</span>
                        </div>
                        <div style="width: 1000px; height: 35px;float: left;">
                            <textarea id="dosa_information" name="dosa_information"  style="margin:10px;width: 900px; height: 290px; border: 1px solid #ddd; padding:10px; font-size: 13px; float:left; font-family: 'Malgun Gothic';" readonly><?php echo $row_dosa['dosa_information']?></textarea>
                        </div>
                    </div>

                    <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">주소 정보</span>
                        </div>
                        <div style="width: 450px; height: 35px;float: left;">
                            <input id='dosa_address' name='dosa_address' style="margin-left:10px; margin-top:5px; width: 400px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" value="<?php echo $row_dosa['dosa_address_full']. $row_dosa['dosa_address_detail']?>" readonly>
                        </div>
                    </div>

                    <div style="margin-left:10px;width: 1210px; height: 250px; border:1px solid #d0d2d5; text-align: left;">
                        <div style="width: 150px; height: 250px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                            <span style="margin-left: 20px; margin-top: 110px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지</span>
                        </div>
                        <div style="width: 1050px; height: 250px;float: left; overflow: scroll; display: inline-block;">
                            <?php
                            $dosa_sub_image_list = json_decode($row_dosa['dosa_sub_image_list'], true);
                            $dosa_sub_image_list_count = count($dosa_sub_image_list);
                            for ($x = 0; $x < $dosa_sub_image_list_count; $x++) { ?>
                                <div style="margin: 20px; width: 320px; height: 180px; background-color: #f2f2f2; border: 1px solid #ddd; float: left; text-align: center">
                                    <img style="max-width: 320px; height: 100%" src="<?php echo $dosa_sub_image_list[$x] ?>">
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                </div>

            <div style="margin-top:50px; margin-left:30px; float: left; width: calc(100% - 30px);">
                <div style="width: 1210px; height: 40px; text-align: left;">
                    <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 상품 정보</span>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if($total_row==0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="10%">상담 상품 코드</th>
                                <th width="10%">상담 상품 이름</th>
                                <th width="10%">상담 상품 시간</th>
                                <th width="10%">상담 상품 금액</th>
                                <th width="10%">10분 연장 금액</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">상담가가 상품을 등록하지 않았습니다</span></div>
                    <?php }else{ ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="10%">상담 상품코드</th>
                                <th width="10%">상담 상품이름</th>
                                <th width="10%">상담 상품시간</th>
                                <th width="10%">상담 상품포인트</th>
                                <th width="10%">10분 연장포인트</th>
                            </tr>
                            <?php for ($x = 0; $x < $total_row; $x++) { ?>
                                <tr>
                                    <td><?php echo $x+1 ?></td>
                                    <td><?php echo $product_code[$x] ?></td>
                                    <td><?php echo $product_name[$x] ?></td>
                                    <td><?php echo $product_time[$x].'분' ?></td>
                                    <td><?php echo number_format($product_point[$x]).'P' ?></td>
                                    <td><?php echo number_format($product_extension_point[$x]).'P' ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>

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



    // 도사 패널티 변경
    function penalty_change(){
        var dosa_penalty= document.getElementById("dosa_penalty");
        var select_dosa_penalty = dosa_penalty.options[dosa_penalty.selectedIndex].text;
        var dosa_penalty_status_change;
        var dosa_penalty_email = '<?php echo $dosa_email ?>';

        if(select_dosa_penalty=='0회'){
            dosa_penalty_status_change='0';
        }else if(select_dosa_penalty=='1회'){
            dosa_penalty_status_change='1';
        }else if(select_dosa_penalty=='2회'){
            dosa_penalty_status_change='2';
        }else if(select_dosa_penalty=='3회'){
            dosa_penalty_status_change='3';
        }


        var confirm_test = confirm("해당 상담가의 패널티 횟수를 변경하시겠습니까?");
        if (confirm_test == true ) {
            $.ajax({
                type: "POST"
                ,url: "/admin/server/status_change.php"
                ,data: {type:'dosa_penalty_status', status:dosa_penalty_status_change, email:dosa_penalty_email}
                ,success:function(result){
                    if(result=='success'){
                        alert('상담가의 패널티 횟수 변경을 완료했습니다');
                        location.reload();
                    }else{
                        alert("상담가의 패널티 횟수 변경에 실패하였습니다. 다시한번 시도해주세요");
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

    function password_reset(){

        var dosa_email = '<?php echo $dosa_email ?>';

        var confirm_test = confirm("해당 상담가 비밀번호를 초기화하시겠습니까? 비밀번호는 'password1234'로 초기화됩니다");
        if (confirm_test == true ) {
            $.ajax({
                type: "POST"
                ,url: "/admin/server/status_change.php"
                ,data: {type:'password_reset', email:dosa_email}
                ,success:function(result){
                    if(result=='success'){
                        alert('상담가의 비밀번호를 초기화했습니다');
                        location.reload();
                    }else{
                        alert("상담가 비밀번호 초기화에 실패하였습니다. 다시한번 시도해주세요");
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

    // 도사 상태 변경
    function status_change(){
        var dosa_status= document.getElementById("dosa_status");
        var select_dosa_status = dosa_status.options[dosa_status.selectedIndex].text;
        var dosa_status_change;
        var dosa_email = '<?php echo $dosa_email ?>';


        if(select_dosa_status=='사용가능'){
            dosa_status_change='0';
        }else if(select_dosa_status=='사용제한'){
            dosa_status_change='1';
        }else{
            dosa_status_change='2';
        }

        var confirm_test = confirm("해당 상담가의 상태를 변경하시겠습니까?");
        if (confirm_test == true ) {
            $.ajax({
                type: "POST"
                ,url: "/admin/server/status_change.php"
                ,data: {type:'dosa_status', status:dosa_status_change, email:dosa_email}
                ,success:function(result){
                    if(result=='success'){
                        alert('상담가 상태 변경을 완료했습니다');
                        location.reload();
                    }else{
                        alert("상담가 상태 변경에 실패하였습니다. 다시한번 시도해주세요");
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


    // 레이아웃
    window.onload = function(){
        change_layout_design();
    };

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