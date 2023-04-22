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