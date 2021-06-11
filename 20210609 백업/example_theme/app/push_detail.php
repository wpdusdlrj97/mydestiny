<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");


$push_number = $_GET['push_number'];

$qry_string = "SELECT * FROM push where push_number='$push_number'";
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
        body{ padding:0; margin:0; overflow:auto; }
        #global_layout{ float:left; }
        #contents_box{ float:left; width:calc(100% - 314px); min-height:calc(100vh - 55px); margin-top:55px; margin-left:314px; background-color:#FFFFFF; }
        #main_contents_box{ float:left; width:100%; height:100%; text-align:center; }
        #main_contents_box_place{ margin-left: 50px; width:1420px; }
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 30px; width: 100%; height: 3px; background-color: #2C3B5F;}

        #main_contents_box_place_content_left{width: 10%; height: 640px; float: left; text-align: left;}
        #main_contents_box_place_content_left_title{width: 100%; margin-top: 12.5px; margin-left:30px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;}
        #main_contents_box_place_content_left_target{width: 100%;margin-top: 12.5px;  margin-left:30px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;}
        #main_contents_box_place_content_left_content{width: 100%;margin-top: 12.5px;  margin-left:30px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;}
        #main_contents_box_place_content_left_date{width: 100%; margin-top: 312.5px; margin-left:30px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;}


        #main_contents_box_place_content_right{margin-left:20px; width:calc(90% - 20px);height: 640px; float: right;}
        #main_contents_box_place_content_right_title_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left; }
        #main_contents_box_place_content_right_title_input{width: 550px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_target_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_target_input{width: 120px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_target_select{display:none;width: 120px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_content_box{width: 100%; height:300px;margin-top: 3px; margin-bottom: 40px; float: left; }
        #main_contents_box_place_content_right_content_input{width: 1250px; height: 290px; border: 1px solid #ddd; padding:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_date_box{width: 100%; height:40px;margin-top: 33px; margin-bottom: 27px; float: left; }
        #main_contents_box_place_content_right_date_input{width: 350px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}

        /* 버튼*/
        .white_button {float: right;margin-right:10px; width: 107px; height: 32px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 14px; color:  #2C3B5F; text-align: center; line-height: 32px; cursor: pointer;}
        .white_button:hover{background-color:#2C3B5F; color:white; }
        .black_button {float: right; margin-left: 160px; width: 107px; height: 32px;background-color: #2C3B5F; border:1px solid #2C3B5F; font-weight: bold; font-size: 14px; color:  white; text-align: center; line-height: 32px; cursor: pointer;}
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

            <div id="main_contents_box_place_title">푸시알림 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if($total_row == 0) {?>
                해당 글이 존재하지 않습니다
            <?php }else { ?>


                <div id="main_contents_box_place_content_left">
                    <div id="main_contents_box_place_content_left_title">제목</div>
                    <div id="main_contents_box_place_content_left_target">대상</div>
                    <div id="main_contents_box_place_content_left_content">내용</div>
                    <div id="main_contents_box_place_content_left_date">전송날짜</div>
                </div>


                <div id="main_contents_box_place_content_right">
                    <div id="main_contents_box_place_content_right_title_box">
                        <input type="text" id="main_contents_box_place_content_right_title_input" maxlength="50" value="<?php echo $row['push_title'];?>" readonly>
                    </div>
                    <div id="main_contents_box_place_content_right_target_box">
                        <input type="text" id="main_contents_box_place_content_right_target_input" value="<?php
                        if($row['push_target']=='0'){
                            echo '전체';
                        }elseif($row['push_target']=='1'){
                            echo '사용자';
                        }else{
                            echo '상담가';
                        }
                        ?>"
                               readonly>

                        <select id="main_contents_box_place_content_right_target_select" id="user_list_search">
                            <?php if($row['push_target']=='0'){ ?>
                                <option selected>전체</option>
                                <option>사용자</option>
                                <option>상담가</option>
                            <?php }else if($row['push_target']=='1'){  ?>
                                <option>전체</option>
                                <option selected>사용자</option>
                                <option>상담가</option>
                            <?php }else{  ?>
                                <option>전체</option>
                                <option>사용자</option>
                                <option selected>상담가</option>
                            <?php }  ?>
                        </select>

                    </div>
                    <div id="main_contents_box_place_content_right_content_box">
                        <textarea id="main_contents_box_place_content_right_content_input" readonly><?php echo $row['push_content'];?> </textarea>
                    </div>
                    <div id="main_contents_box_place_content_right_date_box">
                        <input type="text" id="main_contents_box_place_content_right_date_input" maxlength="50" value="<?php echo  date('Y년 m월 d일 H시 i분 s초', strtotime($row['push_date']));?>" readonly>

                        <div class="black_button" onclick="history.back()">목록</div>

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