<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IIEX Cinema - Thông tin của bạn</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <?php include_once(__DIR__ . "/"  . "/Style.php"); ?>
</head>

<body>
    <div id="wrapper" class="min-vh-100 d-flex flex-column">
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

        <!-- Main -->
        <div class="container">
            <div id="bookingHistory-main" class="rounded-4">
                <div id="bookingHistory-main-inner" class="card mx-auto pb-4 pt-2 my-4 shadow rounded-4 container text-white">
                    <!-- Title + Button -->
                    <div id="bookingHistory-main-inner-title" class="card-header rounded-top-4 mb-3">
                        <span class="fs-4 fw-medium">Lịch sử đặt vé</span>
                        <br>
                        <span>Kiểm tra lịch sử đặt vé của bạn </span>
                    </div>

                    <!-- Main -->
                    <div class="container">
                        <table id="bookingHistoryDataTable" class="table table-dark table-borderless table-hover dt-responsive nowrapt">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề phim</th>
                                    <th>Ngày đặt vé</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Số ghế</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $transaction) {
                                ?>
                                    <tr>
                                        <td><?php echo $transaction['ID'] ?></td>
                                        <td><?php echo $transaction['TITLE'] ?></td>
                                        <td><?php echo $transaction['CREATED_AT'] ?></td>
                                        <td><?php echo $transaction['STARTTIME'] ?></td>
                                        <td><?php echo $transaction['Seats'] ?></td>
                                        <td>
                                            <a href="./?booking&id=<?php echo $transaction['ID'] ?>">Chi tiết</a>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div id="footer" class="container-fluid" style="background-color: rgba(0, 19, 55, 0.48);">
            <div class="container">
                <footer class="d-flex flex-wrap justify-content-between align-items-center py-5 text-white">
                    <!-- Logo -->
                    <a class="col-12 navbar-brand col-lg-4 me-0 border-end" href="#">
                        <img src="../assets/img/homepage/Logo.png" alt="Logo" style="height: 4rem;">
                    </a>
                    <!-- Link -->
                    <div class="col-12 col-lg-4 d-flex justify-content-center flex-column my-2">
                        <div class="row ms-5 my-1">
                            <div class="col-12 col-md-4 ps-0 py-2">
                                <a href="#" class="text-white hover-yellow text-decoration-none">Trang chủ</a>
                            </div>
                            <div class="col-12 col-md-4 ps-0 py-2">
                                <a href="#" class="text-white hover-yellow text-decoration-none">Hỗ trợ</a>
                            </div>
                            <div class="col-12 col-md-4 ps-0 py-2">
                                <a href="#" class="text-white hover-yellow text-decoration-none">Liên hệ</a>
                            </div>
                        </div>
                        <div class="ms-5 my-1">
                            <p class="mb-0">Copyright © 2023, IIEX Cinema</p>
                        </div>
                    </div>
                    <!-- Brand -->
                    <ul class="col-12 col-lg-4 nav justify-content-end">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white hover-yellow"><i class="fa-brands fa-facebook fa-2xl"></i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white hover-yellow"><i class="fa-brands fa-instagram fa-2xl"></i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white hover-yellow"><i class="fa-brands fa-twitter fa-2xl"></i></a></li>
                    </ul>
                </footer>
            </div>
        </div>
    </div>
    <?php include_once(__DIR__ . "/" . "/Script.php"); ?>
</body>

</html>