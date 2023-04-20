<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIEX Cinema - sign in or sign up</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Font awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .text-yellow {
            color: #FFBA08 !important;
        }

        .bg-yellow {
            background-color: #FFBA08 !important;
        }

        input::placeholder {
            color: #ffffff;
        }

        body {
            margin: 0;
            background: url(../assets/img/signin-signup/container-main.png);
            background-size: cover;
            font: 600 16px/18px 'Open Sans', sans-serif;
        }

        .login-wrap {
            max-width: 450px;
            height: 480px;
            background: rgba(217, 217, 217, 0.25);
            background-size: cover;
            box-shadow: 0 15px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
        }

        .login-html {
            background: rgba(217, 217, 217, 0.25);
        }

        .login-html .sign-in-html,
        .login-html .sign-up-html {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: all .4s linear;
            transition: all .4s linear;
        }

        .login-html .group .input,
        .login-html .group .button {
            padding: 15px 20px;
        }

        .login-html .sign-in,
        .login-html .sign-up,
        .login-form .group .check {
            display: none;
        }

        .login-html .tab {
            font-size: 22px;
            display: inline-block;
            border-bottom: 2px solid transparent;
        }

        .login-html .sign-in:checked+.tab,
        .login-html .sign-up:checked+.tab {
            color: var(--color-1);
            border-color: var(--color-1);
        }

        .login-form {
            min-height: 345px;
            -webkit-perspective: 1000px;
            perspective: 1000px;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .login-form .group .input,
        .login-form .group .button {
            border: none;
            background: rgba(0, 0, 0, 0.05);
        }

        .login-form .group input[data-type="password"] {
            -webkit-text-security: circle;
        }

        .login-form .group .label {
            color: var(--color-1);
            font-size: 12px;
        }

        .login-form .group .button {
            background: var(--color-4);
        }

        .login-form .group .check:checked+label {
            color: #ffffff;
        }

        .login-form .group .check:checked+label .icon {
            background: var(--color-1);
        }

        .login-form .group .check:checked+label .icon:before {
            -webkit-transform: scale(1) rotate(45deg);
            transform: scale(1) rotate(45deg);
        }

        .login-form .group .check:checked+label .icon:after {
            -webkit-transform: scale(1) rotate(-45deg);
            transform: scale(1) rotate(-45deg);
        }

        .login-html .sign-in:checked+.tab+.sign-up+.tab+.login-form .sign-in-html {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        .login-html .sign-up:checked+.tab+.login-form .sign-up-html {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        .foot-lnk {
            text-align: center;
        }
    </style>

</head>

<body>
    <div id="wrapper" class="d-flex flex-column align-items-center">
        <!-- Logo -->
        <div class="my-5">
            <img class="object-fit-contain" src="../assets/img/signin-signup/Logo.png" alt="">
        </div>
        <!-- Login form -->
        <div class="login-wrap w-50 rounded-5 mx-auto mb-5">
            <div class="login-html w-100 h-100 px-5 py-5 rounded-5 clearfix">
                <!-- Tab 1 -->
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
                <label id="tab-1-label" for="tab-1" class="tab fs-3 text-white text-yellow">Đăng nhập</label>

                <!-- Tab 2 -->
                <input id="tab-2" type="radio" name="tab" class="sign-up">
                <label id="tab-2-label" for="tab-2" class="tab fs-3 text-white float-end">Đăng ký</label>

                <!-- Form main -->
                <div class="login-form">

                    <div class="sign-in-html">
                        <form action="./?login" method="post">
                            <!-- Input -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Username hoặc Email</label>
                                <input name="username" id="sign-in-user" placeholder="Username" aria-label="sign-in-username" type="text" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>

                            <!-- Input -->
                            <div class="group mt-5">
                                <label for="pass" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Mật khẩu</label>
                                <input name="password" id="sign-in-pass" placeholder="Password" aria-label="sign-in-password" type="password" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold" data-type="password">
                            </div>

                            <!-- Button -->
                            <div class="group mt-5">
                                <input type="submit" class="button rounded-5 w-100 d-block text-black fw-semibold bg-yellow fs-4" value="Đăng nhập">
                            </div>
                            <hr style="height: 2px; background-color: rgb(0, 0, 0, 0.5);">
                            <input type="hidden" name="tb" value="client">
                        </form>
                    </div>

                    <!-- Sign up -->
                    <div class="sign-up-html">
                        <form action="./?register" method="post">
                            <!-- Input -->
                            <!-- Sign up username -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Username</label>
                                <input id="sign-up-user" name="username" placeholder="Username123" type="text" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>
                            <!-- Sign up name -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Họ và tên</label>
                                <input id="sign-up-name" name="name" placeholder="abc123@xyz.com.vn" type="text" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>
                            <!-- Sign up phone -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Số điện thoại</label>
                                <input id="sign-up-phone" name="phone" placeholder="08432...." type="tel" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>

                            <!-- Sign up password -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Mật khẩu</label>
                                <input id="sign-up-password" name="password" placeholder="p@sSword" type="password" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>
                            <!-- Sign up confirm password -->
                            <div class="group mt-5">
                                <label for="user" class="label w-100 d-block text-black fw-semibold text-yellow fs-6">Xác nhận mật khẩu</label>
                                <input id="sign-up-cfpassword" placeholder="p@sSword" type="password" class="input mt-3 rounded-5 w-100 d-block text-black fw-semibold">
                            </div>
                            <div class="group mt-5">
                                <input type="submit" class="button rounded-5 w-100 d-block text-black fw-semibold bg-yellow fs-4" value="Đăng ký">
                            </div>
                        </form>
                        <hr style="height: 2px; background-color: rgb(0, 0, 0, 0.5);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

    <!-- JS -->
    <script>
        $(document).ready(function() {
            $('#tab-1').click(function(e) {
                $('.login-wrap').css({
                    "height": "540px",
                    "transition": ".3s"
                });
                $('#tab-2-label').removeClass('text-yellow')
                $('#tab-1-label').addClass('text-yellow')
            });
            $('#tab-2').click(function(e) {
                $('.login-wrap').css({
                    "height": "720px",
                    "transition": ".3s"
                });
                $('#tab-1-label').removeClass('text-yellow')
                $('#tab-2-label').addClass('text-yellow')
            });
        })
    </script>
</body>

</html>