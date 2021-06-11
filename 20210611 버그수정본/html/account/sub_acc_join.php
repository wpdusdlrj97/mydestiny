<?php
//회원가입 페이지
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
<div id="popup"></div>
    <div id="wrap" class="sub sub-join">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inline ft_b"><span class="tit on">회원가입</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="signup">
                            <form onsubmit="return false;">
                                <div class="row row_tit clear">
                                    <span class="join_tit">회원가입을 해 주세요.</span>
                                    <span class="join_info">계정이 있나요?<a href="/html/account/sub_acc_login.php">로그인</a></span>
                                </div>
                                <div class="row clear">
                                    <label for="joinName">성명<span class="details">실명가입</span></label>
                                    <div class="bx-input"><input type="text" id="user_name" minlength="2" maxlength="4" Placeholder="성명(실명)을 기입해주세요."></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinName">닉네임</label>
                                    <div class="bx-input"><input type="text" id="user_nickname" minlength="2" maxlength="6" Placeholder="사용하실 닉네임을 입력해주세요 (2~6자리)"></div>
                                </div>
                                <div class="row clear">
                                    <label for="joinId">ID<span class="details">이메일주소</span></label>
                                    <button type="button" class="btn btn_mcheck bx-round_l bg_v" onclick="email_overlap()">중복확인</button>
                                    <div class="bx-input email"><input type="email" id="user_id" maxlength="50" placeholder="이메일 주소를 입력해주세요."></div>
                                    <input type="text" id='user_id_overlap' value="0" style="display: none">
                                </div>
                                <div class="row clear">
                                    <label for="joinTel">휴대전화 번호</label>
                                    <div class="bx-input"><input type="number" id="user_phone"  minlength="11" maxlength="11" placeholder="연락 가능한 휴대전화 번호 (-제외)를 입력해주세요. "></div>
                                </div>
                                <div class="row clear">
                                    <label for="userpwd">비밀번호</label>
                                    <div class="bx-input">
                                        <input type="password" id="user_password" minlength="4" maxlength="16" placeholder="4~16자 비밀번호를 입력해주세요 (영문/숫자)">
                                    </div>
                                </div>
                                <div class="row row_pwd row_hr clear">
                                    <label for="userpwd">비밀번호 확인</label>
                                    <div class="bx-input">
                                        <input type="password" id="user_password_check" minlength="4" maxlength="16" placeholder="4~16자 비밀번호를 입력해주세요 (영문/숫자)">
                                    </div>
                                </div>
                                <div class="row row_check clear">
                                    <label class="checkbox" for="check"></label>
                                    <input type="checkbox" id='user_agree'  value="0">
                                    <span class="txt"><a href="/html/sub_term.php">이용약관</a>과 <a href="/html/sub_privacy.php">개인정보처리방침</a>에 동의합니다.</span>
                                </div>
                                <button class="row btn bg_v bx-round_l" onclick="join()">등록</button>
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
    <script>
        //이메일 중복확인 버튼 클릭 시 작동 스크립트
        function email_overlap(){

            //이메일 중복확인 버튼 클릭
            var $mailCheckBtn = $('.sub-join .btn_mcheck');

            var user_email = $("#user_id").val();
            var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;


            if(user_email==''){
                alert('이메일을 입력해주세요')
            }else if(reg_email.test(user_email)==false){
                alert('올바른 이메일을 입력해주세요')
            }else{
                $.ajax({
                    type: "POST"
                    ,url: "/server/overlap_server.php"
                    ,data: {email:user_email}
                    ,success:function(result){
                        if(result=='success'){
                            //document.getElementById("user_email_overlap").value = '1';
                            alert("사용가능한 이메일입니다");

                            //버튼 체크 버튼 주기
                            event.preventDefault();
                            if(!$mailCheckBtn.hasClass('loading')) $mailCheckBtn.addClass('loading');
                            setTimeout(function(){
                                $mailCheckBtn.removeClass('loading');
                                $mailCheckBtn.addClass('loaded');
                            },500);
                            event.preventDefault();
                            if($(this).parent().prev().hasClass('loaded')) $mailCheckBtn.removeClass('loaded');

                            //
                            document.getElementById("user_id_overlap").value = '1';

                        }else{
                            //document.getElementById("user_email_overlap").value = '0';
                            alert("해당 이메일로 가입된 계정이 존재합니다");
                            document.getElementById("user_id_overlap").value = '0';
                        }
                    }
                    ,error:function(){
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });
            }
        }



        /* ====== [계정] 회원가입 : 약관 동의 ====== */
        function acceptTermsFn(){

            var $jCheckBox = $('.signup .checkbox'),
                $jCheckValue = $jCheckBox.next();

            $jCheckBox.on('click', function(event){
                event.preventDefault();
                if(!$jCheckBox.hasClass('checked')){
                    $jCheckValue.attr('value', 'yes');
                    $jCheckBox.addClass('checked');
                    alert('약관에 동의하셨습니다');
                    document.getElementById("user_agree").value = '1';
                }else{
                    $jCheckValue.attr('value', '');
                    $jCheckBox.removeClass('checked');
                    document.getElementById("user_agree").value = '0';
                };
            })

        }acceptTermsFn();


        //회원가입 버튼 클릭 시 작동 스크립트
        function join(){

            var user_name= $("#user_name").val();
            var user_nickname= $("#user_nickname").val();
            var user_id= $("#user_id").val();
            var user_phone= $("#user_phone").val();
            var user_password = $("#user_password").val();
            var user_password_check = $("#user_password_check").val();
            var user_id_overlap = $("#user_id_overlap").val();
            var user_agree = $("#user_agree").val();

            if(user_name==''){
                alert('이름을 입력해주세요');
            }else if(user_nickname==''){
                alert('닉네임을 입력해주세요');
            }else if(user_nickname.length<2 || user_nickname.length>6){
                alert('닉네임을 4~6자리로 입력해주세요')
            }else if(user_id==''){
                alert('아이디(이메일)를 입력해주세요');
            }else if(user_id_overlap=='0') {
                alert('아이디(이메일) 중복검사를 해주세요');
            }else if(user_phone==''){
                alert('전화번호를 입력해주세요');
            }else if(user_phone.length!=11){
                alert('휴대전화번호 11자리를 정확히 입력해주세요');
            }else if(user_password==''){
                alert('비밀번호를 입력해주세요');
            }else if(user_password_check==''){
                alert('비밀번호 확인을 입력해주세요');
            }else if(user_password.length<4 || user_password.length>16){
                alert('비밀번호를 영문,숫자 4~16자리로 입력해주세요')
            }else if(user_password!=user_password_check){
                alert('비밀번호가 일치하지 않습니다');
            }else if(user_agree=='0') {
                alert('약관에 동의해주세요');
            }else{
                $.ajax({
                    type: "POST"
                    ,url: "/server/join_server.php"
                    ,data: {name:user_name,nickname:user_nickname,id:user_id,phone:user_phone,password:user_password}
                    ,success:function(result){
                        if(result=='success'){
                            location.href='<?php echo $land_url."/html/account/sub_acc_join_c.php";?>';
                        }else if(result=='overlap'){
                            alert("중복되는 이메일이 존재합니다");
                        }else{
                            alert("회원가입에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    }
                    ,error:function(){
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });
            }
        }

    </script>
</body>
</html>