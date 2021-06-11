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
    <div class="modal" data-modal="delete">
        <div class="wrap">
            <span class="txt">삭제하시겠습니까?</span>
            <button class="btn btn_cancel">취소</button>
            <button class="btn btn_confirm">확인</button>
        </div>
    </div>
    <div id="wrap">
        <header id="header"></header>
        <main id="main">
            <div class="container">
                <div class="inner">
                    <h2 class="title">일반회원</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form>
                                <fieldset class="select-box is-id">
                                    <input type="text" class="select" value="아이디" onfocus="this.blur();" readonly/>
                                    <div class="options">
                                        <span class="option is-selected" data-option="아이디">아이디</span>
                                        <span class="option" data-option="실명">실명</span>
                                        <span class="option" data-option="전화번호">전화번호</span>
                                    </div>
                                </fieldset>
                                <input type="text" name="id" class="input keywords" placeholder="검색어를 입력해주세요">
                                <button type="submit" class="btn btn_sm">검색</button>
                            </form>
                            <a href="../html/user_join.php" class="btn btn_join">회원등록</a>
                        </div>
                        <div class="check-area l-fleft">
                            <form>
                                <div class="check-wrap"><input type="checkbox" class="check-all"></div>
                                <div class="check-wrap"><input type="checkbox" class="check"></div>
                                <div class="check-wrap"><input type="checkbox" class="check"></div>
                                <div class="check-wrap"><input type="checkbox" class="check"></div>
                                <div class="check-wrap"><input type="checkbox" class="check"></div>
                                <div class="check-wrap"><input type="checkbox" class="check"></div>
                                <button type="submit" class="btn btn_del btn_modal" data-modal="delete">삭제</button>
                            </form>
                        </div>
                        <div class="table-area l-fright">
                            <table class="table">
                                <thead class="thead">
                                    <tr class= "tr">
                                        <th class="th t-num">번호</th>
                                        <th class="th t-id">아이디</th>
                                        <th class="th t-name">실명</th>
                                        <th class="th t-tel">휴대폰</th>
                                        <th class="th t-date t-date_latest">최종접속일</th>
                                        <th class="th t-date t-date_join">가입일</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <tr class="tr has-link" onClick="location.href='../html/user_common_detail.php'">
                                        <td class="td t-num"><span class="value">5</span></td>
                                        <td class="td t-id"><span class="value">sonsky77@naver.com</span></td>
                                        <td class="td t-name"><span class="value">손종현</span></td>
                                        <td class="td t-tel"><span class="value">000-0000-0000</span></td>
                                        <td class="td t-date t-date_latest"><span class="value">2021.01.01</span></td>
                                        <td class="td t-date t-date_join"><span class="value">2021.01.01</span></td>
                                    </tr>
                                    <tr class="tr has-link" onClick="location.href='../html/user_common_detail.php'">
                                        <td class="td t-num"><span class="value">4</span></td>
                                        <td class="td t-id"><span class="value">sonsky77@naver.com</span></td>
                                        <td class="td t-name"><span class="value">손종현</span></td>
                                        <td class="td t-tel"><span class="value">000-0000-0000</span></td>
                                        <td class="td t-date t-date_latest"><span class="value">2021.01.01</span></td>
                                        <td class="td t-date t-date_join"><span class="value">2021.01.01</span></td>
                                    </tr>
                                    <tr class="tr has-link" onClick="location.href='../html/user_common_detail.php'">
                                        <td class="td t-num"><span class="value">3</span></td>
                                        <td class="td t-id"><span class="value">sonsky77@naver.com</span></td>
                                        <td class="td t-name"><span class="value">손종현</span></td>
                                        <td class="td t-tel"><span class="value">000-0000-0000</span></td>
                                        <td class="td t-date t-date_latest"><span class="value">2021.01.01</span></td>
                                        <td class="td t-date t-date_join"><span class="value">2021.01.01</span></td>
                                    </tr>
                                    <tr class="tr has-link" onClick="location.href='../html/user_common_detail.php'">
                                        <td class="td t-num"><span class="value">2</span></td>
                                        <td class="td t-id"><span class="value">sonsky77@naver.com</span></td>
                                        <td class="td t-name"><span class="value">손종현</span></td>
                                        <td class="td t-tel"><span class="value">000-0000-0000</span></td>
                                        <td class="td t-date t-date_latest"><span class="value">2021.01.01</span></td>
                                        <td class="td t-date t-date_join"><span class="value">2021.01.01</span></td>
                                    </tr>
                                    <tr class="tr has-link" onClick="location.href='../html/user_common_detail.php'">
                                        <td class="td t-num"><span class="value">1</span></td>
                                        <td class="td t-id"><span class="value">sonsky77@naver.com</span></td>
                                        <td class="td t-name"><span class="value">손종현</span></td>
                                        <td class="td t-tel"><span class="value">000-0000-0000</span></td>
                                        <td class="td t-date t-date_latest"><span class="value">2021.01.01</span></td>
                                        <td class="td t-date t-date_join"><span class="value">2021.01.01</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagenation">
                        <div class="wrap">
                            <button class="btn btn_prev"></button>
                            <a href="#none" class="num on">1</a>
                            <a href="#none" class="num">2</a>
                            <a href="#none" class="num">3</a>
                            <a href="#none" class="num">4</a>
                            <a href="#none" class="num">5</a>
                            <a href="#none" class="num">...</a>
                            <button class="btn btn_next"></button>
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