// 用手机号查询用户
$("#query").on('click', function(){

    var kwd = $("#kwd").val();
    //alert(phone);
    $.getJSON('index.php', {
        'r':'device/find_user_ajax',
        'kwd':kwd
    }, function(data) {
        if(data.code==0){
            $('#pre').html(JSON.stringify(data.data, undefined, 2));
            if(typeof data.data.entity_id != 'undefined'){
                $('input[name="DynamicModel[customer_id]"]').val(data.data.entity_id);
                $('input[name="DynamicModel[level]"]').val(1);
            }
        }else{
            $('#pre').html('未找到用户');
        }
    });
});
