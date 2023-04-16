<div id="showtime" class="mb-5">
    <?php foreach ($showtimes as $showtime) { ?>
        <div class="showtime-item mx-auto d-flex mt-5">
            <!-- Left side info -->
            <div class="showtime-item-info d-flex align-items-center">
                <!-- DATAFILL POSTER -->
                <div class="showtime-item-info-poster">
                    <img src="<?php echo $showtime['POSTER'] ?>" alt="Movie Poster" style="height: 260px; width: 230px;">
                </div>
                <!-- Content -->
                <div class="showtime-item-info-content text-white d-flex flex-column mx-4">

                    <!-- DATAFILL MOVIE TITLE -->
                    <h4 class="showtime-item-info-content-title text-center"><?php echo $showtime['TITLE'] ?></h4>

                    <!-- DATAFILL MOVIE DESCRIPTION -->
                    <p class="showtime-item-info-content-content"><?php echo $showtime['STORY'] ?> </p>

                    <!-- DATAFILL RATING -->
                    <span class="showtime-item-info-content-rating">
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

            <!-- Time -->
            <div class="showtime-item-time my-auto d-flex">

                <!-- Date -->
                <div class="showtime-item-time-date position-relative d-flex">
                    <div class="showtime-item-time-date-cut1"></div>
                    <div class="showtime-item-time-date-cut2"></div>
                    <?php $day = explode('-', $showtime['DAY']) ?>
                    <!-- DATAFILL DATE -->
                    <div class="showtime-item-time-date-date text-white position-absolute top-50 translate-middle-y">
                        <h3><?php echo $day[2] . '/' . $day[1] ?></h3>
                        <h3><?php echo $day[0] ?></h3>
                    </div>
                </div>

                <!-- Tag and time-->
                <div class="showtime-item-time-tagntime d-flex flex-column mx-4 my-2 justify-content-around w-100">

                    <!-- Tag -->
                    <div class="showtime-item-time-tagntime-tag">
                        <img src="../assets/img/2dtag.png" alt="Tag 2D">
                    </div>

                    <!-- Time slot -->
                    <div class="showtime-item-time-tagntime-time d-flex">
                        <!-- DATAFILL TIME -->
                        <?php foreach ($showtime['TIME'] as $timeSlot) { ?>
                            <div class="showtime-item-time-tagntime-time-slot me-4">
                                <a href="./?moviedetail&id=<?php echo $showtime['MID'] ?>" class="showtime-item-time-tagntime-time-slot-inner text-white text-center text-decoration-none">
                                    <h4><?php echo explode(':', $timeSlot)[0] ?> : <?php echo explode(':', $timeSlot)[1] ?></h4>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } ?>
</div>