<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Font awesome 5 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap 5.3 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


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

    .hover-green:hover {
        transition: 0.5s;
        cursor: pointer !important;
        color: #CCF381 !important;
    }

    .hover-yellow:hover {
        transition: 0.5s;
        cursor: pointer !important;
        color: #FFBA08 !important;
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

    .movie-image {
        max-height: 1029px;
        /*width: 728px; */
    }

    /* ============================= */

    /* Top part*/
    #toppart {
        margin: 0;
        height: 1000px;
        background: url(../assets/img/homepage/movie-area.png);
        background-size: cover;
    }

    /* Main content */
    #maincontent {
        height: 1000px;
        background-color: antiquewhite;
    }

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

    @media screen and (max-width: 992px) {
        #icon-camera {
            display: flex;
            justify-content: center;
        }
    }
</style>