;(function(){

    //IE11 : forEach
    if (window.NodeList && !NodeList.prototype.forEach) {
        NodeList.prototype.forEach = Array.prototype.forEach;
    }

    //메뉴
    function gnbFn(){
        var gnb = document.getElementById('gnb'),
            depth = gnb.querySelectorAll('.has-depth'), 
            menu = gnb.querySelectorAll('.menu'); //모든 메뉴

        // 하위메뉴 열기
        var onDepthFn = function(event){
            event.preventDefault();
            if(event.target.classList.contains('on')) event.target.classList.remove('on');
            else{
                offDepthFn();
                event.target.classList.add('on');
            }
        };

        //하위 메뉴 닫기
        var offDepthFn = function(){
            depth.forEach(function(el){
                if(el.classList.contains('on')) el.classList.remove('on');
            })
        };

        //현재 메뉴 체크
        var onMenuFn = function(event){
            // event.preventDsefault();
            if(event.target.classList.contains('has-depth') || event.target.classList.contains('is-on')) return;
            else{
                offMenuFn();
                event.target.classList.add('is-on');
                //타겟 아닌 하위메뉴 닫기
                if(!event.target.classList.contains('depth02')) offDepthFn();
            }
        };

        //현재 메뉴 체크 해제
        var offMenuFn = function(){
            menu.forEach(function(el){
                if(el.classList.contains('is-on')) el.classList.remove('is-on');
            });
        };

        //메뉴 방문
        menu.forEach(function(el){
            el.addEventListener('click', onMenuFn);
        });

        //하위 메뉴 열기
        depth.forEach(function(el){
            el.addEventListener('click', onDepthFn);
        })

        //현재페이지 체크
        window.addEventListener('load', function(){
            var currentPath = this.location.pathname;
            var selectTxt = '.menu[href="..' + currentPath + '"]';
            var currentMenu = gnb.querySelectorAll(selectTxt);
            if(currentMenu.length <= 0) return;
            else {
                currentMenu[0].parentNode.previousElementSibling.classList.add('on');
                currentMenu[0].classList.add('is-on');
            }
        });
        
    }gnbFn();


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


    //파일 업로드하기
    function fileLoadFn(){
        var fileInput = document.querySelectorAll('input[type="file"]');
        var file = {};
        var fileList = [];

        //토지등록 대표이미지, 첨부파일 
        var addSingleFile = function(event){
            event.preventDefault();
            
            file = event.target.files[0];
            var uploaded = event.target.nextElementSibling;
            
            var name = '첨부파일';
            if( event.target.hasAttribute('accept') && event.target.getAttribute('accept').includes('image')) name = '대표이미지';
            
            var htmlTxt = ['<div class="wrap"><span class="tit">'
                            ,'</span><span class="file">'
                            ,'</span><button class="btn btn_del"></button></div>'];

            uploaded.innerHTML= htmlTxt[0] + name + htmlTxt[1] + file.name+htmlTxt[2];

            uploaded.querySelector('.btn_del').addEventListener('click',function(e){
                e.preventDefault();
                file = null;
                uploaded.innerHTML = '';
            })
        };

        //토지등록 참고이미지(multiple)
        var addMultipleFile = function(event){
            event.preventDefault();
            //리스트에 파일 추가
            fileList.push(event.target.files[0]);

            var idx = fileList.length-1;
            var uploaded = event.target.nextElementSibling;

            var htmlTxt = ['<div class="wrap"><span class="tit">참고 이미지</span><span class="file">'
            ,'</span><button class="btn btn_del" data-index="'
            ,'"></button></div>'];

            uploaded.innerHTML += htmlTxt[0] + fileList[idx].name + htmlTxt[1] + idx + htmlTxt[2];

            uploaded.querySelectorAll('.btn_del').forEach(function(el){
                el.addEventListener('click', function(e){
                    e.preventDefault();
                    if(fileList.length <= 1){
                        fileList = [];
                        uploaded.innerHTML = '';
                    }else{
                        var delIdx = Number(e.target.getAttribute('data-index'));
                        var fileWrap = e.target.parentElement;
                        uploaded.removeChild(fileWrap);

                        //list
                        var newFileList = fileList.slice(0, delIdx).concat(fileList.slice(delIdx+1, fileList.length));
                        fileList = newFileList;
                        console.log(fileList);

                        //태그 data-index 처리
                        for(var i = delIdx; i < fileList.length; i++){
                            uploaded.querySelector('button[data-index="' + (i+1) + '"]').dataset.index = i + '';
                        }
                    }
                })
            });
        };

        fileInput.forEach(function(el){
            el.addEventListener('change', function(event){
                var isMultiple = event.target.getAttribute('multiple');
                if(isMultiple){
                    addMultipleFile(event);
                }else{
                    addSingleFile(event);
                }
            });
        });

    }fileLoadFn();
    
    //체크박스 이벤트
    function checkBoxFn(){
        //체크박스 클릭 이벤트
        var checkAll = document.querySelector('.check-all');
        if(checkAll){
            var checkBox = document.querySelectorAll('input[type=checkbox]');
            checkAll.addEventListener('change', function(event){
                event.preventDefault();
                if(!event.target.checked === false){
                    event.target.checked = true;
                    checkBox.forEach(function(el){
                        el.checked = true;
                    })
                }else{
                    event.target.checked = false;
                    checkBox.forEach(function(el){
                        el.checked = false;
                    })
                }
            });
        }

    }checkBoxFn();

    //모달창(삭제창)
    function modalFn(){
        var modalBtn = document.querySelectorAll('.btn_modal');

        modalBtn.forEach(function(el){
            el.addEventListener('click', function(e){
                e.preventDefault();
                var data = e.target.getAttribute('data-modal');
                var selectTxt = '.modal[data-modal="' + data + '"]'
                var targetModal = document.querySelector(selectTxt);

                //modal show
                targetModal.classList.add('show');

                //modal hide
                targetModal.querySelectorAll('.btn').forEach(function(el){
                    el.addEventListener('click', function(e){
                        e.preventDefault();
                        targetModal.classList.remove('show');
                    })
                })
            });
        });
    }modalFn();

})();

