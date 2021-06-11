<?php
//개인정보 변경
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";


$qry_string_admin = "SELECT * FROM admin_information where admin_email='$admin_id'";
$qry_admin = mysqli_query($connect, $qry_string_admin);
$row_admin = mysqli_fetch_array($qry_admin);
$total_row_admin = mysqli_num_rows($qry_admin);
//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}else {



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
    <!--네이버 지도 API 이용-->
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=egcozauon9&submodules=geocoder"></script>
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
        <header id="header"> </header>
        <main id="main" class="rg-form">
            <div class="container">
                <div class="inner">
                    <h2 class="title">토지등록</h2>
                    <div class="contents">
                        <div class="search-wrap form-wrap">
                            <form onsubmit="return false;">
                                <fieldset>
                                    <div class="wrap claer">
                                        <label for="addr">직접 입력하기</label>
                                        <input type="text" class="input" id="rg_addr" placeholder="도로명 또는 지번 주소를 입력해 보세요.">
                                        <button class="btn btn_sm l-fright" onclick="rg_search()">열람</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="form-wrap wide">
                            <form onsubmit="return false;">
                                <fieldset>
                                    <legend class="legend">등록 정보</legend>
                                    <div class="wrap">
                                        <label for="userId">아이디</label>
                                        <input type="text" id="land_register_email" required>
                                    </div>
                                    <div class="wrap">
                                        <label for="userName">성명</label>
                                        <input type="text" id="land_register_name">
                                    </div>
                                    <div class="wrap">
                                        <label for="userTel">전화번호</label>
                                        <input type="tel" id="land_register_phone">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 정보</legend>
                                    <div class="wrap">
                                        <label for="landTitle">제목</label>
                                        <input type="text" id="land_register_email" placeholder="50자까지만 입력 가능합니다." maxlength="50">
                                    </div>
                                    <div class="wrap">
                                        <label for="landSize">면적</label>
                                        <input class="has-unit" type="number" id="land_register_area" placeholder="m2단위로 입력해 주세요">
                                        <i class="unit">m<sup>2</sup></i>
                                    </div>
                                    <div class="wrap">
                                        <label for="landAddr">주소</label>
                                        <input type="text" id="land_address" placeholder="입력필수" readonly>
                                        <input type="text" id="land_x" style="display: none;" readonly>
                                        <input type="text" id="land_y" style="display: none;" readonly>
                                    </div>
                                    <div class="wrap">
                                        <label for="landPrice">가격</label>
                                        <input class="has-unit" type="number" id="land_register_price" placeholder="원 단위로 입력해 주세요">
                                        <i class="unit">원</i>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">토지 내용</legend>
                                    <textarea name="text" cols="50" rows="10" id="land_register_content" required></textarea>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">대표 이미지</legend>
                                    <label class="btn_file" for="thumbnail">파일 올리기</label>
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                                    <div class="uploaded">
                                    </div>
                                </fieldset>


                                <fieldset class="has-files">
                                    <legend class="legend">참고 이미지</legend>
                                    <label class="btn_file" for="images">파일 올리기</label>
                                    <input type="file" name="imgList[]" id="images" accept=".jpg, .jpeg, .png" multiple>
                                    <div class="uploaded sub_image_uploaded">
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
                                    <button type="button" class="btn btn_sm" onclick="land_register()">등록하기</button>
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
    <!-- 토지 등록 시 작동하는 네이버 지도 API 스크립트 -->
    <script>

        function rg_search() {
            var rg_addr = $("#rg_addr").val();
            if (rg_addr == '') {
                alert('도로명 또는 지번 주소를 입력해보세요');
            } else {
                searchAddressToCoordinate(rg_addr);
            }
        }

        //해당 지번 주소 검증 스크립트
        function searchAddressToCoordinate(address) {
            //랜드마킹 주소
            var land_url = '<?php echo $land_url;?>';
            naver.maps.Service.geocode({
                query: address
            }, function (status, response) {
                if (status === naver.maps.Service.Status.ERROR) {
                    if (!address) {
                        return alert('Geocode Error, Please check address');
                    }
                    return alert('Geocode Error, address:' + address);
                }
                var htmlAddresses = [],
                    item = response.v2.addresses[0];
                if (item) {
                    point = new naver.maps.Point(item.x, item.y);
                }

                if (response.v2.meta.totalCount === 0) {
                    return alert('도로명이나 지번주소를 정확히 입력해주세요');
                } else {
                    //return alert(item.x+'/'+item.y);
                    //지번주소로 get 전송

                    if (item.jibunAddress) {
                        alert(item.jibunAddress+"는 등록 가능한 주소명입니다");
                        $('#land_address').val(item.jibunAddress);
                        $('#land_x').val(item.x);
                        $('#land_y').val(item.y);
                        //location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.jibunAddress + '&x=' + item.x + '&y=' + item.y;
                    } else if (item.roadAddress) {
                        alert(item.roadAddress+"는 등록 가능한 주소명입니다");
                        $('#land_address').val(item.roadAddress);
                        $('#land_x').val(item.x);
                        $('#land_y').val(item.y);
                        //location.href = land_url + '/html/land/sub_rg_form.php?rg_addr=' + item.roadAddress + '&x=' + item.x + '&y=' + item.y;
                    } else {
                        alert('도로명이나 지번주소를 정확히 입력해주세요');
                    }
                    // if (item.englishAddress) {
                    //     alert('도로명이나 지번주소를 정확히 입력해주세요');
                    //     //htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
                    // }
                }
            });
        }
    </script>
    <!-- 대표이미지, 참고이미지 업로드 스크립트-->
    <script>
        var $fileInput = $('.form-wrap'),
            $thumbInput = $fileInput.find('#thumbnail'),
            $imgsInput = $fileInput.find('#images'),
            // $imgFileWrap = $fileInput.find('.file-wrap'),
            thumbImg = {}, //대표 이미지
            imgList = []; //참고 이미지 배열

        /* ====== [토지 등록] 이미지 파일 업로드 ======= */
        function registerFormFileFn(){
            //대표 이미지
            $thumbInput.on('change', function(event){

                var $thumbHtml =['<div class="wrap"><span class="tit">'
                    ,'</span><span class="file">'
                    ,'</span><button class="btn btn_del"></button></div>'];

                thumbImg = event.target.files[0];
                var uploaded = event.target.nextElementSibling;
                uploaded.innerHTML= $thumbHtml[0] + '대표이미지' + $thumbHtml[1] + thumbImg.name + $thumbHtml[2];


                $('#thumbnail').next().find('.btn_del').click(function (event) {
                    event.preventDefault();
                    $('#thumbnail').val('');
                    thumbImg = {};
                    $(this).parent().remove();
                })

            });

            //참고 이미지
            $imgsInput.on('change', function(event){
                var stop = false;

                const target = document.getElementsByName('imgList[]');

                $.each(target[0].files, function(index, file){
                    if($(".sub_image").children("div").length > 10){
                        if(!stop){
                            alert("최대 등록 파일은 10개 입니다.");
                            stop = true;
                        }
                    }else{
                        if(!stop){
                            const fileName = file.name;
                            const fileEx = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length).toLowerCase();
                            if(fileEx != "jpg" && fileEx != "png" && fileEx != "jpeg"){
                                alert("파일은 (jpg, png, jpeg) 형식만 등록 가능합니다.");
                                return false;
                            }else{


                                var $imgsHtml =['<div class="wrap sub_image"><span class="tit">참고 이미지</span><span class="file">'
                                    ,'</span><button class="btn btn_del" data-index="'
                                    ,'"></button></div>'];

                                imgList.push(file);
                                $imgsInput.next().append($imgsHtml[0] + fileName + $imgsHtml[1] + (imgList.length - 1) + $imgsHtml[2]);

                            }
                        }
                    }
                });
                $(target).val("");

                //파일 삭제
                $('#images').next().find('.btn_del').off('click').on('click', function(event){
                    event.preventDefault();
                    var delNum = $(this).data('index');
                    var $fileWrap = $(this).parents('.sub_image_uploaded');
                    //파일 태그 삭제
                    $fileWrap.children('.sub_image').eq(delNum).remove();
                    //이미지 리스트 업데이트
                    var imgArr = imgList.slice(delNum+1);
                    imgList = imgList.slice(0, delNum).concat(imgArr);
                    //태그 속성 업데이트
                    for(var idx = delNum; idx < imgArr.length + delNum; idx++){
                        $fileWrap.find('.btn_del').eq(idx).data('index', idx);
                    };


                });
            });
        }registerFormFileFn();

    </script>
    <!-- 토지 등록 버튼 클릭 시 스크립트-->
    <script>
        function land_register(){


            var rg_land_register_email = $("#land_register_email").val();
            var rg_land_register_name = $("#land_register_name").val();
            var rg_land_register_phone = $("#land_register_phone").val();

            var rg_land_register_title = $("#land_register_title").val();
            var rg_land_register_area = $("#land_register_area").val();
            var rg_land_address = $("#land_address").val();
            var rg_land_x = $("#land_x").val();
            var rg_land_y = $("#land_y").val();
            var rg_land_register_price = $("#land_register_price").val();
            var rg_land_register_content = $("#land_register_content").val();

            var thumbnail = document.querySelector("#thumbnail");
            var formData = new FormData();


            if (rg_land_register_email == '') {
                alert('아이디를 입력해주세요')
            } else if (rg_land_register_name == '') {
                alert('전화번호를 입력해주세요')
            }else if (rg_land_register_phone == '') {
                alert('전화번호를 입력해주세요')
            } else if (rg_land_register_phone.length!=11) {
                alert('전화번호 11자리를 정확히 입력해주세요')
            }else if (rg_land_register_title == '') {
                alert('토지 제목을 입력해주세요')
            }else if (rg_land_register_area == '') {
                alert('토지 면적을 입력해주세요')
            }else if (rg_land_register_price == '') {
                alert('토지 가격을 입력해주세요')
            }else if (rg_land_address == '') {
                alert('토지 주소를 입력해주세요')
            }else if (rg_land_register_content == '') {
                alert('토지 내용을 입력해주세요')
            }else if (imgList.length >10) {
                alert("최대 등록 파일은 10개 입니다.");
            }else {

                // alert(rg_land_register_email+"/"+rg_land_register_name+"/"+rg_land_register_phone+"/"+rg_land_register_title+"/"+
                //     rg_land_register_area+"/"+rg_land_address+"/"+rg_land_x+"/"+rg_land_y+"/"+
                //     rg_land_register_price+"/"+rg_land_register_content)

                if(imgList.length>0){
                    for(var i=0;i<imgList.length; i++) {
                        console.log(imgList[i]);
                        console.log(i);
                        formData.append("sub_files[]", imgList[i]);
                    }
                }

                if (thumbnail.files[0]) { // 대표 이미지를 등록한 경우

                }else{  // 대표 이미지를 등록하지 않은 경우
                    alert('대표 이미지가 기본 이미지로 등록됩니다.')
                }

                console.log(imgList.length.toString());
                console.log(thumbnail.files[0]);



                formData.append("land_email", rg_land_register_email);
                formData.append("land_name", rg_land_register_name);
                formData.append("land_phone", rg_land_register_phone);

                formData.append("land_title", rg_land_register_title);
                formData.append("land_area", rg_land_register_area);
                formData.append("land_address", rg_land_address);
                formData.append("land_x", rg_land_x);
                formData.append("land_y", rg_land_y);
                formData.append("land_price", rg_land_register_price);
                formData.append("land_content", rg_land_register_content);

                formData.append("thumbnail",thumbnail.files[0]);
                formData.append("sub_image_count",imgList.length.toString());


                $.ajax({
                    type:"POST",
                    url:"/admin_server/land_register_server.php",
                    data:formData,
                    cache:false,
                    contentType:false,
                    processData:false,
                    dataType:"text",
                    success:function(result){
                        console.log(result);
                        if(result=='success'){
                            alert("토지 등록을 완료했습니다");
                            location.href='https://landmarking.co.kr/admin/html/land_list.php';
                        }else{
                            alert("토지 등록에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                        alert(errorThrown);
                    }
                });

            }






        }

    </script>



</body>
</html>
<?php } ?>