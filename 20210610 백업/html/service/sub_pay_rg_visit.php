<?php
//등록 대행 구매 페이지
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

    $qry_string_user = "SELECT * FROM user_information where user_email='$user_session'";
    $qry_user = mysqli_query($connect, $qry_string_user);
    $row_user = mysqli_fetch_array($qry_user);
    $total_row_user = mysqli_num_rows($qry_user);
    //상품 가격
    $service_price=320000;
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
    <!--네이버 지도 API 이용-->
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=egcozauon9&submodules=geocoder"></script>
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
                            <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b">등록대행</span></h2>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="container service-box">
                    <div class="inner">
                        <div class="title-wrap">
                            <h2 class="title">등록 대행</h2>
                            <p class="desc">
                                <span>토지를 등록했다면 꼭 필요한 심층분석! 랜드마킹이 도와드립니다.</span>
                                <br>
                                <span>전화를 통해 간편하지만 심층적인 상담을, 방문을 통해 가장 심층적인 상담을 받을 수 있습니다.</span>
                            </p>
                            <div class="img_area">
                                <img src="../../images/sub/img_service02.png" alt="전문분석대행">
                            </div>
                        </div>
                        <div class="form">
                            <p class="tit">등록 + 방문 분석</p>
                            <fieldset>
                                <label for="addr">주소지 기입</label>
                                <input type="text" id="rg_addr" required placeholder="도로명 또는 지번 주소를 입력하고 구매해 주세요.">
                                <p class="info warn">
                                    <i class="icon"></i>
                                    입력한 주소지를 통해 진행 되므로 정확한 정보를 기입해 주시기 바랍니다.
                                </p>
                                <p class="info warn">
                                    <i class="icon"></i>
                                    입력한 주소지가 잘못되어 분석에 오류가 생길 경우, 환불 또는 재분석 되지 않습니다.                    
                                </p>
                                <p class="info warn">
                                    <i class="icon"></i>
                                    국내 주소지에 대해서만 진행 가능합니다
                                </p>
                            </fieldset>
                            <div class="btn-wrap">
                                <button class="btn btn_sm bx-round_s bg_v" onclick="rg_search()">입력한 주소지로 구매하기</button>
                            </div>
                        </div>
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
<!-- 토지 등록 시 작동하는 네이버 지도 API 스크립트 -->
<script>

    IMP.init('imp33197231');

    var merchant_uid = 'merchant_rg_visit' + new Date().getTime();
    var service_type = '<?php echo '4'?>';
    var service_price = '<?php echo $service_price?>';
    var user_email = '<?php echo $row_user['user_email']?>';
    var user_name = '<?php echo $row_user['user_name']?>';
    var user_phone = '<?php echo $row_user['user_phone']?>';
    var user_phone_dash = user_phone.substr(0, 3) + "-" + user_phone.substr(3, 4) + "-" + user_phone.substr(7,4);
    var land_id = '';
    var pg_radio  = '';
    var land_address = '';
    var land_x = '';
    var land_y = '';

    //중단 검색 함수
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
        //카드 결제 or 실시간 계좌이체 값 가져오기
        pg_radio = $('input[name="pg"]:checked').val();


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

                if (item.jibunAddress) {

                    land_address = item.jibunAddress;
                    land_x = item.x;
                    land_y = item.y;

                    pg_service()

                } else if (item.roadAddress) {

                    land_address = item.roadAddress;
                    land_x = item.x;
                    land_y = item.y;

                    pg_service()

                } else {
                    alert('도로명이나 지번주소를 정확히 입력해주세요');
                }
            }
        });
    }


    function pg_service() {
        IMP.request_pay({
            pg : 'inicis', //ActiveX 결제창은 inicis를 사용
            pay_method : pg_radio, //card(신용카드), trans(실시간계좌이체), vbank(가상계좌), phone(휴대폰소액결제)
            merchant_uid : merchant_uid, //상점에서 관리하시는 고유 주문번호를 전달
            name : '랜드마킹 : 등록 + 방문분석',
            amount : service_price,
            buyer_email : user_email,
            buyer_name : user_name,
            buyer_tel : user_phone_dash, //누락되면 이니시스 결제창에서 오류
            m_redirect_url: "https://landmarking.co.kr/server/pay_server_mobile.php?pg_pay_id="+merchant_uid+"&pg_service_type="+service_type+"&pg_pay_type="+pg_radio
                +"&pg_service_price="+service_price+"&pg_user_email="+user_email+"&pg_user_name="+user_name+"&pg_user_phone="+user_phone+"&pg_land_id="+land_id
                +"&pg_land_address="+land_address+"&pg_land_x="+land_x+"&pg_land_y="+land_y
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
                        ,pg_user_name:user_name,pg_user_phone:user_phone,pg_land_id:land_id,pg_land_address:land_address,pg_land_x:land_x,pg_land_y:land_y}
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

</script>
</body>
</html>
<?php } ?>