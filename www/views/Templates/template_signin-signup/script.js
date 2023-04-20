$(document).ready(function() {
    $('#tab-1').click(function (e) { 
        $('.login-wrap').css({
            "height": "540px",
            "transition": ".3s"
        });
        $('#tab-2-label').removeClass('text-yellow')
        $('#tab-1-label').addClass('text-yellow')
    });
    $('#tab-2').click(function (e) { 
        $('.login-wrap').css({
            "height": "720px",
            "transition": ".3s"
        });
        $('#tab-1-label').removeClass('text-yellow')
        $('#tab-2-label').addClass('text-yellow')
    });
})