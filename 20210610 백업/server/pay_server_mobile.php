<?php
error_reporting(0);
session_start();


//데이터베이스 연결
include_once("/home/client/web/private_resource/dbconnection.php");

//url 연결
include_once("/home/client/web/private_resource/land_url.php");

//웹 버전에서는 결제 정보(imp_uid)를 직접 다룰 수 있지만, 모바일 버전에서는 그렇지 못하다.
//모바일 버전에서는 결제가 끝난 후에 리다이렉트 되는 페이지의 url에서 결제 정보(imp_uid)를 볼 수 있다.
//예를 들어, 파라미터 값으로 m_redirect_url : 'http://aaaa/bbbb/cccc' 를 줬다면
//리다이렉트 되는 페이지의 url은 'http://aaaa/bbbb/cccc?imp_uid={imp_uid}&merchant_uid={merchant_uid}&imp_success={true/false}' 가 된다.
//For example, if m_redirect_url is 'http://aaaa/bbbb/cccc' then the redirect page's url is 'http://aaaa/bbbb/cccc?imp_uid={imp_uid}&merchant_uid={merchant_uid}&imp_success={true/false}'.
//따라서 리다이렉트 url를 파싱하거나 get 으로 받을 수 있는 url을 m_redirect_url의 파라미터로 넣어서 결제 정보를 다뤄야 하겠다.

//결제 성공/실패 변수
$pg_imp_success = $_GET['imp_success'];
//GET 값 전달 받기 (결제상품 ID, 결제상품 종류, 결제종류, 결제가격, 아이디, 이름, 전화번호, 토지아이디, 토지 주소)
$pg_pay_id = $_GET['pg_pay_id'];
$pg_service_type = $_GET['pg_service_type'];
$pg_pay_type = $_GET['pg_pay_type'];
$pg_service_price = $_GET['pg_service_price'];
$pg_user_email = $_GET['pg_user_email'];
$pg_user_name = $_GET['pg_user_name'];
$pg_user_phone = $_GET['pg_user_phone'];
$pg_land_id = $_GET['pg_land_id'];
$pg_land_address = $_GET['pg_land_address'];
$pg_land_x = $_GET['pg_land_x'];
$pg_land_y = $_GET['pg_land_y'];
$pg_pay_date = date( 'YmdHis', time());

//이동할 페이지
$pg_complete_url = "https://landmarking.co.kr/html/sub_mp_paid.php?merchant_uid=".$pg_pay_id;

if($pg_imp_success=='true'){


    if($pg_service_type=='0'){ // 단순 등록대행

        //토지 등록 대행이므로 토지 아이디 생성 필요
        //토지 아이디 생성 (임의의 알파벳 8자리)
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pg_land_id =implode($pass);

        //결제 정보 테이블에 값 삽입
        $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date, service_status)
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date','2')";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){

            //등록 대행 시 -> 토지 정보 테이블에도 토지 등록
            //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
            $qry_string_land = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date,land_agent_status)
                 VALUES ('$pg_land_id','$pg_land_address','$pg_land_x','$pg_land_y','$pg_user_email','$pg_user_name','$pg_user_phone'
                 ,'등록 대행','0','0','등록 대행','https://landmarking.co.kr/land_image/land_default.png','$pg_pay_date','1')";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if($qry_land){

                $qry_string_chart="INSERT INTO chart_information (land_id, value_1,value_2,value_3,value_4,value_5,dev_1,dev_2,sub_1,sub_2,pre_1,pre_2)
                                VALUES ('$pg_land_id','5','5','5','5','5','5','5','5','5','5','5')";
                $qry_chart = mysqli_query($connect, $qry_string_chart);


                if($qry_chart){
                    echo "<meta http-equiv='refresh' content='0; url=$pg_complete_url'>";
                }else{
                    echo 'fail';
                }

            }else{
                echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다1');location.href='https://landmarking.co.kr/'</script>";

            }

        }else{
            echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다2');location.href='https://landmarking.co.kr/'</script>";

        }

    }else if($pg_service_type=='1' || $pg_service_type=='2'){ // 전화 분석 or 방문 분석 일 경우

        //결제 정보 테이블에 값 삽입
        $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date, service_status)
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date','2')";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){

            //전화 분석 or 방문 분석일 경우 토지의 상태값도 변경 필요
            //해당 토지 아이디의 유료분석 상태값 변경
            $qry_string_land = "update land_information set land_cost_analysis_status='1' where land_id='$pg_land_id'";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if($qry_land){
                echo "<meta http-equiv='refresh' content='0; url=$pg_complete_url'>";
            }else{
                echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다3');location.href='https://landmarking.co.kr/'</script>";

            }

        }else{

            echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다4');location.href='https://landmarking.co.kr/'</script>";
        }

    }else if($pg_service_type=='3' || $pg_service_type=='4'){ //등록 + 분석인 경우

        //토지 등록 대행이므로 토지 아이디 생성 필요
        //토지 아이디 생성 (임의의 알파벳 8자리)
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pg_land_id =implode($pass);

        //결제 정보 테이블에 값 삽입
        $qry_string = "INSERT INTO pay_information (pay_id, service_type, pay_type, pay_price, buyer_id, buyer_name, buyer_phone, land_id, land_address, pay_date, service_status)
                 VALUES ('$pg_pay_id','$pg_service_type','$pg_pay_type','$pg_service_price','$pg_user_email','$pg_user_name','$pg_user_phone','$pg_land_id','$pg_land_address', '$pg_pay_date','2')";
        $qry = mysqli_query($connect, $qry_string);

        if($qry){

            //등록 대행 시 -> 토지 정보 테이블에도 토지 등록
            //land_information 테이블에 저장할 토지아이디, 지번 주소, 좌표, 작성자 이름/번호, 토지등록제목, 토지면적, 토지 가격, 토지등록내용, 토지 대표이미지, 토지등록 날짜
            $qry_string_land = "INSERT INTO land_information (land_id, land_address, land_x, land_y, land_register_id, land_register_name, land_register_phone,
                    land_register_title,land_register_area,land_register_price,land_register_content,land_main_image,land_register_date,land_agent_status)
                 VALUES ('$pg_land_id','$pg_land_address','$pg_land_x','$pg_land_y','$pg_user_email','$pg_user_name','$pg_user_phone'
                 ,'등록 대행','0','0','등록 대행','https://landmarking.co.kr/land_image/land_default.png','$pg_pay_date','1')";
            $qry_land = mysqli_query($connect, $qry_string_land);

            if($qry_land){

                //전화 분석 or 방문 분석일 경우 토지의 상태값도 변경 필요
                //해당 토지 아이디의 유료분석 상태값 변경
                $qry_string_land_update = "update land_information set land_cost_analysis_status='1' where land_id='$pg_land_id'";
                $qry_land_update = mysqli_query($connect, $qry_string_land_update);

                if($qry_land_update){

                    $qry_string_chart="INSERT INTO chart_information (land_id, value_1,value_2,value_3,value_4,value_5,dev_1,dev_2,sub_1,sub_2,pre_1,pre_2)
                                VALUES ('$pg_land_id','5','5','5','5','5','5','5','5','5','5','5')";
                    $qry_chart = mysqli_query($connect, $qry_string_chart);


                    if($qry_chart){
                        echo "<meta http-equiv='refresh' content='0; url=$pg_complete_url'>";
                    }else{
                        echo 'fail';
                    }
                    
                }else{
                    echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다5');location.href='https://landmarking.co.kr/'</script>";

                }

            }else{



                echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다6');location.href='https://landmarking.co.kr/'</script>";

            }

        }else{
            echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다7');location.href='https://landmarking.co.kr/'</script>";

        }


    }else{
        echo "<script>alert('결제 요청에 실패하셨습니다. 환불 요청 문의 바랍니다8');location.href='https://landmarking.co.kr/'</script>";
    }

}else{
    echo "<script>alert('결제 취소하셨습니다.');location.href='https://landmarking.co.kr/'</script>";
}




mysqli_close($connect)

?>