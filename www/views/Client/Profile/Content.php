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

    <?php include_once(__DIR__  . "/Style.php"); ?>
</head>

<body>
    <div id="wrapper" class="min-vh-100 d-flex flex-column">

        <?php include_once(__DIR__  . "/Nav.php"); ?>
        <!-- Main -->
        <?php include_once(__DIR__  . "/".$path.".php"); ?>
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
    <?php include_once(__DIR__ . "/Script.php"); ?>
</body>

</html>