<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login Page - Nasmoco Siliwangi Sales System">
    <meta name="author" content="Nasmoco Siliwangi">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nasmoco Siliwangi - LOGIN</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free-5.9.0-web/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Sweetalert 2 -->
    <link href="{{ asset('vendor/sweetalert2-8.13.1/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <blockquote class="blockquote">
                                        <h1 class="h4 text-gray-900">NASMOCO Siliwangi</h1>
                                        <footer class="blockquote-footer">Sales System</footer>
                                    </blockquote>
                                </div>
                                <form class="user" id="form_login">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan username anda disini" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password anda">
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block">LOGIN</button>
{{--                                    <hr>--}}
{{--                                    <a href="index.html" class="btn btn-google btn-user btn-block">--}}
{{--                                        <i class="fab fa-google fa-fw"></i> Login with Google--}}
{{--                                    </a>--}}
{{--                                    <a href="index.html" class="btn btn-facebook btn-user btn-block">--}}
{{--                                        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook--}}
{{--                                    </a>--}}
                                </form>
{{--                                <hr>--}}
{{--                                <div class="text-center">--}}
{{--                                    <a class="small" href="forgot-password.html">Forgot Password?</a>--}}
{{--                                </div>--}}
{{--                                <div class="text-center">--}}
{{--                                    <a class="small" href="register.html">Create an Account!</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Sweetalert 2-->
<script src="{{ asset('vendor/sweetalert2-8.13.1/sweetalert2.all.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

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