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

$qry_string = "SELECT * FROM review where counsel_code='$counsel_code'";
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

        #main_contents_box_place_content_left{width: 10%; height: 1080px; float: left;}
        #main_contents_box_place_content_left_code{width: 100%; margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: center;}
        #main_contents_box_place_content_left_product{width: 100%; margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: center;}
        #main_contents_box_place_content_left_dosa_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px; margin-left:15px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_user_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px; margin-left:15px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_star{width: 100%;margin-top: 12.5px; margin-bottom: 40px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_content{width: 100%;margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_reply{width: 100%;margin-top: 282.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}

        #main_contents_box_place_content_right{margin-left:20px; width:calc(90% - 20px); height: 1080px; float: right;}
        #main_contents_box_place_content_right_title_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left; }
        #main_contents_box_place_content_right_code_input{width: 120px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_product_input{width: 400px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_dosa_nickname_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_dosa_nickname_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_user_nickname_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_user_nickname_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_star_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left; text-align: left;}
        #main_contents_box_place_content_right_star_image{margin-top:10px; margin-right:5px; width: 20px; height: 20px; float:left;}
        #main_contents_box_place_content_right_star_text{margin-top:12px; margin-left:5px; font-size:13px; font-weight:bold;float:left;}
        #main_contents_box_place_content_right_content_box{width: 100%; height:300px;margin-top: 3px; margin-bottom: 40px; float: left; }
        #main_contents_box_place_content_right_content_input{width: 1250px; height: 290px; border: 1px solid #ddd; padding:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_reply_box{width: 100%; height:300px;margin-top: 3px; margin-bottom: 40px; float: left; }
        #main_contents_box_place_content_right_reply_input{width: 1250px; height: 290px; border: 1px solid #ddd; padding:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}

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

            <div id="main_contents_box_place_title">사용자 리뷰 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>
            
            <?php if($total_row == 0) {?>
                해당 글이 존재하지 않습니다
            <?php }else { ?>

            <div id="main_contents_box_place_content_left">
                <div id="main_contents_box_place_content_left_code">상담코드</div>
                <div id="main_contents_box_place_content_left_product">상담상품</div>
                <div id="main_contents_box_place_content_left_dosa_name">상담자 닉네임</div>
                <div id="main_contents_box_place_content_left_user_name">작성자 닉네임</div>
                <div id="main_contents_box_place_content_left_star">리뷰 평점</div>
                <div id="main_contents_box_place_content_left_content">리뷰 내용</div>
                <div id="main_contents_box_place_content_left_reply">답변 내용</div>
            </div>


            <div id="main_contents_box_place_content_right">
                <div id="main_contents_box_place_content_right_title_box">
                    <input type="text" id="main_contents_box_place_content_right_code_input" maxlength="50" value="<?php echo $row['counsel_code'];?>" readonly>
                </div>
                <div id="main_contents_box_place_content_right_title_box">
                    <input type="text" id="main_contents_box_place_content_right_product_input" maxlength="50" value="<?php echo $row['product_name'];?>" readonly>
                </div>

                <div id="main_contents_box_place_content_right_dosa_nickname_box">
                    <input type="text" id="main_contents_box_place_content_right_dosa_nickname_input" value="<?php echo $row['dosa_nickname'];?>"  readonly>
                </div>

                <div id="main_contents_box_place_content_right_user_nickname_box">
                    <input type="text" id="main_contents_box_place_content_right_user_nickname_input" value="<?php echo $row['user_nickname'];?>"  readonly>
                </div>

                <div id="main_contents_box_place_content_right_star_box">
                    <?php if($row['review_score']=='1'){?>
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <span id="main_contents_box_place_content_right_star_text">(평점 1.0)</span>
                    <?php }elseif($row['review_score']=='2'){ ?>
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <span id="main_contents_box_place_content_right_star_text">(평점 2.0)</span>
                    <?php }elseif($row['review_score']=='3'){ ?>
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <span id="main_contents_box_place_content_right_star_text">(평점 3.0)</span>
                    <?php }elseif($row['review_score']=='4'){ ?>
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staroff.png">
                        <span id="main_contents_box_place_content_right_star_text">(평점 4.0)</span>
                    <?php }else{ ?>
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <img id='main_contents_box_place_content_right_star_image' src="/admin/image/staron.png">
                        <span id="main_contents_box_place_content_right_star_text">(평점 5.0)</span>
                    <?php } ?>

                </div>

                <div id="main_contents_box_place_content_right_content_box">
                    <textarea id="main_contents_box_place_content_right_content_input" readonly><?php echo $row['review_content'];?> </textarea>
                </div>

                <div id="main_contents_box_place_content_right_reply_box">
                    <?php if($row['review_reply_content']==null){?>
                    <textarea id="main_contents_box_place_content_right_reply_input" style="color: grey;" readonly>답변이 등록되지 않았습니다</textarea>
                    <?php }else{ ?>
                    <textarea id="main_contents_box_place_content_right_reply_input" readonly><?php echo $row['review_reply_content'];?> </textarea>
                    <?php } ?>
                </div>

            </div>

            <div class="black_button" onclick="history.back()">목록</div>

            <div class="white_button" id="review_delete_button" onclick="review_delete();">삭제하기</div>

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


    function review_delete(){
        var counsel_code = '<?php echo $counsel_code;?>';
        
        var result = confirm("정말로 삭제하시겠습니까?");
        if(result){
            $.ajax({
                type: "POST"
                ,url: "/admin/server/review_server.php"
                ,data: {type:"delete", counsel_code:counsel_code}
                ,success:function(result){
                    if(result=='success'){
                        alert("리뷰가 삭제되었습니다");
                        location.href='/admin/theme/cs/review_list.php';
                    }else{
                        alert("리뷰 삭제에 실패하였습니다. 다시한번 시도해주세요");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }else{

        }

    }




    window.onload = function(){
        change_layout_design();
    };



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_cs_menu_review");
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