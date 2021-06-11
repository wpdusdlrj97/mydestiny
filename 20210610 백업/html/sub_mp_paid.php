<?php
//결제 완료 페이지
session_start();
$user_session = $_SESSION['user_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");
//url 연결
include_once("/home/client/web/private_resource/land_url.php");
$session_url = $land_url . "/html/account/sub_acc_login.php";
$merchant_uid = $_GET['merchant_uid'];

$qry_string_pay = "SELECT * FROM pay_information where pay_id='$merchant_uid'";
$qry_pay = mysqli_query($connect, $qry_string_pay);
$row_pay = mysqli_fetch_array($qry_pay);
$total_row_pay = mysqli_num_rows($qry_pay);

//세션이 없을 경우 로그인 페이지 로드
if(!$user_session){
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
}else if($total_row_pay<1){
    echo "<script>alert('잘못된 접근입니다');location.href='https://landmarking.co.kr/'</script>";
}
else{

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
    <meta property="og:image" content="../images/common/icon_logo01.png">
    <meta property="og:title" content="랜드마킹">
    <meta property="og:site_name" content="랜드마킹">
    <meta property="og:description" content="토지 중개 플랫폼 랜드마킹">
    <meta property="og:locale" content="ko_KR">
    <title>랜드마킹</title>
    <!-- FAVICON-->

    <!-- STYLE LINK-->
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/main.css" >

    <!-- SCRIPT -->
    <script src="../js/lib/jquery-3.6.0.min.js"></script>
    <!--[if lte IE 9]>
    <script src="../js/lib/IE9.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="../js/lib/html5shiv.min.js"></script>
    <script src="../js/lib/jqPIE.js"></script>
    <script src="../js/lib/PIE.js"></script>
    <![endif]-->
</head>
<body>
<div id="popup"></div>
<div id="wrap" class="sub mp_paid">
    <header id="header"></header>
    <main id="main">
        <div class="main-title">
            <div class="container">
                <div class="inner">
                    <div class="tit">
                        <i class="tit-icon icon_pencil bx-round_l"></i>
                        <h2 class="tit-wrap l-inlinebox"><span class="tit ft_b">
                                <?php if($row_pay['pay_status']=='0'){ ?>
                                    결제내역
                                <?php }else{ ?>
                                    환불내역
                                <?php  } ?>
                            </span></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="inner">
                    <div class="inform-box">
                        <div class="wrap">
                            <i class="icon_smile"></i>

                            <?php if($row_pay['pay_status']=='0'){ ?>
                                <p>
                                    결제가 완료되었습니다.
                                    <br>
                                    결제 해 주셔서 감사합니다.
                                </p>
                            <?php }else if($row_pay['pay_status']=='1'){ ?>
                                <p>
                                    환불 요청이 접수되었습니다.
                                    <br>
                                    조금만 기다려 주세요.
                                </p>
                            <?php }else if($row_pay['pay_status']=='2'){ ?>
                                <p>
                                    환불이 완료되었습니다.
                                    <br>
                                    이용해 주셔서 감사합니다.
                                </p>
                            <?php  } ?>

                        </div>
                    </div>
                    <table>
                        <thead>
                        <tr>
                            <th>구매항목</th>
                            <th>상품명</th>
                            <th>가격</th>
                            <th>구매일</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php if($row_pay['service_type']=='0'){ ?>
                                <td>등록대행</td>
                                <td>기본</td>
                            <?php }else if($row_pay['service_type']=='1') { ?>
                                <td>전문분석</td>
                                <td>전화</td>
                            <?php }else if($row_pay['service_type']=='2') { ?>
                                <td>전문분석</td>
                                <td>방문</td>
                            <?php }else if($row_pay['service_type']=='3') { ?>
                                <td>등록대행</td>
                                <td>기본 + 전화</td>
                            <?php }else if($row_pay['service_type']=='4') { ?>
                                <td>등록대행</td>
                                <td>기본 + 방문</td>
                            <?php } ?>
                            <td><?php echo number_format($row_pay['pay_price'])?>원</td>
                            <td><?php echo date('Y년 m월 d일', strtotime($row_pay['pay_date'])) ?></td>
                        </tr>
                        </tbody>
                    </table>
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
</body>
</html>
<?php } ?>