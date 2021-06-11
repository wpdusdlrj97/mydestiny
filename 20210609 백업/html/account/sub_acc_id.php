<?php
//아이디 찾기 페이지
session_start();
$user_session = $_SESSION['user_session'];

//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url= $land_url."/html/index.php";

//세션이 있을 경우 메인 페이지 로드
if($user_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="토지 중개 플랫폼 랜드마킹입니다.">
    <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
    <meta name="author" content="랜드마킹">
    <meta property="og:type" content="website">
    <meta property="og:url" content="url">
    <meta property="og:image" content="../../images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹">
    <meta property="og:site_name" content="랜드마킹">
    <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
    <meta property="og:locale" content="ko_KR">
    <title>랜드마킹</title>
    <!-- FAVICON-->

    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../../css/default.css">
    <link rel="stylesheet" href="../../css/font.css">
    <link rel="stylesheet" href="../../css/common.css">
    <link rel="stylesheet" href="../../css/main.css" >

    <!-- SCRIPT -->
    <script src="../../js/lib/jquery-3.6.0.min.js"></script>
    <!--[if lte IE 9]>
    <script src="../../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../../js/lib/html5shiv.min.js"></script>
    <script src="../../js/lib/jqPIE.js"></script>
    <script src="../../js/lib/PIE.js"></script>
    <![endif]-->
    <style>
        /*input number 화살표 제거*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
</head>
<body>
<div id="find_id_popup" class="popup popup-acc">
    <div class="dim"></div>
    <div class="container">
        <div class="inner">
            <div class="box">
                <p class="tit">ID를 확인해주세요</p>
                <p class="txt bx-round_l" id="find_id_result"></p>
                <hr class="hr">
                <a href="#none" class="btn btn_accept bx-round_l bg_v" onclick="find_id_popup_close()">확인</a>
                <i class="btn btn_close" onclick="find_id_popup_close()"></i>
            </div>
        </div>
    </div>
</div>
<div id="popup"></div>
<div id="wrap" class="sub">
    <header id="header"></header>
    <main id="main">
        <div class="main-title">
            <div class="container">
                <div class="inner">
                    <div class="tit">
                        <i class="tit-icon icon_key bx-round_l"></i>
                        <h2 class="tit-wrap l-inline ft_b"><span class="tit on">ID(이메일주소) 찾기</span></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="inner">
                    <div class="signup acc_check">
                        <form onsubmit="return false;">
                            <div class="row row_tit clear">
                                <span class="join_tit">성명, 휴대전화 번호를 입력해 주세요.</span>
                            </div>
                            <div class="row clear">
                                <label for="checkName">성명<span class="details">실명가입</span></label>
                                <div class="bx-input"><input type="text" id="user_name" minlength="2" maxlength="4" Placeholder="성명(실명)을 기입해주세요."></div>
                            </div>
                            <div class="row row_hr clear">
                                <label for="checkEmail">휴대전화 번호</label>
                                <div class="bx-input"><input type="number" id="user_phone"  placeholder="연락가능한 휴대전화 번호 (-제외)를 입력해주세요."></div>
                            </div>
                            <button class="row btn btn_sm btn_pop bg_v bx-round_l" onclick="find_id()">아이디 찾기</button>
<!--                            <span class="row btn status bg_v bx-round_l">입력 정보가 잘못되었습니다.</span>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer id="footer"></footer>
</div>
<!-- script -->
<script src="/js/main.js"></script>
<!-- 팝업,헤더,푸터 삽입 스크립트 -->
<script>
    $("#header").load("/html/_header.php");
    $("#footer").load("/html/_footer.php");
    $("#popup").load("/html/_popup.php");
</script>
<!-- 아이디 찾기 버튼 클릭 시 팝업 노출 스크립트 -->
<script>
    function find_id() {

        var user_name= $("#user_name").val();
        var user_phone = $("#user_phone").val();

        if(user_name==''){
            alert('이름을 입력해주세요');
        }else if(user_phone==''){
            alert('전화번호를 입력해주세요');
        }else if(user_phone.length!=11){
            alert('전화번호를 11자리로 입력해주세요');
        }else{

            $.ajax({
                type: "POST"
                ,url: "/server/find_id_server.php"
                ,data: {name:user_name,phone:user_phone}
                ,success:function(result){
                    if(result=='fail'){
                        //해당 정보로 가입된 계정이 존재하지 않습니다 공지
                        $('#find_id_result').text("해당 정보로 가입된 계정이 존재하지 않습니다");
                        $('#find_id_popup').css('display', 'block');
                    }else{
                        //이메일 공지
                        $('#find_id_result').text(result);
                        $('#find_id_popup').css('display', 'block');
                    }
                }
                ,error:function(){
                    alert("잠시 후에 다시 시도해주세요");
                }
            });

        }
    }

    function find_id_popup_close(){
        $('#find_id_result').text("");
        $('#find_id_popup').css('display', 'none');
    }
</script>

</body>
</html>