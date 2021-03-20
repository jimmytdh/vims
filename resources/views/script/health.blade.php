<script>
    $('body').on('change','.question_04',function(){
        var ans = $(this).val();
        if(ans=='02_No'){
            $('.div_question_05').removeClass('hidden');
        }else{
            $('.div_question_05').addClass('hidden');
        }
    });

    $('body').on('change','.question_06',function(){
        var ans = $(this).val();
        if(ans=='02_No'){
            $('.div_question_07').removeClass('hidden');
        }else{
            $('.div_question_07').addClass('hidden');
        }
    });

    $('body').on('change','.question_08',function(){
        var ans = $(this).val();
        if(ans=='02_No'){
            $('.div_question_09').removeClass('hidden');
        }else{
            $('.div_question_09').addClass('hidden');
        }
    });

    $('body').on('change','.question_14',function(){
        var ans = $(this).val();
        if(ans=='02_No'){
            $('.div_question_15').removeClass('hidden');
        }else{
            $('.div_question_15').addClass('hidden');
        }
    });

    $('body').on('change','.question_16',function(){
        var ans = $(this).val();
        if(ans=='02_No'){
            $('.div_question_17').removeClass('hidden');
            $('.div_question_18').removeClass('hidden');
        }else{
            $('.div_question_17').addClass('hidden');
            $('.div_question_18').addClass('hidden');
        }
    });
</script>
