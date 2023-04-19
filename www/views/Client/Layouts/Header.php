<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Font awesome 5 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap 5.3 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<!-- Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    a:link {
        color: #ffffff;
        text-decoration: none;
    }

    a:visited {
        color: #ffffff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    a:active {
        text-decoration: underline;
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

    /* Main content */
    #content-toggler .row::after,
    #trailer-separator .container::after {
        content: "";
        position: absolute;
        background-color: #ffffff;
        height: 1px;
        width: 100%;
        bottom: -10px;
    }

    /* Trailer */
    #carousel-trailer iframe {
        width: 75%;
        aspect-ratio: 16/9;
    }

    .carousel-control-prev-icon {
        color: #FFBA08;
    }

    /* Sidenav */

    #profileSideNav {
        position: fixed;
    }

    #profileSideNav a {
        left: -200px;
        transition: 0.5s;
        width: 240px;
        border-radius: 0 5px 5px 0;
    }

    #profileSideNav a:hover {
        left: 0;
    }

    #profileDetails {
        top: 50px;
    }

    #changePassword {
        background-color: rgba(217, 217, 217, 0.25);
        top: 100px;
    }

    #logout {
        background-color: rgba(217, 217, 217, 0.25);
        top: 150px;
    }

    /* Main */
    #profile-main {
        background-color: rgba(217, 217, 217, 0.25);
    }

    #profile-main table {
        border-collapse: separate;
        border-spacing: 12px;
    }

    #profile-main input {
        min-height: 44px;
        background-color: rgba(217, 217, 217, 0.25);
        border: #FFFFFF solid 1px;
    }

    @media screen and (max-width: 992px) {
        #icon-camera {
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