<nav class="navbar navbar-expand-sm navbar-light bg-white shadow" style="height: 60px;">
    <div class="container-fluid">

        <!-- Left -->
        <div>
            <!-- Side navigation button -->
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="../assets/img/logo.png" height="60rem" alt="IIEX Logo" loading="lazy" />
            </a>
        </div>

        <!-- Right -->
        <div>
            <button id="btn_logout" type="button" name="btn_logout" class="btn text-white shadow border-0 btn_custom" data-bs-toggle="modal" data-bs-target="#signOutModal">
                Log out
                <i class="fa-solid fa-right-from-bracket ms-2"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Side navigation -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width: 280px;">

    <!-- Offcanvas header -->
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Admin Control Panel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Offcanvas body -->
    <div class="offcanvas-body">
        <a href="./?admin/staff" id="Staff" class="btn btn-lg  my-1 w-100">
            Quản lý nhân viên
        </a>
        <a href="/?admin/theater" id="theater" class="btn btn-lg my-1 w-100">
            Quản lý phòng chiếu phim
        </a>
        <a href="/?admin/movie" id="Movie" class="btn btn-lg my-1 w-100">
            Quản lý phim
        </a>
        <a href="/?admin/schedule" id="Schedule" class="btn btn-lg my-1 w-100">
            Quản lý lịch chiếu phim
        </a>
        <a href="/?admin/product" id="Product" class="btn btn-lg my-1 w-100">
            Quản lý sản phẩm
        </a>
    </div>

    <!-- Offcanvas footer -->
    <div class="offcanvas-bottom">

    </div>
</div>