<?php
session_start();
$admin_session = $_SESSION['admin_session'];

//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

$session_url = "https://landmarking.co.kr/admin/html/login.php";

//유저 정보 조회
$pay_id = $_GET['id'];

$qry_string_pay = "SELECT * FROM pay_information where pay_id='$pay_id'";
$qry_pay = mysqli_query($connect, $qry_string_pay);
$row_pay = mysqli_fetch_array($qry_pay);
$total_row_pay = mysqli_num_rows($qry_pay);

//세션이 없을 경우 로그인 페이지 로드
if (!$admin_session) {
    echo "<script>alert('로그인을 해주세요')</script>";
    echo "<meta http-equiv='refresh' content='0; url=$session_url'>";
} else if ($total_row_pay < 1) {
    echo "<script>alert('잘못된 접근입니다');history.back();</script>";
} else {

    function format_phone($phone)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $length = strlen($phone);

        switch ($length) {
            case 11 :
                return preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $phone);
                break;
            case 10:
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
                break;
            default :
                return $phone;
                break;
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <div class="popup popup-pay pay-form">
            <div class="container">
                <div class="inner">
                PG사 상세 결제 정보 변경창
                    <br><br><br>
                <div class="table-area">
                    <table class="table">
                        <thead class="thead">
                            <tr class= "tr">
                                <th class="th t-id">아이디</th>
                                <th class="th t-sort">결제유형</th>
                                <th class="th t-name">결제상품</th>
                                <th class="th t-price">결제금액</th>
                                <th class="th t-status">결제상황</th>
                                <th class="th t-date">결제일</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr class="tr">
                                <td class="td t-id"><span class="value"><?php echo $row_pay['buyer_id'] ?></span>
                                </td>
                                <td class="td t-sort">
                                                <span class="value">
                                                    <?php if ($row_pay['pay_type'] == 'card') { ?>
                                                        신용카드
                                                    <?php } else { ?>
                                                        계좌이체
                                                    <?php } ?>
                                                </span></td>
                                <td class="td t-name">
                                                <span class="value">
                                                <?php if ($row_pay['service_type'] == '0') { ?>
                                                    등록 대행
                                                <?php } else if($row_pay['service_type'] == '1') { ?>
                                                    전화 분석
                                                <?php }  else if($row_pay['service_type'] == '2') { ?>
                                                    방문 분석
                                                <?php }  else if($row_pay['service_type'] == '3') { ?>
                                                    등록 + 전화 분석
                                                <?php }  else if($row_pay['service_type'] == '4') { ?>
                                                    등록 + 방문 분석
                                                <?php } ?>

                                                </span></td>
                                <td class="td t-price"><span
                                            class="value"><?php echo number_format($row_pay['pay_price']) . '원' ?></span>
                                </td>
                                <td class="td t-status" onClick="event.cancelBubble=true; return false;">
                                    <form onsubmit="return false;">
                                        <fieldset class="select-box is-table">

                                            <?php if($row_pay['pay_status']=='0'){?>
                                                <input type="text" class="select" value="결제완료" onfocus="this.blur();" readonly >
                                                <div class="options"  id="pay_status_option">
                                                    <span class="option is-selected" data-option="결제완료">결제완료</span>
                                                    <span class="option" data-option="환불요청">환불요청</span>
                                                    <span class="option" data-option="환불완료">환불완료</span>
                                                </div>
                                            <?php }else if($row_pay['pay_status']=='1'){  ?>
                                                <input type="text" class="select" value="환불요청" onfocus="this.blur();" readonly >
                                                <div class="options"  id="pay_status_option">
                                                    <span class="option" data-option="결제완료">결제완료</span>
                                                    <span class="option is-selected" data-option="환불요청">환불요청</span>
                                                    <span class="option" data-option="환불완료">환불완료</span>
                                                </div>
                                            <?php }else{ ?>
                                                <input type="text" class="select" value="환불완료" onfocus="this.blur();" readonly >
                                                <div class="options"  id="pay_status_option">
                                                    <span class="option" data-option="결제완료">결제완료</span>
                                                    <span class="option" data-option="환불요청">환불요청</span>
                                                    <span class="option is-selected" data-option="환불완료">환불완료</span>
                                                </div>
                                            <?php }?>

                                        </fieldset>
                                    </form>
                                </td>
                                <td class="td t-date"><span class="value"><?php echo date('Y.m.d H:i', strtotime($row_pay['pay_date'])) ?></span>
                                </td>



                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-wrap">
                        <button type="button" class="btn btn_cancel" onClick="javascript:window.close()">닫기</button>
                        <button type="button" class="btn btn_sm" onclick="pay_status_update()">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>

    function pay_status_update() {

        var rg_pay_id = '<?php echo $pay_id;?>';

        var pay_status_search =  $('#pay_status_option').children(".is-selected").text();
        var rg_pay_status;
        if(pay_status_search=='결제완료'){
            rg_pay_status='0';
        }else if(pay_status_search=='환불요청'){
            rg_pay_status='1';
        }else if(pay_status_search=='환불완료'){
            rg_pay_status='2';
        }
        


        $.ajax({
            type: "POST"
            , url: "/admin_server/pay_server.php"
            , data: {type:'update', pay_id: rg_pay_id, pay_status: rg_pay_status}
            , success: function (result) {

                if (result == 'success') {
                    alert("결제 상태를 수정하였습니다");
                    opener.parent.location.reload();
                    window.close();
                } else {
                    alert("결제 상태에 실패하였습니다, 잠시 후에 다시 시도해주세요");
                }
            }
            , error: function () {
                alert("잠시 후에 다시 시도해주세요");
            }
        });


    }


    //셀렉트박스 커스텀
    function selectBoxFn(){

    var select = document.querySelectorAll('.select');
    var $currentSelect; //현재 열린 셀렉트박스

    var onSelectFn = function(event){
        event.preventDefault();
        if(event.target.classList.contains('on')) offSelectFn(event.target);
        else {
            if($currentSelect) offSelectFn($currentSelect);
            event.target.classList.add('on');
            $currentSelect = event.target;
            onOptionFn(event.target);
            // 외부 클릭 시 해제
            window.addEventListener('click', quitSelectBoxFn);
        }

    };

    var offSelectFn = function(targetSelect){
      targetSelect.classList.remove('on');
      $currentSelect = null;  
    };

    var onOptionFn = function(selectNode){
        var select = selectNode;
            options = select.nextElementSibling,
            option = options.querySelectorAll('.option');

        option.forEach(function(el){
            el.addEventListener('click', function(e){
                e.preventDefault();

                var newValue = e.target.getAttribute('data-option');
                var oldValue = select.getAttribute('value');
                var selectTxt = '[data-option="' + oldValue + '"]';

                if(oldValue.length > 0) options.querySelector(selectTxt).classList.remove('is-selected');
                e.target.classList.add('is-selected');

                //selection
                select.setAttribute('value', newValue);
                select.innerText = newValue;
                offSelectFn($currentSelect);

                //외부클릭시 닫기 FN 해제
                window.removeEventListener('click', quitSelectBoxFn);
            })
        });
    };

    //셀렉트 박스 외부 클릭시 해제
    var quitSelectBoxFn = function(event){
        event.preventDefault();
        if($currentSelect === event.target) return false;
        else {
            offSelectFn($currentSelect);
            window.removeEventListener('click', quitSelectBoxFn);
            console.log('quitSelect');
        }
    }
    
    select.forEach(function(el){
        el.addEventListener('click', onSelectFn);
    });
    
    }selectBoxFn();
</script>
</html>

<?php } ?>