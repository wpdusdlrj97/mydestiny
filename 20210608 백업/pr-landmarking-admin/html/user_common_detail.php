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
</head>
<body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">일반회원 상세페이지</h2>
                    <div class="contents">
                        <div class="form-wrap">
                            <form>
                                <div class="wrap">
                                    <label for="userNum">회원번호</label>
                                    <input type="text" name="userNum" id="userNum" required placeholder="입력필수">
                                </div>
                                <div class="wrap">
                                    <label for="userId">아이디<em class="inform">이메일주소</em></label>
                                    <input type="email" name="userId" id="userId" required placeholder="입력필수">
                                    <button class="btn btn_check">중복확인</button>
                                </div>
                                <div class="wrap">
                                    <label for="userPwd">비밀번호</label>
                                    <input type="password" name="userPwd" id="userPwd" required placeholder="입력필수">                                
                                </div>
                                <div class="wrap">
                                    <label for="userNick">닉네임</label>
                                    <input type="text" name="userNick" id="userNick" required placeholder="입력필수">
                                    <button class="btn btn_check">중복확인</button>
                                </div>
                                <div class="wrap">
                                    <label for="userName">실명</label>
                                    <input type="text" name="userName" id="userName" required placeholder="입력필수">
                                </div>
                                <div class="wrap">
                                    <label for="userTel">휴대전화</label>
                                    <input type="tel" class="userTel" id="userTel" required placeholder="입력필수">
                                </div>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_del btn_modal" data-modal="delete">삭제</button>
                                    <button type="button" class="btn btn_cancel">취소</button>
                                    <button type="button" class="btn btn_sm">확인</button>
                                    <div class="modal" data-modal="delete">
                                        <div class="wrap">
                                            <span class="txt">삭제하시겠습니까?</span>
                                            <button class="btn btn_cancel">취소</button>
                                            <button class="btn btn_confirm">확인</button>
                                        </div>
                                    </div>
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
</body>
</html>