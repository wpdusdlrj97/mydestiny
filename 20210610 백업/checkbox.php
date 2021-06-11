<input type="checkbox" name="fruit" value="apple"/>사과
<input type="checkbox" name="fruit" value="strawberry"/>딸기
<input type="checkbox" name="fruit" value="lemon"/>레몬
<input type="checkbox" name="fruit" value="mango"/>망고
<input type="checkbox" name="fruit" value="melon"/>메론

<button onclick="test()">체크된 객체 value 가져오기</button>

<script>
    function test() {
        var obj_length = document.getElementsByName("fruit").length;
        var fruit_string ='';

        for (var i=0; i<obj_length; i++) {

            if (document.getElementsByName("fruit")[i].checked == true) {

                if(fruit_string==''){
                    fruit_string = fruit_string+document.getElementsByName("fruit")[i].value;
                }else{
                    fruit_string = fruit_string+'/'+document.getElementsByName("fruit")[i].value;
                }
            }
        }
        alert(fruit_string);
    }
</script>