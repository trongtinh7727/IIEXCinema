<script>
    function get_upcoming_movies() {
        fetch('./?api/movie/upcoming').then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.status)
                    $.each(json.data, function(index, movie) {
                        let cardTemplate = `
                                     <div class="content-ongoing-movies-item col-12 col-lg-6 my-3">
                                        <div class="content-ongoing-movies-item-inner rounded-4 mx-2 py-3 row justify-content-center">
                                            <img class="col-12 col-lg-6 object-fit-contain w-50" src="${movie.POSTER}"
                                                alt="Poster">
                                            <div class="col-12 col-lg-6">
                                                <div class="ongoing-movies-list-item-title fs-4 text-capitalize fw-semibold my-2">${movie.TITLE}</div>
                                                <div class="ongoing-movies-list-item-description my-2">${movie.STORY}</div>
                                                <img class="ongoing-movies-list-item-tag my-2" src="../assets/img/homepage/2dtag.png"
                                                    alt="2D tag">
                                                <br>
                                                <div
                                                    class="ongoing-movies-list-item-description-btn fs-5 fw-medium bg-green hover-bg-yellow p-2 rounded-3 my-2 text-center">
                                                    <a class="text-decoration-none text-dark"
                                                        href="./?moviedetail&id=${movie.ID}">Xem
                                                        chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
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
                                     <div class="content-ongoing-movies-item col-12 col-lg-6 my-3">
                                        <div class="content-ongoing-movies-item-inner rounded-4 mx-2 py-3 row justify-content-center">
                                            <img class="col-12 col-lg-6 object-fit-contain w-50" src="${movie.POSTER}"
                                                alt="Poster">
                                            <div class="col-12 col-lg-6">
                                                <div class="ongoing-movies-list-item-title fs-4 text-capitalize fw-semibold my-2">${movie.TITLE}</div>
                                                <div class="ongoing-movies-list-item-description my-2">${movie.STORY}</div>
                                                <img class="ongoing-movies-list-item-tag my-2" src="../assets/img/homepage/2dtag.png"
                                                    alt="2D tag">
                                                <br>
                                                <div
                                                    class="ongoing-movies-list-item-description-btn fs-5 fw-medium bg-green hover-bg-yellow p-2 rounded-3 my-2 text-center">
                                                    <a class="text-decoration-none text-dark"
                                                        href="./?moviedetail&id=${movie.ID}">Xem
                                                        chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                        let $card = $(cardTemplate);
                        let $cardContainer = $('#ongoing-movies-list');
                        $cardContainer.append($card);
                    });
                else
                    alert(json.message)
            })
            .catch(err => console.log(err))
    }


    $(function() {
        // get_ongoing_movies();
        // get_trailer_movies();
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