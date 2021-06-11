<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

/* 신청 도사 정보*/
$apply_number = $_GET['apply_number'];

$qry_string = "SELECT * FROM dosa_apply where apply_number='$apply_number'";
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

        /* 좌측 네이밍*/
        #main_contents_box_place_content_left{margin-left:20px; width:calc(10% - 20px);height: 350px; float: left;}
        #main_contents_box_place_content_left_full{margin-left:20px; width:calc(10% - 20px);height: 500px; float: left;}
        #main_contents_box_place_content_left_image{width: 100%;margin-top: 12.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_name{width: 100%;margin-top: 72.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_nickname{width: 100%;margin-top: 142.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_email{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_phone{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_date{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_field{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}
        #main_contents_box_place_content_left_info{width: 100%;margin-top: 12.5px; margin-bottom: 40px;  color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: left;}

        /* 우측 입력박스*/
        #main_contents_box_place_content_right{margin-left:20px; width:calc(40% - 20px); height:350px; float: left; }
        #main_contents_box_place_content_right_full{margin-left:20px; width:calc(90% - 20px); height:500px; float: left;}
        #main_contents_box_place_content_right_image_box{width: 100%; height:100px;margin-top: 3px; margin-bottom: 27px; float: left; }
        #main_contents_box_place_content_right_image_input{height: 100px; border: 1px solid #ddd; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_name_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_name_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_nickname_box{width: 100%; height:40px;margin-top: 133px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_nickname_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_email_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_email_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_phone_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_phone_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_date_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_date_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_field_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_field_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_info_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_info_input{width: 90%; height: 350px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; padding:15px; font-family: 'Malgun Gothic';}



        /* 버튼*/
        .white_button {float: right;margin-right:10px; margin-bottom:50px;width: 107px; height: 32px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 14px; color:  #2C3B5F; text-align: center; line-height: 32px; cursor: pointer; display: inline-block;}
        .white_button:hover{background-color:#2C3B5F; color:white; }
        .black_button {float: left; margin-left: 160px; margin-bottom:50px; margin-right:10px; width: 107px; height: 32px;background-color: #2C3B5F; border:1px solid #2C3B5F; font-weight: bold; font-size: 14px; color:  white; text-align: center; line-height: 32px; cursor: pointer; display: inline-block;}
        .black_button:hover{background-color:white; color:#2C3B5F; }
        .black_button_hide {display:none;float: right; margin-left: 140px; margin-right:10px; width: 107px; height: 32px;background-color: #2C3B5F; border:1px solid #2C3B5F; font-weight: bold; font-size: 14px; color:  white; text-align: center; line-height: 32px; cursor: pointer;}
        .black_button_hide:hover{background-color:white; color:#2C3B5F; }
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

            <div id="main_contents_box_place_title">신청 상담가 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if($total_row == 0) {?>
                해당 글이 존재하지 않습니다
            <?php }else { ?>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_image">프로필 이미지</div>
                    <div id="main_contents_box_place_content_left_name">이름</div>
                    <div id="main_contents_box_place_content_left_email">이메일</div>
                    <div id="main_contents_box_place_content_left_phone">전화번호</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_image_box">
                        <?php if($row['apply_profile_image']==null){ ?>
                            <img id="main_contents_box_place_content_right_image_input" src="/admin/image/profile.png">
                        <?php }else{ ?>
                            <img id="main_contents_box_place_content_right_image_input" src="<?php echo $row['apply_profile_image'];?>">
                        <?php }?>
                    </div>
                    <div id="main_contents_box_place_content_right_name_box">
                        <input type="text" id="main_contents_box_place_content_right_name_input"
                               value="<?php echo $row['apply_name']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_email_box">
                        <input type="text" id="main_contents_box_place_content_right_email_input"
                               value="<?php echo $row['apply_email']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_phone_box">
                        <input type="text" id="main_contents_box_place_content_right_phone_input"
                               value="<?php echo $row['apply_phone']; ?>" readonly>
                    </div>
                </div>

                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_nickname">닉네임</div>
                    <div id="main_contents_box_place_content_left_date">신청날짜</div>
                    <div id="main_contents_box_place_content_left_field">상담분야</div>

                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_nickname_box">
                        <input type="text" id="main_contents_box_place_content_right_nickname_input"
                               value="<?php echo $row['apply_nickname']; ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_date_box">
                        <input type="text" id="main_contents_box_place_content_right_date_input"
                               value="<?php echo date('Y년 m월 d일', strtotime($row['apply_date'])); ?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_field_box">
                        <input type="text" id="main_contents_box_place_content_right_field_input"
                               value="<?php echo $row['apply_counsel_field']; ?>" readonly>
                    </div>

                </div>

                <div id="main_contents_box_place_content_left_full">
                    <div id="main_contents_box_place_content_left_info">소개글</div>
                </div>

                <div id="main_contents_box_place_content_right_full">
                    <div id="main_contents_box_place_content_right_info_box">
                        <textarea id="main_contents_box_place_content_right_info_input" readonly><?php echo $row['apply_information']; ?></textarea>
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



    window.onload = function(){
        change_layout_design();
    };



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_dosa_menu_apply_list");
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