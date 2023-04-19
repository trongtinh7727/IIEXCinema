<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .text-yellow {
        color: #FFBA08 !important;
    }

    .bg-yellow {
        background-color: #FFBA08 !important;
    }

    .text-green {
        color: #CCF381 !important;
    }

    .bg-green {
        background-color: #CCF381 !important;
    }

    .hover-green:hover {
        transition: 0.5s;
        cursor: pointer !important;
        color: #CCF381 !important;
    }

    .hover-bg-green:hover {
        color: #000000 !important;
        transition: 0.5s !important;
        cursor: pointer !important;
        background-color: #CCF381 !important;
    }

    .hover-yellow:hover {
        transition: 0.5s;
        cursor: pointer !important;
        color: #FFBA08 !important;
    }

    .hover-bg-yellow:hover {
        color: #000000 !important;
        transition: 0.5s !important;
        cursor: pointer !important;
        background-color: #FFBA08 !important;
    }

    .custom-active::after {
        content: "";
        position: absolute;
        background-color: #FFBA08;
        height: 1px;
        width: 80%;
        left: 50%;
        transform: translateX(-50%);
        bottom: 0;
    }

    #wrapper {
        min-height: 100vh;
        background-color: #000218;
    }

    /* ============================= */

    /* Top part*/
    #toppart {
        margin: 0;
        background: url(../assets/img/homepage/movie-area.png);
        background-size: cover;
    }

    /* Swiper */
    .swiper-slide {
        background-color: rgba(219, 227, 255, 0.25);
        width: 35%;
    }

    .swiper-slide-inner-left img {
        top: -40px;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
    }

    #swiper-slide-inner-movie-trailer-modal iframe {
        width: 100%;
        aspect-ratio: 16/9;
    }

    /* Swiper Nagivation Button */
    .swiper-button-prev,
    .swiper-button-next {
        width: 44px;
    }

    /* Main content toggler */
    #content-toggler .row::after,
    #trailer-separator .container::after {
        content: "";
        position: absolute;
        background-color: #ffffff;
        height: 1px;
        width: 100%;
        bottom: -10px;
    }

    /* Main content */
    .content-ongoing-movies-item-inner,
    .content-upcoming-movies-item-inner {
        background-color: rgba(219, 227, 255, 0.25);
    }

    @media screen and (max-width: 992px) {
        #content-icon-camera {
            display: flex;
            justify-content: center;
        }

        .custom-active::after {
            content: "";
            position: absolute;
            background-color: #FFBA08;
            height: 1px;
            width: 100%;
            left: 50%;
            transform: translateX(-50%);
            bottom: 0;
        }
    }

    @media screen and (max-width: 1200px) {
        .swiper-slide {
            background-color: transparent;
        }

        .swiper-slide-inner-right {
            display: none;
        }

        .swiper-slide-inner-left {
            height: 300px;
        }
    }
</style>