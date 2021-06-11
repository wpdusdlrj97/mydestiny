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
        });

    }headerFn();


    /* ====== [홈] 퀵서치 ====== */
    function quickSearchFn(){
        var $quickSearch = $('#quickSearch'),
            $quickInput = $quickSearch.find('input'),
            $quickList = $quickSearch.find('.addr-list'),
            $quickSubmit = $quickSearch.find('button');

        $quickInput.on('focus', function(event){
            event.preventDefault();
            $quickList.removeClass('hide');
        });

        $quickList.find('li').on('click', function(event){
            event.preventDefault();
            var addrValue = $(event.target).text();
            $quickInput.val(addrValue);
        })

        $('.home').on('click',function(event){
            if($quickSearch.has(event.target).length === 0) {
                if(!$quickList.hasClass('hide')) $quickList.addClass('hide');
            }
        });

        $quickSubmit.on('click', function(event){
            event.preventDefault();
            alert(`test : 선택값 : ${$quickInput.val()}`);
            if(!$quickList.hasClass('hide')) $quickList.addClass('hide');
        });

    }quickSearchFn();

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

    /* ====== [매물리스트] 매물 목록 탭  ====== */
    function listTabFn(){
        //해당 탭 컨텐츠 보여주기
        var $tabWrap = $('#wrap')
        var $currentTab = $tabWrap.data('tab');
        $tabWrap.addClass($currentTab);

        //탭 버튼 이벤트
        var $tabBtn = $('.tabBtn');
        $tabBtn.on('click', function(event){
            event.preventDefault();

            var $target = $(this).data('tab');

            if($tabWrap.hasClass($target)){
                return;
            }else{
                $tabWrap.removeClass($tabWrap.data('tab'));
                $tabWrap.addClass($target);
                $tabWrap.data('tab', $target);
            }
        })
    }listTabFn();

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

    
    /* ====== [계정] 아이디 중복 조회 ====== */
    function checkMailFn(){
         
        var $mailCheckBtn = $('.sub-join .btn_mcheck'),
            $mailCheckInput = $mailCheckBtn.next().find('input');

        $mailCheckBtn.on('click', function(event){
            event.preventDefault();
            if(!$mailCheckBtn.hasClass('loading')) $mailCheckBtn.addClass('loading');
            //texst
            setTimeout(function(){
                alert('test : id checked');
                $mailCheckBtn.removeClass('loading');
                $mailCheckBtn.addClass('loaded');
            },4000);
        });

        $mailCheckInput.on('focus', function(event){
            event.preventDefault();
            if($(this).parent().prev().hasClass('loaded')) $mailCheckBtn.removeClass('loaded');
        })

    }checkMailFn();

    /* ====== [계정] 아이디, 비밀번호 찾기 ====== */
    function checkAccFn(){
        var $accCheck = $('.acc_check'),
            $input = $accCheck.find('input'),
            $submit = $accCheck.find('button[type="submit"]');

        $input.on('focus', function(event){
            event.preventDefault();
            if($accCheck.hasClass('loading')) $accCheck.removeClass('loading');
            if($accCheck.hasClass('failed')) $accCheck.removeClass('failed');
        });

        $submit.on('click', function(event){
            event.preventDefault();
            event.stopPropagation();
            $accCheck.addClass('loading');
            //test
            setTimeout(function(){
                $accCheck.addClass('failed');
            },3000);
        });

    }checkAccFn();

     /* ====== [계정] 회원가입 : 약관 동의 ====== */
    function acceptTermsFn(){

        var $jCheckBox = $('.signup .checkbox'),
            $jCheckValue = $jCheckBox.next();
        
        $jCheckBox.on('click', function(event){
            event.preventDefault();
            if(!$jCheckBox.hasClass('checked')){
                $jCheckValue.attr('value', 'yes');
                $jCheckBox.addClass('checked');
            }else{
                $jCheckValue.attr('value', '');
                $jCheckBox.removeClass('checked');
            };
            //test
            alert(`test || checkbox value: ${$jCheckValue.attr('value')}`);

        })

    }acceptTermsFn();

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

    /* ====== [마이페이지 등록] 이미지 파일 업로드 ======= */
    function registerFormFileFn(){

        var $fileInput = $('.rg-form .form-wrap_f'),
            $thumbInput = $fileInput.find('#thumbnail'),
            $imgsInput = $fileInput.find('#images'),
            // $imgFileWrap = $fileInput.find('.file-wrap'),
            thumbImg = {}, //대표 이미지
            imgList = []; //참고 이미지 배열
            
        //대표 이미지  
        $thumbInput.on('change', function(event){

            var $thumbHtml = ["<div class='input-wrap bx-round_s'><input type='text' readonly value='"
                            ,"'><button class='btn btn_del' type='button'></button></div>"];
            
            thumbImg = event.target.files[0];

            if($thumbInput.next('.input-wrap').length > 0) $thumbInput.next().find('input').val( thumbImg.name );
            else $thumbInput.after($thumbHtml[0] +  thumbImg.name + $thumbHtml[1]);
            
            $('#thumbnail').next().find('.btn_del').click(function (event) {
                event.preventDefault();
                $('#thumbnail').val('');
                thumbImg = {};
                $(this).parent().remove();
            })
        });

        //참고 이미지
        $imgsInput.on('change', function(event){
            
            var $imgsHtml =["<i class='num bx-round_s bg_n'>"
                            , "</i><div class='input-wrap bx-round_s'><input type='text' readonly value='"
                            ,"'><button class='btn btn_del' type='button' data-index='","'></button></div>" ];

            imgList.push(event.target.files[0]);

            $imgsInput.next().append($imgsHtml[0] + imgList.length //라벨 넘버
                                    + $imgsHtml[1] + imgList[imgList.length - 1].name 
                                    + $imgsHtml[2] + (imgList.length - 1) //버튼 데이터 속성
                                    + $imgsHtml[3]);
        
            
            //파일 삭제
            $('#images').next().find('.btn_del').off('click').on('click', function(event){
                event.preventDefault();
                var delNum = $(this).data('index');
                var $fileWrap = $(this).parents('.file-wrap');
                //파일 태그 삭제
                $fileWrap.children('i').eq(delNum).remove();
                $fileWrap.children('.input-wrap').eq(delNum).remove();
                //이미지 리스트 업데이트
                var imgArr = imgList.slice(delNum+1);
                imgList = imgList.slice(0, delNum).concat(imgArr);
                //태그 속성 업데이트
                for(var idx = delNum; idx < imgArr.length + delNum; idx++){
                    $fileWrap.children('i').eq(idx).text(`${idx+1}`);
                    $fileWrap.find('.btn_del').eq(idx).data('index', idx);
                };
            });
        });
    }registerFormFileFn();

    
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

    function handleImgSize(){

        var $imgWrap = document.querySelectorAll('.thumbnail, .sub .slide, .card-img');

        $imgWrap.forEach(function(el){
            if(el.childElementCount <= 0) return;
            var $wrapW = el.clientWidth,
                $wrapH = el.clientHeight,
                $img = el.querySelector('img'),
                $imgW = $img.naturalWidth,
                $imgH = $img.naturalHeight;
            var $ratio = $wrapW / $imgW;
            var $resizedH = $ratio*$imgH;
        
            if($resizedH - $wrapH > 0){
                var $moveY = ($resizedH - $wrapH)/2; 
                $img.style.transform = 'translateY(-' + $moveY + 'px)';
            }else {
                var $gapRatio = ($wrapH - $resizedH) / $resizedH;
                var $resizedW = $wrapW + ($wrapW * $gapRatio);
                var $moveX = ($resizedW - $wrapW)/2;
                $img.style.height = $wrapH + 'px';
                $img.style.width = $resizedW + 'px';
                $img.style.transform = 'translateX(-' + $moveX + 'px)';
            }
        
        });

    }handleImgSize();


})(jQuery);
