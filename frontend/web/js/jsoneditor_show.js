/**
 * Created by zgr0629 on 14/6/16.
 */
$(document).ready(function() {
    $('.jsonEditor').each(function () {
        var string = decodeURIComponent($(this).html());
        //string = Base64.decode(string);
        //console.log(string);
        var obj = JSON.parse(string);
        //console.log(obj);
        $(this).html('');
        new JSONEditor(this, {}, obj);
        $(this).css('max-width', '');
    });
});