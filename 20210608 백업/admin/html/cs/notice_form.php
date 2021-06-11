<?php
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";


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
    <link rel="stylesheet" href="../../css/default.css">
    <link rel="stylesheet" href="../../css/font.css">
    <link rel="stylesheet" href="../../css/style.css" >

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
        <main id="main" class="notice-form form">
            <div class="container">
                <div class="inner">
                    <h2 class="title">공지사항 글쓰기</h2>
                    <div class="contents">
                        <div class="form-wrap wide">
                            <form onsubmit="return false;">
                                <fieldset>
                                    <legend class="legend">제목</legend>
                                    <input type="text" class="notice-tit" id="notice_title" maxlength="30">
                                </fieldset>
                                <fieldset>
                                    <legend class="legend">내용</legend>
                                    <textarea name="quest" class="notice-cont" cols="60" rows="30" id="notice_content"></textarea>
                                </fieldset>
                                <fieldset class="has-files">
                                    <legend class="legend">첨부 파일</legend>
                                    <label class="btn_file" for="notice_file">파일 올리기</label>
                                    <input type="file" name="notice_file" id="notice_file" accept=".jpg, .jpeg, .png, .pdf, .pptx, .hwp, .xlsx, .docx">
                                    <div class="uploaded">
                                        <!-- <div class="wrap">
                                            <span class="tit">참고이미지</span>
                                            <span class="file">파일이름.png</span>
                                            <button class="btn btn_del"></button>
                                        </div> -->
                                    </div>
                                </fieldset>
                                <div class="btn-wrap">
                                    <button type="button" class="btn btn_cancel" onclick="history.back()">취소</button>
                                    <button type="button" class="btn btn_sm" onclick="notice_register()">등록</button>
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
       //파일 업로드하기
       function fileLoadFn(){
           var fileInput = document.querySelectorAll('input[type="file"]');
           var file = {};


           //토지등록 대표이미지, 첨부파일
           var addSingleFile = function(event){
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
   </script>

    <script>
        function notice_register() {

            var notice_title = $("#notice_title").val();
            var notice_content = $("#notice_content").val();
            var notice_file = document.querySelector("#notice_file");

            var formData = new FormData();

            if (notice_title == '') {
                alert('공지사항 제목을 입력해주세요')
            } else if (notice_content == '') {
                alert('공지사항 내용을 입력해주세요')
            } else {


                formData.append("type", 'register');
                formData.append("notice_title", notice_title);
                formData.append("notice_content", notice_content);
                if(notice_file.files[0]){
                    console.log( notice_file.files[0]);
                    formData.append("notice_file", notice_file.files[0]);
                }

                $.ajax({
                    type: "POST",
                    url: "/admin_server/notice_server.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "text",
                    success: function (result) {
                        console.log(result);
                        if (result == 'success') {
                            alert("공지사항 등록을 완료했습니다");
                            location.href = '<?php echo "https://landmarking.co.kr/admin/html/cs/notice_list.php";?>';
                        } else {
                            alert("공지사항 등록에 실패하였습니다, 잠시 후에 다시 시도해주세요");
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