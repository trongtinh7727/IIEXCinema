<div id="toppart">
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
                        <a class="nav-link mx-4 text-yellow fs-5 fw-semibold active custom-active" aria-current="page" href="./?">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" href="#">Phim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" href="../template_showtime/index.html">Lịch chiếu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-4 text-white hover-green fs-5 fw-semibold" href="../template_promotion/">Khuyến mãi</a>
                    </li>
                </ul>
                <div id="btn-signin" class="d-lg-flex col-lg-3 justify-content-lg-end">
                    <?php
                    if (isset($_SESSION['userLogin']['username'])) {
                    ?>
                        <a href="./?logout" class="btn text-green text-decoration-none hover-yellow">
                            <?php
                            echo $_SESSION['userLogin']['username'];
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
</div>