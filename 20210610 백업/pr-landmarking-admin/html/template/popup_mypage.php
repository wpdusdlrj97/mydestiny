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
    <link rel="stylesheet" href="../../css/default.css">
    <link rel="stylesheet" href="../../css/font.css">
    <link rel="stylesheet" href="../../css/style.css" >
</head>
<body>
    <div id="wrapper">
        <div class="popup popup-mypage">
            <div class="container">
                <div class="inner">
                    <div class="title">회원 정보 수정</div>
                    <div class="form-wrap">
                        <form action="">
                            <div class="wrap">
                                <input type="email" id="userEmail" name="userEmail" required placeholder="이메일">
                                <label for="userEamil">이메일을 입력해 주세요</label>
                            </div>
                            <div class="wrap">
                                <input type="text" id="userPwd" name="userPwd" required minlength="4" maxlength="16" placeholder="현재 비빌번호">                                
                                <label for="userPwd">문자와 숫자포함 4~16자 비밀번호를 입력해 주세요</label>
                            </div>
                            <div class="wrap">
                                <input type="password" id="newPwd"  name="newPwd" required minlength="4" maxlength="16" placeholder="새 비빌번호">
                                <label for="newPwd">문자와 숫자포함 4~16자 비밀번호를 입력해 주세요</label>
                            </div>
                            <div class="wrap">
                                <input type="password" id="pwdCheck" name="pwdCheck" required minlength="4" maxlength="16" placeholder="새 비빌번호 확인">
                                <label for="pwdCheck">한 번 더 비밀번호를 입력해 주세요</label>
                            </div>
                            <div class="btn-wrap">
                                <button type="button" class="btn btn_cancel" onClick="javascript:window.close()">취소</button>
                                <button type="button" class="btn btn_sm">수정완료</button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>

