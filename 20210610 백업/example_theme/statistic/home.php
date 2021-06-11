<?php
session_start();

$admin = $_SESSION['ADMIN'];
if(!$admin){
    echo '<script>alert("허용되지 않은 접근입니다.")</script>';
    echo '<script>location.href=\'https://www.myluck.kr/\'</script>';
}


//데이터베이스 연결
include_once("/home/mydestiny/html/private/private_resource.php");

//연,월,일 별 상담건수, 사용자수, 도사수
$graph_counsel = $_GET['graph_counsel'];
if (!$graph_counsel) { $graph_counsel = 'day';}
$graph_user = $_GET['graph_user'];
if (!$graph_user) { $graph_user = 'day';}
$graph_dosa = $_GET['graph_dosa'];
if (!$graph_dosa) { $graph_dosa = 'day';}

/* 최근 1대1 문의글 */
$qry_string_qna = "SELECT * FROM qna where qna_writer_email is not null ORDER BY qna_date DESC limit 0,5";
$qry_qna = mysqli_query($connect, $qry_string_qna);
$count_qna = mysqli_num_rows($qry_qna);

if($count_qna>5){
    $count_qna=5;
}


$qna_number = array();
$qna_writer_email = array();
$qna_writer_nickname = array();
$qna_writer_type = array();
$qna_title = array();
$qna_date = array();
$qna_reply_status = array();

while ($row_qna = mysqli_fetch_array($qry_qna )) {
    array_push($qna_number, $row_qna['qna_number']);
    array_push($qna_writer_email, $row_qna['qna_writer_email']);
    array_push($qna_writer_nickname, $row_qna['qna_writer_nickname']);
    array_push($qna_writer_type, $row_qna['qna_writer_type']);
    array_push($qna_title, $row_qna['qna_title']);
    array_push($qna_date, date('Y.m.d', strtotime($row_qna['qna_date'])));
    array_push($qna_reply_status, $row_qna['qna_reply_status']);
}



/* 최근 리뷰글 */
$qry_string_review = "SELECT * FROM review where user_email is not null order by review_date desc limit 0,5";
$qry_review = mysqli_query($connect, $qry_string_review);
$count_review = mysqli_num_rows($qry_review);

if($count_review>5){
    $count_review=5;
}

$review_counsel_code = array();
$review_user_email = array();
$review_user_nickname = array();
$review_score = array();
$review_date = array();
$review_reply_status = array();

while ($row_review = mysqli_fetch_array($qry_review)) {
    array_push($review_counsel_code, $row_review['counsel_code']);
    array_push($review_user_email, $row_review['user_email']);
    array_push($review_user_nickname, $row_review['user_nickname']);
    array_push($review_score, $row_review['review_score']);
    array_push($review_date, date('Y.m.d', strtotime($row_review['review_date'])));
    array_push($review_reply_status, $row_review['review_reply_status']);
}


/* 일반상담 데이터 */
$qry_string_normal = "SELECT * FROM counsel_code where counsel_product_type IN ('1','2') order by counsel_date desc limit 0,5";
$qry_normal = mysqli_query($connect, $qry_string_normal);
$count_normal = mysqli_num_rows($qry_normal);

if($count_normal>5){
    $count_normal=5;
}

$normal_counsel_code = array();
$normal_counsel_product_type = array();
$normal_user_nickname  = array();
$normal_dosa_nickname  = array();
$normal_counsel_date = array();
$normal_counsel_status = array();
while ($row_normal = mysqli_fetch_array($qry_normal)) {
    array_push($normal_counsel_code, $row_normal['counsel_code']);
    array_push($normal_counsel_product_type, $row_normal['counsel_product_type']);
    array_push($normal_user_nickname, $row_normal['user_nickname']);
    array_push($normal_dosa_nickname, $row_normal['dosa_nickname']);
    array_push($normal_counsel_date, date('Y.m.d', strtotime($row_normal['counsel_date'])));
    array_push($normal_counsel_status, $row_normal['counsel_status']);
}

/* 5분 예약상담 데이터 */
$qry_string_short = "SELECT * FROM counsel_code where counsel_product_type='0' order by counsel_date desc limit 0,5";
$qry_short = mysqli_query($connect, $qry_string_short);
$count_short = mysqli_num_rows($qry_short);

if($count_short>5){
    $count_short=5;
}

$short_counsel_code = array();
$short_counsel_product_type = array();
$short_user_nickname  = array();
$short_dosa_nickname  = array();
$short_counsel_date = array();
$short_counsel_status = array();
while ($row_short = mysqli_fetch_array($qry_short)) {
    array_push($short_counsel_code, $row_short['counsel_code']);
    array_push($short_counsel_product_type, $row_short['counsel_product_type']);
    array_push($short_user_nickname, $row_short['user_nickname']);
    array_push($short_dosa_nickname, $row_short['dosa_nickname']);
    array_push($short_counsel_date, date('Y.m.d', strtotime($row_short['counsel_date'])));
    array_push($short_counsel_status, $row_short['counsel_status']);
}


////////////////////////////////////////////총 통계 분석 //////////////////////////////////////

// 총 사용자, 총상담가, 총 상담건수
$qry_string_user_count_total= "SELECT user_email FROM user_information where not user_status = '2'";
$qry_user_count_total = mysqli_query($connect, $qry_string_user_count_total);
$graph_user_count_total = mysqli_num_rows($qry_user_count_total);
$qry_string_dosa_count_total= "SELECT dosa_email FROM dosa_information where not dosa_status = '2'";
$qry_dosa_count_total = mysqli_query($connect, $qry_string_dosa_count_total);
$graph_dosa_count_total = mysqli_num_rows($qry_dosa_count_total);
$qry_string_counsel_count_total= "SELECT counsel_code FROM counsel_code where counsel_status is not null";
$qry_counsel_count_total = mysqli_query($connect, $qry_string_counsel_count_total);
$graph_counsel_count_total = mysqli_num_rows($qry_counsel_count_total);
//수수료율
$qry_string_commission= "SELECT * FROM admin_information";
$qry_commission = mysqli_query($connect, $qry_string_commission);
$row_commission = mysqli_fetch_array($qry_commission);

/////////////////////////////////////////////    오늘날짜, 내팔자야 서비스 시작 날짜    /////////////////////////////////////////////

$today_date = date( 'YmdHis', time());
$service_start_date = date( 'Ymd', strtotime('20201231'));


////////////////////////////////////////////  상담건수 연/월/일별 그래프 //////////////////////////////////////


if($graph_counsel=='day'){
    //일별 상담건수 (오늘 ~ 7일전까지)
    $counsel_code_day_date_array = array(); //일별 상담 날짜
    $counsel_code_day_count_array = array(); //일별 상담  수

    for($i=9; $i>=0; $i=$i-1)
    {
        //상담  날짜
        $counsel_code_day = date("Ymd", strtotime("-".$i." day", strtotime($today_date)));
        $date_counsel_code_day = date("m월 d일", strtotime("-".$i." day", strtotime($today_date)));
        //상담  수
        $qry_string_counsel_code_day = "SELECT * FROM counsel_code where counsel_date like '$counsel_code_day%'";
        $qry_counsel_code_day = mysqli_query($connect, $qry_string_counsel_code_day);
        $count_counsel_code_day = mysqli_num_rows($qry_counsel_code_day);

        array_push($counsel_code_day_date_array, $date_counsel_code_day);
        array_push($counsel_code_day_count_array, $count_counsel_code_day);
    }

}else if($graph_counsel=='month'){

    //월별 상담 가입 수 (이번달 ~ 작년 이번달까지)
    $counsel_code_month_date_array = array(); //월별 상담 날짜
    $counsel_code_month_count_array = array(); //월별 상담 수

    for($i=6; $i>=0; $i=$i-1)
    {
        //상담  달
        $counsel_code_month = date("Ym", strtotime("-".$i." month", strtotime($today_date)));
        $date_counsel_code_month = date("Y년 m월", strtotime("-".$i." month", strtotime($today_date)));
        //상담  수
        $qry_string_counsel_code_month = "SELECT * FROM counsel_code where counsel_date like '$counsel_code_month%'";
        $qry_counsel_code_month = mysqli_query($connect, $qry_string_counsel_code_month);
        $count_counsel_code_month = mysqli_num_rows($qry_counsel_code_month);

        array_push($counsel_code_month_date_array, $date_counsel_code_month);
        array_push($counsel_code_month_count_array, $count_counsel_code_month);

    }

}else if($graph_counsel=='year'){

    //연별 상담  수 (2020년 ~ 2024년)
    $counsel_code_year_date_array = array(); //연별 상담  날짜
    $counsel_code_year_count_array = array(); //연별 상담  수

    for($i=0; $i<=4; $i=$i+1)
    {
        //상담  년도
        $counsel_code_year = date("Y", strtotime("+".$i." year", strtotime($service_start_date)));
        $date_counsel_code_year = date("Y년", strtotime("+".$i." year", strtotime($service_start_date)));
        //상담 수
        $qry_string_counsel_code_year = "SELECT * FROM counsel_code where counsel_date like '$counsel_code_year%'";
        $qry_counsel_code_year = mysqli_query($connect, $qry_string_counsel_code_year);
        $count_counsel_code_year = mysqli_num_rows($qry_counsel_code_year);

        array_push($counsel_code_year_date_array, $date_counsel_code_year);
        array_push($counsel_code_year_count_array, $count_counsel_code_year);

    }
}


////////////////////////////////////////////  사용자 연/월/일별 그래프 //////////////////////////////////////


if($graph_user=='day'){
    //일별 사용자 가입 수 (오늘 ~ 14일전까지)
    $user_day_date_array = array(); //일별 사용자 가입 날짜
    $user_day_count_array = array(); //일별 사용자 가입 수

    for($i=6; $i>=0; $i=$i-1)
    {
        //가입 날짜
        $user_day = date("Ymd", strtotime("-".$i." day", strtotime($today_date)));
        $date_user_day = date("m.d", strtotime("-".$i." day", strtotime($today_date)));
        //가입 수
        $qry_string_user_day = "SELECT * FROM user_information where user_join_date like '$user_day%'";
        $qry_user_day = mysqli_query($connect, $qry_string_user_day);
        $count_user_day = mysqli_num_rows($qry_user_day);

        array_push($user_day_date_array, $date_user_day);
        array_push($user_day_count_array, $count_user_day);
    }

}else if($graph_user=='month'){

    //월별 사용자 가입 수 (이번달 ~ 작년 이번달까지)
    $user_month_date_array = array(); //월별 사용자 가입 날짜
    $user_month_count_array = array(); //월별 사용자 가입 수

    for($i=6; $i>=0; $i=$i-1)
    {
        //가입 달
        $user_month = date("Ym", strtotime("-".$i." month", strtotime($today_date)));
        $date_user_month = date("Y.m", strtotime("-".$i." month", strtotime($today_date)));
        //가입 수
        $qry_string_user_month = "SELECT * FROM user_information where user_join_date like '$user_month%'";
        $qry_user_month = mysqli_query($connect, $qry_string_user_month);
        $count_user_month = mysqli_num_rows($qry_user_month);

        array_push($user_month_date_array, $date_user_month);
        array_push($user_month_count_array, $count_user_month);

    }

}else if($graph_user=='year'){

    //연별 사용자 가입 수 (2020년 ~ 2024년)
    $user_year_date_array = array(); //연별 사용자 가입 날짜
    $user_year_count_array = array(); //연별 사용자 가입 수

    for($i=0; $i<=4; $i=$i+1)
    {
        //가입 년도
        $user_year = date("Y", strtotime("+".$i." year", strtotime($service_start_date)));
        $date_user_year = date("Y년", strtotime("+".$i." year", strtotime($service_start_date)));
        //가입 수
        $qry_string_user_year = "SELECT * FROM user_information where user_join_date like '$user_year%'";
        $qry_user_year = mysqli_query($connect, $qry_string_user_year);
        $count_user_year = mysqli_num_rows($qry_user_year);

        array_push($user_year_date_array, $date_user_year);
        array_push($user_year_count_array, $count_user_year);

    }
}


////////////////////////////////////////////  상담가 연/월/일별 그래프 //////////////////////////////////////


if($graph_dosa=='day'){
    //일별 사용자 가입 수 (오늘 ~ 7일전까지)
    $dosa_day_date_array = array(); //일별 상담가 가입 날짜
    $dosa_day_count_array = array(); //일별 상담가 가입 수

    for($i=6; $i>=0; $i=$i-1)
    {
        //가입 날짜
        $dosa_day = date("Ymd", strtotime("-".$i." day", strtotime($today_date)));
        $date_dosa_day = date("m.d", strtotime("-".$i." day", strtotime($today_date)));
        //가입 수
        $qry_string_dosa_day = "SELECT * FROM dosa_information where dosa_join_date like '$dosa_day%'";
        $qry_dosa_day = mysqli_query($connect, $qry_string_dosa_day);
        $count_dosa_day = mysqli_num_rows($qry_dosa_day);

        array_push($dosa_day_date_array, $date_dosa_day);
        array_push($dosa_day_count_array, $count_dosa_day);
    }

}else if($graph_dosa=='month'){

    //월별 상담가 가입 수 (이번달 ~ 작년 이번달까지)
    $dosa_month_date_array = array(); //월별 상담가 가입 날짜
    $dosa_month_count_array = array(); //월별 상담가 가입 수

    for($i=6; $i>=0; $i=$i-1)
    {
        //가입 달
        $dosa_month = date("Ym", strtotime("-".$i." month", strtotime($today_date)));
        $date_dosa_month = date("Y.m", strtotime("-".$i." month", strtotime($today_date)));
        //가입 수
        $qry_string_dosa_month = "SELECT * FROM dosa_information where dosa_join_date like '$dosa_month%'";
        $qry_dosa_month = mysqli_query($connect, $qry_string_dosa_month);
        $count_dosa_month = mysqli_num_rows($qry_dosa_month);

        array_push($dosa_month_date_array, $date_dosa_month);
        array_push($dosa_month_count_array, $count_dosa_month);

    }

}else if($graph_dosa=='year'){

    //연별 상담가 가입 수 (2020년 ~ 2024년)
    $dosa_year_date_array = array(); //연별 상담가 가입 날짜
    $dosa_year_count_array = array(); //연별 상담가 가입 수

    for($i=0; $i<=4; $i=$i+1)
    {
        //가입 년도
        $dosa_year = date("Y", strtotime("+".$i." year", strtotime($service_start_date)));
        $date_dosa_year = date("Y년", strtotime("+".$i." year", strtotime($service_start_date)));
        //가입 수
        $qry_string_dosa_year = "SELECT * FROM dosa_information where dosa_join_date like '$dosa_year%'";
        $qry_dosa_year = mysqli_query($connect, $qry_string_dosa_year);
        $count_dosa_year = mysqli_num_rows($qry_dosa_year);

        array_push($dosa_year_date_array, $date_dosa_year);
        array_push($dosa_year_count_array, $count_dosa_year);

    }
}




?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <meta charset="UTF-8">
    <title>내팔자야 - 관리자 페이지</title>
    <meta name="title" content="내팔자야 - 관리자 페이지"/>
    <meta name="description" content="재미로 보는 12가지 운세부터 신점/사주/타로 관련 '영상,음성 상담'까지 내팔자야"/>
    <meta name="og:locale" content="ko_KR"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://www.myluck.kr/"/>
    <meta property="og:locale" content="ko_KR"/>
    <!-- 홈페이지 아이콘 -->
    <link rel="shortcut icon" href="https://www.myluck.kr/admin/image/web_icon.png">

    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!--일간 상담 건수-->
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        var counsel_count='<?php echo $graph_counsel?>';

        if(counsel_count=='day'){
            graph_horizontal_counsel_text='일별 상담건수';
            var counsel_code_date = <?php echo json_encode($counsel_code_day_date_array) ?>;
            var counsel_code_count = <?php echo json_encode($counsel_code_day_count_array) ?>;
        }else if(counsel_count=='month'){
            graph_horizontal_counsel_text='월별 상담건수';
            var counsel_code_date = <?php echo json_encode($counsel_code_month_date_array) ?>;
            var counsel_code_count = <?php echo json_encode($counsel_code_month_count_array) ?>;
        }else{
            graph_horizontal_counsel_text='연별 상담건수';
            var counsel_code_date = <?php echo json_encode($counsel_code_year_date_array) ?>;
            var counsel_code_count = <?php echo json_encode($counsel_code_year_count_array) ?>;
        }





        function drawChart() {
            var data_counsel = new google.visualization.DataTable();
            data_counsel.addColumn('string', '일자');
            data_counsel.addColumn('number', graph_horizontal_counsel_text);
            for(var i=0; i<counsel_code_date.length; i++) {
                data_counsel.addRows([
                    [counsel_code_date[i] ,counsel_code_count[i]],
                ]);
            }
            var options_counsel = {
                curveType: 'function',
                width:885,
                height:460,
                animation: { //차트가 뿌려질때 실행될 애니메이션 효과
                    startup: true,
                    duration: 500,
                    easing: 'linear'},
                chartArea: {'width': '90%', 'height': '80%'},
                legend: { position: 'bottom' },
                colors: ['red'],
                vAxis: {maxValue:50,minValue:0}, //vAxis는 y축에 대한 옵션이다.
            };
            var chart_counsel = new google.visualization.LineChart(document.getElementById('counsel_count_chart'));
            chart_counsel.draw(data_counsel, options_counsel);
        }
    </script>


    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        var user_count='<?php echo $graph_user?>';

        if(user_count=='day'){
            graph_horizontal_user_text='일간 가입 수(사용자)';
            var user_date = <?php echo json_encode($user_day_date_array) ?>;
            var user_count = <?php echo json_encode($user_day_count_array) ?>;
        }else if(user_count=='month'){
            graph_horizontal_user_text='월간 가입 수(사용자)';
            var user_date = <?php echo json_encode($user_month_date_array) ?>;
            var user_count = <?php echo json_encode($user_month_count_array) ?>;
        }else{
            graph_horizontal_user_text='연간 가입 수(사용자)';
            var user_date = <?php echo json_encode($user_year_date_array) ?>;
            var user_count = <?php echo json_encode($user_year_count_array) ?>;
        }





        function drawBasic() {

            var data_user = new google.visualization.DataTable();
            data_user.addColumn('string', '일자');
            data_user.addColumn('number', graph_horizontal_user_text);
            for(var i=0; i<user_date.length; i++) {
                data_user.addRows([
                    [user_date[i] ,user_count[i]],
                ]);
            }
            var options_user = {
                width: 440,
                height: 200,
                animation: { //차트가 뿌려질때 실행될 애니메이션 효과
                    startup: true,
                    duration: 500,
                    easing: 'linear'},
                chartArea: {'width': '80%', 'height': '70%'},
                legend: { position: 'bottom' },
                colors: ['red'],
                vAxis: {maxValue:30,minValue:0}, //vAxis는 y축에 대한 옵션이다.
            };
            var chart_user = new google.visualization.ColumnChart(document.getElementById('user_count'));
            chart_user.draw(data_user, options_user);
        }
    </script>


    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        var dosa_count='<?php echo $graph_dosa?>';

        if(dosa_count=='day'){
            graph_horizontal_dosa_text='일간 가입 수(상담가)';
            var dosa_date = <?php echo json_encode($dosa_day_date_array) ?>;
            var dosa_count = <?php echo json_encode($dosa_day_count_array) ?>;
        }else if(dosa_count=='month'){
            graph_horizontal_dosa_text='월간 가입 수(상담가)';
            var dosa_date = <?php echo json_encode($dosa_month_date_array) ?>;
            var dosa_count = <?php echo json_encode($dosa_month_count_array) ?>;
        }else{
            graph_horizontal_dosa_text='연간 가입 수(상담가)';
            var dosa_date = <?php echo json_encode($dosa_year_date_array) ?>;
            var dosa_count = <?php echo json_encode($dosa_year_count_array) ?>;
        }




        function drawBasic() {

            var data_dosa = new google.visualization.DataTable();
            data_dosa.addColumn('string', '일자');
            data_dosa.addColumn('number', graph_horizontal_dosa_text);
            for(var i=0; i<dosa_date.length; i++) {
                data_dosa.addRows([
                    [dosa_date[i] ,dosa_count[i]],
                ]);
            }
            var options_dosa = {
                width: 440,
                height: 200,
                animation: { //차트가 뿌려질때 실행될 애니메이션 효과
                    startup: true,
                    duration: 500,
                    easing: 'linear'},
                chartArea: {'width': '80%', 'height': '70%'},
                legend: { position: 'bottom' },
                colors: ['red'],
                vAxis: {maxValue:30,minValue:0}, //vAxis는 y축에 대한 옵션이다.
            };
            var chart_dosa = new google.visualization.ColumnChart(document.getElementById('dosa_count'));
            chart_dosa.draw(data_dosa, options_dosa);
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body{ padding:0; margin:0; overflow:auto; }
        #global_layout{ float:left; }
        #contents_box{ float:left; width:calc(100% - 314px); min-height:calc(100vh - 55px); margin-top:55px; margin-left:314px; background-color:#FFFFFF; }
        #main_contents_box{ float:left; width:100%; height:100%; text-align:center; }
        #main_contents_box_place{ margin-left: 50px; width:1420px; }
        #main_contents_box_place_title{ width: 100%; height: 30px; margin-top: 30px; margin-bottom: 14.5px; font-size: 20px; font-weight: bold; text-align: left;color: #2C3B5F; }
        #main_contents_box_place_title_line {margin-bottom: 30px; width: 100%; height: 3px; background-color: #2C3B5F; display: inline-block;}

        .home_graph_box{margin-bottom:30px; margin-left: 10px; width: calc(100% - 14px); height: 650px; border: 2px solid #ddd; float: left;}
        .home_graph_box_total{width: 100%; height: 78px; float: left; border-bottom: 2px solid #ddd;}
        .home_graph_box_total_box{margin-top:10px;margin-left:25px; width: 120px; height: 60px; float: left;}
        .home_graph_box_total_box_text{width: 100%; float: left; font-size: 18px; font-weight: bold;color: #2C3B5F;}
        .home_graph_box_total_box_count{margin-top:10px;width: 100%; float: left;font-size: 16px; font-weight: bold;color: #2C3B5F;}
        .home_graph_box_total_box_payment{margin-top:10px;margin-right:5px; width: 500px; height: 60px;float: right;}
        .home_graph_box_total_box_payment_text{float: left;margin-top: 5px; font-size: 13px; color: grey;}

        .home_graph_box_left{width: 65%; height: 570px; float: left;}
        .home_graph_box_left_box{width: 100%; height: 50px; margin-top: 10px; float: left;}
        .home_graph_box_left_box_text{margin-top: 15px;margin-left: 25px; font-size: 18px;color: #2C3B5F; font-weight: bold;float: left; }
        .home_graph_box_left_chart_box{width:885px; height:400px; margin-left: 25px; float: left;}
        .home_graph_box_left_chart_loading{margin-top:150px;width:50px; height: 50px;}

        .home_graph_box_middle{width: 2px; height: 570px; float: left; background-color: #ddd}
        .home_graph_box_right{width: calc(35% - 2px); height: 570px; float: left;}
        .home_graph_box_right_box{width: 100%; height: 70px; margin-top: 10px; float: left;}
        .home_graph_box_right_box_text{margin-top: 15px;margin-left: 25px; font-size: 18px;color: #2C3B5F; font-weight: bold;float: left; }
        .home_graph_box_right_chart_box{width:440px;height:198px; margin-left:25px; float: left;}
        .home_graph_box_right_chart_loading{margin-top:75px;width:50px; height: 50px;}

        .graph_select {width: 150px;padding: 5px;background: url(https://farm1.staticflickr.com/379/19928272501_4ef877c265_t.jpg) no-repeat 95% 50%;-webkit-appearance: none;-moz-appearance: none;appearance: none;border: none;font-size: 14px;}
        .graph_select::-ms-expand {display: none;}

        #home_table_box{margin-bottom:30px; margin-left: 10px; width: calc(50% - 14px); height: 300px; border: 2px solid #ddd; float: left;}
        #home_table_box_title{width: 100%; height: 50px; float: left;}
        #home_table_box_title_span{margin: 25px; font-size: 18px;color: #2C3B5F; font-weight: bold;float: left; }
        #home_table_box_title_plus_span{margin: 30px; font-size: 13px; color:grey; font-weight: bold; float: right; cursor: pointer;}




        /*테이블*/
        #main_contents_box_place_table {margin:20px; width: calc(100% - 40px);display: inline-block; }
        #destiny_table {border-collapse: collapse;width: 100%; font-size: 12px;}
        #destiny_table td, #destiny_table th {border: 1px solid #d0d2d5;padding: 8px;}
        #destiny_table th {padding-top: 8px;padding-bottom: 8px;text-align: center;background-color: #f2f3f5;color: black;}
        #main_contents_box_place_pagination {margin-bottom:20px; width: 100%; height: 30px;  float: left;}
        #none_data_table {width: calc(100% - 2px); padding-top: 40px;  padding-bottom: 40px; border-left: 1px solid #d0d2d5; border-right: 1px solid #d0d2d5; border-bottom: 1px solid #d0d2d5;}
        #none_data_table_span {font-size: 12px; font-weight: bold;}
        #destiny_table_move_detail {cursor: pointer; }
        #destiny_table_move_detail:hover {font-weight: bolder;}
        #destiny_click_table {cursor: pointer; }
        #destiny_click_table:hover { background-color: #f7f7f7;}

        select:focus {outline:none; font-family: 'Malgun Gothic';}


        /* 모달 */
        .modal {display:none;position: fixed;z-index: 1;padding-top: 300px;padding-left: 100px;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);}
        .modal_content {background-color: #fefefe;margin: auto;border: 1px solid #888;width: 300px;}
        .close {color: #000000;float: right;font-size: 20px;font-weight: bold;margin-right: 8px;}
        .close:hover,
        .close:focus {color: #000;text-decoration: none;cursor: pointer;}
        #modal_content_head{width:100%; height:30px;background-color:#f2f3f5;}
        #modal_content_head_span{margin-left:10px; margin-top:5px; float: left; font-weight: bold; font-size: 14px;}
        #modal_content_full_change_button{float: right;margin-right:30px; width: 60px; height: 25px;background-color: #2C3B5F; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color: white; text-align: center; line-height: 25px; cursor: pointer;}
        #modal_content_full_cancel_button{float: right;margin-right:10px; width: 60px; height: 25px;background-color: white; border:1px solid  #2C3B5F; font-weight: bold; font-size: 12px; color:  #2C3B5F; text-align: center; line-height: 25px; cursor: pointer;}


        /* 버튼*/
        .home_button {float: left; margin-top: 2px;margin-left:15px; width: 77px; height: 24px;background-color:  grey; border:1px solid  grey; font-weight: bold; font-size: 13px; color:  white; text-align: center; line-height: 24px; cursor: pointer;}



    </style>
</head>
<body>
<div id="global_layout"></div>
<div id="contents_box">
    <div id="main_contents_box">
        <div id="main_contents_box_place">
            <div id="main_contents_box_place_title">대시보드</div>
            <div id="main_contents_box_place_title_line"></div>

            <div class='home_graph_box'>
                <div class='home_graph_box_total'>
                    <div class='home_graph_box_total_box'>
                        <span class='home_graph_box_total_box_text'>총 사용자 수</span>
                        <span class='home_graph_box_total_box_count'><?php echo $graph_user_count_total?></span>
                    </div>
                    <div class='home_graph_box_total_box'>
                        <span class='home_graph_box_total_box_text'>총 상담가 수</span>
                        <span class='home_graph_box_total_box_count'><?php echo $graph_dosa_count_total?></span>
                    </div>
                    <div class='home_graph_box_total_box'>
                        <span class='home_graph_box_total_box_text'>총 상담 건수</span>
                        <span class='home_graph_box_total_box_count'><?php echo $graph_counsel_count_total?></span>
                    </div>
                    <div class='home_graph_box_total_box_payment' >
                        <span class='home_graph_box_total_box_payment_text' >현재 내팔자야의 수수료율은 <?php echo $row_commission['commission']?>%입니다. </span>
                        <div class="home_button" onclick="change_commission()">변경하기</div>
                        <span class='home_graph_box_total_box_payment_text' >아임포트 관리자 모드(http://admin.iamport.kr/) 상세한 매출 내역 </span>
                        <div class="home_button" onclick="open_import()">바로가기</div>
                    </div>
                </div>
                <div class='home_graph_box_left'>
                    <div class='home_graph_box_left_box'>
                        <span class='home_graph_box_left_box_text'>상담 건수 통계</span>
                        <select id="counsel_count_graph_select" class="graph_select" onchange="counsel_graph_change()" style="margin-top: 15px; margin-right: 50px; border: 2px solid #d0d2d5; float: right;" >
                            <?php if($graph_counsel=='day'){  ?>
                                <option selected>일간 상담 수</option>
                                <option>월간 상담 수</option>
                                <option>연간 상담 수</option>
                            <?php   }else if($graph_counsel=='month'){  ?>
                                <option>일간 상담 수</option>
                                <option selected>월간 상담 수</option>
                                <option>연간 상담 수</option>
                            <?php   }else{  ?>
                                <option>일간 상담 수</option>
                                <option>월간 상담 수</option>
                                <option selected>연간 상담 수</option>
                            <?php   } ?>
                        </select>
                    </div>
                    <div id="counsel_count_chart" class='home_graph_box_left_chart_box'>
                        <img class='home_graph_box_left_chart_loading' src="/admin/image/Rolling-1s-200px.gif">
                        <br>
                        <span style="font-size: 16px; font-weight: bold;">상담 건수를 분석 중입니다...</span>
                    </div>
                </div>
                <div class='home_graph_box_middle'>
                </div>
                <div class='home_graph_box_right'>
                    <div class='home_graph_box_right_box'>
                        <span class='home_graph_box_right_box_text'>사용자 가입 통계</span>
                        <select id="user_count_graph_select" class="graph_select"  onchange="user_graph_change()" style="margin-top: 15px; margin-right: 20px; border: 2px solid #d0d2d5; float: right;">
                            <?php if($graph_user=='day'){  ?>
                                <option selected>일간 가입 수</option>
                                <option>월간 가입 수</option>
                                <option>연간 가입 수</option>
                            <?php   }else if($graph_user=='month'){  ?>
                                <option>일간 가입 수</option>
                                <option selected>월간 가입 수</option>
                                <option>연간 가입 수</option>
                            <?php   }else{  ?>
                                <option>일간 가입 수</option>
                                <option>월간 가입 수</option>
                                <option selected>연간 가입 수</option>
                            <?php   } ?>
                        </select>
                    </div>
                    <div id="user_count" class='home_graph_box_right_chart_box' >
                        <img class='home_graph_box_right_chart_loading' src="/admin/image/Rolling-1s-200px.gif">
                        <br>
                        <span style="font-size: 14px; font-weight: bold;">사용자 수를 분석 중입니다...</span>
                    </div>

                    <div class='home_graph_box_right_box'>
                        <span class='home_graph_box_right_box_text'>상담자 가입 통계</span>
                        <select id="dosa_count_graph_select" class="graph_select" onchange="dosa_graph_change()"  style="margin-top: 15px; margin-right: 20px; border: 2px solid #d0d2d5; float: right;">
                            <?php if($graph_dosa=='day'){  ?>
                                <option selected>일간 가입 수</option>
                                <option>월간 가입 수</option>
                                <option>연간 가입 수</option>
                            <?php   }else if($graph_dosa=='month'){  ?>
                                <option>일간 가입 수</option>
                                <option selected>월간 가입 수</option>
                                <option>연간 가입 수</option>
                            <?php   }else{  ?>
                                <option>일간 가입 수</option>
                                <option>월간 가입 수</option>
                                <option selected>연간 가입 수</option>
                            <?php   } ?>
                        </select>
                    </div>
                    <div id="dosa_count" class='home_graph_box_right_chart_box'>
                        <img class='home_graph_box_right_chart_loading' src="/admin/image/Rolling-1s-200px.gif">
                        <br>
                        <span style="font-size: 14px; font-weight: bold;">상담자 수를 분석 중입니다...</span>
                    </div>
                </div>


            </div>



            <div id='home_table_box'>
                <div id='home_table_box_title'>
                    <span id="home_table_box_title_span"> 최근 1:1 문의 </span>
                    <span id="home_table_box_title_plus_span" onclick="location.href='/admin/theme/cs/qna_list.php'"> 더보기+ </span>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if($count_review==0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="8%">분류</th>
                                <th width="12%">이메일</th>
                                <th width="10%">닉네임</th>
                                <th width="15%">문의제목</th>
                                <th width="8%">문의일시</th>
                                <th width="8%">답변여부</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">최근 1대1 문의 글이 존재하지 않습니다</span></div>
                    <?php }else{ ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="8%">분류</th>
                                <th width="12%">이메일</th>
                                <th width="10%">닉네임</th>
                                <th width="15%">문의제목</th>
                                <th width="8%">문의일시</th>
                                <th width="8%">답변여부</th>
                            </tr>
                            <?php for ($x = 0; $x < $count_qna ; $x++) { ?>
                                <tr id='destiny_click_table' onclick="location.href='/admin/theme/cs/qna_detail.php?qna_number=<?php echo $qna_number[$x]?>'">
                                    <td><?php
                                        if($qna_writer_type[$x]==0){
                                            echo '사용자';
                                        }else{
                                            echo '상담가';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $qna_writer_email_short=$qna_writer_email[$x];
                                        $qna_writer_email_length= mb_strlen($qna_writer_email[$x],'utf-8');
                                        if($qna_writer_email_length>20){ 
                                            $qna_writer_email_long = mb_substr($qna_writer_email[$x], 0, 19,'utf-8');
                                            echo $qna_writer_email_long.'...';
                                        }else{ 
                                            echo $qna_writer_email_short;
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $qna_writer_nickname_short=$qna_writer_nickname[$x];
                                        $qna_writer_nickname_length= mb_strlen($qna_writer_nickname[$x],'utf-8');
                                        if($qna_writer_nickname_length>7){ 
                                            $qna_writer_nickname_long = mb_substr($qna_writer_nickname[$x], 0, 6,'utf-8');
                                            echo $qna_writer_nickname_long.'...';
                                        }else{ 
                                            echo $qna_writer_nickname_short;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $qna_title_short=$qna_title[$x];
                                        $qna_title_length= mb_strlen($qna_title[$x],'utf-8');
                                        if($qna_title_length>10){ // 데이터의 내용이 10자보다 길 경우
                                            $qna_title_long = mb_substr($qna_title[$x], 0, 9,'utf-8');
                                            echo $qna_title_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $qna_title_short;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $qna_date[$x] ?></td>
                                    <?php if($qna_reply_status[$x]==0){ ?>
                                        <td style="color: red; font-weight: bold">미답변</td>
                                    <?php  }else if($qna_reply_status[$x]==1){ ?>
                                        <td style="color: #2C3B5F; font-weight: bold">답변완료</td>
                                    <?php }?>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>
            </div>



            <div id='home_table_box'>
                <div id='home_table_box_title'>
                    <span id="home_table_box_title_span"> 최근 리뷰글 </span>
                    <span id="home_table_box_title_plus_span" onclick="location.href='/admin/theme/cs/review_list.php'"> 더보기+ </span>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if($count_review==0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="7%">상담코드</th>
                                <th width="12%">작성가 이메일</th>
                                <th width="10%">작성가 닉네임</th>
                                <th width="7%">리뷰평점</th>
                                <th width="8%">작성날짜</th>
                                <th width="8%">답변상태</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">최근 리뷰 글이 존재하지 않습니다</span></div>
                    <?php }else{ ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="7%">상담코드</th>
                                <th width="12%">작성가 이메일</th>
                                <th width="10%">작성가 닉네임</th>
                                <th width="7%">리뷰평점</th>
                                <th width="8%">작성날짜</th>
                                <th width="8%">답변상태</th>
                            </tr>
                            <?php for ($x = 0; $x < $count_review; $x++) { ?>
                                <tr id='destiny_click_table' onclick="location.href='/admin/theme/cs/review_detail.php?counsel_code=<?php echo $review_counsel_code[$x]?>'">
                                    <td><?php echo $review_counsel_code[$x] ?></td>
                                    <td><?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $review_user_email_short=$review_user_email[$x];
                                        $review_user_email_length= mb_strlen($review_user_email[$x],'utf-8');
                                        if($review_user_email_length>20){ // 데이터의 내용이 10자보다 길 경우
                                            $review_user_email_long = mb_substr($review_user_email[$x], 0, 19,'utf-8');
                                            echo $review_user_email_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $review_user_email_short;
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $review_user_nickname_short=$review_user_nickname[$x];
                                        $review_user_nickname_length= mb_strlen($review_user_nickname[$x],'utf-8');
                                        if($review_user_nickname_length>7){ // 데이터의 내용이 10자보다 길 경우
                                            $review_user_nickname_long = mb_substr($review_user_nickname[$x], 0, 6,'utf-8');
                                            echo $review_user_nickname_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $review_user_nickname_short;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $review_score[$x] ?></td>
                                    <td><?php echo $review_date[$x] ?></td>
                                    <?php if($review_reply_status[$x]==0){ ?>
                                        <td style="color: red; font-weight: bold">미답변</td>
                                    <?php  }else if($review_reply_status[$x]==1){ ?>
                                        <td style="color: #2C3B5F; font-weight: bold">답변완료</td>
                                    <?php }?>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>
            </div>

            <div id='home_table_box'>
                <div id='home_table_box_title'>
                    <span id="home_table_box_title_span"> 최근 일반상담 내역 </span>
                    <span id="home_table_box_title_plus_span" onclick="location.href='/admin/theme/app/counsel_data_list.php'"> 더보기+ </span>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if($count_normal==0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="8%">상담코드</th>
                                <th width="8%">상담유형</th>
                                <th width="12%">상담가 닉네임</th>
                                <th width="12%">유저 닉네임</th>
                                <th width="8%">상담날짜</th>
                                <th width="8%">상담상태</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">최근 일반상담 내역이 존재하지 않습니다</span></div>
                    <?php }else{ ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="8%">상담코드</th>
                                <th width="8%">상담유형</th>
                                <th width="12%">상담가 닉네임</th>
                                <th width="12%">유저 닉네임</th>
                                <th width="8%">상담날짜</th>
                                <th width="8%">상담상태</th>
                            </tr>
                            <?php for ($x = 0; $x < $count_normal; $x++) { ?>
                                <tr id='destiny_click_table' onclick="location.href='/admin/theme/app/counsel_data_detail.php?counsel_code=<?php echo $normal_counsel_code[$x]?>'">
                                    <td><?php echo $normal_counsel_code[$x] ?></td>
                                    <?php if($normal_counsel_product_type[$x]=='0'){ ?>
                                        <td>예약상담</td>
                                    <?php  }else if($normal_counsel_product_type[$x]=='1'){ ?>
                                        <td>음성상담</td>
                                    <?php }else { ?>
                                        <td>화상상담</td>
                                    <?php } ?>
                                    <td> <?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $normal_dosa_nickname_short=$normal_dosa_nickname[$x];
                                        $normal_dosa_nickname_length= mb_strlen($normal_dosa_nickname[$x],'utf-8');
                                        if($normal_dosa_nickname_length>7){ // 데이터의 내용이 10자보다 길 경우
                                            $normal_dosa_nickname_long = mb_substr($normal_dosa_nickname[$x], 0, 6,'utf-8');
                                            echo $normal_dosa_nickname_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $normal_dosa_nickname_short;
                                        }
                                        ?>
                                    </td>
                                    <td> <?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $normal_user_nickname_short=$normal_user_nickname[$x];
                                        $normal_user_nickname_length= mb_strlen($normal_user_nickname[$x],'utf-8');
                                        if($normal_user_nickname_length>7){ // 데이터의 내용이 10자보다 길 경우
                                            $normal_user_nickname_long = mb_substr($normal_user_nickname[$x], 0, 6,'utf-8');
                                            echo $normal_user_nickname_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $normal_user_nickname_short;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $normal_counsel_date[$x] ?></td>
                                    <?php if($normal_counsel_status[$x]==null){ ?>
                                        <td style="color: red; font-weight: bold">미연결</td>
                                    <?php }else if($normal_counsel_status[$x]==0){ ?>
                                        <td style="color: red; font-weight: bold">실패</td>
                                    <?php  }else if($normal_counsel_status[$x]==1){ ?>
                                        <td style="color: black; font-weight: bold">성공</td>
                                    <?php }?>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>
            </div>

            <div id='home_table_box' style="margin-bottom: 150px;">
                <div id='home_table_box_title'>
                    <span id="home_table_box_title_span"> 최근 5분 예약상담 내역 </span>
                    <span id="home_table_box_title_plus_span" onclick="location.href='/admin/theme/app/counsel_data_list.php'"> 더보기+ </span>
                </div>

                <div id="main_contents_box_place_table">

                    <?php if($count_short==0) { ?>
                        <table id="destiny_table">
                            <tr>
                                <th width="8%">상담코드</th>
                                <th width="8%">상담유형</th>
                                <th width="12%">상담가 닉네임</th>
                                <th width="12%">유저 닉네임</th>
                                <th width="8%">상담날짜</th>
                                <th width="8%">상담상태</th>
                            </tr>
                        </table>
                        <div id="none_data_table"><span id="none_data_table_span">최근 일반상담 내역이 존재하지 않습니다</span></div>
                    <?php }else{ ?>

                        <table id="destiny_table">
                            <tr>
                                <th width="8%">상담코드</th>
                                <th width="8%">상담유형</th>
                                <th width="12%">상담가 닉네임</th>
                                <th width="12%">유저 닉네임</th>
                                <th width="8%">상담날짜</th>
                                <th width="8%">상담상태</th>
                            </tr>
                            <?php for ($x = 0; $x < $count_short; $x++) { ?>
                                <tr id='destiny_click_table' onclick="location.href='/admin/theme/app/counsel_data_detail.php?counsel_code=<?php echo $short_counsel_code[$x]?>'">
                                    <td><?php echo $short_counsel_code[$x] ?></td>
                                    <?php if($short_counsel_product_type[$x]=='0'){ ?>
                                        <td>예약상담</td>
                                    <?php  }else if($short_counsel_product_type[$x]=='1'){ ?>
                                        <td>음성상담</td>
                                    <?php }else { ?>
                                        <td>화상상담</td>
                                    <?php } ?>
                                    <td>
                                        <?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $short_dosa_nickname_short=$short_dosa_nickname[$x];
                                        $short_dosa_nickname_length= mb_strlen($short_dosa_nickname[$x],'utf-8');
                                        if($short_dosa_nickname_length>7){ // 데이터의 내용이 10자보다 길 경우
                                            $short_dosa_nickname_long = mb_substr($short_dosa_nickname[$x], 0, 6,'utf-8');
                                            echo $short_dosa_nickname_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $short_dosa_nickname_short;
                                        }
                                        ?>
                                    </td>
                                    <td> <?php
                                        //문자열이 깨질경우 sudo apt-get install php-mbstring 명령어를 통해 mb_string 모듈 설치
                                        //내용의 길이
                                        $short_user_nickname_short=$short_user_nickname[$x];
                                        $short_user_nickname_length= mb_strlen($short_user_nickname[$x],'utf-8');
                                        if($short_user_nickname_length>7){ // 데이터의 내용이 10자보다 길 경우
                                            $short_user_nickname_long = mb_substr($short_user_nickname[$x], 0, 6,'utf-8');
                                            echo $short_user_nickname_long.'...';
                                        }else{ // 데이터의 내용이 20자보다 짧을 경우
                                            echo $short_user_nickname_short;
                                        }
                                        ?> </td>
                                    <td><?php echo $short_counsel_date[$x] ?></td>
                                    <?php if($short_counsel_status[$x]==null){ ?>
                                        <td style="color: red; font-weight: bold">미연결</td>
                                    <?php }else if($short_counsel_status[$x]==0){ ?>
                                        <td style="color: red; font-weight: bold">실패</td>
                                    <?php  }else if($short_counsel_status[$x]==1){ ?>
                                        <td style="color: black; font-weight: bold">성공</td>
                                    <?php }?>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal_content">
                    <div id="modal_content_head">
                        <span id="modal_content_head_span">수수료 변경</span> <span class="close">&times;</span>
                    </div>
                    <div style="width: 100%; height: 70px;">
                        <div style="width: 30%; height: 70px;float: left;">
                            <span style="margin-top:20px;font-size: 14px; font-weight: bold; display: inline-block;">수수료</span>
                        </div>
                        <div style="width:70%; height: 70px;float: left;">
                            <select id='commission_select'  style="margin-top:17px;width: 180px; height: 28px;display: inline-block;float: left;">
                                    <option>5%</option>
                                    <option>10%</option>
                                    <option>15%</option>
                                    <option>20%</option>
                                    <option>25%</option>
                                    <option>30%</option>
                                    <option>35%</option>
                                    <option>40%</option>
                            </select>
                        </div>
                    </div>
                    <div style="width: 100%; height: 40px;">
                        <div id='modal_content_full_change_button' onclick="change_commission_okay()">변경</div>
                        <div id='modal_content_full_cancel_button' onclick="change_commission_cancel()">취소</div>
                    </div>
                </div>

            </div>



        </div>
    </div>
</div>
<div id="footer_contents"></div>
</body>

<script>
    /* 공통 레이아웃 load */
    $("#global_layout").load("/admin/theme/_layout.php");
    $("#footer_contents").load("/admin/theme/_footer.php");


    // 상담 건수
    function counsel_graph_change() {
        var counsel_count = document.getElementById("counsel_count_graph_select");
        var counsel_count_status = counsel_count.options[counsel_count.selectedIndex].text;

        if (counsel_count_status == '일간 상담 수') {
            //alert('일간 상담 수');
            location.href = "home.php?graph_counsel=day&graph_user=<?php echo $graph_user?>"+"&graph_dosa=<?php echo $graph_dosa?>";
        } else if (counsel_count_status == '월간 상담 수') {
            //alert('월간 상담 수');
            location.href ="home.php?graph_counsel=month&graph_user=<?php echo $graph_user?>"+"&graph_dosa=<?php echo $graph_dosa?>";
        } else {
            //alert('연간 상담 수');
            location.href = "home.php?graph_counsel=year&graph_user=<?php echo $graph_user?>"+"&graph_dosa=<?php echo $graph_dosa?>";
        }
    }

    // 사용자 가입 수
    function user_graph_change() {
        var user_count = document.getElementById("user_count_graph_select");
        var user_count_status = user_count.options[user_count.selectedIndex].text;

        if (user_count_status == '일간 가입 수') {
            //alert('일간 가입 수(사용자)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=day&graph_dosa=<?php echo $graph_dosa?>";
        } else if (user_count_status == '월간 가입 수') {
            //alert('월간 가입 수(사용자)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=month&graph_dosa=<?php echo $graph_dosa?>";
        } else {
            //alert('연간 가입 수(사용자)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=year&graph_dosa=<?php echo $graph_dosa?>";
        }
    }


    // 상담가 가입 수
    function dosa_graph_change() {
        var dosa_count = document.getElementById("dosa_count_graph_select");
        var dosa_count_status = dosa_count.options[dosa_count.selectedIndex].text;

        if (dosa_count_status == '일간 가입 수') {
            //alert('일간 가입 수(상담가)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=<?php echo $graph_user?>&graph_dosa=day";
        } else if (dosa_count_status == '월간 가입 수') {
            //alert('월간 가입 수(상담가)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=<?php echo $graph_user?>&graph_dosa=month";
        } else {
            //alert('연간 가입 수(상담가)');
            location.href = "home.php?graph_counsel=<?php echo $graph_counsel?>"+"&graph_user=<?php echo $graph_user?>&graph_dosa=year";
        }
    }


    /* 수수료 변경 자바 스크립트*/

    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function change_commission(){
        modal.style.display = "block";
    }
    function change_commission_okay(){
        var commission_select = $("#commission_select option:selected").text();
        commission_select = commission_select.replace('%', '');
        commission_select = Number(commission_select);
        $.ajax({
            type: "POST"
            ,url: "/admin/server/commission_change.php"
            ,data: {commission:commission_select}
            ,success:function(result){
                if(result=='success'){
                    alert('수수료 변경을 완료했습니다');
                    location.reload();
                }else{
                    alert("수수료 변경에 실패하였습니다. 다시한번 시도해주세요");
                    location.reload();
                }
            }
            ,error:function(){
                alert("잠시 후에 다시 시도해주세요");
            }
        });
    }
    function change_commission_cancel(){
        modal.style.display = "none";
    }


    function open_import(){
        window.open("http://admin.iamport.kr/", "아임포트 관리자페이지", "width=800, height=700, toolbar=no, menubar=no, scrollbars=no, resizable=yes" );
    }


    window.onload = function(){
        change_layout_design();
    };

    function change_layout_design(){
        setTimeout(function() {
            var text = document.getElementById("layout_left_statistic_menu_dashboard");
            if(text){
                text.style.color="#f80000";
                text.style.fontWeight="bold";
            }else{
                change_layout_design();
            }
        }, 10);
    }


</script>

</html>