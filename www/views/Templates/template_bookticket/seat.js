$(document).ready(function () {
    $("#bookticket-seat-main-seat").find($(".seat-item")).click(function() {
        if($(this).hasClass("seat-choosing")) {
            $(this).removeClass("seat-choosing");
        }
        else {
            $(this).addClass("seat-choosing");
        }
    });
})