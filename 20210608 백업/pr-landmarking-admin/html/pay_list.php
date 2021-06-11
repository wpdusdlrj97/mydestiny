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
                    <h2 class="title">결제상품 리스트</h2>
                    <div class="contents has-pg clear">
                        <div class="search-area">
                            <form>
                                <span class="label">검색어</span>
                                <fieldset class="select-box">
                                    <input type="text" class="select" value="" onfocus="this.blur();" readonly placeholder="검색어">
                                    <div class="options">
                                        <span class="option" data-option="모두보기">모두보기</span>
                                        <span class="option" data-option="결제상품명">결제상품명</span>
                                        <span class="option" data-option="결제금액">결제금액</span>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <input type="text" name="keywords" class="input" placeholder="검색어를 입력해주세요">
                                </fieldset>
                                <button class="btn btn_sm" type="submit">검색</button>
                            </form>
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
                                        <th class="th t-name">결제상품명</th>
                                        <th class="th t-price">결제금액</th>
                                        <th class="th t-date">등록일</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <tr class="tr has-link"  onClick="window.open('../html/template/popup_pay.php','pop','width=768, height=596, top=200, left=200');">
                                        <td class="td t-num"><span class="value">5</span></td>
                                        <td class="td t-name"><span class="value">전문분석+방문분석</span></td>
                                        <td class="td t-price"><span class="value">200,000</span>원</td>
                                        <td class="td t-date"><span class="value">2021.01.01.<br>00:00</span></td>
                                    </tr>
                                    <tr class="tr has-link"  onClick="window.open('../html/template/popup_pay.php','pop','width=768, height=596, top=200, left=200');">
                                        <td class="td t-num"><span class="value">4</span></td>
                                        <td class="td t-name"><span class="value">전문분석+전화분석</span></td>
                                        <td class="td t-price"><span class="value">30,000</span>원</td>
                                        <td class="td t-date"><span class="value">2021.01.01.<br>00:00</span></td>
                                    </tr>
                                    <tr class="tr has-link"  onClick="window.open('../html/template/popup_pay.php','pop','width=768, height=596, top=200, left=200');">
                                        <td class="td t-num"><span class="value">3</span></td>
                                        <td class="td t-name"><span class="value">등록대행+방문분석</span></td>
                                        <td class="td t-price"><span class="value">320,000</span>원</td>
                                        <td class="td t-date"><span class="value">2021.01.01.<br>00:00</span></td>
                                    </tr>
                                    <tr class="tr has-link"  onClick="window.open('../html/template/popup_pay.php','pop','width=768, height=596, top=200, left=200');">
                                        <td class="td t-num"><span class="value">2</span></td>
                                        <td class="td t-name"><span class="value">등록대행+전화분석</span></td>
                                        <td class="td t-price"><span class="value">160,000</span>원</td>
                                        <td class="td t-date"><span class="value">2021.01.01.<br>00:00</span></td>
                                    </tr>
                                    <tr class="tr has-link"  onClick="window.open('../html/template/popup_pay.php','pop','width=768, height=596, top=200, left=200');">
                                        <td class="td t-num"><span class="value">1</span></td>
                                        <td class="td t-name"><span class="value">등록대행</span></td>
                                        <td class="td t-price"><span class="value">150,000</span>원</td>
                                        <td class="td t-date"><span class="value">2021.01.01.<br>00:00</span></td>
                                    </tr>
                                </tbody>
                            </table>
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