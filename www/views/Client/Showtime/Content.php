<div id="showtime" class="mb-5 container-lg">
    <!-- Separator -->
    <div id="showtime-separator" class="my-4">
        <div class="container position-relative">
            <div class="d-flex justify-content-start align-items-center">
                <div id="showtime-icon-play" class="text-yellow fs-1 me-5">
                    <i class="fa-solid fa-play"></i>
                </div>
                <div id="showtime-text" class="text-white">
                    <h1>Suất chiếu</h1>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($showtimes as $showtime) { ?>
        <div class="showtime-item my-5 row">
            <!-- Left Side Info -->
            <div class="showtime-item-info row col-xl-5 rounded-4 mx-auto">
                <!-- DATAFILL POSTER -->
                <div class="showtime-item-info-poster col-12 col-lg-6 d-flex align-items-center">
                    <img src="<?php echo $showtime['POSTER'] ?>" alt="Movie Poster" style="height: 260px; width: 230px;">
                </div>
                <!-- Content -->
                <div class="showtime-item-info-content text-white col-12 col-lg-6 my-3">
                    <!-- DATAFILL MOVIE TITLE -->
                    <h4 class="showtime-item-info-content-title text-capitalize">
                        <a href="./?moviedetail&id=<?php echo $showtime['MID'] ?>">
                            <?php echo $showtime['TITLE'] ?>
                        </a>
                    </h4>
                    <!-- DATAFILL MOVIE DESCRIPTION -->
                    <p class="showtime-item-info-content-content"><?php echo $showtime['STORY'] ?> </p>
                    <!-- DATAFILL RATING -->
                    <span class="showtime-item-info-content-rating text-yellow">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </span>

                    <!-- DATAFILL RATING -->
                    <span>180k voters</span>
                </div>
            </div>
            <!-- Right Side Time -->
            <div class="showtime-item-time col-xl-7 px-0 d-flex align-items-center">
                <!-- Date -->
                <div class="showtime-item-time-date d-flex">
                    <!-- DATAFILL DATE -->
                    <?php $day = explode('-', $showtime['DAY']) ?>
                    <div class="showtime-item-time-date-date bg-yellow d-flex align-items-center">
                        <div class="ms-2">
                            <h3><?php echo $day[2] . '/' . $day[1] ?></h3>
                            <h3><?php echo $day[0] ?></h3>
                        </div>
                    </div>
                </div>
                <!-- Slot -->
                <div class="showtime-item-time-tagntime w-100 py-2">
                    <div class="showtime-item-time-tagntime-inner">
                        <!-- Tag -->
                        <div class="showtime-item-time-tagntime-tag">
                            <img src="../assets/img/2dtag.png" alt="Tag 2D">
                        </div>
                        <!-- Time slot pick -->
                        <div class="showtime-item-time-tagntime-time d-flex flex-wrap">
                            <!-- DATAFILL -->
                            <?php foreach ($showtime['TIME'] as $timeSlot) { ?>
                                <div class="showtime-item-time-tagntime-time-slot mx-2 my-2 hover-bg-green px-1">
                                    <a href="./?moviedetail&id=<?php echo $showtime['MID'] ?>" class="showtime-item-time-tagntime-time-slot-inner text-center text-white text-decoration-none">
                                        <span class="fs-4 fw-medium"><?php echo explode(':', $timeSlot)[0] ?> : <?php echo explode(':', $timeSlot)[1] ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } ?>
</div>