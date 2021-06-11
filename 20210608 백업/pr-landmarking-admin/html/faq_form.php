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
        <main id="main" class="faq-form form">
            <div class="container">
                <div class="inner">
                    <h2 class="title">문의 내역</h2>
                    <div class="contents">
                        <div class="form-wrap wide clear">
                            <div class="thumbnail">
                                <img class="img img_f l-fleft" src="../upload/faq_sample.png" alt="문의사항">
                                <span class="txt l-fright">
                                    <em class="tit">서울 마포구 땅 의뢰합니다.</em>
                                    <em class="date bar">등록일<i class="value">2021.01.01 00:00</i></em>
                                </span>
                            </div>
                            <form>
                                <fieldset>
                                    <legend class="legend">본문 내용</legend>
                                    <textarea name="quest" cols="30" rows="10" required></textarea>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">답변 내용</legend>
                                    <label class="btn tag">랜드마킹 답변</label>
                                    <textarea class="has-tag" name="answer" cols="30" rows="10" required ></textarea>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">참고 파일</legend>
                                    <label class="btn_file" for="imgs">파일 올리기</label>
                                    <input type="file" name="files" id="imgs">
                                    <div class="uploaded">
                                        <!-- <div class="wrap">
                                            <span class="tit">참고이미지</span>
                                            <span class="file">파일이름.png</span>
                                            <button class="btn btn_del"></button>
                                        </div> -->
                                    </div>
                                </fieldset>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel">취소</button>
                                    <button type="button" class="btn btn_sm">등록</button>
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