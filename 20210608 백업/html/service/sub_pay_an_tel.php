<?php
//전화분석 구매 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";

//사용자 정보
$qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
$qry_user = mysqli_query($connect, $qry_string_user);
$row_user = mysqli_fetch_array($qry_user);
$total_row_user = mysqli_num_rows($qry_user);
//등록한 토지 정보 (전문분석을 받지 않은 토지만)
$qry_string_land = "SELECT * FROM land_information where land_register_id='$user_session' and land_cost_analysis_status='0'";
$qry_land = mysqli_query($connect, $qry_string_land);
$total_row_land = mysqli_num_rows($qry_land);
$no_land_url = $land_url . "/html/service/sub_pay_noland.php";
//세션이 없을 경우 로그인 페이지 로드
if (!$user_session) {
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}if ($total_row_land<1) {
    echo "<meta http-equiv='refresh' content='0; url=$no_land_url'>";
} else {



    $land_id = array();
    $land_address = array();

    while ($row_land = mysqli_fetch_array($qry_land)) {
        array_push($land_id, $row_land['land_id']);
        array_push($land_address, $row_land['land_address']);
    }


    //상품 가격
    $service_price = 30000;
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
        <!-- iamport.payment.js -->
        <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    </head>
    <body>
    <div id="popup"></div>
    <div id="wrap" class="sub sub_pay">
        <header id="header"></header>
        <main id="main">
            <div class="main-title">
                <div class="container">
                    <div class="inner">
                        <div class="tit">
                            <i class="tit-icon icon_pencil bx-round_l"></i>
                            <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b">전문분석</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container service-box">
                    <div class="inner">
                        <div class="title-wrap">
                            <h2 class="title">전문 분석 (전화)</h2>
                            <p class="desc">
                                <span>토지를 등록했다면 꼭 필요한 심층분석! 랜드마킹이 도와드립니다.</span>
                                <br>
                                <span>전화를 통해 가장 심층적인 상담을 받을 수 있습니다.</span>
                            </p>
                            <div class="img_area">
                                <img src="../../images/sub/img_service04.png" alt="전문분석대행">
                            </div>
                        </div>
                        <form class="form form_addr" onsubmit="return false;">
                            <p class="tit">등록된 토지 1개를 선택해 주세요.</p>
                            <ul class="select clear">

                                <?php for ($x = 0; $x < $total_row_land; $x++) { ?>

                                    <li class="option"><?php echo $land_address[$x] ?> <span style="display: none"><?php echo '///'.$land_id[$x] ?></span></li>

                                <?php } ?>
                            </ul>
                            <div class="btn-wrap">
                                <button class="btn btn_sm bx-round_s bg_v" onclick="pg_service()">선택한 토지로 구매하기</button>
                            </div>
                        </form>
                        <div style="margin-top:10px;margin-right:15px;float: right;">
                            <label style="margin-right: 15px;"><input type="radio" name="pg" value="card" checked> 카드 결제</label>
                            <label><input type="radio" name="pg" value="trans"> 실시간 계좌 이체</label>
                        </div>
                        <p class="warn">
                            <i class="icon"></i>
                            등록 또는 분석이 불가능하다고 판단되는 경우, 개별 안내 후 환불 처리 됩니다.
                        </p>
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


    <script>

        IMP.init('imp33197231');

        var pg_radio  = '';
        var merchant_uid = 'merchant_an_tel' + new Date().getTime();
        var service_type = '<?php echo '1'?>';
        var service_price = '<?php echo $service_price?>';
        var user_email = '<?php echo $row_user['user_email']?>';
        var user_name = '<?php echo $row_user['user_name']?>';
        var user_phone = '<?php echo $row_user['user_phone']?>';
        var user_phone_dash = user_phone.substr(0, 3) + "-" + user_phone.substr(3, 4) + "-" + user_phone.substr(7,4);


        var land_data = '';
        var land_data_array = '';
        var land_address = '';
        var land_id = '';

        //해당 아이템 클릭 시
        $(".select li").click(function () {

            //주소, 토지아이디
            land_data = $(this).text();
            land_data_array =  land_data.split('///');
            land_address = land_data_array[0];
            land_id = land_data_array[1];

            //주소, 토지아이디
            console.log(land_address);
            console.log(land_id);
            //css 변화
            $(this).addClass("selected");
            $(".select li").not($(this)).removeClass("selected");
        });



        function pg_service() {

            if(land_address=='' || land_id==''){
                alert('토지를 선택해주세요');
            }else{
                //alert(land_address+'/'+land_id);

                pg_radio = $('input[name="pg"]:checked').val();

                IMP.request_pay({
                    pg : 'inicis', //ActiveX 결제창은 inicis를 사용
                    pay_method : pg_radio, //card(신용카드), trans(실시간계좌이체), vbank(가상계좌), phone(휴대폰소액결제)
                    merchant_uid : merchant_uid, //상점에서 관리하시는 고유 주문번호를 전달
                    name : '랜드마킹 : 전화분석',
                    amount : service_price,
                    buyer_email : user_email,
                    buyer_name : user_name,
                    buyer_tel : user_phone_dash, //누락되면 이니시스 결제창에서 오류
                    m_redirect_url: "https://landmarking.co.kr/server/pay_server_mobile.php?pg_pay_id="+merchant_uid+"&pg_service_type="+service_type+"&pg_pay_type="+pg_radio
                        +"&pg_service_price="+service_price+"&pg_user_email="+user_email+"&pg_user_name="+user_name+"&pg_user_phone="+user_phone+"&pg_land_id="+land_id
                        +"&pg_land_address="+land_address
                }, function(rsp) {
                    if ( rsp.success ) {

                        var msg = '결제가 완료되었습니다.';
                        msg += '\n고유ID : ' + rsp.imp_uid;
                        msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                        msg += '\n결제 금액 : ' + rsp.paid_amount+'원';
                        alert(msg);

                        $.ajax({
                            type: "POST"
                            ,url: "/server/pay_server.php"
                            ,data: {pg_pay_id:merchant_uid,pg_service_type:service_type,pg_pay_type:pg_radio,pg_service_price:service_price,pg_user_email:user_email
                                ,pg_user_name:user_name,pg_user_phone:user_phone,pg_land_id:land_id,pg_land_address:land_address}
                            ,success:function(result){
                                if(result=='success'){
                                    location.href="https://landmarking.co.kr/html/sub_mp_paid.php?merchant_uid="+merchant_uid;
                                }else{
                                    alert("결제 상품 요청에 실패하였습니다, 환불 요청 문의해주세요");
                                }
                            }
                            ,error:function(){
                                alert("잠시 후에 다시 시도해주세요");
                            }
                        });


                    } else {
                        var msg = '결제에 실패하였습니다.';
                        msg += '에러내용 : ' + rsp.error_msg;

                        alert(msg);
                    }
                });
            }



        }


    </script>

    </body>
    </html>
<?php } ?>