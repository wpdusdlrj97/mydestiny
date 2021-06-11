<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
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

        .register_button {margin-top:70px;margin-left:10px;width: 300px; height: 50px;background-color: white; border:1px solid  red; font-weight: bold; font-size: 20px; color:  red; text-align: center; line-height: 50px; cursor: pointer; display: inline-block;}
        .register_button:hover{background-color:red; color:white; }

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


            <div id="main_contents_box_place_title">상담가 등록</div>
            <div id="main_contents_box_place_title_line"></div>

            <form id="dosa_register_from" action="/admin/server/dosa_register_server.php" method="post" enctype="multipart/form-data">

            <!-- 개인정보 -->
            <div style="margin-left:30px; float: left; width: calc(50% - 30px);">
                <div style="width: 500px; height: 40px; text-align: left;">
                    <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 개인 정보</span>
                </div>
                <div style="margin-left:10px;width: 500px; height: 240px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 240px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 110px; font-size: 13px; font-weight: bold; display: inline-block;"> 프로필 이미지</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">
                        <div id="thumb-output" style="margin:20px;max-width: 100px; height: 100px; border: 1px solid #d0d2d5; text-align: center;">
                            <img style="width: 100px; height: 100px;" src="/admin/image/dosa_profile_image_default.png">
                        </div>
                            <input type="file" id='dosa_profile_image' name="dosa_profile_image" style="float: left; margin-left: 20px;">
                            <span style="margin-top: 15px;margin-left:20px; font-size: 12px; color: grey; display: inline-block;"> - 이미지를 등록하지 않을 시, 기본 이미지로 등록됩니다 </span>
                            <span style="margin-top: 5px;margin-left:20px; font-size: 12px; color: grey; display: inline-block;"> - 사이즈 200px * 200px / 사진 비율 1:1 * / 크기 2MB 이하 </span>
                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 닉네임 </span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="text" id='dosa_nickname' name='dosa_nickname' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" minlength="2" maxlength="6" placeholder="닉네임을 입력해주세요 (2~6자리)">

                        <div class="white_button" onclick="nickname_overlap()">중복 확인</div>
                        <input type="text" id='dosa_nickname_overlap' name='dosa_nickname_overlap' value="0" style="display: none">

                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 이름</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="text" id='dosa_name' name='dosa_name' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" minlength="2" maxlength="4" placeholder="이름을 입력해주세요">

                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5;; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 전화번호</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">
                        <input type="number" id='dosa_phone' name='dosa_phone' style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" minlength="11" maxlength="11" placeholder="전화번호를 입력해주세요 ( '-' 없이)">
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
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="email" id='dosa_email' name='dosa_email' placeholder="이메일을 입력해주세요" style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">

                        <div class="white_button" onclick="email_overlap()">중복 확인</div>

                        <input type="text" id='dosa_email_overlap' name='dosa_email_overlap' value="0" style="display: none">
                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5;; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 비밀번호</span>
                        <span style="color: red">*</span>
                    </div>

                    <div style="width: 349px; height: 35px;float: left;">
                        <input type="text" id='dosa_password' name='dosa_password' placeholder="비밀번호를 입력해주세요 (영문/숫자 8~16자리)" minlength="8" maxlength="16" style="margin-left:10px; margin-top:5px; width: 320px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">
                    </div>
                </div>
            </div>



            <div style="margin-top:80px; margin-left:30px; float: left; width: calc(50% - 30px);">
                <div style="width: 500px; height: 40px; text-align: left;">
                    <span style="margin-left:10px; font-size: 17px; font-weight: bold"> 사업자 정보</span>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 사업자 등록번호</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="text" id='dosa_business_number' name='dosa_business_number' placeholder="ex.000-00-00000"  style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">

                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 예금주</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="text" id='dosa_account_holder' name='dosa_account_holder' placeholder="ex.홍길동" style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">

                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 은행</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">

                        <input type="text" id='dosa_account_bank' name='dosa_account_bank' placeholder="계좌의 은행을 입력해주세요"  style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">

                    </div>
                </div>
                <div style="margin-left:10px;width: 500px; height: 35px; border:1px solid #d0d2d5;; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;  float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;"> 계좌 번호</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 349px; height: 35px;float: left;">
                        <input type="text" id='dosa_account_number' name='dosa_account_number' placeholder="계좌번호를 입력해주세요 ( '-' 포함)" style="margin-left:10px; margin-top:5px; width: 240px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">
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
                        <span style="font-size: 11px;color: red">(중복불가)</span>
                    </div>
                    <div style="width: 1000px; height: 35px;float: left;">
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="사주" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;" checked> <label style="font-size: 13px; margin-top:8px;display: inline-block;">사주</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="타로" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">타로</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="손금" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">손금</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="관상" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">관상</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="궁합" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">궁합</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="신점" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">신점</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="작명" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">작명</label>
                        <input type="checkbox"  id="counsel_field" name="counsel_field" value="꿈해몽" onclick="NoMultiChk(this)" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">꿈해몽</label>

                    </div>
                </div>
                <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 분류</span>
                        <span style="font-size: 11px;color: #0057e3">(중복가능)</span>
                    </div>
                    <div style="width: 1000px; height: 35px;float: left;">
                        <input type="checkbox"  name="counsel_field_detail" value="애정운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">애정운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="사업운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">사업운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="궁합" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">궁합</label>
                        <input type="checkbox"  name="counsel_field_detail" value="부부운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">부부운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="재물운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">재물운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="진로운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">진로운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="건강운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">건강운</label>
                        <input type="checkbox"  name="counsel_field_detail" value="학업운" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">학업운</label>
                        <input type="text" id="counsel_field_detail_array" name="counsel_field_detail_array" style="display: none">
                    </div>
                </div>
                <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 방식</span>
                        <span style="font-size: 11px;color: #0057e3">(중복가능)</span>
                    </div>
                    <div style="width: 1000px; height: 35px;float: left;">
                        <input type="checkbox"  name="counsel_type" value="오프라인" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">오프라인</label>
                        <input type="checkbox"  name="counsel_type" value="영상통화" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">영상통화</label>
                        <input type="checkbox"  name="counsel_type" value="음성통화" style="margin-top:12px;margin-left:12px;"> <label style="font-size: 13px; margin-top:8px;display: inline-block;">음성통화</label>
                        <input type="text" id="counsel_type_array" name="counsel_type_array" style="display: none">
                    </div>
                </div>
                <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">상담 소개 제목</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 1000px; height: 35px;float: left;">
                        <input type="text" id="dosa_title" name="dosa_title" placeholder="상담 소개 제목을 작성해주세요 (50자 이내)" maxlength="50" style="margin-left:10px; margin-top:5px; width: 800px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">
                    </div>
                </div>

                <div style="margin-left:10px;width: 1210px; height: 350px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 350px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 160px; font-size: 13px; font-weight: bold; display: inline-block;">상담 업체 정보</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 1000px; height: 35px;float: left;">
                        <textarea id="dosa_information" name="dosa_information" placeholder="상담 업체 정보를 작성해주세요 (200자 이내)" maxlength="200" style="margin:10px;width: 900px; height: 290px; border: 1px solid #ddd; padding:10px; font-size: 13px; float:left; font-family: 'Malgun Gothic';" ></textarea>
                    </div>
                </div>

                <div style="margin-left:10px;width: 1210px; height: 100px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 100px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 40px; font-size: 13px; font-weight: bold; display: inline-block;">주소 정보</span>
                        <span style="color: red">*</span>
                    </div>
                    <div style="width: 450px; height: 35px;float: left;">
                        <input id='dosa_address_postcode' style="margin-left:10px; margin-top:5px; width: 100px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" readonly>
                        <div class="white_button" onclick="daum_address()">주소 찾기</div>
                        <input id='dosa_address_full' name='dosa_address_full' style="margin-left:10px; margin-top:5px; width: 400px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;" readonly>
                        <input id='dosa_address_detail' name='dosa_address_detail' style="margin-left:10px; margin-top:5px; width: 400px; height: 22px; border: 1px solid #ddd; padding-left:10px; font-size: 13px; float:left;">

                    </div>
                </div>

                <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지1</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile1" name="upfile1" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;border-left: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지2</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile2" name="upfile2" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                </div>

                <div style="margin-left:10px;width: 1210px; height: 35px; border-top:1px solid #d0d2d5;border-left:1px solid #d0d2d5;border-right:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지3</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile3" name="upfile3" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;border-left: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지4</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile4" name="upfile4" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                </div>

                <div style="margin-left:10px;width: 1210px; height: 35px; border:1px solid #d0d2d5; text-align: left;">
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지5</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile5" name="upfile5" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                    <div style="width: 150px; height: 35px;background-color: #f2f3f5; border-right: 1px solid #d0d2d5;border-left: 1px solid #d0d2d5; float: left;">
                        <span style="margin-left: 20px; margin-top: 8px; font-size: 13px; font-weight: bold; display: inline-block;">소개 이미지6</span>
                    </div>
                    <div style="width: 449px; height: 35px;float: left;">
                        <input type="file" id="upfile6"  name="upfile6" style="float: left; margin-top: 5px; margin-left: 10px;">
                    </div>
                </div>
            </div>
                <div style="margin-left:30px; float: left; width: calc(100% - 30px);"> <span style="float:left; margin-top: 10px;margin-left:20px; font-size: 12px; color: grey; display: inline-block;"> - 사이즈 480px * 270px / 사진 비율 16:9 * / 크기 2MB 이하 </span></div>
                <div style="margin-left:30px; float: left; width: calc(100% - 30px);"> <span style="float:left; margin-top: 10px;margin-left:20px; font-size: 12px; color: grey; display: inline-block;"> - 상담사 소개 이미지를 등록하지 않을 시, 기본 이미지로 등록됩니다 </span></div>


                <div style="margin-left:30px; float: left; width: calc(100% - 30px);">

                <div class="register_button" onclick="register()">등록하기</div>

            </div>


                
            </form>


        </div>
    </div>
</div>
<div id="footer_contents"></div>
</body>

<script>
    /* 공통 레이아웃 load */
    $("#global_layout").load("/admin/theme/_layout.php");
    $("#footer_contents").load("/admin/theme/_footer.php");


    function nickname_overlap(){

        var dosa_nickname = $("#dosa_nickname").val();

        if(dosa_nickname==''){
            alert('도사 닉네임을 입력해주세요')
        }else if(dosa_nickname.length<2 || dosa_nickname.length>6){
            alert('도사 닉네임을 2~6자리로 입력해주세요')
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/overlap_server.php"
                ,data: {type:"nickname",content:dosa_nickname,}
                ,success:function(result){
                    if(result=='success'){
                        document.getElementById("dosa_nickname_overlap").value = '1';
                        alert("사용가능한 닉네임입니다");
                    }else{
                        document.getElementById("dosa_nickname_overlap").value = '0';
                        alert("이미 존재하는 닉네임입니다");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }


    }
    function email_overlap(){
        var dosa_email = $("#dosa_email").val();
        var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;


        if(dosa_email==''){
            alert('도사 이메일을 입력해주세요')
        }else if(reg_email.test(dosa_email)==false){
                alert('올바른 이메일을 입력해주세요')
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/overlap_server.php"
                ,data: {type:"email",content:dosa_email,}
                ,success:function(result){
                    if(result=='success'){
                        document.getElementById("dosa_email_overlap").value = '1';
                        alert("사용가능한 이메일입니다");
                    }else{
                        document.getElementById("dosa_email_overlap").value = '0';
                        alert("해당 이메일로 가입된 계정이 존재합니다");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }
    }

    //프로필 이미지 미리보기 기능
    $(document).ready(function(){
        $('#dosa_profile_image').on('change', function(){
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
                var ext = $('#dosa_profile_image').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                    alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
                    this.value = "";
                    return;
                }else if(this.files[0].size > 2000000){
                    alert("사진 크기가 너무 큽니다");
                    this.value = "";
                }else{

                    $('#thumb-output').html('');
                    var data = $(this)[0].files;

                    $.each(data, function(index, file){
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
                            var fRead = new FileReader();
                            fRead.onload = (function(file){
                                return function(e) {
                                    var img = $('<img style="width:100px; height: 100px;"/>').addClass('thumb').attr('src', e.target.result);
                                    $('#thumb-output').append(img);
                                };
                            })(file);
                            fRead.readAsDataURL(file);
                        }
                    });

                }

            }else{
                alert("해당 브라우저의 지원 기능에 이상이 있습니다"); //if File API is absent
            }
        });
    });


    //상담 업종 중복체크 방지
    function NoMultiChk(chk){
        var obj = document.getElementsByName("counsel_field");
        for(var i=0; i < obj.length; i++){
            if(obj[i] != chk){
                obj[i].checked = false;
            }
        }
    }

    //상담 분류 배열에 저장
    $(function(){
        $('input[name="counsel_field_detail"]').click(function(){
            var counsel_field_detail_output = '';
            $('input[name="counsel_field_detail"]:checked').each(function(index,item){
                if(index!=0){
                    counsel_field_detail_output += ',';
                }
                counsel_field_detail_output += $(this).val();
            });
            $('#counsel_field_detail_array').val(counsel_field_detail_output);
        });
    });
    //상담 방식 배열에 저장
    $(function(){
        $('input[name="counsel_type"]').click(function(){
            var counsel_type_output = '';
            $('input[name="counsel_type"]:checked').each(function(index,item){
                if(index!=0){
                    counsel_type_output += ',';
                }
                counsel_type_output += $(this).val();
            });
            $('#counsel_type_array').val(counsel_type_output);
        });
    });

    //주소 찾기 API
    function daum_address() {
        new daum.Postcode({
            oncomplete: function(data) {
                //우편번호
                document.getElementById("dosa_address_postcode").value = data.zonecode;
                //기본 주소
                document.getElementById("dosa_address_full").value = data.address;
            }
        }).open();
    }

            


    //상담사 소개 이미지 사진 크기, 이미지인지 아닌지 구분 필요
    var upfile1 = document.getElementById("upfile1");
    var upfile2 = document.getElementById("upfile2");
    var upfile3 = document.getElementById("upfile3");
    var upfile4 = document.getElementById("upfile4");
    var upfile5 = document.getElementById("upfile5");
    var upfile6 = document.getElementById("upfile6");
    upfile1.onchange = function() {
        var ext1 = $('#upfile1').val().split('.').pop().toLowerCase();
        if($.inArray(ext1, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };
    upfile2.onchange = function() {
        var ext2 = $('#upfile2').val().split('.').pop().toLowerCase();
        if($.inArray(ext2, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };
    upfile3.onchange = function() {
        var ext3 = $('#upfile3').val().split('.').pop().toLowerCase();
        if($.inArray(ext3, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };
    upfile4.onchange = function() {
        var ext4 = $('#upfile4').val().split('.').pop().toLowerCase();
        if($.inArray(ext4, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };
    upfile5.onchange = function() {
        var ext5 = $('#upfile5').val().split('.').pop().toLowerCase();
        if($.inArray(ext5, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };
    upfile6.onchange = function() {
        var ext6 = $('#upfile6').val().split('.').pop().toLowerCase();
        if($.inArray(ext6, ['gif','png','jpg','jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 이미지 파일만 업로드 할수 있습니다.');
            this.value = "";
            return;
        }else if(this.files[0].size > 2000000){ // 2MB이하
            alert("사진크기가 너무 큽니다");
            this.value = "";
        }
    };




    function register(){

        //도사 개인정보
        var dosa_nickname = $("#dosa_nickname").val();
        var dosa_nickname_overlap = $("#dosa_nickname_overlap").val();
        var dosa_name = $("#dosa_name").val();
        var dosa_phone = $("#dosa_phone").val();
        var dosa_email = $("#dosa_email").val();
        var dosa_email_overlap = $("#dosa_email_overlap").val();
        var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
        var dosa_password = $("#dosa_password").val();
        var num = dosa_password.search(/[0-9]/g);
        var eng = dosa_password.search(/[a-z]/ig);
        //도사 사업자 정보
        var dosa_account_holder = $("#dosa_account_holder").val();
        var dosa_account_bank = $("#dosa_account_bank").val();
        var dosa_account_number = $("#dosa_account_number").val();
        //도사 상담 정보
        var counsel_field_detail_array = $("#counsel_field_detail_array").val();
        var counsel_type_array = $("#counsel_type_array").val();
        var dosa_title = $("#dosa_title").val();
        var dosa_information = $("#dosa_information").val();
        var dosa_address_full = $("#dosa_address_full").val();
        var dosa_address_detail = $("#dosa_address_detail").val();


        if(dosa_nickname==''){
            alert('도사 닉네임을 입력해주세요')
        }else if(dosa_nickname.length<2 || dosa_nickname.length>6){
            alert('도사 닉네임을 2~6자리로 입력해주세요')
        }else if(dosa_nickname_overlap=='0'){
            alert('도사 닉네임 중복검사를 해주세요')
        }else if(dosa_name==''){
            alert('도사 이름을 입력해주세요')
        }else if(dosa_phone==''){
            alert('도사 전화번호를 입력해주세요')
        }else if(dosa_phone.length!=11){
            alert('도사 전화번호를 올바르게 입력해주세요')
        }else if(dosa_email==''){
            alert('도사 이메일을 입력해주세요')
        }else if(reg_email.test(dosa_email)==false){
            alert('올바른 이메일을 입력해주세요')
        }else if(dosa_email_overlap=='0'){
            alert('도사 이메일 중복검사를 해주세요')
        }else if(dosa_password==''){
            alert('도사 비밀번호를 입력해주세요')
        }else if(dosa_password.length<8 || dosa_password.length>16){
            alert('도사 비밀번호를 영문,숫자 8~16자리로 입력해주세요')
        }else if(num < 0 || eng < 0 ){
            alert('도사 비밀번호를 영문,숫자 8~16자리로 입력해주세요')
        }else if(dosa_account_holder==''){
            alert('도사의 계좌 예금주를 입력해주세요')
        }else if(dosa_account_bank==''){
            alert('도사의 계좌 은행을 입력해주세요')
        }else if(dosa_account_number==''){
            alert('도사 계좌번호를 입력해주세요')
        }else if(counsel_field_detail_array==''){
            alert('도사의 상담분류를 선택해주세요')
        }else if(counsel_type_array==''){
            alert('도사의 상담방식을 선택해주세요')
        }else if(dosa_title==''){
            alert('도사의 상담소개 제목을 입력해주세요')
        }else if(dosa_information==''){
            alert('도사의 상담업체 정보를 입력해주세요')
        }else if(dosa_address_full==''){
            alert('도사의 주소 정보를 입력해주세요')
        }else if(dosa_address_detail==''){
            alert('도사의 자세한 정보를 입력해주세요')
        }else{
            $('#dosa_register_from').submit();
        }


    }








    // 레이아웃
    window.onload = function(){
        change_layout_design();
    };

    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_dosa_menu_register_list");
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