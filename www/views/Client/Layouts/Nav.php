<div id="toppart" class="pb-5">
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg bg-transparent" aria-label="Thirteenth navbar example" style="background: transparent;">
        <div class="container-fluid">
            <!-- Navbar toggler for mobile -->
            <button class="navbar-toggler collapsed bg-yellow" type="button" data-bs-toggle="collapse" data-bs-target="#homepageNavBar" aria-controls="homepageNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse d-lg-flex collapse mt-sm-3" id="homepageNavBar">
                <a class="navbar-brand col-lg-3 me-0" href="./?">
                    <img src="../assets/img/homepage/Logo.png" alt="Logo" style="height: 4rem;">
                </a>
                <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                    <li class="nav-item position-relative">
                        <a id="HomePage" class="nav-link mx-4 hover-green fs-5 fw-semibold text-white  " aria-current="page" href="./?">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" aria-current="page" href="./?movie">Phim</a>
                    </li>
                    <li class="nav-item">
                        <a id="Showtime" class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" aria-current="page" href="./?showtime">Lịch chiếu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" aria-current="page" href="../template_promotion/">Khuyến mãi</a>
                    </li>
                </ul>
                <div id="btn-signin" class="d-lg-flex col-lg-3 justify-content-lg-end">
                    <?php
                    if (isset($_SESSION['userLogin']['name'])) {
                    ?>
                        <a href="./?profile" class="btn text-green text-decoration-none hover-yellow">
                            <?php
                            echo $_SESSION['userLogin']['name'];
                            ?>
                        </a>
                    <?php
                    } else {
                    ?>
                        <a href="./?login" class="btn text-green text-decoration-none hover-yellow">
                            <?php
                            echo 'Đăng nhập';
                            ?>
                        </a>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </nav> <!-- Slider -->
    <!-- Sidenav -->
    <div id="profileSideNav" class="sidenav">
        <a class="position-absolute p-2 text-decoration-none text-dark bg-yellow fs-5 fw-medium d-flex align-items-center justify-content-between" href="./?profile" id="profileDetails">
            Thông tin tài khoản
            <i class="fa-solid fa-user"></i>
        </a>
        <a class="position-absolute p-2 text-decoration-none text-dark hover-bg-green fs-5 fw-medium d-flex align-items-center justify-content-between" href="./?bookinghistory" id="bookingHistory">
            Lịch sử đặt vé
            <i class="fa-solid fa-clock-rotate-left"></i>
        </a>
        <a class="position-absolute p-2 text-decoration-none text-white hover-bg-green fs-5 fw-medium d-flex align-items-center justify-content-between" href="./?changepassword" id="changePassword">
            Đổi mật khẩu
            <i class="fa-solid fa-key"></i>
        </a>
        <a class="position-absolute p-2 text-decoration-none text-white hover-bg-green fs-5 fw-medium d-flex align-items-center justify-content-between" href="./?logout" id="logout">
            Đăng xuất
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </div>

    <!-- Swiper -->
    <div id="toppartSwiper" class="swiper w-100 py-5 mt-4">
        <div class="swiper-wrapper">
            <?php
            foreach ($ongoing as $movie) {
            ?>
                <!-- Swiper Slide -->
                <div class="swiper-slide rounded-4">
                    <div class="swiper-slide-inner row px-lg-5">
                        <div class="swiper-slide-inner-left col-12 col-xl-5 position-relative px-0">
                            <!-- DATAFILL Poster -->
                            <a href="./?moviedetail&id=<?php echo $movie->ID ?>"><img class="align-self-center position-absolute" src="<?php echo $movie->POSTER ?>" alt="Swiper Photo"></a>

                        </div>
                        <div class="swiper-slide-inner-right col-12 col-xl-7 text-white">
                            <div class="swiper-slide-inner-right-main ms-4 py-3">
                                <!-- DATAFILL Title -->
                                <h3 name="swiper-slide-inner-movie-title"> <a href="./?moviedetail&id=<?php echo $movie->ID ?>"><?php echo $movie->TITLE ?></a></h3>
                                <!-- DATAFILL Rating -->
                                <div class="swiper-movie-rating text-green my-2">
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                    <i class="fa-solid fa-star fa-xl"></i>
                                </div>
                                <!-- DATAFILL Description -->
                                <p class="swiper-slide-inner-movie-desc my-2">
                                    <?php echo $movie->STORY ?>
                                </p>
                                <!-- DATAFILL Actors -->
                                <div class="swiper-slide-inner-movie-actors my-2">
                                    <h3>Diễn viên</h3>
                                    <div class="swiper-slide-inner-movie-actors-img d-flex">
                                        <?php echo $movie->ACTORS ?>
                                    </div>
                                </div>
                                <!-- Trailer -->
                                <div class="swiper-slide-inner-movie-trailer" id="trailer-btn">
                                    <button onclick="changeTrailer(this)" id="swiper-slide-inner-movie-trailer-modal-trigger" type="button" class="btn mt-3 px-3 bg-green hover-bg-yellow" data-bs-toggle="modal" data-bs-target="#swiper-slide-inner-movie-trailer-modal">
                                        <i class="fa-solid fa-play me-2"></i>
                                        Trailer
                                    </button>
                                    <input type="hidden" value="<?php echo $movie->TRAILER ?>">
                                </div>
                            </div>
                            <script>

                            </script>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-prev text-yellow hover-green"></div>
        <div class="swiper-button-next text-yellow hover-green"></div>
    </div>
</div>

<!-- Swiper Trailer Modal -->
<div class="modal fade" id="swiper-slide-inner-movie-trailer-modal" tabindex="-1" aria-labelledby="swiper-slide-inner-movie-trailer-modal-Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background-color: transparent;">
            <div align="center">
                <iframe id="trailerswiper" class="swiper-trailer-video" src="https://www.youtube.com/embed/xy8RznX_uyM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>