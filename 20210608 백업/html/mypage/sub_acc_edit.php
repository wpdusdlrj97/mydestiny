<?php
//개인정보 변경
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
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
    <div class="popup popup-acc" data-popup="editPwd">
        <div class="dim"></div>
        <div class="container">
            <div class="inner">
                <div class="box">
                    <div class="signup acc_check">
                        <form onsubmit="return false;">
                            <div class="row row_tit clear">
                                <span class="join_tit">변경 할 비밀번호를 입력해 주세요.</span>
                            </div>
                            <div class="row row_pwd clear">
                                <label for="userpwd">비밀번호</label>
                                <div class="bx-input">
                                    <input type="password" id="change_pw" required
                                           placeholder="4~16자 비밀번호를 입력해주세요(영문·숫자)">
                                    <span class="pwdBtns">
                                        <i class="btn_closed"></i>
                                        <i class="btn_open"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row row_pwd row_hr clear">
                                <label for="userpwd">비밀번호 확인</label>
                                <div class="bx-input">
                                    <input type="password" id="change_pw_check" required
                                           placeholder="4~16자 비밀번호를 입력해주세요(영문·숫자)">
                                    <span class="pwdBtns">
                                        <i class="btn_closed"></i>
                                        <i class="btn_open"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                            <div class="row row_sm">
                                <button class="row btn btn_sm bg_v bx-round_l" onclick="change_pw();">비밀번호 변경하기</button>
                            </div>
                        <button type="button" class="row btn btn_close btn_pop bg_v bx-round_l"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="popup"></div>
    <div id="wrap" class="sub mypage_edit">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit clear">
                            <i class="tit-icon icon_user bx-round_l"></i>
                            <h2 class="tit-wrap l-inline ft_b"><span class="tit on">마이 페이지</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <div class="inner">
                        <div class="user-wrap">
                            <span><em class="name"><?php echo $row_user['user_nickname'] ?></em><span class="name_desc"> 님 안녕하세요</span></span>
                        </div>
                        <div class="signup">
                            <form onsubmit="return false;">
                                <div class="row clear">
                                    <label for="email" class="ft_m_l">ID<i class="details">이메일주소</i></label>
                                    <div class="bx-input fn l-inline bx-round_l">
                                        <input type="email" id="email" name="user_email"
                                               value="<?php echo $row_user['user_email'] ?>" readonly
                                               placeholder="이메일주소를 입력해주세요">
                                    </div>
                                    <span class="check l-inline ft_m_m">로그인 ID로 사용되며, 변경 할 수 없습니다.</span>
                                </div>
                                <div class="row clear">
                                    <label for="name" class="ft_m_l">성명</label>
                                    <div class="bx-input l-inline bx-round_l">
                                        <input type="text" id="user_name" minlength="2" maxlength="4"
                                               value="<?php echo $row_user['user_name'] ?>" placeholder="이름을 입력해주세요">
                                    </div>
                                    <span class="check pc l-inline ft_m_m">원활한 서비스 이용을 위해 실명을 기입해 주세요.</span>
                                    <span class="check mobile l-inline ft_m_m">실명을 사용해 주세요.</span>
                                </div>
                                <div class="row clear">
                                    <label for="nick" class="ft_m_l">닉네임</label>
                                    <div class="bx-input l-inline bx-round_l">
                                        <input type="text" id="user_nickname" minlength="2" maxlength="6"
                                               value="<?php echo $row_user['user_nickname'] ?>"
                                               placeholder="닉네임을 입력해주세요">
                                    </div>
                                    <span class="check pc l-inline ft_m_m">서비스 운영에 문제가 있는 닉네임은 변경됩니다.</span>
                                </div>
                                <div class="row row_pwd row_hr clear">
                                    <label for="tel" class="ft_m_l">휴대전화 번호</label>
                                    <div class="bx-input l-inline bx-round_l">
                                        <input type="tel" id="user_phone"
                                               value="<?php echo $row_user['user_phone'] ?>"
                                               placeholder="휴대전화 번호를 입력해주세요">
                                    </div>
                                    <span class="check pc l-inline ft_m_m">연락 가능한 휴대전화 번호를 기입해주세요.</span>
                                </div>
                                <div class="row row_sm clear">
                                    <button class="btn btn_sm bx-round_l bg_v item" onclick="change_info()">변경<span class="pc">사항 적용</span>하기</button>
                                    <a class="item btn_pop" data-popup="editPwd">비밀번호 변경하기</a>
                                    <a class="item btn_cancel" href="/html/mypage/sub_mp_menu.php">취소하고 돌아가기</a>
                                </div>
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

    <!-- 변경사항 적용하기 버튼 클릭 시 작동하는 개인정보 변경 스크립트 -->
    <script>
        function change_info() {

            var user_name = $("#user_name").val();
            var user_nickname = $("#user_nickname").val();
            var user_phone = $("#user_phone").val();


            if (user_name == '') {
                alert('이름을 입력해주세요');
            } else if (user_nickname == '') {
                alert('닉네임을 입력해주세요');
            } else if (user_nickname.length < 2 || user_nickname.length > 6) {
                alert('닉네임을 2~6자리로 입력해주세요')
            } else if (user_phone == '') {
                alert('전화번호를 입력해주세요');
            } else if (user_phone.length != 11) {
                alert('휴대전화번호 11자리를 정확히 입력해주세요');
            } else {
                $.ajax({
                    type: "POST"
                    , url: "/server/mypage_edit_server.php"
                    , data: {name: user_name, nickname: user_nickname, phone: user_phone}
                    , success: function (result) {
                        if (result == 'success') {
                            location.href = '<?php echo $land_url . "/html/mypage/sub_mp_menu.php";?>';
                            alert("개인정보가 변경되었습니다.");
                        } else {
                            alert("회원가입에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    }
                    , error: function () {
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });
            }
        }
    </script>
    <!-- 팝업창 내의 비밀번호 변경하기 버튼 클릭 시 비밀번호 변경을 담당하는 스크립트 -->
    <script>
        function change_pw() {
            var change_pw= $("#change_pw").val();
            var change_pw_check= $("#change_pw_check").val();

            if(change_pw==''){
                alert('변경할 비밀번호를 입력해주세요');
            }else if(change_pw.length<4 || change_pw.length>16){
                alert('변경할 비밀번호를 영문,숫자 4~16자리로 입력해주세요')
            }else if(change_pw!=change_pw_check){
                alert('비밀번호가 일치하지 않습니다');
            }else{
                $.ajax({
                    type: "POST"
                    , url: "/server/change_pw_server.php"
                    , data: {change_password: change_pw}
                    , success: function (result) {
                        if (result == 'success') {
                            location.href = '<?php echo $land_url . "/html/mypage/sub_mp_menu.php";?>';
                            alert("비밀번호가 변경되었습니다.");
                        } else {
                            alert("비밀번호 변경에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                        }
                    }
                    , error: function () {
                        alert("잠시 후에 다시 시도해주세요");
                    }
                });
            }
        }
    </script>
</body>
</html>
<?php } ?>