<script>
    function load_movie() {
        let ID = <?php echo $movie_id; ?>;
        $.post("./?api/movie/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#TITLE').text(object.TITLE)
                $('#DIRECTOR').text(object.DIRECTOR)
                $('#ACTORS').text(object.ACTORS)
                $('#GENRE').text(object.GENRE)
                $('#STORY').text(object.STORY)
                $('#DURATION').text(object.DURATION + " phút")
                $('#OPENING_DAY').text("Từ ngày " + object.OPENING_DAY + " đến ngày " + object.CLOSING_DAY)
                $('#POSTER').attr('src', object.POSTER);
                $('#TRAILER').attr('src', object.TRAILER)
                console.log(object)
            });
        }, "json");
    }


    $(function() {
        // load_schedule();
        load_movie();
    })
</script>