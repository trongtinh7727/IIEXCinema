<script>
    function get_upcoming_movies() {
        fetch('./?api/movie/upcoming').then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.status)
                    $.each(json.data, function(index, movie) {
                        let cardTemplate = `
                                     <div name="upcoming-movie-item" class="movie-item col-12 col-lg-6 col-xl-4">
                                      <a href="./?moviedetail&id=${movie.ID}">      
                                        <div class="card bg-transparent border-0">
                                                <img name="upcoming-movie-item-poster" src="" class="card-img-top rounded-5 movie-image" alt="Poster">
                                                <div class="card-body">
                                                    <h3 name="upcoming-movie-item-title" class="card-title text-white text-center"></h3>
                                                    <p class="card-text text-center">
                                                        <img src="../assets/img/homepage/2dtag.png" alt="">
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
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
                                     <a href="./?moviedetail&id=${movie.ID}">   
                                        <div class="card bg-transparent border-0">
                                                <img name="ongoing-movie-item-poster" src="" class="card-img-top rounded-5 movie-image" alt="Poster">
                                                <div class="card-body">
                                                    <h3 name="ongoing-movie-item-title" class="card-title text-white text-center"></h3>
                                                    <p class="card-text text-center">
                                                        <img src="../assets/img/homepage/2dtag.png" alt="">
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
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
</script>