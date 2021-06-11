<!--푸터 페이지-->
<div class="container">
    <div class="inner">
        <div class="f-top">
            <div class="inner">
                <p class="row01 ft_b_s">최고의 토지 거래를 원하시나요?</p>
                <p class="row02">랜드마킹의 토지 분석은<br>전국 최고 수준입니다.</p>
                <a href="/html/land/sub_rg_search.php" class="row03 l-box bg_w bx-round_xs">토지 등록하기</a>
            </div>
        </div>
        <div class="f-mid l-inline clear">
            <div class="col02 l-inline">
                <div class="f-util-wrap l-inline">
                    <p class="f-tit ft_b_s">서비스 소개</p>
                    <div class="l-slide-wrap">
                        <ul>
                            <li><a class="btn_pop" data-popup="inform_register">토지 직접 등록</a></li>
                            <li><a class="btn_pop" data-popup="service_rg01">토지 등록 대행</a></li>
                            <li><a class="btn_pop" data-popup="inform_analysis">무료 분석</a></li>
                            <li><a class="btn_pop" data-popup="service_an01">전문 분석</a></li>
                            <li><a href="/html/sub_service.php#sTotal">종합 분석</a></li>
                            <li><a href="/html/sub_service_map.php">오시는 길</a></li>
                            <li><a href="/html/mypage/sub_notice.php">공지사항</a></li>
                        </ul>
                    </div>
                </div>
                <div class="f-util-wrap l-inline">
                    <p class="f-tit ft_b_s">토지</p>
                    <div class="l-slide-wrap">
                        <ul>
                            <li><a href="/html/sub_list_master.php">마스터 추천 토지</a></li>
                            <li><a href="/html/sub_list.php">등록된 토지</a></li>
                        </ul>
                    </div>
                </div>
                <div class="f-util-wrap l-inline">
                    <p class="f-tit ft_b_s">약관</p>
                    <div class="l-slide-wrap">
                        <ul>
                            <li><a href="/html/sub_term.php">이용약관</a></li>
                            <li><a href="/html/sub_privacy.php">개인정보처리방침</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="f-btm">
            <div class="inner">
                <div class="info-wrap ft_m_m">
                    <p class="f-tit ft_b_s">주식회사 알에이에스</p>
                    <ul>
                        <li class="f-info">대표 : 최영준</li>
                        <li class="f-info l-inline">사업자등록번호 : 809-86-01924</li>
                        <li class="f-info l-inline bar">통신판매업 신고번호 : 제 2021-대구중구-0434 호</li>
                        <li class="f-info">주소 : (41951)대구광역시 중구 달구벌대로 2204, 2층 (대봉동)</li>
                        <li class="f-info l-inline">고객센터 : 053-269-5094</li>
                        <li class="f-info l-inline bar">contact@landmaster.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="f-copy-wrap clear">
            <span class="copyright">&copy;LANDMARKING</span>
            <span class="f-logo"><img src="/images/common/icon_foot_logo.svg" alt="토지"></span>
        </div>
    </div>
</div>
<!-- 팝업 스크립트 -->
<script>
    function popupFn(){
        var $popBtn = $('.btn_pop'),
            $popup = $('.popup'),
            $closeBtn = $popup.find('.btn_close, .btn_accept .btn_cancel'); //아이디,비번 체크 팝업창

        $popBtn.on('click',function(event){
            event.preventDefault();
            //팝업 열기
            var $targetData = $(this).data("popup");
            var $targetPop = $(`.popup[data-popup=${$targetData}]`);
            $targetPop.addClass('on');
            //배경 처리
            var $contentHeight = $targetPop.find('.container').outerHeight();
            if($contentHeight > $(window).innerHeight()) $targetPop.find('.dim').css('height', $contentHeight + 80);
            //팝업 position
            $popup.css({'top' : ($(window).height() - $popup.outerHeight()) / 2 + $(window).scrollTop() +"px"});
            //스크롤 방지
            var $wraps = document.querySelectorAll('html, body');
            $wraps.forEach(function(el){
                el.setAttribute('style', 'overflow: hidden; height: 100%;');
                el.addEventListener('scroll touchmove mousewheel', function(event){
                    event.preventDefault();
                }, {passive:false} );
            });
        });

        $closeBtn.on('click', function(event){
            event.preventDefault();
            $popup.removeClass('on');
            var $wraps = document.querySelectorAll('html, body');
            $wraps.forEach(function(el){
                el.setAttribute('style', 'overflow: auto; height: auto;');
                el.removeEventListener('scroll touchmove mousewheel', function(event){
                    event.preventDefault();
                });
            });
        });

    }popupFn();
</script>