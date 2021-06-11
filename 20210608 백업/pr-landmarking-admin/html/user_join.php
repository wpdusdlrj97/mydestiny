<?php
//회원등록 페이지
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="description" content="랜드마킹 관리자 페이지입니다.">
    <meta name="keywords" content="랜드마킹, 토지중개, 토지분석">
    <meta name="author" content="랜드마킹">
    <meta property="og:type" content="website">
    <meta property="og:url" content="url">
    <meta property="og:image" content="/images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹 ADMIN">   
    <meta property="og:site_name" content="랜드마킹 ADMIN">   
    <meta property="og:description" content="랜드마킹 관리자 페이지"> 
    <meta property="og:locale" content="ko_KR"> 
    <title>관리자페이지</title>
    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/style.css" >

    <!-- SCRIPT -->
    <!--[if lte IE 9]>
    <script src="../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../js/lib/html5shiv.min.js"></script>    
    <script src="../js/lib/jqPIE.js"></script>    
    <script src="../js/lib/PIE.js"></script> 
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        /*input number 화살표 제거*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
</head>
<body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">일반 회원등록</h2>
                    <div class="contents">
                        <div class="form-wrap">
                            <form onsubmit="return false;">
                                <div class="wrap">
                                    <label for="userName">실명</label>
                                    <input type="text" id="join_name" minlength="2" maxlength="4" Placeholder="성명(실명)을 기입해주세요.">
                                </div>
                                <div class="wrap">
                                    <label for="userNick">닉네임</label>
                                    <input type="text" id="join_nickname" minlength="2" maxlength="6" Placeholder="사용하실 닉네임을 입력해주세요 (2~6자리)">
                                </div>
                                <div class="wrap">
                                    <label for="userId">ID<em class="inform">이메일주소</em></label>
                                    <input type="email" id="join_id" maxlength="50" placeholder="이메일 주소를 입력해주세요.">
                                    <button class="btn btn_check" onclick="email_overlap()">중복확인</button>
                                    <input type="text" id='join_id_overlap' value="0" style="display: none">
                                </div>
                                <div class="wrap">
                                    <label for="userTel">휴대전화</label>
                                    <input type="number" id="join_phone"  minlength="11" maxlength="11" placeholder="연락 가능한 휴대전화 번호 (-제외)를 입력해주세요. ">
                                </div>
                                <div class="wrap">
                                    <label for="userPwd">비밀번호</label>
                                    <input type="password" id="join_password" minlength="4" maxlength="16" placeholder="4~16자 비밀번호를 입력해주세요 (영문/숫자)">
                                </div>
                                <div class="wrap">
                                    <label for="userPwd">비밀번호 확인</label>
                                    <input type="password" id="join_password_check" minlength="4" maxlength="16" placeholder="4~16자 비밀번호를 입력해주세요 (영문/숫자)">
                                </div>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel">취소</button>
                                    <button type="button" class="btn btn_sm" onclick="user_join()">확인</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/script.js"></script>
    <script>
        $("#header").load("../html/_header.php");
    </script>
    <script>

        //이메일 중복확인 버튼 클릭 시 작동 스크립트
        function email_overlap(){

            var join_email = $("#join_id").val();
            var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;


            if(join_email==''){
                alert('이메일을 입력해주세요')
            }else if(reg_email.test(join_email)==false){
                alert('올바른 이메일을 입력해주세요')
            }else{
                $.ajax({
                    type: "POST"
                    ,url: "/admin_server/overlap_server.php"
                    ,data: {type:'user',email:join_email}
                    ,success:function(result){
                        if(result=='success'){
                            //document.getElementById("join_email_overlap").value = '1';
                            alert("사용가능한 이메일입니다");

                            document.getElementById("join_id_overlap").value = '1';

                        }else{
                            //document.getElementById("join_email_overlap").value = '0';
                            alert("해당 이메일로 가입된 계정이 존재합니다");
                            document.getElementById("join_id_overlap").value = '0';
                        }
                    }
                    ,error:function(){
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });
            }
        }


        //회원가입 버튼 클릭 시 작동 스크립트
        function user_join(){

            var join_name= $("#join_name").val();
            var join_nickname= $("#join_nickname").val();
            var join_id= $("#join_id").val();
            var join_phone= $("#join_phone").val();
            var join_password = $("#join_password").val();
            var join_password_check = $("#join_password_check").val();
            var join_id_overlap = $("#join_id_overlap").val();


            if(join_name==''){
                alert('이름을 입력해주세요');
            }else if(join_nickname==''){
                alert('닉네임을 입력해주세요');
            }else if(join_nickname.length<2 || join_nickname.length>6){
                alert('닉네임을 4~6자리로 입력해주세요')
            }else if(join_id==''){
                alert('아이디(이메일)를 입력해주세요');
            }else if(join_id_overlap=='0') {
                alert('아이디(이메일) 중복검사를 해주세요');
            }else if(join_phone==''){
                alert('전화번호를 입력해주세요');
            }else if(join_phone.length!=11){
                alert('휴대전화번호 11자리를 정확히 입력해주세요');
            }else if(join_password==''){
                alert('비밀번호를 입력해주세요');
            }else if(join_password_check==''){
                alert('비밀번호 확인을 입력해주세요');
            }else if(join_password.length<4 || join_password.length>16){
                alert('비밀번호를 영문,숫자 4~16자리로 입력해주세요')
            }else if(join_password!=join_password_check){
                alert('비밀번호가 일치하지 않습니다');
            }else{
                alert('성공');
                //$.ajax({
                //    type: "POST"
                //    ,url: "/server/join_server.php"
                //    ,data: {name:join_name,nickname:join_nickname,id:join_id,phone:join_phone,password:join_password}
                //    ,success:function(result){
                //        if(result=='success'){
                //            //location.href='<?php //echo $land_url."/html/account/sub_acc_join_c.php";?>//';
                //        }else if(result=='overlap'){
                //            alert("중복되는 이메일이 존재합니다");
                //        }else{
                //            alert("회원가입에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                //        }
                //    }
                //    ,error:function(){
                //        alert("잠시 후에 다시 시도해주세요");
                //    }
                //});
            }
        }
    </script>
</body>
</html>