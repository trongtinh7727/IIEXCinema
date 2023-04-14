$(document).ready(function () {
    $swiper = new Swiper("#toppartSwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        }
    });
    $("#swiper-slide-inner-movie-trailer-modal").on("hidden.bs.modal", function () {
        $('.swiper-trailer-video').attr('src', $('.trailer-video').attr('src'));
    });
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