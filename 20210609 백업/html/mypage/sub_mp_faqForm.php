<?php
//마이 페이지 - 문의작성
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else {

    $qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
    $qry_user = mysqli_query($connect, $qry_string_user);
    $row_user = mysqli_fetch_array($qry_user);
    $total_row_user = mysqli_num_rows($qry_user);

    ?>

    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
        <link rel="stylesheet" href="../../css/main.css">

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


    </head>

    <body>
    <div id="popup"></div>
    <div id="wrap" class="sub">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit clear">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox">
                                <a href="/html/mypage/sub_mp_menu.php" class="tit ft_b on">마이 페이지</a>
                                <span class="tit ft_b on">문의 등록하기</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="rg-form">
                            <form class="ft_m_l" onsubmit="return false;">
                                <fieldset>
                                    <div class="form-wrap bx-round_l bg_g">
                                        <label for="title" class="tit">제목</label>
                                        <div class="input-wrap bx-round_s">
                                            <input type="text" id="qna_title" name="qna_title" maxlength="49"
                                                   placeholder="제목을 입력해주세요">
                                            <span class="cnt"><em class="value">0</em> / <em>50</em></span>
                                        </div>
                                    </div>
                                    <div class="form-wrap form-wrap_t bx-round_l bg_g">
                                        <label for="text" class="tit">본문</label>
                                        <div class="input-wrap bx-round_s ">
                                            <textarea id="qna_content" name="qna_content" rows="50" cols="30"
                                                      placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-wrap form-wrap_f clear bx-round_l bg_g">
                                        <span class="tit">대표 이미지 &middot; 사진 업로드 </span>
                                        <label for="thumbnail" class="btn btn_thumb bg_v bx-round_l">추가하기</label>
                                        <input type="file" id="thumbnail" name="thumbnail" accept="image/* ">
                                    </div>
                                    <div class="form-wrap form-wrap_f clear bx-round_l bg_g">
                                        <span class="tit">참고 이미지 &middot; 사진 업로드 </span>
                                        <label for="images" class="btn btn_imgs bg_v bx-round_l">추가하기</label>
                                        <input type="file" id="images" name="imgList[]" accept=".jpg, .jpeg, .png"
                                               multiple>
                                        <div class="file-wrap">
                                        </div>
                                    </div>
                                    <button class="btn btn_sm bx-round_l bg_v" onclick="register()"> 문의 등록 하기</button>
                                </fieldset>
                            </form>
                            <!--                            <button class="btn btn_sm bx-round_l bg_v" onclick="register()"> 문의 등록 하기</button>-->
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
    <!-- 글자 수 측정 스크립트 -->
    <script>
        function registerFormTxtFn() {
            var $registerTitle = $('.rg-form #qna_title'),
                $numTxt = $registerTitle.next('.cnt').find('.value');
            $len = 0;

            $registerTitle.on('keyup', function (event) {
                event.preventDefault();
                $len = $(this).val().length;
                $numTxt.text($len);
            });
        }

        registerFormTxtFn();
    </script>
    <!-- 대표 이미지, 참고이미지 업로드 스크립트 -->
    <script>
        var $fileInput = $('.rg-form .form-wrap_f'),
            $thumbInput = $fileInput.find('#thumbnail'),
            $imgsInput = $fileInput.find('#images'),
            // $imgFileWrap = $fileInput.find('.file-wrap'),
            thumbImg = {}, //대표 이미지
            imgList = []; //참고 이미지 배열

        /* ====== [마이페이지 등록] 이미지 파일 업로드 ======= */
        function registerFormFileFn() {
            //대표 이미지
            $thumbInput.on('change', function (event) {

                var $thumbHtml = ["<div class='input-wrap bx-round_s'><input type='text'  value='"
                    , "'><button class='btn btn_del' type='button'></button></div>"];

                thumbImg = event.target.files[0];

                if ($thumbInput.next('.input-wrap').length > 0) $thumbInput.next().find('input').val(thumbImg.name);
                else $thumbInput.after($thumbHtml[0] + thumbImg.name + $thumbHtml[1]);

                $('#thumbnail').next().find('.btn_del').click(function (event) {
                    event.preventDefault();
                    $('#thumbnail').val('');
                    thumbImg = {};
                    $(this).parent().remove();
                })
            });

            //참고 이미지
            $imgsInput.on('change', function (event) {
                var stop = false;

                const target = document.getElementsByName('imgList[]');

                $.each(target[0].files, function (index, file) {
                    if ($(".num bx-round_s bg_n").children("div").length > 10) {
                        if (!stop) {
                            alert("최대 등록 파일은 10개 입니다.");
                            stop = true;
                        }
                    } else {
                        if (!stop) {
                            const fileName = file.name;
                            const fileEx = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length).toLowerCase();
                            if (fileEx != "jpg" && fileEx != "png" && fileEx != "jpeg") {
                                alert("파일은 (jpg, png, jpeg) 형식만 등록 가능합니다.");
                                return false;
                            } else {

                                var $imgsHtml = ["<i class='num bx-round_s bg_n'>"
                                    , "</i><div class='input-wrap bx-round_s'><input type='text' readonly value='"
                                    , "'><button class='btn btn_del' type='button' data-index='", "'></button></div>"];
                                imgList.push(file);
                                $imgsInput.next().append($imgsHtml[0] + imgList.length + $imgsHtml[1] + fileName + $imgsHtml[2] + (imgList.length - 1) + $imgsHtml[3]);

                            }
                        }
                    }
                });
                $(target).val("");

                //파일 삭제
                $('#images').next().find('.btn_del').off('click').on('click', function (event) {
                    event.preventDefault();
                    var delNum = $(this).data('index');
                    var $fileWrap = $(this).parents('.file-wrap');
                    //파일 태그 삭제
                    $fileWrap.children('i').eq(delNum).remove();
                    $fileWrap.children('.input-wrap').eq(delNum).remove();
                    //이미지 리스트 업데이트
                    var imgArr = imgList.slice(delNum + 1);
                    imgList = imgList.slice(0, delNum).concat(imgArr);
                    //태그 속성 업데이트
                    for (var idx = delNum; idx < imgArr.length + delNum; idx++) {
                        $fileWrap.children('i').eq(idx).text(`${idx + 1}`);
                        $fileWrap.find('.btn_del').eq(idx).data('index', idx);
                    }
                    ;
                });
            });
        }

        registerFormFileFn();
    </script>

    <!-- 문의 등록 버튼 클릭 시 스크립트 -->
    <script>
        function register() {

            var qna_title = $("#qna_title").val();
            var qna_content = $("#qna_content").val();
            var thumbnail = document.querySelector("#thumbnail");

            var formData = new FormData();

            if (qna_title == '') {
                alert('문의 제목을 입력해주세요')
            } else if (qna_content == '') {
                alert('문의 내용을 입력해주세요')
            } else if (imgList.length > 10) {
                alert("최대 등록 파일은 10개 입니다.");
            } else {

                if (imgList.length > 0) {
                    for (var i = 0; i < imgList.length; i++) {
                        //console.log(imgList[i]);
                        console.log(i);
                        formData.append("sub_files[]", imgList[i]);
                    }
                }

                console.log(imgList.length.toString());

                formData.append("qna_title", qna_title);
                formData.append("qna_content", qna_content);
                formData.append("thumbnail", thumbnail.files[0]);
                formData.append("sub_image_count", imgList.length.toString());


                $.ajax({
                    type: "POST",
                    url: "/server/qna_register_server.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "text",
                    success: function (result) {
                        console.log(result);
                        if (result == 'success') {
                            alert("문의 등록을 완료했습니다");
                            location.href = '<?php echo $land_url . "/html/mypage/sub_mp_faq_all.php";?>';
                        } else {
                            alert("문의 등록에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        }

    </script>
    </body>
    </html>
<?php } ?>