<?php
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";


$qna_id = $_GET['id'];

$qry_string_qna = "SELECT * FROM qna_information where qna_id='$qna_id'";
$qry_qna = mysqli_query($connect, $qry_string_qna);
$row_qna = mysqli_fetch_array($qry_qna);
$total_row_qna = mysqli_num_rows($qry_qna);

//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else if ($total_row_qna < 1) {
    echo "<script>alert('잘못된 접근입니다');history.back();</script>";
} else {


    ?>
    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
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
        <link rel="stylesheet" href="../../css/style.css">

        <!-- SCRIPT -->
        <!--[if lte IE 9]>
        <script src="../../js/lib/IE9.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="../../js/lib/html5shiv.min.js"></script>
        <script src="../../js/lib/jqPIE.js"></script>
        <script src="../../js/lib/PIE.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
    <div id="wrap">
        <header id="header"></header>
        <main id="main" class="faq-form form">
            <div class="container">
                <div class="inner">
                    <h2 class="title">문의내역 답변 등록/수정</h2>
                    <div class="contents">
                        <div class="form-wrap wide clear">
                            <div class="thumbnail">
                                <?php if ($row_qna['qna_main_image'] == null) { ?>
                                    <img class="img img_f l-fleft" src="https://landmarking.co.kr/land_image/land_default.png" alt="문의사항">
                                <?php } else { ?>
                                    <img class="img img_f l-fleft" src="<?php echo $row_qna['qna_main_image'] ?>" alt="문의사항">
                                <?php } ?>
                                <span class="txt l-fright">
                                    <em class="tit"><?php echo $row_qna['qna_title'] ?></em>
                                    <em class="date bar">등록일<i
                                            class="value"><?php echo date('Y.m.d H:i', strtotime($row_qna['qna_date'])) ?></i></em>
                                </span>
                            </div>
                            <form onsubmit="return false;">
                                <fieldset>
                                    <legend class="legend">본문 내용</legend>
                                    <textarea name="quest" cols="30" rows="10"
                                              readonly><?php echo $row_qna['qna_content'] ?></textarea>
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">답변 내용</legend>
                                    <label class="btn tag">랜드마킹 답변</label>
                                    <textarea class="has-tag" id="qna_reply_content" cols="30" rows="10"><?php echo strip_tags($row_qna['reply_content'])  ?></textarea>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">첨부 파일</legend>
                                    <label class="btn_file" for="qna_file">파일 올리기</label>
                                    <input type="file" name="qna_file" id="qna_file" accept=".jpg, .jpeg, .png, .pdf, .pptx, .hwp, .xlsx, .docx">
                                    <div class="uploaded">

                                        <?php if ($row_qna['reply_file']==null || $row_qna['reply_file']=='') { ?>

                                        <?php } else { ?>
                                            <div class="wrap" id="original_qna_file">
                                                <span class="tit">기존 파일</span>
                                                <span class="file"><?php
                                                    $qna_file_array = explode( '_&문의&_', $row_qna['reply_file']);
                                                    echo $qna_file_array[1];
                                                    ?></span>
                                                <button class="btn btn_del" onclick="delete_qna_file()"></button>
                                            </div>
                                        <?php } ?>


                                    </div>
                                </fieldset>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel" onclick="history.back()">취소</button>
                                    <button type="button" class="btn btn_sm" onclick="qna_reply_complete()">답변 완료</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../../js/script.js"></script>
    <script>
        $("#header").load("../../html/_header.php");
    </script>
    <script>

        //기존 파일 상태 값 : 0 - 그대로, 1 - 삭제, 2- 새로운 파일 업로드
        var original_file_status='0';

        //파일 업로드하기
        function fileLoadFn(){
            var fileInput = document.querySelectorAll('input[type="file"]');
            var file = {};


            //토지등록 대표이미지, 첨부파일
            var addSingleFile = function(event){
                //기존 파일 상태 값 : 0 - 그대로, 1 - 삭제, 2- 새로운 파일 업로드
                original_file_status='2';

                event.preventDefault();

                file = event.target.files[0];
                var uploaded = event.target.nextElementSibling;

                var name = '첨부파일';
                if( event.target.hasAttribute('accept') && event.target.getAttribute('accept').includes('image')) name = '대표이미지';

                var htmlTxt = ['<div class="wrap"><span class="tit">'
                    ,'</span><span class="file">'
                    ,'</span><button class="btn btn_del"></button></div>'];

                uploaded.innerHTML= htmlTxt[0] + name + htmlTxt[1] + file.name+htmlTxt[2];

                uploaded.querySelector('.btn_del').addEventListener('click',function(e){
                    e.preventDefault();
                    file = null;
                    uploaded.innerHTML = '';
                })
            };

            fileInput.forEach(function(el){
                el.addEventListener('change', function(event){
                    addSingleFile(event);
                });
            });

        }fileLoadFn();

        //기존 첨부파일 삭제 버튼
        function delete_qna_file() {
            //해당 아이템 삭제
            document.getElementById('original_qna_file').remove();
            //기존 파일 상태 값 : 0 - 그대로, 1 - 삭제, 2- 새로운 파일 업로드
            original_file_status='1';
        }


        function qna_reply_complete() {

            var qna_id = '<?php echo $qna_id?>';
            var qna_reply_content = $("#qna_reply_content").val();
            var qna_file = document.querySelector("#qna_file");
            var formData = new FormData();

            if (qna_reply_content == '') {
                alert('답변 내용을 입력해주세요')
            } else {


                formData.append("qna_id", qna_id);
                formData.append("qna_reply_content", qna_reply_content);
                formData.append("original_file_status", original_file_status);
                if(qna_file.files[0]){
                    console.log( qna_file.files[0]);
                    formData.append("qna_file", qna_file.files[0]);
                }

                $.ajax({
                    type: "POST",
                    url: "/admin_server/qna_server.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "text",
                    success: function (result) {
                        console.log(result);
                        if (result == 'success') {
                            alert("답변 등록을 완료했습니다");
                            location.href = '<?php echo "https://landmarking.co.kr/admin/html/cs/qna_detail.php?id=".$qna_id;?>';
                        } else {
                            alert("답변 등록에 실패하였습니다, 잠시 후에 다시 시도해주세요");
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