$(document).ready(function () {
    $('#toggler-ongoing-movies').click(function (e) {
        $('#content-ongoing-movies').removeClass('d-none');
        $('#content-upcoming-movies').addClass('d-none');
        $('#toggler-ongoing-movies').find('a').addClass('text-yellow');
        $('#toggler-upcoming-movies').find('a').removeClass('text-yellow');
    });
    $('#toggler-upcoming-movies').click(function (e) {
        $('#content-ongoing-movies').addClass('d-none');
        $('#content-upcoming-movies').removeClass('d-none');
        $('#toggler-upcoming-movies').find('a').addClass('text-yellow');
        $('#toggler-ongoing-movies').find('a').removeClass('text-yellow');
    });
    $('.carousel-control-next, .carousel-control-prev').click(function () {
        $('.trailer-video').attr('src', $('.trailer-video').attr('src'));
    });
})