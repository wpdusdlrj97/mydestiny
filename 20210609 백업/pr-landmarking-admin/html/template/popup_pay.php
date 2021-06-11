<!DOCTYPE html>
<html lang="en">
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
        <div class="popup popup-pay pay-form">
            <div class="container">
                <div class="inner">
                    <div class="form-wrap">
                        <form action="">
                            <fieldset>
                                <legend class="legend">상품 정보</legend>
                                <div class="wrap clear">
                                    <label for="pdName" class="l-fleft">상품명</label>
                                    <input type="text" name="pdName" id="pdName" class="l-fright" required value="상품명">
                                </div>
                                <div class="wrap">
                                    <label for="pdPrice" class="l-fleft">결제 금액</label>
                                    <input type="text" name="pdPrice" id="pdPrice" class="l-fright" required value="300,000원">
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="legend">상품 내용</legend>
                                <textarea name="text" id="" cols="30" rows="10" required>상품내용</textarea>
                            </fieldset>
                            <div class="btn-wrap">
                                <button type="button" class="btn btn_cancel" onClick="javascript:window.close()">취소</button>
                                <button type="button" class="btn btn_sm">수정</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>

