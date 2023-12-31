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

    .bg-cyan {
        background-color: #00FFE5 !important;
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

    /* Step indicator */
    #bookticket-stepindicator {
        height: 76px;
    }

    /* Pointer */
    .pointer {
        width: 200px;
        height: 40px;
        clip-path: polygon(90% 0, 100% 50%, 90% 100%, 0% 100%, 10% 50%, 0% 0%);
    }

    /* Pointer first */
    .pointer-first {
        width: 200px;
        height: 40px;
        clip-path: polygon(90% 0, 100% 50%, 90% 100%, 10% 100%, 10% 50%, 10% 0%);
    }

    /* Pointer last */
    .pointer-last {
        width: 200px;
        height: 40px;
        clip-path: polygon(90% 0, 90% 50%, 90% 100%, 0% 100%, 10% 50%, 0% 0%);
    }


    /* Common */
    #bookticket-ticket-main-info,
    #bookticket-ticket-main-number,
    #bookticket-ticket-main-cart,
    #bookticket-seat-main-info,
    #bookticket-seat-main-number,
    #bookticket-seat-main-cart,
    #bookticket-combo-main-combo,
    #bookticket-combo-main-cart,
    #bookticket-confirm-main {
        background-color: rgba(217, 217, 217, 0.25);
    }

    #bookticket-ticket-main-info img,
    #bookticket-seat-main-info img {
        width: 300px;
        aspect-ratio: 2/3;
        object-fit: cover;
        border: 4px #FFBA08 solid;
        border-bottom: 0px;
    }

    #bookticket-ticket-main-cart-total,
    #bookticket-seat-main-cart-total,
    #bookticket-combo-main-cart-total {
        border-top: 4px solid #000218;
    }

    #bookticket-ticket-main-cart h3,
    #bookticket-seat-main-cart h3,
    #bookticket-combo-main-cart h3 {
        border-bottom: 4px solid #000218;
    }


    /* Ticket */
    #bookticket-ticket-main-number thead tr {
        border-bottom: 12px solid #000218;
    }


    /* Seat */
    .status-block,
    .seat-item,
    .seat-letter {
        width: 28px;
        height: 28px;
        margin: 4px
    }

    #bookticket-seat-main-seat {
        background-color: #D9D9D9;
    }

    #bookticket-seat-main-seat-status {
        background-color: #000218;
    }

    #bookticket-seat-main-seat-screen {
        background-color: #484848;
    }

    .seat-item {
        background-color: #959595 !important;
        cursor: pointer;
    }

    .seat-item-couple {
        width: 64px !important;
    }

    .seat-letter {
        text-align: center;
        background-color: #4583CC !important;
    }

    .seat-choosing {
        background-color: red !important;
    }

    .seat-sold {
        background-color: #FFBA08 !important;
    }
</style>