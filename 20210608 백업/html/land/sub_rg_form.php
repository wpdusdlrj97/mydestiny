<?php
//마이 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
//세션이 없을 경우 로그인 페이지 로드
if(!$user_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}else{

$rg_addr=$_GET['rg_addr'];
$latlng_x=$_GET['x'];
$latlng_y=$_GET['y'];

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
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ewzw7q7mjs&submodules=geocoder"></script>
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
    <div id="wrap" class="sub sub-register">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_pencil bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <a href="#" class="tit ft_b">토지등록</a>
                                <span class="tit ft_b"><span class="addr"><?php echo $rg_addr;?></span></span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="rg-inform_txt"><span class="addr"><?php echo $rg_addr;?></span>등록하기</div>
                        <div class="rg-inform bx-round_l bg_n">
                            <div class="wrap">
                                <img src="../../images/sub/icon_MapPinLine.png" alt="check icon">
                                <span><?php echo $rg_addr;?></span>
                            </div>
                        </div>
                        <div id="map" style="margin-bottom:40px; width: 100%; height: 500px;border-radius: 10px;"> </div>
                        <div class="rg-link bx-round_l bg_g" style="width:100%; height:240px; margin-bottom: 50px; text-align:center">토지 이음 링크 & 관련 설명</div>

                        <div class="rg-form">
                            <form class="ft_m_l" onsubmit="return false;">
                                <fieldset class="clear">
                                    <h4 class="form-tit">등록 정보</h4>
                                    <div class="form-wrap bx-round_l">
                                        <label for="name" class="tit clear">성명<span class="check">공인중개사는 꼭 실명을 기입해 주세요.</span> </label>
                                        <div class="input-wrap bx-round_s">
                                            <input type="text" id="land_name"  maxlength="4" placeholder="이름을 입력주세요">
                                            <!-- <span class="cnt"><em class="value">0</em> / <em>50</em></span> -->
                                        </div>
                                    </div>
                                    <div class="form-wrap bx-round_l">
                                        <label for="tel" class="tit">전화번호</label>
                                        <div class="input-wrap bx-round_s">
                                            <input type="number" id="land_phone"  maxlength="11" placeholder="전화번호를 입력해주세요">
                                            <!-- <span class="cnt"><em class="value">0</em> / <em>50</em></span> -->
                                        </div>
                                    </div>
                                    <h4 class="form-tit">토지 정보</h4>
                                    <div class="form-wrap bx-round_l">
                                        <label for="title" class="tit">제목</label>
                                        <div class="input-wrap bx-round_s">
                                            <input type="text" id="land_title"  maxlength="50" placeholder="제목을 입력해주세요">
                                            <span class="cnt"><em class="value">0</em> / <em>50</em></span>
                                        </div>
                                    </div>
                                    <div class="col-wrap clear">
                                        <div class="form-wrap bx-round_l">
                                            <label for="size" class="tit">면적</label>
                                            <div class="input-wrap bx-round_s">
                                                <input type="number" id="land_area" maxlength="50" placeholder="'제곱미터'단위로 입력해주세요">
                                                <span class="unit">m<sup>2</sup> </span>
                                            </div>
                                        </div>
                                        <div class="form-wrap bx-round_l l-fright">
                                            <label for="cost" class="tit">가격</label>
                                            <div class="input-wrap bx-round_price">
                                                <input type="number" id="land_price" maxlength="50" placeholder="'원'단위로 입력해주세요.">
                                                <span class="unit">&#8361;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-wrap form-wrap_t bx-round_l">
                                        <label for="text" class="tit">본문</label>
                                        <div class="input-wrap bx-round_s ">
                                            <textarea id="land_content" rows="50" cols="30" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-wrap form-wrap_f clear bx-round_l">
                                        <span class="tit">대표 이미지 &middot; 사진 업로드 </span>
                                        <label for="thumbnail" class="btn btn_thumb bx-round_l">추가<span class="pc">하기</span></label>
                                        <input type="file" id="thumbnail" name="thumbnail" accept="image/* ">
                                    </div>
                                    <div class="form-wrap form-wrap_f clear bx-round_l">
                                        <span class="tit">참고 이미지 &middot; 사진 업로드 </span>
                                        <label for="images" class="btn btn_imgs bx-round_l">추가<span class="pc">하기</span></label>
                                        <input type="file" id="images" name="imgList[]" accept=".jpg, .jpeg, .png" multiple>
                                        <div class="file-wrap">
                                        </div>
                                    </div>

                                    <button  class="btn btn_sm bx-round_l bg_v" onclick="land_register()"> 등록 하기 </button>
                                    <a href="/html/index.php" class="btn btn_del">취소하고 삭제하기</a>
                                </fieldset>
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
    <!-- 네이버 지도 API 자바스크립트-->
    <script>
        var latlng_x = '<?php echo $latlng_x?>';
        var latlng_y = '<?php echo $latlng_y?>';

        var map = new naver.maps.Map('map', {
            useStyleMap: true,
            zoom: 18,
            center: new naver.maps.LatLng(latlng_y, latlng_x),
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: naver.maps.MapTypeControlStyle.DROPDOWN
            }
        });

        function startCadastralLayer() {
            var cadastralLayer = new naver.maps.CadastralLayer({ useStyleMap: true });

            var btn = $('#cadastral');

            naver.maps.Event.addListener(map, 'cadastralLayer_changed', function(cadastralLayer) {
                if (cadastralLayer.getMap()) {
                    btn.addClass('control-on').val('지적도 끄기');
                } else {
                    btn.removeClass('control-on').val('지적도 켜기');
                }
            });

            cadastralLayer.setMap(map);

            btn.on('click', function(e) {
                e.preventDefault();

                if (cadastralLayer.getMap()) {
                    cadastralLayer.setMap(null);
                    btn.removeClass('control-on').val('지적도 켜기');
                } else {
                    cadastralLayer.setMap(map);
                    btn.addClass('control-on').val('지적도 끄기');
                }
            });
        }
        naver.maps.Event.once(map, 'init_stylemap', startCadastralLayer);
    </script>
    <!-- 글자 수 측정 스크립트-->
    <script>
        function registerFormTxtFn(){
            var $registerTitle = $('.rg-form #land_title'),
                $numTxt = $registerTitle.next('.cnt').find('.value');
            $len = 0;

            $registerTitle.on('keyup', function(event){
                event.preventDefault();
                $len = $(this).val().length;
                $numTxt.text($len);
            });
        }registerFormTxtFn();
    </script>

    <!-- 대표이미지, 참고이미지 업로드 스크립트-->
    <script>
        var $fileInput = $('.rg-form .form-wrap_f'),
            $thumbInput = $fileInput.find('#thumbnail'),
            $imgsInput = $fileInput.find('#images'),
            // $imgFileWrap = $fileInput.find('.file-wrap'),
            thumbImg = {}, //대표 이미지
            imgList = []; //참고 이미지 배열

        /* ====== [토지 등록] 이미지 파일 업로드 ======= */
        function registerFormFileFn(){
            //대표 이미지
            $thumbInput.on('change', function(event){

                var $thumbHtml = ["<div class='input-wrap bx-round_s'><input type='text'  value='"
                    ,"'><button class='btn btn_del' type='button'></button></div>"];

                thumbImg = event.target.files[0];

                if($thumbInput.next('.input-wrap').length > 0) $thumbInput.next().find('input').val( thumbImg.name );
                else $thumbInput.after($thumbHtml[0] +  thumbImg.name + $thumbHtml[1]);

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
                    if($(".num bx-round_s bg_n").children("div").length > 10){
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

                                var $imgsHtml =["<i class='num bx-round_s bg_n'>"
                                    , "</i><div class='input-wrap bx-round_s'><input type='text' readonly value='"
                                    ,"'><button class='btn btn_del' type='button' data-index='","'></button></div>" ];
                                imgList.push(file);
                                $imgsInput.next().append($imgsHtml[0] + imgList.length + $imgsHtml[1] + fileName + $imgsHtml[2] + (imgList.length - 1) + $imgsHtml[3]);

                            }
                        }
                    }
                });
                $(target).val("");

                //파일 삭제
                $('#images').next().find('.btn_del').off('click').on('click', function(event){
                    event.preventDefault();
                    var delNum = $(this).data('index');
                    var $fileWrap = $(this).parents('.file-wrap');
                    //파일 태그 삭제
                    $fileWrap.children('i').eq(delNum).remove();
                    $fileWrap.children('.input-wrap').eq(delNum).remove();
                    //이미지 리스트 업데이트
                    var imgArr = imgList.slice(delNum+1);
                    imgList = imgList.slice(0, delNum).concat(imgArr);
                    //태그 속성 업데이트
                    for(var idx = delNum; idx < imgArr.length + delNum; idx++){
                        $fileWrap.children('i').eq(idx).text(`${idx+1}`);
                        $fileWrap.find('.btn_del').eq(idx).data('index', idx);
                    };
                });
            });
        }registerFormFileFn();

    </script>
    <!-- 토지 등록 버튼 클릭 시 스크립트-->
    <script>
        function land_register(){

            var land_address = '<?php echo  $rg_addr; ?>';
            var land_x = '<?php echo  $latlng_x; ?>';
            var land_y = '<?php echo  $latlng_y; ?>';
            var land_name = $("#land_name").val();
            var land_phone = $("#land_phone").val();
            var land_title = $("#land_title").val();
            var land_area = $("#land_area").val();
            var land_price = $("#land_price").val();
            var land_content = $("#land_content").val();
            var thumbnail = document.querySelector("#thumbnail");

            var formData = new FormData();

            if (land_name == '') {
                alert('실명을 입력해주세요')
            } else if (land_phone == '') {
                alert('전화번호를 입력해주세요')
            } else if (land_phone.length!=11) {
                alert('전화번호 11자리를 정확히 입력해주세요')
            }else if (land_title == '') {
                alert('토지 제목을 입력해주세요')
            }else if (land_area == '') {
                alert('토지 면적을 입력해주세요')
            }else if (land_price == '') {
                alert('토지 가격을 입력해주세요')
            }else if (land_content == '') {
                alert('토지 내용을 입력해주세요')
            }else if (imgList.length >10) {
                alert("최대 등록 파일은 10개 입니다.");
            }else {

                //alert(land_address+"/"+land_x+"/"+land_y+"/"+land_name+"/"+land_phone+"/"+land_title+"/"+land_area+"/"+land_price+"/"+land_content);

                if(imgList.length>0){
                    for(var i=0;i<imgList.length; i++) {
                        //console.log(imgList[i]);
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

                formData.append("land_address", land_address);
                formData.append("land_x", land_x);
                formData.append("land_y", land_y);
                formData.append("land_name", land_name);
                formData.append("land_phone", land_phone);
                formData.append("land_title", land_title);
                formData.append("land_area", land_area);
                formData.append("land_price", land_price);
                formData.append("land_content", land_content);

                formData.append("thumbnail",thumbnail.files[0]);
                formData.append("sub_image_count",imgList.length.toString());


                $.ajax({
                    type:"POST",
                    url:"/server/land_register_server.php",
                    data:formData,
                    cache:false,
                    contentType:false,
                    processData:false,
                    dataType:"text",
                    success:function(result){
                        console.log(result);
                        if(result=='success'){
                            alert("토지 등록을 완료했습니다");
                            location.href='<?php echo $land_url."/html/land/sub_mp_list_all.php";?>';
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