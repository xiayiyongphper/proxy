/**
 * Created by zgr0629 on 21/6/16.
 */
var offset = 0;
jQuery(document).ready(function(){
    $.repeat(1000, function() {
        $.getJSON('index.php', {
            'r':'site/tailajax',
            'offset':offset
        }, function(data) {
            if(data){
                var text = data['text'];
                offset = data['next_offset'];
                if(text){
                    $('#tail').append('<pre class="line">'+text+'</pre>');
                    $('#tail').scrollTop(99999);
                }
            }
        });
    });
});