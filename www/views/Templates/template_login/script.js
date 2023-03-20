$(document).ready(function() {
    $('#tab-1').click(function (e) { 
        $('.login-wrap').css({
            "height": "480px",
            "transition": ".3s"
        });
    });
    $('#tab-2').click(function (e) { 
        $('.login-wrap').css({
            "height": "680",
            "transition": ".3s"
        });
    });
})