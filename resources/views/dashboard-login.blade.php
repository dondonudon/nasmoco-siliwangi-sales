<!DOCTYPE html>
<html lang="en">
<head>
    <title>NASMOCO SILIWANGI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('img/logosiliwangilingkaran.png') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free-5.9.0-web/css/all.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">
    <!--===============================================================================================-->
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{ asset('img/logosiliwangilingkaran.png') }}" alt="IMG">
            </div>

            <form class="login100-form validate-form" id="form_login">
                <span class="login100-form-title">NASMOCO Siliwangi</span>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/tilt/tilt.jquery.min.js') }}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{ asset('login/js/main.js') }}"></script>

<!-- Sweetalert 2-->
<script src="{{ asset('vendor/sweetalert2-8.13.1/sweetalert2.all.min.js') }}"></script>

<script type="text/javascript">
    $('#form_login').submit(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: "{{ url('dashboard/login/check') }}",
            method: "post",
            data: $(this).serialize(),
            success: function(result) {
                let data = JSON.parse(result);
                if (data.status == 'success') {
                    window.location.replace('{{ url('dashboard') }}')
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: 'Gagal Login',
                        text: 'Silahkan cek kembali username atau password anda.'
                    });
                }
            }
        });
    })
</script>
</body>
</html>