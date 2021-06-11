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
        <header id="header"> </header>
        <main id="main" class="rg-form">
            <div class="container">
                <div class="inner">
                    <h2 class="title">토지등록</h2>
                    <div class="contents">
                        <div class="search-wrap form-wrap">
                            <form>
                                <fieldset>
                                    <div class="wrap claer">
                                        <label for="addr">직접 입력하기</label>
                                        <input type="text" class="input" name="addr" id="addr" placeholder="도로명 또는 지번 주소를 입력해 보세요.">
                                        <button class="btn btn_sm l-fright">열람</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="form-wrap wide">
                            <form>
                                <fieldset>
                                    <legend class="legend">등록 정보</legend>
                                    <div class="wrap">
                                        <label for="userId">아이디</label>
                                        <input type="text" name="userId" id="userId" required>
                                    </div>
                                    <div class="wrap">
                                        <label for="userName">성명</label>
                                        <input type="text" name="userName" id="userName">
                                    </div>
                                    <div class="wrap">
                                        <label for="userTel">전화번호</label>
                                        <input type="tel" name="userTel" id="userTel">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 정보</legend>
                                    <div class="wrap">
                                        <label for="landTitle">제목</label>
                                        <input type="text" id="landTitle" name="landTitle" required placeholder="50자까지만 입력 가능합니다." maxlength="50">
                                    </div>
                                    <div class="wrap">
                                        <label for="landSize">면적</label>
                                        <input class="has-unit" type="text" id="landSize" name="landSize" required placeholder="m2단위로 입력해 주세요">
                                        <i class="unit">m<sup>2</sup></i>
                                    </div>
                                    <div class="wrap">
                                        <label for="landAddr">주소</label>
                                        <input type="text" id="landAddr" name="landAddr" required placeholder="입력필수">
                                    </div>
                                    <div class="wrap">
                                        <label for="landPrice">가격</label>
                                        <input class="has-unit" type="text" id="landPrice" name="landPrice" required placeholder="원 단위로 입력해 주세요">
                                        <i class="unit">원</i>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 내용</legend>
                                    <textarea name="text" cols="50" rows="10" required></textarea>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">대표 이미지</legend>
                                    <label class="btn_file" for="thumbnail">파일 올리기</label>
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                                    <div class="uploaded">
                                        <!-- <div class="wrap">
                                            <span class="tit">대표이미지</span>
                                            <span class="file">파일이름.png</span>
                                            <button class="btn btn_del"></button>
                                        </div> -->
                                    </div>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">참고 이미지</legend>
                                    <label class="btn_file" for="imgs">파일 올리기</label>
                                    <input type="file" name="imgs" id="imgs" accept="image/*" multiple="multiple">
                                    <div class="uploaded">
                                        <!-- <div class="wrap">
                                            <span class="tit">참고이미지</span>
                                            <span class="file">파일이름.png</span>
                                            <button class="btn btn_del"></button>
                                        </div> -->
                                    </div>
                                </fieldset>
                                <fieldset class="is-master clear">
                                    <legend class="legend">마스터 추천 하기</legend>
                                    <input type="checkbox" name="master" id="master" class="l-fleft" value="master">
                                    <label for="master" class="l-fright">
                                        마스터 추천하기 체크시 메인 페이지와 마스터 추천 매물 패이지의 목록에 노출되며<br>매물 이미지 상단에 마스터 추천 태그가 추가됩니다.
                                    </label>
                                </fieldset>
                                <fieldset class="has-checks">
                                    <legend class="legend">가치 분석 / 개발축 분석</legend>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">개발가능성</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis01" value="1">1
                                            <input class="check" type="radio" name="analysis01" value="2">2
                                            <input class="check" type="radio" name="analysis01" value="3">3
                                            <input class="check" type="radio" name="analysis01" value="4">4
                                            <input class="check" type="radio" name="analysis01" value="5">5
                                            <input class="check" type="radio" name="analysis01" value="6">6
                                            <input class="check" type="radio" name="analysis01" value="7">7
                                            <input class="check" type="radio" name="analysis01" value="8">8
                                            <input class="check" type="radio" name="analysis01" value="9">9
                                            <input class="check" type="radio" name="analysis01" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">도로유무</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis02" value="1">1
                                            <input class="check" type="radio" name="analysis02" value="2">2
                                            <input class="check" type="radio" name="analysis02" value="3">3
                                            <input class="check" type="radio" name="analysis02" value="4">4
                                            <input class="check" type="radio" name="analysis02" value="5">5
                                            <input class="check" type="radio" name="analysis02" value="6">6
                                            <input class="check" type="radio" name="analysis02" value="7">7
                                            <input class="check" type="radio" name="analysis02" value="8">8
                                            <input class="check" type="radio" name="analysis02" value="9">9
                                            <input class="check" type="radio" name="analysis02" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clera">
                                        <label class="label l-fleft">경사완만</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis03" value="1">1
                                            <input class="check" type="radio" name="analysis03" value="2">2
                                            <input class="check" type="radio" name="analysis03" value="3">3
                                            <input class="check" type="radio" name="analysis03" value="4">4
                                            <input class="check" type="radio" name="analysis03" value="5">5
                                            <input class="check" type="radio" name="analysis03" value="6">6
                                            <input class="check" type="radio" name="analysis03" value="7">7
                                            <input class="check" type="radio" name="analysis03" value="8">8
                                            <input class="check" type="radio" name="analysis03" value="9">9
                                            <input class="check" type="radio" name="analysis03" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">개발호재</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis04" value="1">1
                                            <input class="check" type="radio" name="analysis04" value="2">2
                                            <input class="check" type="radio" name="analysis04" value="3">3
                                            <input class="check" type="radio" name="analysis04" value="4">4
                                            <input class="check" type="radio" name="analysis04" value="5">5
                                            <input class="check" type="radio" name="analysis04" value="6">6
                                            <input class="check" type="radio" name="analysis04" value="7">7
                                            <input class="check" type="radio" name="analysis04" value="8">8
                                            <input class="check" type="radio" name="analysis04" value="9">9
                                            <input class="check" type="radio" name="analysis04" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">인구유입률</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis05" value="1">1
                                            <input class="check" type="radio" name="analysis05" value="2">2
                                            <input class="check" type="radio" name="analysis05" value="3">3
                                            <input class="check" type="radio" name="analysis05" value="4">4
                                            <input class="check" type="radio" name="analysis05" value="5">5
                                            <input class="check" type="radio" name="analysis05" value="6">6
                                            <input class="check" type="radio" name="analysis05" value="7">7
                                            <input class="check" type="radio" name="analysis05" value="8">8
                                            <input class="check" type="radio" name="analysis05" value="9"> 9
                                            <input class="check" type="radio" name="analysis05" value="10">10
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="has-checks">
                                    <legend class="legend no-letter"></legend>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">개발축 기간</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis06" value="1">1
                                            <input class="check" type="radio" name="analysis06" value="2">2
                                            <input class="check" type="radio" name="analysis06" value="3">3
                                            <input class="check" type="radio" name="analysis06" value="4">4
                                            <input class="check" type="radio" name="analysis06" value="5">5
                                            <input class="check" type="radio" name="analysis06" value="6">6
                                            <input class="check" type="radio" name="analysis06" value="7">7
                                            <input class="check" type="radio" name="analysis06" value="8">8
                                            <input class="check" type="radio" name="analysis06" value="9">9
                                            <input class="check" type="radio" name="analysis06" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label has-space l-fleft">수익</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis07" value="1">1
                                            <input class="check" type="radio" name="analysis07" value="2">2
                                            <input class="check" type="radio" name="analysis07" value="3">3
                                            <input class="check" type="radio" name="analysis07" value="4">4
                                            <input class="check" type="radio" name="analysis07" value="5">5
                                            <input class="check" type="radio" name="analysis07" value="6">6
                                            <input class="check" type="radio" name="analysis07" value="7">7
                                            <input class="check" type="radio" name="analysis07" value="8">8
                                            <input class="check" type="radio" name="analysis07" value="9">9
                                            <input class="check" type="radio" name="analysis07" value="10">10
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="has-checks">
                                    <legend class="legend no-letter"></legend>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">보조축 기간</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis08" value="1">1
                                            <input class="check" type="radio" name="analysis08" value="2">2
                                            <input class="check" type="radio" name="analysis08" value="3">3
                                            <input class="check" type="radio" name="analysis08" value="4">4
                                            <input class="check" type="radio" name="analysis08" value="5">5
                                            <input class="check" type="radio" name="analysis08" value="6">6
                                            <input class="check" type="radio" name="analysis08" value="7">7
                                            <input class="check" type="radio" name="analysis08" value="8">8
                                            <input class="check" type="radio" name="analysis08" value="9">9
                                            <input class="check" type="radio" name="analysis08" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label has-space l-fleft">수익</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis09" value="1">1
                                            <input class="check" type="radio" name="analysis09" value="2">2
                                            <input class="check" type="radio" name="analysis09" value="3">3
                                            <input class="check" type="radio" name="analysis09" value="4">4
                                            <input class="check" type="radio" name="analysis09" value="5">5
                                            <input class="check" type="radio" name="analysis09" value="6">6
                                            <input class="check" type="radio" name="analysis09" value="7">7
                                            <input class="check" type="radio" name="analysis09" value="8">8
                                            <input class="check" type="radio" name="analysis09" value="9">9
                                            <input class="check" type="radio" name="analysis09" value="10">10
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="has-checks">
                                    <legend class="legend no-letter"></legend>
                                    <div class="wrap clear">
                                        <label class="label l-fleft">보전축 기간</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis10" value="1">1
                                            <input class="check" type="radio" name="analysis10" value="2">2
                                            <input class="check" type="radio" name="analysis10" value="3">3
                                            <input class="check" type="radio" name="analysis10" value="4">4
                                            <input class="check" type="radio" name="analysis10" value="5">5
                                            <input class="check" type="radio" name="analysis10" value="6">6
                                            <input class="check" type="radio" name="analysis10" value="7">7
                                            <input class="check" type="radio" name="analysis10" value="8">8
                                            <input class="check" type="radio" name="analysis10" value="9">9
                                            <input class="check" type="radio" name="analysis10" value="10">10
                                        </div>
                                    </div>
                                    <div class="wrap clear">
                                        <label class="label has-space l-fleft">수익</label>
                                        <div class="check-wrap l-fright">
                                            <input class="check" type="radio" name="analysis11" value="1">1
                                            <input class="check" type="radio" name="analysis11" value="2">2
                                            <input class="check" type="radio" name="analysis11" value="3">3
                                            <input class="check" type="radio" name="analysis11" value="4">4
                                            <input class="check" type="radio" name="analysis11" value="5">5
                                            <input class="check" type="radio" name="analysis11" value="6">6
                                            <input class="check" type="radio" name="analysis11" value="7">7
                                            <input class="check" type="radio" name="analysis11" value="8">8
                                            <input class="check" type="radio" name="analysis11" value="9">9
                                            <input class="check" type="radio" name="analysis11" value="10">10
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel">취소</button>
                                    <button type="button" class="btn btn_sm">등록하기</button>
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