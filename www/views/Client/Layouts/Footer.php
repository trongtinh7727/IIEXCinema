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
<script language="JavaScript" type="text/javascript" src="../assets/bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- JQuery -->
<script language="JavaScript" type="text/javascript" src="../assets/jquery/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#toggler-ongoing-movies').click(function(e) {
            $('#content-ongoing-movies').removeClass('d-none');
            $('#content-upcoming-movies').addClass('d-none');
            $('#toggler-ongoing-movies').find('a').addClass('text-yellow');
            $('#toggler-upcoming-movies').find('a').removeClass('text-yellow');
        });
        $('#toggler-upcoming-movies').click(function(e) {
            $('#content-ongoing-movies').addClass('d-none');
            $('#content-upcoming-movies').removeClass('d-none');
            $('#toggler-upcoming-movies').find('a').addClass('text-yellow');
            $('#toggler-ongoing-movies').find('a').removeClass('text-yellow');
        });
        $('.carousel-control-next, .carousel-control-prev').click(function() {
            $('.trailer-video').attr('src', $('.trailer-video').attr('src'));
        });

    })

    function get_upcoming_movies() {
        fetch('./?api/movie/upcoming').then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.status)
                    $.each(json.data, function(index, movie) {
                        let cardTemplate = `
                                     <div name="upcoming-movie-item" class="movie-item col-12 col-lg-6 col-xl-4">
                                        <div class="card bg-transparent border-0">
                                            <img name="upcoming-movie-item-poster" src="" class="card-img-top rounded-5 movie-image" alt="Poster">
                                            <div class="card-body">
                                                <h3 name="upcoming-movie-item-title" class="card-title text-white text-center"></h3>
                                                <p class="card-text text-center">
                                                    <img src="../assets/img/homepage/2dtag.png" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    <div>`;
                        let $card = $(cardTemplate);
                        let $cardContainer = $('#upcoming-movies-list');
                        $card.find('[name="upcoming-movie-item-poster"]').attr('src', movie.POSTER);
                        $card.find('[name="upcoming-movie-item-title"]').text(movie.TITLE);
                        // $card.find('img').attr('src', movie.tag);
                        $cardContainer.append($card);
                    });
                else
                    alert(json.message)
            })
            .catch(err => console.log(err))
    }

    function get_ongoing_movies() {
        fetch('./?api/movie/ongoing').then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.status)
                    $.each(json.data, function(index, movie) {
                        let cardTemplate = `
                                     <div name="ongoing-movie-item" class="movie-item col-12 col-lg-6 col-xl-4">
                                        <div class="card bg-transparent border-0">
                                            <img name="ongoing-movie-item-poster" src="" class="card-img-top rounded-5 movie-image" alt="Poster">
                                            <div class="card-body">
                                                <h3 name="ongoing-movie-item-title" class="card-title text-white text-center"></h3>
                                                <p class="card-text text-center">
                                                    <img src="../assets/img/homepage/2dtag.png" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    <div>`;
                        let $card = $(cardTemplate);
                        let $cardContainer = $('#ongoing-movies-list');
                        $card.find('[name="ongoing-movie-item-poster"]').attr('src', movie.POSTER);
                        $card.find('[name="ongoing-movie-item-title"]').text(movie.TITLE);
                        // $card.find('img').attr('src', movie.tag);
                        $cardContainer.append($card);
                    });
                else
                    alert(json.message)
            })
            .catch(err => console.log(err))
    }

    function get_trailer_movies() {
        fetch('./?api/movie/gettrailer').then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.status)
                    $.each(json.data, function(index, movie) {
                        let cardTemplate = `
                            <div class="carousel-item col-12">
                                <div align="center">
                                    <iframe width="560" height="315" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            </div>`;
                        let $card = $(cardTemplate);
                        let $cardContainer = $('#trailer-container');
                        $card.find('iframe').attr('src', movie.trailer);
                        // $card.find('[name="ongoing-movie-item-title"]').text(movie.TITLE);
                        // $card.find('img').attr('src', movie.tag);
                        $cardContainer.append($card);
                    });
                else
                    alert(json.message)
            })
            .catch(err => console.log(err))
    }
    $(function() {
        // get_ongoing_movies();
        get_trailer_movies();
        $("#toggler-ongoing-movies").click(get_ongoing_movies());
        $("#toggler-upcoming-movies").click(get_upcoming_movies());
    })
</script>