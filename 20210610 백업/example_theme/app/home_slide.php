<?php
session_start();
$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}
//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");



$qry_string = "SELECT * FROM home_slide order by slide_number asc";
$qry = mysqli_query($connect, $qry_string);
$total_row = mysqli_num_rows($qry);

$slide_number = array();
$slide_type = array();
$slide_content = array();
$slide_date= array();

while ($row = mysqli_fetch_array($qry)) {
    array_push($slide_number, $row['slide_number']);
    array_push($slide_type, $row['slide_type']);
    array_push($slide_content, $row['slide_content']);

    array_push($slide_date, date('Y.m.d', strtotime($row['slide_date'])));
}


$String = "apple;banana;cat;dog";
$strTok =explode(';' , $String);




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
        #main_contents_box_place{ margin-left: 50px; width:1420px; display: inline-block;}
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 10px; width: 100%; height: 3px; background-color: #2C3B5F;}

        #main_contents_box_place_subtitle_box {margin-bottom: 10px; width: 100%; height: 70px; text-align: left;}
        #main_contents_box_place_subtitle_span { font-size: 12px; color: grey; font-weight: bold;}



        .main_contents_box_place_content_left{width: 10%; height: 1040px; float: left; text-align: left; }
        .main_contents_box_place_content_left_slide1{width: 100%; margin-top: 3px;height:270px; margin-left:20px;color:#000000;font-size: 16px; font-weight: bold; float: left; background-color: #f2f3f5; border-left: 2px solid #ddd;border-top: 2px solid #ddd;border-bottom: 2px solid #ddd;}
        .main_contents_box_place_content_left_slide2{width: 100%; margin-top: 3px;height:270px; margin-left:20px;color:#000000;font-size: 16px; font-weight: bold; float: left; background-color: #f2f3f5; border-left: 2px solid #ddd;border-top: 2px solid #ddd;border-bottom: 2px solid #ddd;}
        .main_contents_box_place_content_left_slide3{width: 100%; margin-top: 46px;height:270px; margin-left:20px;color:#000000;font-size: 16px; font-weight: bold; float: left; background-color: #f2f3f5; border-left: 2px solid #ddd;border-top: 2px solid #ddd;border-bottom: 2px solid #ddd;}
        .main_contents_box_place_content_left_slide4{width: 100%; margin-top: 46px;height:270px; margin-left:20px;color:#000000;font-size: 16px; font-weight: bold; float: left; background-color: #f2f3f5; border-left: 2px solid #ddd;border-top: 2px solid #ddd;border-bottom: 2px solid #ddd;}
        .main_contents_box_place_content_left_slide5{width: 100%; margin-top: 46px;height:270px; margin-left:20px;color:#000000;font-size: 16px; font-weight: bold; float: left; background-color: #f2f3f5; border-left: 2px solid #ddd;border-top: 2px solid #ddd;border-bottom: 2px solid #ddd;}

        #main_contents_box_place_content_right{margin-left:20px; width:calc(40% - 20px);height: 1040px; float: left;}
        .main_contents_box_place_content_right_slide1_box{position:relative;width: 100%; height:40px;margin-top: 3px; margin-bottom: 27px; float: left; }
        .main_contents_box_place_content_right_slide2_box{position:relative; width: 100%; height:40px;margin-top: 3px;  margin-bottom: 27px; float: left; }
        .main_contents_box_place_content_right_slide3_box{position:relative;width: 100%; height:40px;margin-top: 253px; margin-bottom: 27px; float: left; }
        .main_contents_box_place_content_right_slide4_box{position:relative;width: 100%; height:40px;margin-top: 253px; margin-bottom: 27px; float: left; }
        .main_contents_box_place_content_right_slide5_box{position:relative;width: 100%; height:40px;margin-top: 253px; margin-bottom: 27px; float: left; }


        input:focus {outline:none; font-family: 'Malgun Gothic';}
        textarea:focus {outline:none; font-family: 'Malgun Gothic';}
        select:focus {outline:none; font-family: 'Malgun Gothic';}

        .image_slide_box {
            width: 480px; height: 270px;
            position: absolute;
            top: 0;
            left: 0;
            border: 2px solid #ddd;

        }

        .overlay {
            z-index: 9;
        }


        .image_slide_box_image{max-width: 480px; height: 100%;}
        .image_slide_box_image_menu{margin-top:230px;width: 100%; height: 40px; background-color: #000000; opacity: 0.6}
        .image_slide_box_image_menu_video{width: 33%; height:40px; float: left; color: white;line-height: 40px; cursor: pointer}
        .image_slide_box_image_menu_image{width: 33%; height:40px; float: left; border-left: 2px solid white;  border-right: 2px solid white;color: white;line-height: 40px;cursor: pointer}
        .image_slide_box_image_menu_delete{width: 33%; height:40px; float: left;color: white;line-height: 40px;cursor: pointer}
        .image_slide_box_image_menu_video:hover{ color: red; font-weight: bold;}
        .image_slide_box_image_menu_image:hover{ color: red; font-weight: bold;}
        .image_slide_box_image_menu_delete:hover{color: red; font-weight: bold;}



        .image_slide_box_video{max-width: 480px; height: 100%;}
        .image_slide_box_video_youtube_icon{margin-top:75px;width: 100px;}
        .image_slide_box_video_menu{margin-top:50px;width: 100%; height: 40px; background-color: #000000; opacity: 0.6}
        .image_slide_box_video_menu_video{width: 33%; height:40px; float: left; color: white;line-height: 40px; cursor: pointer}
        .image_slide_box_video_menu_image{width: 33%; height:40px; float: left; border-left: 2px solid white;  border-right: 2px solid white;color: white;line-height: 40px;cursor: pointer}
        .image_slide_box_video_menu_delete{width: 33%; height:40px; float: left;color: white;line-height: 40px;cursor: pointer}
        .image_slide_box_video_menu_video:hover{ color: red; font-weight: bold;}
        .image_slide_box_video_menu_image:hover{ color: red; font-weight: bold;}
        .image_slide_box_video_menu_delete:hover{color: red; font-weight: bold;}

        .image_slide_box_text{font-size: 30px; color: grey; line-height: 270px;}
        .image_slide_box_text_menu{margin-top:230px;width: 100%; height: 40px; background-color: #000000; opacity: 0.6}
        .image_slide_box_text_menu_video{width: 49.5%; height:40px; float: left; color: white;line-height: 40px; cursor: pointer}
        .image_slide_box_text_menu_image{width: 49.5%; height:40px; float: left; border-left: 2px solid white; color: white;line-height: 40px;cursor: pointer}
        .image_slide_box_text_menu_video:hover{ color: red; font-weight: bold;}
        .image_slide_box_text_menu_image:hover{ color: red; font-weight: bold;}




        /* 모달 */
        .modal_video {display:none;position: fixed;z-index: 11;padding-top: 250px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_video_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 500px; height: 200px;}
        .close_video {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close_video:hover,
        .close_video:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_video_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_video_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_video_content_right{margin-top:30px; margin-left:50px; width: 380px; height: 40px;  font-size: 14px;  float: left;}
        #modal_video_content_right_video{margin-top:5px; width: 400px; height: 18px; padding: 5px; border: 1px solid #ddd; display: inline-block;float: left;}

        #modal_video_content_full{width: 500px; height: 50px; margin-bottom: 10px;  font-size: 14px;  float: left;}
        #modal_video_content_full_send_button{float: right;margin-right:30px; width: 60px; height: 25px;background-color: #2C3B5F; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color: white; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_video_content_full_cancel_button{float: right;margin-right:10px; width: 60px; height: 25px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_video_content_info_text{font-size: 12px; color: grey; margin-left:50px; margin-top:10px; margin-bottom: 20px; display: inline-block; float: left}


        .modal_image {display:none;position: fixed;z-index: 11;padding-top: 300px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_image_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 500px; height: 180px;}
        .close_image {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close_image:hover,
        .close_image:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_image_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_image_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_image_content_right{margin-top:30px; margin-left:50px; width: 380px; height: 40px;  font-size: 14px;  float: left;}
        #modal_image_content_right_video{margin-top:5px; width: 400px; height: 18px; padding: 5px; border: 1px solid #ddd; display: inline-block;float: left;}

        #modal_image_content_full{width: 500px; height: 40px;  font-size: 14px;  float: left;}
        #modal_image_content_full_send_button{float: right;margin-right:30px; width: 60px; height: 25px;background-color: #2C3B5F; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color: white; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_image_content_full_cancel_button{float: right;margin-right:10px; width: 60px; height: 25px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_image_content_info_text{font-size: 12px; color: grey; margin-left:50px; margin-bottom: 10px; display: inline-block; float: left}






    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">

            <div id="main_contents_box_place_title">홈 슬라이드 관리</div>
            <div id="main_contents_box_place_title_line"></div>

            <div id="main_contents_box_place_subtitle_box">
                <span id="main_contents_box_place_subtitle_span">
                    * 홈슬라이드 광고에는 유튜브 영상 혹은 이미지 등록이 가능합니다. (최대 5개)
                </span>
                <br>
                <span id="main_contents_box_place_subtitle_span" style="margin-left:10px;">
                    유튜브 링크 형식 : https://www.youtube.com/watch?v=aaaaaaa  &nbsp; /  &nbsp;이미지 비율 : 가로 480px * 세로 360px 이하
                </span>
            </div>


            <div class="main_contents_box_place_content_left">
                <div class="main_contents_box_place_content_left_slide1"><span style="margin-top:110px;margin-left: 30px; display: inline-block">슬라이드 1</span>
                </div>
                <div class="main_contents_box_place_content_left_slide3"><span style="margin-top:110px;margin-left: 30px; display: inline-block">슬라이드 3</span></div>
                <div class="main_contents_box_place_content_left_slide5"><span style="margin-top:110px;margin-left: 30px; display: inline-block">슬라이드 5</span></div>
            </div>


            <div id="main_contents_box_place_content_right">
                <div class="main_contents_box_place_content_right_slide1_box">
                    <?php if($slide_type[0]=='1'){ ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_image" src="<?php echo $slide_content[0];?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_image_menu">
                                <div class="image_slide_box_image_menu_video" onclick="slide_video(1)" > 영상 업로드</div>
                                <div class="image_slide_box_image_menu_image" onclick="slide_image(1)"> 사진 업로드</div>
                                <div class="image_slide_box_image_menu_delete" onclick="slide_delete(1)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }elseif($slide_type[0]=='2'){
                        $content_1 = $slide_content[0];
                        $content_split_1 = explode('?v=' , $content_1);
                        $youtube_thumbnail_1 = "http://img.youtube.com/vi/".$content_split_1[1]."/mqdefault.jpg";
                        ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_video" src="<?php echo $youtube_thumbnail_1?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <img class="image_slide_box_video_youtube_icon"  src="/admin/image/youtube_logo.png">
                            <div class="image_slide_box_video_menu">
                                <div class="image_slide_box_video_menu_video" onclick="slide_video(1)" > 영상 업로드</div>
                                <div class="image_slide_box_video_menu_image" onclick="slide_image(1)"> 사진 업로드</div>
                                <div class="image_slide_box_video_menu_delete" onclick="slide_delete(1)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="image_slide_box">
                            <span class="image_slide_box_text" > + </span>
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_text_menu">
                                <div class="image_slide_box_text_menu_video" onclick="slide_video(1)" > 영상 업로드</div>
                                <div class="image_slide_box_text_menu_image" onclick="slide_image(1)"> 사진 업로드</div>
                            </div>
                        </div>
                    <?php }?>

                </div>
                <div class="main_contents_box_place_content_right_slide3_box" >
                    <?php if($slide_type[2]=='1'){ ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_image" src="<?php echo $slide_content[2];?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_image_menu">
                                <div class="image_slide_box_image_menu_video" onclick="slide_video(3)" > 영상 업로드</div>
                                <div class="image_slide_box_image_menu_image" onclick="slide_image(3)"> 사진 업로드</div>
                                <div class="image_slide_box_image_menu_delete" onclick="slide_delete(3)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }elseif($slide_type[2]=='2'){

                        $content_3 = $slide_content[2];
                        $content_split_3 = explode('?v=' , $content_3);
                        $youtube_thumbnail_3 = "http://img.youtube.com/vi/".$content_split_3[1]."/mqdefault.jpg";

                        ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_video"  src="<?php echo $youtube_thumbnail_3?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <img class="image_slide_box_video_youtube_icon"  src="/admin/image/youtube_logo.png">
                            <div class="image_slide_box_video_menu">
                                <div class="image_slide_box_video_menu_video" onclick="slide_video(3)" > 영상 업로드</div>
                                <div class="image_slide_box_video_menu_image" onclick="slide_image(3)"> 사진 업로드</div>
                                <div class="image_slide_box_video_menu_delete" onclick="slide_delete(3)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="image_slide_box">
                            <span class="image_slide_box_text" > + </span>
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_text_menu">
                                <div class="image_slide_box_text_menu_video" onclick="slide_video(3)" > 영상 업로드</div>
                                <div class="image_slide_box_text_menu_image" onclick="slide_image(3)"> 사진 업로드</div>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="main_contents_box_place_content_right_slide5_box" >
                    <?php if($slide_type[4]=='1'){ ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_image" src="<?php echo $slide_content[4];?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_image_menu">
                                <div class="image_slide_box_image_menu_video" onclick="slide_video(5)" > 영상 업로드</div>
                                <div class="image_slide_box_image_menu_image" onclick="slide_image(5)"> 사진 업로드</div>
                                <div class="image_slide_box_image_menu_delete" onclick="slide_delete(5)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }elseif($slide_type[4]=='2'){

                        $content_5 = $slide_content[4];
                        $content_split_5 = explode('?v=' , $content_5);
                        $youtube_thumbnail_5 = "http://img.youtube.com/vi/".$content_split_5[1]."/mqdefault.jpg";

                        ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_video" src="<?php echo $youtube_thumbnail_5?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <img class="image_slide_box_video_youtube_icon"  src="/admin/image/youtube_logo.png">
                            <div class="image_slide_box_video_menu">
                                <div class="image_slide_box_video_menu_video" onclick="slide_video(5)" > 영상 업로드</div>
                                <div class="image_slide_box_video_menu_image" onclick="slide_image(5)"> 사진 업로드</div>
                                <div class="image_slide_box_video_menu_delete" onclick="slide_delete(5)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="image_slide_box">
                            <span class="image_slide_box_text" > + </span>
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_text_menu">
                                <div class="image_slide_box_text_menu_video" onclick="slide_video(5)" > 영상 업로드</div>
                                <div class="image_slide_box_text_menu_image" onclick="slide_image(5)"> 사진 업로드</div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>

            <div class="main_contents_box_place_content_left">
                <div class="main_contents_box_place_content_left_slide2"><span style="margin-top:110px;margin-left: 30px; display: inline-block">슬라이드 2</span></div>
                <div class="main_contents_box_place_content_left_slide4"><span style="margin-top:110px;margin-left: 30px; display: inline-block">슬라이드 4</span></div>
            </div>


            <div id="main_contents_box_place_content_right">
                <div class="main_contents_box_place_content_right_slide2_box">
                    <?php if($slide_type[1]=='1'){ ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_image" src="<?php echo $slide_content[1];?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_image_menu">
                                <div class="image_slide_box_image_menu_video" onclick="slide_video(2)" > 영상 업로드</div>
                                <div class="image_slide_box_image_menu_image" onclick="slide_image(2)"> 사진 업로드</div>
                                <div class="image_slide_box_image_menu_delete" onclick="slide_delete(2)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }elseif($slide_type[1]=='2'){

                        $content_2 = $slide_content[1];
                        $content_split_2 = explode('?v=' , $content_2);
                        $youtube_thumbnail_2 = "http://img.youtube.com/vi/".$content_split_2[1]."/mqdefault.jpg";

                        ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_video" src="<?php echo $youtube_thumbnail_2?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <img class="image_slide_box_video_youtube_icon"  src="/admin/image/youtube_logo.png">
                            <div class="image_slide_box_video_menu">
                                <div class="image_slide_box_video_menu_video" onclick="slide_video(2)" > 영상 업로드</div>
                                <div class="image_slide_box_video_menu_image" onclick="slide_image(2)"> 사진 업로드</div>
                                <div class="image_slide_box_video_menu_delete" onclick="slide_delete(2)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="image_slide_box">
                            <span class="image_slide_box_text" > + </span>
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_text_menu">
                                <div class="image_slide_box_text_menu_video" onclick="slide_video(2)" > 영상 업로드</div>
                                <div class="image_slide_box_text_menu_image" onclick="slide_image(2)"> 사진 업로드</div>
                            </div>
                        </div>
                    <?php }?>

                </div>

                <div class="main_contents_box_place_content_right_slide4_box" >
                    <?php if($slide_type[3]=='1'){ ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_image" src="<?php echo $slide_content[3];?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_image_menu">
                                <div class="image_slide_box_image_menu_video" onclick="slide_video(4)" > 영상 업로드</div>
                                <div class="image_slide_box_image_menu_image" onclick="slide_image(4)"> 사진 업로드</div>
                                <div class="image_slide_box_image_menu_delete" onclick="slide_delete(4)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }elseif($slide_type[3]=='2'){


                        $content_4 = $slide_content[3];
                        $content_split_4 = explode('?v=' , $content_4);
                        $youtube_thumbnail_4 = "http://img.youtube.com/vi/".$content_split_4[1]."/mqdefault.jpg";


                        ?>
                        <div class="image_slide_box">
                            <img class="image_slide_box_video" src="<?php echo $youtube_thumbnail_4?>">
                        </div>
                        <div class="image_slide_box overlay">
                            <img class="image_slide_box_video_youtube_icon"  src="/admin/image/youtube_logo.png">
                            <div class="image_slide_box_video_menu">
                                <div class="image_slide_box_video_menu_video" onclick="slide_video(4)" > 영상 업로드</div>
                                <div class="image_slide_box_video_menu_image" onclick="slide_image(4)"> 사진 업로드</div>
                                <div class="image_slide_box_video_menu_delete" onclick="slide_delete(4)" > 컨텐츠 삭제</div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="image_slide_box">
                            <span class="image_slide_box_text" > + </span>
                        </div>
                        <div class="image_slide_box overlay">
                            <div class="image_slide_box_text_menu">
                                <div class="image_slide_box_text_menu_video" onclick="slide_video(4)" > 영상 업로드</div>
                                <div class="image_slide_box_text_menu_image" onclick="slide_image(4)"> 사진 업로드</div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>



            <div id="mymodal_video" class="modal_video">
                <div class="modal_video_content">
                    <div id="modal_video_content_head">
                        <span id="modal_video_content_head_span">유튜브 링크</span> <span class="close_video">&times;</span>
                    </div>
                    <div id='modal_video_content_right'>
                        <input id='modal_video_content_right_video' type="text" placeholder="영상링크를 입력해주세요">
                    </div>
                    <div id='modal_video_content_full'>
                        <div>
                            <span id='modal_video_content_info_text'>유튜브 링크 예시) https://www.youtube.com/watch?v=abcdef123</span>
                        </div>
                    </div>
                    <div id='modal_video_content_full'>
                        <div id='modal_video_content_full_send_button'  onclick="video_upload()">업로드</div>
                        <input id='video_upload_number' type="text" style="display: none;">
                        <div id='modal_video_content_full_cancel_button'  onclick="video_cancel()">취소</div>
                    </div>
                </div>
            </div>

            <div id="mymodal_image" class="modal_image">
                <form id="image_target" action="/admin/server/home_slide_server.php" method="post" enctype="multipart/form-data">
                <div class="modal_image_content">
                    <div id="modal_image_content_head">
                        <span id="modal_image_content_head_span">이미지 업로드</span> <span class="close_image">&times;</span>
                    </div>
                    <div id='modal_image_content_right'>
                        <input type="file" name="upfile" style="float: left">
                        <input type="text" name="type" value="image" style="display: none;">

                    </div>
                    <div id='modal_image_content_full'>
                        <div>
                            <span id='modal_image_content_info_text' >이미지 권장 픽셀) 가로-640px / 세로-360px</span>
                        </div>
                    </div>
                    <div id='modal_image_content_full'>
                        <input id='image_upload_number' type="text" name="number" style="display: none;">
                        <div id='modal_image_content_full_send_button'  onclick="image_upload()">업로드</div>
                        <div id='modal_image_content_full_cancel_button'  onclick="image_cancel()">취소</div>
                    </div>
                </div>
                </form>
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



    /* 영상 업로드 */

    function slide_video(slide_number) {
        modal_video.style.display = "block";
        document.getElementById("video_upload_number").value = slide_number;

    }
    var modal_video = document.getElementById("mymodal_video");
    var span_video = document.getElementsByClassName("close_video")[0];
    
    span_video.onclick = function() {
        modal_video.style.display = "none";
        window.location.reload();
    }
    function video_upload() {
        var modal_video_content_right_video= $("#modal_video_content_right_video").val();
        var slide_number= $("#video_upload_number").val();
        var youtube_string ='https://www.youtube.com/watch?v=';

        if(modal_video_content_right_video==''){
            alert('영상링크를 입력해주세요')
        }else if(modal_video_content_right_video.indexOf(youtube_string) == -1){
            alert('유튜르 링크 업로드 양식에 맞게 입력해주세요')
        } else{
            $.ajax({
                type: "POST"
                ,url: "/admin/server/home_slide_server.php"
                ,data: {number:slide_number, type:'video', content:modal_video_content_right_video}
                ,success:function(result){
                    if(result=='success'){
                        alert("홈 슬라이드가 변경되었습니다");
                        window.location.reload();
                    }else{
                        alert("홈 슬라이드 변경에 실패하였습니다. 다시한번 시도해주세요");
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });
        }
    }
    
    function video_cancel() {
        modal_video.style.display = "none";
        window.location.reload();
    }



    /* 이미지 업로드 */


    function slide_image(slide_number) {
        modal_image.style.display = "block";
        document.getElementById("image_upload_number").value = slide_number;
    }
    var modal_image = document.getElementById("mymodal_image");
    var span_image = document.getElementsByClassName("close_image")[0];

    span_image.onclick = function() {
        modal_image.style.display = "none";
        window.location.reload();
    }
    function image_upload() {
        $('#image_target').submit();
    }
    function image_cancel() {
        modal_image.style.display = "none";
        window.location.reload();
    }


    /* 컨텐츠 삭제 */

    function slide_delete(slide_number) {

        var result = confirm("정말로 삭제하시겠습니까?");
        if(result){
            $.ajax({
                type: "POST"
                ,url: "/admin/server/home_slide_server.php"
                ,data: {number:slide_number, type:''}
                ,success:function(result){
                    if(result=='success'){
                        alert("컨텐츠가 삭제되었습니다");
                        window.location.reload();
                    }else{
                        alert("홈 슬라이드 변경에 실패하였습니다. 다시한번 시도해주세요");
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
            var text = document.getElementById("layout_left_app_menu_home");
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