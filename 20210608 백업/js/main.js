;(function($){

    /* ====== [헤더] ====== */
    function headerFn(){
        var $header = $('#header'),
            $hHeader = $('.home #header'),
            $gnb = $header.find('.menu-wrap'),
            $gnbBtn = $('#header #navBtn');

        // 모바일 모드 전환
        $(window).on('load resize', function (event){
            event.preventDefault();
            if($(window).innerWidth() <= 890){
                if(!$header.hasClass('mobile')) $header.addClass('mobile');
            }else {
                if($header.hasClass('mobile')) $header.removeClass('mobile');

                if($gnb.hasClass('on')) $gnb.removeClass('on');
                if($gnbBtn.hasClass('on')) $gnbBtn.removeClass('on');
            };
        });

        // [홈 헤더] 스크롤
        $(window).scroll(function(event){
            event.preventDefault();
            if($(this).scrollTop() >= 200) $hHeader.addClass('scroll');
            else $hHeader.removeClass('scroll');
        });

        // depth메뉴 보기
        $gnbBtn.on('click', function (event){
            event.preventDefault();
            $(this).toggleClass('on');
            $gnb.toggleClass('on');
            console.log('aaaa')
        });

    }headerFn();


    /* ====== 이미지 조정 ====== */
    window.addEventListener("load", handleImgSize);
    window.addEventListener("resize", handleImgSize);

    function handleImgSize(){

        //매물 리스트 : card-img,
        //분석페이지, 토지목록, 문의사항 목록: thumbnail, slide
        var $imgWrap = document.querySelectorAll('.card-img, .thumbnail, .an-card .slide');

        $imgWrap.forEach(function(el){
            if(el.childElementCount <= 0) return;
            var $wrapW = el.clientWidth,
                $wrapH = el.clientHeight,
                $img = el.querySelector('img'),
                $imgW = $img.naturalWidth,
                $imgH = $img.naturalHeight;

            var $ratio = $wrapW / $imgW; //css상으로 조정된 이미지 너비 비율
            var $resizedH = $ratio*$imgH; //css 상으로 조정된 이미지 높이 계산

            if($resizedH - $wrapH > 0){
                //이미지 높이가 다 찼을 경우 : 세로 중앙 정렬
                var $moveY = ($resizedH - $wrapH)/2;
                $img.style.transform = 'translateY(-' + $moveY + 'px)';
            }else {
                //이미지 높이가 부족할 경우 : 높이 100% + 부족한 높이 만큼 너비 확대 + 가로 중앙 정렬
                var $gapRatio = ($wrapH - $resizedH) / $resizedH;
                var $resizedW = $wrapW + ($wrapW * $gapRatio);
                var $moveX = ($resizedW - $wrapW)/2;
                $img.style.height = $wrapH + 'px';
                $img.style.width = $resizedW + 'px';
                $img.style.transform = 'translateX(-' + $moveX + 'px)';
            }
        });
    }

     /* ====== 메인 비주얼 슬라이드 ====== */
    function visualSlideFn(){

        var $mainVisual = $('.main-visual'),
            $slideWrap = $mainVisual.find('.slide-wrap'),
            $slide = $slideWrap.find('.slide');

        var $slideLength,
            $slideWrapWidth,
            $slideWrapCenter;

        var intervalSlide;

        //슬라이드 이벤트 생성
        var initSlide = function(){
            $slide = $slideWrap.find('.slide');
            $slide.first().before($slide.last().clone());
            $slide.last().after($slide.first().clone());
            $slideLength = $slideWrap.find('.slide').length;

            $slideWrapWidth = ($slide.eq(0).outerWidth(true) * $slideLength);
            $slideWrap.css({'width': $slideWrapWidth});

            setSlideCenter();
        };


        //슬라이드 포지션
        var setSlideCenter = function(){
            $slideWrapCenter = ($slideWrapWidth - $(window).innerWidth())/2 ;
            $slideWrap.css({'left': '-'+$slideWrapCenter+'px'});
        };

        //슬라이드 버튼 이벤트
        var setSlideBtns = function(){

            var $prevBtn = $mainVisual.find('.btn_prev'),
                $nextBtn = $mainVisual.find('.btn_next');

            $prevBtn.click(function(event){
                event.preventDefault();
                clearInterval(intervalSlide);
                shiftToLeft();
                autoSlideFn();
            });
            $nextBtn.click(function(event){
                event.preventDefault();
                clearInterval(intervalSlide);
                shiftToRight();
                autoSlideFn();
            });
        };

        //슬라이드 오른쪽으로 밀기
        var shiftToRight = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : -$slideWrapCenter + $slide.innerWidth() + 'px'});
            $slide.first().detach();

            $slideWrap.stop().animate({
                'left': -$slideWrapCenter + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.last().after($slide.eq(1).clone());
        };

        //슬라이드 왼쪽으로 밀기
        var shiftToLeft = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : -$slideWrapCenter - $slide.innerWidth() + 'px'});
            $slide.last().detach();

            $slideWrap.stop().animate({
                'left': -$slideWrapCenter + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.first().before($slide.eq($slide.length -2).clone());

        };

        //오토 슬라이드
        function autoSlideFn() {
            intervalSlide = setInterval(function(){
                shiftToRight();
            },3000);
        };

        $(window).on('load', function(event){
            event.preventDefault();
            initSlide();
            setSlideBtns();
            autoSlideFn();
        });

        $(window).on('resize', function(event) {
            event.preventDefault();
            setSlideCenter();
        });

    }visualSlideFn();

    /* ====== 메인 비주얼 슬라이드 ====== */
    function visualSlideFn(){

        var $mainVisual = $('.main-visual'),
            $slideWrap = $mainVisual.find('.slide-wrap'),
            $slide = $slideWrap.find('.slide');

        var $slideLength,
            $slideWrapWidth,
            $slideWrapCenter;

        var intervalSlide;

        //슬라이드 이벤트 생성
        var initSlide = function(){
            $slide = $slideWrap.find('.slide');
            $slide.first().before($slide.last().clone());
            $slide.last().after($slide.first().clone());
            $slideLength = $slideWrap.find('.slide').length;

            $slideWrapWidth = ($slide.eq(0).outerWidth(true) * $slideLength);
            $slideWrap.css({'width': $slideWrapWidth});

            setSlideCenter();
        };


        //슬라이드 포지션
        var setSlideCenter = function(){
            $slideWrapCenter = ($slideWrapWidth - $(window).innerWidth())/2 ;
            $slideWrap.css({'left': '-'+$slideWrapCenter+'px'});
        };

        //슬라이드 버튼 이벤트
        var setSlideBtns = function(){

            var $prevBtn = $mainVisual.find('.btn_prev'),
                $nextBtn = $mainVisual.find('.btn_next');

            $prevBtn.click(function(event){
                event.preventDefault();
                clearInterval(intervalSlide);
                shiftToLeft();
                autoSlideFn();
            });
            $nextBtn.click(function(event){
                event.preventDefault();
                clearInterval(intervalSlide);
                shiftToRight();
                autoSlideFn();
            });
        };

        //슬라이드 오른쪽으로 밀기
        var shiftToRight = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : -$slideWrapCenter + $slide.innerWidth() + 'px'});
            $slide.first().detach();

            $slideWrap.stop().animate({
                'left': -$slideWrapCenter + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.last().after($slide.eq(1).clone());
        };

        //슬라이드 왼쪽으로 밀기
        var shiftToLeft = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : -$slideWrapCenter - $slide.innerWidth() + 'px'});
            $slide.last().detach();

            $slideWrap.stop().animate({
                'left': -$slideWrapCenter + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.first().before($slide.eq($slide.length -2).clone());

        };

        //오토 슬라이드
        function autoSlideFn() {
            intervalSlide = setInterval(function(){
                shiftToRight();
            },3000);
        };

        $(window).on('load', function(event){
            event.preventDefault();
            initSlide();
            setSlideBtns();
            autoSlideFn();
        });

        $(window).on('resize', function(event) {
            event.preventDefault();
            setSlideCenter();
        });

    }visualSlideFn();

    /* ====== [계정] 입력폼  ====== */
    function accountInputFn(){

        var $accInput = $('.signup form').not('.completed').find('input');
        var $accPwdBtn = $('.signup form .pwdBtns');

        $accInput.on({
            keyup: function(event){
                event.preventDefault();
                $(this).parent('.bx-input').addClass('typing');
            },
            focusout: function(event){
                event.preventDefault();
                if($accPwdBtn.has(event.target).length !== 0) {
                    $(this).focus();
                    return;
                }
                $(this).parent('.bx-input').removeClass('typing');
            },
        });

        //비밀번호
        $accPwdBtn.find('.btn_closed').on('click', function(event){
            event.preventDefault();
            $(this).parent('.pwdBtns').prev().attr('type', 'text');
            $(this).parent('.pwdBtns').addClass('unlock');

        });
        $accPwdBtn.find('.btn_open').on('click', function(event){
            event.preventDefault();
            $(this).parent('.pwdBtns').prev().attr('type', 'password');
            $(this).parent('.pwdBtns').removeClass('unlock');
        });

    }accountInputFn();

    /* ====== [마이페이지 목록] 펼쳐보기 ======= */
    function myFaqListFn(){

        var $myFaqList = $('.mp_faq .mylist li');

        $myFaqList.click(function(event){
            event.preventDefault();
            if($(event.target).is($('.file > a'))) return;
            $(this).toggleClass('show');
        });

    }myFaqListFn();

    /* ====== [마이페이지 등록] 글자수 ======= */
    function registerFormTxtFn(){
        var $registerTitle = $('.rg-form #title'),
            $numTxt = $registerTitle.next('.cnt').find('.value');
            $len = 0;

        $registerTitle.on('keyup', function(event){
            event.preventDefault();
            $len = $(this).val().length;
            $numTxt.text($len);
        });


    }registerFormTxtFn();


    /* ====== [공지사항] 펼쳐보기 ======= */
    function useTermsFn(){

        $('.notice .btn').on('click',function(event){
            event.preventDefault();
            $(this).parent().find('.wrap').slideToggle();
            $(this).toggleClass('on');
        });

    }useTermsFn();

    /* ====== [약관 탭] 선택 보기 ======= */
    function tabTermsFn(){
        var $tabBtns = $('.sub-terms .btn_tab');
        var $terms = $('.sub-terms .terms');

        $tabBtns.on('click',function(event){
            event.preventDefault();
            if($(this).hasClass('on')) return;
            else {
                $tabBtns.removeClass('on');
                $(this).addClass('on');
                $terms.removeClass('on');
                $terms.eq($(this).index()).addClass('on');
            }
        })
    }tabTermsFn();


     /* ====== [푸터] 유틸메뉴 ======= */
    function footerFn(){
        var $fUtilMenu = $('#footer .f-util-wrap');
            $fUtilSlide = $fUtilMenu.find('.l-slide-wrap');

        $fUtilMenu.find('.f-tit').on('click', function(event){
            event.preventDefault();
            if($(this).parent().hasClass('on')) {
                $fUtilMenu.removeClass('on');
            }
            else {
                $fUtilMenu.removeClass('on');
                $(this).parent().addClass('on');
            }
        });

    }footerFn();

    /* ====== [팝업] ======= */
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

    /* ====== [팝업] 확대보기 슬라이드 ======= */
    function zoomSlideFn(){

        var $popupZoom = $('.popup-zoom'),
            $slideWrap = $popupZoom.find('.slide-wrap'),
            $slide = $popupZoom.find('.slide');

        var $slideLength,
            $slideWidth,
            $slideHeight,
            $slideWrapWidth;

        var setSlideNum = function(){
            var len = $slide.length;
            var cnt = 1;
            var $slideNum,
                $num,
                $nums;
            for(var i = 0; i<len; i++){
                $slideNum = $slide.eq(i).find('.slide-num');
                cnt = i+1;

                if(cnt === 1){
                    $slideNum.text('대표이미지');
                }else{
                    $num = $slideNum.find('.num'),
                        $nums = $slideNum.find('.nums');
                    $num.text(cnt);
                    $nums.text(len);
                }
            }
        };


        // var setSlideImg = function(){
        //     $slide = $slideWrap.find('.slide');

        //     var rWidth = $(window).innerWidth();
        //     var rHeight = width * 0.8;

        //     if(rHeight > $(window).innerHeight()){
        //         $slide.css('height', $window.innerHeight());
        //         $slide.css('width', rHeight * 1.25);
        //     }
        // };

        //슬라이드 이벤트 생성
        var initSlide = function(){
            //resize
            $slide = $slideWrap.find('.slide');

            //set slide
            $slideWidth = $(window).innerWidth();
            // $slideHeight = $slideWidth * 0.8 > $(window).innerHeight()? $(window).innerHeight() :  $slideWidth * 0.8;
            $slideHeight = $slideWidth * 0.8;

            if($slideHeight > $(window).innerHeight()){
                $slideHeight = $(window).innerHeight();
                $slide.find('img').css('width', 'auto');
                // $slide.find('.slide-num').css('left', $slide.find('img').width() + 'px');
                // $slideWidth = $slideHeight * 1.25;
            }

            $slide.css({'width' : $slideWidth + 'px', height : $slideHeight + 'px'});

            //copy slide
            $slide.first().before($slide.last().clone());
            $slide.last().after($slide.first().clone());

            //set SlideWrap
            $slideLength = $slideWrap.find('.slide').length;
            $slideWrapWidth = ($slideWidth * $slideLength);
            $slideWrapTop = ($(window).innerHeight() * 0.5) - ($slideHeight * 0.5);
            $slideWrap.css({'width': $slideWrapWidth, 'left' :  -$slideWidth + 'px', 'top' : $slideWrapTop + 'px'});

        };

        //슬라이드 버튼 이벤트
        var setSlideBtns = function(){

            var $prevBtn = $popupZoom.find('.btn_prev'),
                $nextBtn = $popupZoom.find('.btn_next');

            $prevBtn.click(function(event){
                event.preventDefault();
                shiftToLeft();
            });
            $nextBtn.click(function(event){
                event.preventDefault();
                shiftToRight();
            });
        };

        //슬라이드 오른쪽으로 밀기
        var shiftToRight = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : 0});
            $slide.first().detach();

            $slideWrap.stop().animate({
                'left': -$slideWidth + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.last().after($slide.eq(1).clone());
        };

        //슬라이드 왼쪽으로 밀기
        var shiftToLeft = function(){
            $slide = $slideWrap.find('.slide');
            $slideWrap.css({'left' : -$slideWidth*2 + 'px'});
            $slide.last().detach();

            $slideWrap.stop().animate({
                'left': -$slideWidth + 'px'
            }, 600, 'linear');

            $slide = $slideWrap.find('.slide');
            $slide.first().before($slide.eq($slide.length -2).clone());

        };

        $(window).on('load', function(event) {
            // event.preventDefault();
            setSlideNum();
            setSlideBtns();
            initSlide();
        });

        $(window).on('resize', function(event) {
            // event.preventDefault();
            initSlide();
        });

    }zoomSlideFn();

    /* ====== [팝업] 토지 분석 선택하기 ======= */
    function selectAddrFn(){

        var $formAddr = $('.popup-service .form_addr'),
            $inputAddr = $formAddr.find('input'),
            $selectOption = $formAddr.find('.select  .option');

        $selectOption.on('click', function(event) {
            event.preventDefault();
            if($(this).hasClass('selected')) return;
            else {
                var addrValue = $(this).text();
                $inputAddr.val(addrValue);
                console.log($inputAddr.val());
                alert('test select : ' + $inputAddr.val());

                $selectOption.removeClass('selected');
                $(this).addClass('selected');
            }
        })
    }selectAddrFn();
})(jQuery);
