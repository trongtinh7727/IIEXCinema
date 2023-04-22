<div id="moviedetails-main">
    <!-- Separator -->
    <div id="moviedetails-separator" class="py-4">
        <div class="container position-relative">
            <div class="d-flex justify-content-start align-items-center">
                <div id="moviedetails-icon-play" class="text-yellow fs-1 me-5">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div id="moviedetails-text" class="text-white">
                    <h1>Chi tiết phim</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div id="moviedetails-main-content">
        <!-- DATAFILL ITEM -->
        <div class="moviedetails-main-content-item my-5 py-5">
            <div class="moviedetails-main-content-item-inner container">
                <div class="row">
                    <!-- Photo -->
                    <div class="moviedetails-main-content-item-img col-12 col-lg-6 text-center">
                        <img id="POSTER" name="moviedetails-item-poster" src="../assets/img/moviedetails/upcoming-movie-poster.png" alt="Movie Poster">
                    </div>

                    <!-- Details -->
                    <div class="moviedetails-main-content-item-details col-12 col-lg-6">
                        <!-- Title -->
                        <h3 id="TITLE" name="moviedetails-main-content-item-title" class="text-white text-uppercase text-center mb-5">Khóa
                            chặt cửa nào Phú Lê</h3>
                        <!-- Premiere -->
                        <div name="moviedetails-main-content-item-premiere" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-premiere-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Khởi
                                chiếu</span>
                            <div name="moviedetails-main-content-item-premiere-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center">
                                <div class="mx-3" id="OPENING_DAY">

                                </div>
                            </div>
                        </div>
                        <!-- Genre -->
                        <div name="moviedetails-main-content-item-genre" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-genre-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Thể
                                loại</span>
                            <div name="moviedetails-main-content-item-genre-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center">
                                <div class="mx-3" id="GENRE">
                                    <!-- Kinh dị | Phiêu lưu | Giả tưởng -->
                                </div>
                            </div>
                        </div>
                        <!-- DURATION -->
                        <div name="moviedetails-main-content-item-DURATION" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-DURATION-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Thời lượng</span>
                            <div name="moviedetails-main-content-item-DURATION-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center">
                                <div class="mx-3" id="DURATION">
                                    <!-- DURATION -->
                                </div>
                            </div>
                        </div>
                        <!-- Actors -->
                        <div name="moviedetails-main-content-item-actors" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-actors-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Diễn
                                viên</span>
                            <div name="moviedetails-main-content-item-actors-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center text-capitalize">
                                <div class="mx-3" id="ACTORS">
                                    <!-- Lê Trần Phú, Phú đẹp -->
                                </div>
                            </div>
                        </div>
                        <!-- Director -->
                        <div name="moviedetails-main-content-item-director" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-director-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Đạo
                                diễn</span>
                            <div name="moviedetails-main-content-item-director-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center text-capitalize">
                                <div class="mx-3" id="DIRECTOR">
                                    <!-- Phú đạo diễn -->
                                </div>
                            </div>
                        </div>
                        <!-- Tag -->
                        <div class="my-3">
                            <img src="../assets/img/homepage/2dtag.png" alt="Tag">
                        </div>
                        <!-- Rating -->
                        <div name="moviedetails-main-content-item-rating" class="d-flex mt-4 row">
                            <span name="moviedetails-main-content-item-rating-infohead" class="moviedetails-main-content-item-infohead text-white d-flex align-items-center">Đánh
                                giá</span>
                            <div name="moviedetails-main-content-item-rating-info" class="moviedetails-main-content-item-info text-dark bg-yellow d-flex align-items-center rounded-0 text-yellow" style="background-color: transparent !important;">
                                <div class="mx-3">
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Trailer -->
                        <!-- Button trigger trailer modal -->
                        <button id="moviedetails-main-content-item-modal-trigger" type="button" class="btn mt-3 px-3 hover-bg-yellow" data-bs-toggle="modal" data-bs-target="#moviedetails-main-content-item-trailer-modal">
                            <i class="fa-solid fa-play me-2"></i>
                            Trailer
                        </button>
                        <!-- Trailer modal -->
                        <div class="modal fade" id="moviedetails-main-content-item-trailer-modal" tabindex="-1" aria-labelledby="moviedetails-main-content-item-trailer-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-body">
                                    <div align="center">
                                        <iframe id="TRAILER" class="trailer-video" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-white mt-4" id="STORY">
                        <!-- Story -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shift -->
    <div id="moviedetails-main-shift" class="my-5">
        <!-- Title -->
        <h3 class="text-white text-center">Chọn suất chiếu</h3>
        <div class="container">
            <?php
            foreach ($movie_schedule as $cinema) {
            ?>

                <!-- Rạp -->
                <div class="moviedetails-main-shift-theater row justify-content-center align-items-center g-4 my-3">
                    <!-- Title -->
                    <div class="moviedetails-main-shift-theater-name text-white fs-4 fw-medium">
                        <?php echo $cinema['NAME'] ?>
                    </div>
                    <?php
                    foreach ($cinema['Showrooms'] as $showroom) {
                    ?>
                        <div class="moviedetails-main-shift-theater row justify-content-center align-items-center g-4 my-3">
                            <div class="moviedetails-main-shift-theater-name text-white fs-4 fw-medium">
                                Phòng chiếu số <?php echo $showroom['SHOWROOMNUM'] ?>
                            </div>
                            <?php
                            foreach ($showroom['showtimes'] as $showtime) {
                            ?>
                                <!-- Item -->
                                <div name="moviedetails-main-shift-theater-item" class="moviedetails-main-shift-theater-item col-12 col-xl-4 my-4">
                                    <div class="d-flex">
                                        <?php
                                        foreach ($showtime['times'] as $time) {
                                        ?>
                                            <!-- Time slot -->
                                            <div class="moviedetails-main-shift-theater-item-time bg-yellow d-flex align-items-center">
                                                <!-- Time slot -->
                                                <a href="./?ticketbooking&schedule=<?php echo $time['ID']  ?>" class="moviedetails-main-shift-theater-item-time-slot ms-3 text-white d-flex align-items-center justify-content-center text-decoration-none my-0 hover-bg-green">
                                                    <div class="fs-4 fw-medium"><?php echo date('h:i', strtotime($time['TIME']))  ?></div>
                                                </a>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="triangle-bottom-left"></div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="moviedetails-main-shift-theater-item-date bg-yellow">
                                            <div class="moviedetails-main-shift-theater-item-date-dm fs-5 fw-semibold ms-3"><?php echo date('d/m', strtotime($showtime['DAY'])) ?>
                                            </div>
                                            <div class="moviedetails-main-shift-theater-item-date-y fs-4 fw-semibold ms-3"><?php echo date('y', strtotime($showtime['DAY'])) ?>
                                            </div>
                                        </div>
                                        <div class="triangle-top-left"></div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>