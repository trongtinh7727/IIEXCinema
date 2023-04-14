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

    /* Top part */
    #toppart {
        margin: 0;
        height: 1000px;
        background: url(../assets/img/homepage/movie-area.png);
        background-size: cover;
    }

    /* Movie Details toggler */
    #moviedetails-separator .container::after {
        content: "";
        position: absolute;
        background-color: #ffffff;
        height: 1px;
        width: 100%;
        bottom: -10px;
    }

    /* Movie Details Main Item */
    .moviedetails-main-content-item {
        background: rgba(217, 217, 217, 0.25);
    }

    .moviedetails-main-content-item-infohead {
        width: 8rem;
    }

    .moviedetails-main-content-item-info {
        height: 40px;
        border-radius: 10px 0 10px 0;
    }

    #moviedetails-main-content-item-modal-trigger {
        width: auto;
        background-color: #D9D9D9;
        border-radius: 10px 0 10px 0;
    }

    /* Trailer */
    #moviedetails-main-content-item-trailer-modal iframe {
        width: 100%;
        aspect-ratio: 16/9;
    }

    /* Shift */
    .moviedetails-main-shift-item-time {
        width: 80%;
        height: 80px;
    }

    .moviedetails-main-shift-item-time-slot {
        width: 72px;
        height: 44px;
        background-color: rgb(85, 189, 203);
    }

    .moviedetails-main-shift-item-date {
        width: 20%;
        height: 80px;
    }

    .triangle-bottom-left {
        width: 0px;
        height: 0px;
        border-bottom: 80px solid rgb(255, 186, 8);
        border-right: 80px solid transparent;
    }

    .triangle-top-left {
        width: 0px;
        height: 0px;
        border-top: 80px solid rgb(255, 186, 8);
        border-right: 40px solid transparent;
    }

    @media screen and (max-width: 992px) {
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
</style>