<div id="content">
    <!-- Toggler -->
    <div id="content-toggler" class="py-4">
        <div class="container position-relative">
            <div class="row">
                <div id="content-icon-camera" class="col col-lg-2 text-yellow fs-1">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div id="toggler-ongoing-movies" class="col-12 col-lg-5 fs-3 d-flex justify-content-center py-sm-2">
                    <a class="text-decoration-none border-0 bg-transparent fw-semibold hover-green text-white text-yellow">Phim
                        đang
                        chiếu</a>
                </div>
                <div id="toggler-upcoming-movies" class="col-12 col-lg-5 fs-3 d-flex justify-content-center py-sm-2">
                    <a class="text-decoration-none border-0 bg-transparent fw-semibold hover-green text-white">Phim
                        sắp
                        chiếu</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div id="main-content" class="container-fluid">

        <!-- Ongoing movie -->
        <div id="content-ongoing-movies" class="row" style="background-color: rgba(217, 217, 217, 0.25);">
            <!-- Ongoing Movies list -->
            <div id="ongoing-movies-list" class="col-lg-9 row mt-5 mx-auto">
                <!-- @TODO:  Movie item -->
            </div>


        </div>

        <!-- Upcoming movie -->
        <div id="content-upcoming-movies" class="row d-none" style="background-color: rgba(217, 217, 217, 0.25);">
            <!-- Upcoming Movies list -->
            <div id="upcoming-movies-list" class="col-lg-9 row mt-5 mx-auto">
                <!-- DATAFILL - Movie item -->
            </div>


        </div>
    </div>
</div>

<!-- Trailer part -->
<div id="trailer">
    <!-- Separator -->
    <div id="trailer-separator" class="py-4">
        <div class="container position-relative">
            <div class="d-flex justify-content-start align-items-center">
                <div id="trailer-icon-play" class="text-yellow fs-1 me-5">
                    <i class="fa-solid fa-play"></i>
                </div>
                <div id="trailer-text" class="text-white">
                    <h1>Trailers</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main trailer -->
    <div id="carousel-trailer" class="carousel slide py-5">
        <div class="carousel-inner row" id="trailer-container">
            <div class="carousel-item col-12 active">
                <div align="center">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/BQ1pusupDK0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-trailer" data-bs-slide="prev">
                <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                <span aria-hidden="true"><i class="fa-solid fa-chevron-left fa-2xl text-yellow"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-trailer" data-bs-slide="next">
                <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                <span aria-hidden="true"><i class="fa-solid fa-chevron-right fa-2xl text-yellow"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>