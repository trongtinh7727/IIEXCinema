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
                    <a href="/?changepassword">
                        <button id="btn-logout" type="button" name="btn-logout" class="btn text-white shadow border-0 btn-custom">
                            Đổi mật khẩu
                            <i class="fa-solid fa-key"></i>
                        </button>
                    </a>
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
        </div>