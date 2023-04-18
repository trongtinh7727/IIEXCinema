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
        $('.swiper-trailer-video').attr('src', $('.swiper-trailer-video').attr('src'));
    });
})