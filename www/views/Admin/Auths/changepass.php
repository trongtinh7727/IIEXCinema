<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Font awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .poster {
            width: 100px;
            height: 120px;
        }

        .dataTables_filter {
            float: right;
        }

        .dataTables_paginate {
            float: right;
        }
    </style>
</head>

<body>
    <div id="wrapper" class="vh-100" style="background-color: #fbfbfb;">
        <!-- Top Navigation -->
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark shadow">
            <div class="container-fluid">
                <!-- Left -->
                <div>
                    <!-- Side navigation button -->
                    <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#admin-sidebar" aria-controls="admin-sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Logo -->
                    <a class="navbar-brand" href="#">
                        <img src="../assets/img/manager/Logo.png" height="60rem" alt="IIEX Logo" loading="lazy" />
                    </a>
                </div>
                <!-- Right -->
                <div>
                    <button id="btn-logout" type="button" name="btn-logout" class="btn text-white shadow border-0 btn-custom" data-bs-toggle="modal" data-bs-target="#signOutModal">
                        Đăng xuất
                        <i class="fa-solid fa-right-from-bracket ms-2"></i>
                    </button>
                </div>
            </div>
        </nav>
        <!-- Side navigation -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="admin-sidebar" aria-labelledby="admin-sidebar-title" style="width: 280px;">

            <!-- Offcanvas header -->
            <div class="offcanvas-header border-bottom">
                <h3 class="offcanvas-title" id="admin-sidebar-title">Quản lý</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Offcanvas body -->
            <div class="offcanvas-body">
                <a href="./?admin/staff" id="Staff" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Nhân viên
                </a>
                <a href="./?admin/client" id="Client" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Khách hàng
                </a>
                <a href="/?admin/cinema" id="Cinema" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Rạp chiếu phim
                </a>
                <a href="/?admin/showroom" id="Showroom" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Phòng chiếu phim
                </a>
                <a href="/?admin/movie" id="Movie" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Phim
                </a>
                <a href="/?admin/schedule" id="Schedule" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Lịch chiếu phim
                </a>
                <a href="/?admin/product" id="Product" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Sản phẩm
                </a>
                <a href="/?admin/foodcombo" id="Combo" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Combo
                </a>
                <a href="/?admin/transaction" id="Transaction" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Lịch sử đặt vé
                </a>
                <a href="/?admin/revenue" id="Revenue" class="btn btn-lg hover-bg-green my-1 w-100 text-start">
                    Doanh thu
                </a>
            </div>

            <!-- Offcanvas footer -->
            <div class="offcanvas-bottom text-dark text-center">
                Copyright © 2023, IIEX Cinema
            </div>
        </div>
        <!-- Log out modal -->
        <div class="modal fade align-content-center" id="signOutModal" tabindex="-1" aria-labelledby="signOutModalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 360px;">
                    <!-- Log out -->
                    <div class="modal-body d-flex flex-column my-4">
                        <div id="logout-modal-icon" class="m-auto align-middle">
                            <span class="align-middle">
                                <i class="fa-solid fa-door-open fa-2xl text-center w-100"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-2 text-center my-2" id="signOutModalTitle">Đăng xuất?</h1>
                        <span class="text-center text-secondary my-2">Bạn có chắc chắn rằng muốn đăng xuất?</span>
                        <button id="btn_logout" type="button" class="btn btn-danger my-2 py-2 rounded-5">Đăng xuất</button>
                        <button type="button" class="btn btn-secondary my-2 py-2 rounded-5" data-bs-dismiss="modal">Ở
                            lại</button>
                    </div>
                </div>
            </div>
        </div> <!-- Data table -->

        <div class="container">
            <div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

                <!-- Title + Button -->
                <div class="card-header bg-white rounded-top-4">
                    <span class="fs-4">Đổi mật khẩu</span>
                    <br>

                </div>


                <!-- Main -->
                <div class="container">
                    <!-- Table -->
                    <form id="change-password-form" action="./?changepassword" method="post">
                        <input type="hidden" name="tb" value="Staff">
                        <table class="mx-auto">
                            <!-- Old password -->
                            <tr style="height: 44px;">
                                <td class="text-end fw-medium">Mật khẩu cũ:</td>
                                <td><input id="password" name="password" type="password" class="mx-3 rounded-3 text-black w-100 required"></td>
                            </tr>
                            <!-- New password -->
                            <tr style="height: 44px;">
                                <td class="text-end fw-medium">Mật khẩu mới:</td>
                                <td><input id="newpassword" name="newpassword" type="password" class="mx-3 rounded-3 text-black w-100 required"></td>
                            </tr>
                            <!-- Confirm password -->
                            <tr style="height: 44px;">
                                <td class="text-end fw-medium">Xác nhận mật khẩu:</td>
                                <td><input id="confirmpassword" name="confirmpassword" type="password" class="mx-3 rounded-3 text-black w-100 required"></td>
                            </tr>

                            <!-- Submit -->
                            <tr style="height: 44px;">
                                <td></td>
                                <td class="text-end">
                                    <input type="submit" class="mx-3 px-3 rounded-3 bg-yellow hover-bg-green border-0 fw-medium" value="Xác nhận">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php if (isset($msg)) : ?>
                        <div class="alert alert-success"><?php echo $msg; ?></div>
                    <?php elseif (isset($err)) : ?>
                        <div class="alert alert-danger"><?php echo $err; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Modal -->

        </div>
    </div>
    <!-- JQuery -->
    <script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <!-- Bootstrap 5.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Datatable Bootstrap -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- ChartJS -->

    <script>
        $(function() {
            console.log("run")
            $(Staff).addClass("btn-dark")
        })

        $(document).ready(function() {
            $('#btn_logout').click(function() {
                window.location.href = './?logout';
            });
        });
        $(document).ready(function() {
            $('#change-password-form').validate({
                rules: {
                    password: {
                        required: true
                    },
                    newpassword: {
                        required: true
                    },
                    confirmpassword: {
                        required: true,
                        equalTo: '#newpassword'
                    }
                },
                messages: {
                    password: {
                        required: 'Vui lòng nhập mật khẩu cũ'
                    },
                    newpassword: {
                        required: 'Vui lòng nhập mật khẩu mới'
                    },
                    confirmpassword: {
                        required: 'Vui lòng nhập lại mật khẩu mới',
                        equalTo: 'Mật khẩu không khớp'
                    }
                },
                errorElement: 'small',
                errorClass: 'text-danger',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            });
        });
    </script>
    <!-- Log out modal -->
    <div class="modal fade align-content-center" id="signOutModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 360px;">
                <!-- Log out -->
                <div class="modal-body d-flex flex-column my-4">
                    <div id="log_out_modal_icon" class="m-auto align-middle">
                        <span class="align-middle">
                            <i class="fa-solid fa-door-open fa-2xl text-center w-100"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs-2 text-center my-2" id="addEmployeeModalLabel">Are you leaving?</h1>
                    <span class="text-center text-secondary my-2">Are you sure you want to sign out?</span>
                    <a href="./?admin/logout"><button type="button" class="btn btn-danger my-2 py-2 rounded-5">Yes, sign out</button></a>
                    <button type="button" class="btn btn-secondary my-2 py-2 rounded-5" data-bs-dismiss="modal">No,
                        I am staying</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>