<!-- Bootstrap 5.3 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- JQuery -->
<script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- JQuery -->
<script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

<!-- Swiper -->
<script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
    $(document).ready(function() {
        const swiper = new Swiper("#toppartSwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            }
        });

        swiper.on('transitionEnd', function() {
            var newSrc = $('.swiper-slide-active .swiper-slide-inner-right-main input[type="hidden"]').val();
            $('#trailerswiper').attr('src', newSrc);
        });

        $("#swiper-slide-inner-movie-trailer-modal").on("hidden.bs.modal", function() {
            $('.swiper-trailer-video').attr('src', $('.trailer-video').attr('src'));
        });
    })
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault();

            var firstName = $('input[name="FIRSTNAME"]').val().trim();
            var lastName = $('input[name="LASTNAME"]').val().trim();
            var birthday = $('input[name="BIRTHDAY"]').val().trim();
            var address = $('input[name="ADDRESS"]').val().trim();
            var phone = $('input[name="PHONE"]').val().trim();

            // Perform validation checks
            var isValid = true;

            if (firstName.length == 0) {
                isValid = false;
                alert('Họ không được để trống');
            }

            if (lastName.length == 0) {
                isValid = false;
                alert('Tên không được để trống');
            }

            if (birthday.length == 0) {
                isValid = false;
                alert('Ngày sinh không được để trống');
            }

            if (address.length == 0) {
                isValid = false;
                alert('Địa chỉ không được để trống');
            }

            if (phone.length == 0) {
                isValid = false;
                alert('Số điện thoại không được để trống');
            }
            var phoneRegex = /^\d{10}$/;

            if (!phoneRegex.test(phone)) {
                isValid = false;
                alert('Số điện thoại không đúng');
            }

            if (!isValid) {
                return false;
            }

            // If all validation checks pass, submit the form
            this.submit();
        });
    });
</script>