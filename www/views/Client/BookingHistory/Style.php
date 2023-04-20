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

    /* Sidenav */
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
        top: 0px;
    }

    #bookingHistory {
        background-color: rgba(217, 217, 217, 0.25);
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

    /* Main */
    #bookingHistory-main-inner {
        background-color: rgba(255, 255, 255, 0.25);
    }
</style>