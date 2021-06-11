<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");


$qna_number = $_GET['qna_number'];

$qry_string = "SELECT * FROM qna where qna_number='$qna_number'";
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

        #main_contents_box_place_content_left{width: 10%; height: 1200px; float: left;}
        #main_contents_box_place_content_left_title{width: 100%; margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left; text-align: center;}

        #main_contents_box_place_content_left_target{width: 100%;margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_email{width: 100%;margin-top: 12.5px; margin-bottom: 40px; margin-left:10px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_name{width: 100%;margin-top: 12.5px; margin-bottom: 40px; margin-left:6px; color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}

        #main_contents_box_place_content_left_content{width: 100%;margin-top: 12.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_image{width: 100%;margin-top: 292.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}
        #main_contents_box_place_content_left_reply{width: 100%;margin-top: 92.5px; margin-bottom: 40px;color: #2C3B5F;font-size: 14px; font-weight: bold; float: left;text-align: center;}

        #main_contents_box_place_content_right{margin-left:20px; width:calc(90% - 20px); height: 1200px; float: right;}
        #main_contents_box_place_content_right_title_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left; }
        #main_contents_box_place_content_right_title_input{width: 550px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_target_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_target_input{width: 120px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_email_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_email_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_name_box{width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left;  }
        #main_contents_box_place_content_right_name_input{width: 250px; height: 34px; border: 1px solid #ddd; padding-left:18px; font-size: 14px; float:left;}
        #main_contents_box_place_content_right_content_box{width: 100%; height:300px;margin-top: 3px; margin-bottom: 40px; float: left; }
        #main_contents_box_place_content_right_content_input{width: 1250px; height: 290px; border: 1px solid #ddd; padding:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}
        #main_contents_box_place_content_right_image_box{width: 100%; height:120px;margin-top: 3px; margin-bottom: 40px; float: left; display: inline-block; }
        #main_contents_box_place_content_right_image_box_1{height:100px; float: left; margin-top:10px; margin-right:30px; background-color: #efefef; display: inline-block;}
        #main_contents_box_place_content_right_image_box_2{height:100px; float: left; margin-top:10px; margin-right:30px; background-color: #efefef; display: inline-block;}
        #main_contents_box_place_content_right_image_box_3{height:100px; float: left; margin-top:10px; margin-right:30px; background-color: #efefef; display: inline-block;}
        #main_contents_box_place_content_right_reply_box{width: 100%; height:300px;margin-top: 3px; margin-bottom: 40px; float: left; }
        #main_contents_box_place_content_right_reply_input{width: 1250px; height: 290px; border: 1px solid #ddd; padding:18px; font-size: 14px; float:left; font-family: 'Malgun Gothic';}

        /* 버튼*/
        .white_button {float: right;margin-right:10px; margin-bottom:50px;width: 107px; height: 32px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 14px; color:  #2C3B5F; text-align: center; line-height: 32px; cursor: pointer; display: inline-block;}
        .white_button:hover{background-color:#2C3B5F; color:white; }
        .black_button {float: left; margin-left: 160px; margin-bottom:50px; margin-right:10px; width: 107px; height: 32px;background-color: #2C3B5F; border:1px solid #2C3B5F; font-weight: bold; font-size: 14px; color:  white; text-align: center; line-height: 32px; cursor: pointer; display: inline-block;}
        .black_button:hover{background-color:white; color:#2C3B5F; }
        .black_button_hide {display:none;float: right; margin-left: 140px; margin-right:10px; width: 107px; height: 32px;background-color: #2C3B5F; border:1px solid #2C3B5F; font-weight: bold; font-size: 14px; color:  white; text-align: center; line-height: 32px; cursor: pointer;}
        .black_button_hide:hover{background-color:white; color:#2C3B5F; }


        /* 모달 */
        .modal1, .modal2, .modal3 {display:none;position: fixed;z-index: 1;padding-top: 200px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_content1, .modal_content2, .modal_content3 {margin: auto;width: 700px; }
        .close1, .close2, .close3 {color: #000000;float: right;font-size: 30px;font-weight: bold;margin-right: 8px;}
        .close1, .close2, .close3:hover,
        .close1, .close2, .close3:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_content_head1,#modal_content_head2,#modal_content_head3{width:100%; height:30px;}
        #modal_content_image1,#modal_content_image2,#modal_content_image3{width:100%; height: 500px; display: inline-block;}


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

            <div id="main_contents_box_place_title">1대1 문의 상세보기</div>
            <div id="main_contents_box_place_title_line"></div>

            <?php if($total_row == 0) {?>
                해당 글이 존재하지 않습니다
            <?php }else { ?>

            <div id="main_contents_box_place_content_left">
                <div id="main_contents_box_place_content_left_title">문의 제목</div>
                <div id="main_contents_box_place_content_left_target">문의 분류</div>
                <div id="main_contents_box_place_content_left_email">작성자 이메일</div>
                <div id="main_contents_box_place_content_left_name">작성자 이름</div>
                <div id="main_contents_box_place_content_left_content">문의 내용</div>
                <div id="main_contents_box_place_content_left_image">첨부 파일</div>
                <div id="main_contents_box_place_content_left_reply">답변 내용</div>
            </div>


            <div id="main_contents_box_place_content_right">
                <div id="main_contents_box_place_content_right_title_box">
                    <input type="text" id="main_contents_box_place_content_right_title_input" maxlength="50"
                           value="<?php echo $row['qna_title']; ?>" readonly>
                </div>
                <div id="main_contents_box_place_content_right_target_box">
                    <input type="text" id="main_contents_box_place_content_right_target_input" value="<?php
                    if ($row['qna_writer_type'] == '0') {
                        echo '사용자';
                    } elseif ($row['qna_writer_type'] == '1') {
                        echo '상담가';
                    }
                    ?>"
                           readonly>
                </div>
                <div id="main_contents_box_place_content_right_email_box">
                    <input type="text" id="main_contents_box_place_content_right_email_input"
                           value="<?php echo $row['qna_writer_email']; ?>">
                </div>

                <div id="main_contents_box_place_content_right_name_box">
                    <input type="text" id="main_contents_box_place_content_right_name_input"
                           value="<?php echo $row['qna_writer_name']; ?>">
                </div>

                <div id="main_contents_box_place_content_right_content_box">
                    <textarea id="main_contents_box_place_content_right_content_input"
                              readonly><?php echo $row['qna_content']; ?> </textarea>
                </div>

                <div id="main_contents_box_place_content_right_image_box">
                    <div id="main_contents_box_place_content_right_image_box_1">
                        <?php if ($row['qna_image1'] == null) { ?>
                            <img height="100%" src="/admin/image/qna_photo.png">
                        <?php } else { ?>
                            <img height="100%" src="<?php echo $row['qna_image1'];?>" onclick="click_img1()" style="cursor: pointer;">
                        <?php } ?>
                    </div>
                    <div id="main_contents_box_place_content_right_image_box_2">
                        <?php if ($row['qna_image2'] == null) { ?>
                            <img  height="100%" src="/admin/image/qna_photo.png">
                        <?php } else { ?>
                            <img  height="100%" src="<?php echo $row['qna_image2']; ?>" onclick="click_img2()" style="cursor: pointer;">
                        <?php } ?>
                    </div>
                    <div id="main_contents_box_place_content_right_image_box_3">
                        <?php if ($row['qna_image3'] == null) { ?>
                            <img  height="100%" src="/admin/image/qna_photo.png">
                        <?php } else { ?>
                            <img height="100%" src="<?php echo $row['qna_image3']; ?>" onclick="click_img3()" style="cursor: pointer;">
                        <?php } ?>
                    </div>
                </div>

                <div id="main_contents_box_place_content_right_reply_box">
                    <textarea id="main_contents_box_place_content_right_reply_input"
                              readonly><?php echo $row['qna_reply_content']; ?> </textarea>
                </div>
            </div>

            <div class="black_button" onclick="history.back()">목록</div>

            <?php if($row['qna_reply_status'] == '0'){ ?>
            <div class="white_button" id="reply_answer_button" onclick="reply_answer();">답변하기</div>
            <div class="black_button_hide" id="reply_answer_finish_button" onclick="reply_answer_finish();">답변완료</div>
            <?php }else{ ?>
            <div class="white_button" id="reply_modify_button" onclick="reply_modify();">수정하기</div>
            <div class="black_button_hide" id="reply_modify_finish_button" onclick="reply_modify_finish();">수정완료</div>


            <?php }


            }?>
            
        </div>

        <div id="myModal1" class="modal1">
            <div class="modal_content1">
                <div id="modal_content_head1">
                   <span class="close1">&times;</span>
                </div>
                <div id="modal_content_image1">
                    <img  style="max-width:100%; max-height: 500px;"src="<?php echo $row['qna_image1']; ?>">
                </div>
            </div>
        </div>

        <div id="myModal2" class="modal2">
            <div class="modal_content2">
                <div id="modal_content_head2">
                    <span class="close2">&times;</span>
                </div>
                <div id="modal_content_image2">
                    <img style="max-width:100%; max-height: 500px;" src="<?php echo $row['qna_image2']; ?>">
                </div>
            </div>
        </div>

        <div id="myModal3" class="modal3">
            <div class="modal_content3">
                <div id="modal_content_head3">
                    <span class="close3">&times;</span>
                </div>
                <div id="modal_content_image3">
                    <img style="max-width:100%; max-height: 500px;" src="<?php echo $row['qna_image3']; ?>">
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


    var modal1 = document.getElementById("myModal1");
    var span1 = document.getElementsByClassName("close1")[0];
    var modal2 = document.getElementById("myModal2");
    var span2 = document.getElementsByClassName("close2")[0];
    var modal3 = document.getElementById("myModal3");
    var span3 = document.getElementsByClassName("close3")[0];

    function click_img1() {
        modal1.style.display = "block";
    }
    span1.onclick = function() {
        modal1.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
    }

    function click_img2() {
        modal2.style.display = "block";
    }
    span2.onclick = function() {
        modal2.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }

    function click_img3() {
        modal3.style.display = "block";
    }
    span3.onclick = function() {
        modal3.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal3) {
            modal3.style.display = "none";
        }
    }



    function reply_answer(){
        document.getElementById("main_contents_box_place_content_right_reply_input").style.backgroundColor = '#f2f2f2';
        $("#main_contents_box_place_content_right_reply_input").removeAttr("readonly");
        $("#main_contents_box_place_content_right_reply_input").focus();
        document.getElementById("reply_answer_button").style.display = 'none';
        document.getElementById("reply_answer_finish_button").style.display = 'block';
    }
    function reply_modify(){
        document.getElementById("main_contents_box_place_content_right_reply_input").style.backgroundColor = '#f2f2f2';
        $("#main_contents_box_place_content_right_reply_input").removeAttr("readonly");
        var len = $('#main_contents_box_place_content_right_reply_input').val().length;
        $('#main_contents_box_place_content_right_reply_input').focus();
        $('#main_contents_box_place_content_right_reply_input')[0].setSelectionRange(len, len);
        document.getElementById("reply_modify_button").style.display = 'none';
        document.getElementById("reply_modify_finish_button").style.display = 'block';
    }
    function reply_answer_finish(){
        var qna_reply = $("#main_contents_box_place_content_right_reply_input").val();
        var qna_number = '<?php echo $qna_number;?>';

        if(qna_reply==''){
            alert('답변을 입력해주세요');
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/qna_server.php"
                ,data: {type:"answer", reply:qna_reply, number:qna_number}
                ,success:function(result){
                    if(result=='success'){
                        alert("답변을 등록했습니다.");
                        location.href='/admin/theme/cs/qna_detail.php?qna_number=<?php echo $qna_number;?>';
                    }else{
                        alert("답변 등록에 실패하였습니다. 다시한번 시도해주세요");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }

    }
    function reply_modify_finish(){
        var qna_reply = $("#main_contents_box_place_content_right_reply_input").val();
        var qna_number = '<?php echo $qna_number;?>';

        if(qna_reply==''){
            alert('답변을 입력해주세요');
        }else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/qna_server.php"
                ,data: {type:"modify", reply:qna_reply, number:qna_number}
                ,success:function(result){
                    if(result=='success'){
                        alert("답변을 수정했습니다.");
                        location.href='/admin/theme/cs/qna_detail.php?qna_number=<?php echo $qna_number;?>';
                    }else{
                        alert("답변 수정에 실패하였습니다. 다시한번 시도해주세요");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }
    }




    window.onload = function(){
        change_layout_design();
    };



    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_cs_menu_qna");
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