@php
    $sidebar = App\Http\Controllers\Dashboard::getAllSidebar();
    $area = App\Http\Controllers\MasterArea::getListArea();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nasmoco Siliwangi - Register Account</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
{{--                <div class="col-lg-3 d-none d-lg-block bg-register-image"></div>--}}
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat akun baru</h1>
                        </div>
                        <form class="user" id="formRegister">
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputUsername" placeholder="Masukkan username yang anda inginkan" autocomplete="off">
                                <small id="inputUsername" class="form-text text-muted">Username ini akan digunakan untuk login.</small>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputEmail" placeholder="Email" autocomplete="off">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="inputRepeatPassword" placeholder="Repeat Password">
                                </div>
                            </div>

                            <hr style="border-width: 10px">
                            <p><strong>Menu Permission</strong></p>
                            @foreach($sidebar as $s)
                                <div class="form-group row">
                                    <div class="col-sm-2">{{ $s['group']['nama'] }}</div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            @foreach($s['menu'] as $m)
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        @if(in_array($m['id'],['9','8']))
                                                            <input class="form-check-input" type="checkbox" id="permission_{{ $m['id'] }}" name="menu_permission[]" value="{{ $m['id'] }}" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" id="permission_{{ $m['id'] }}" name="menu_permission[]" value="{{ $m['id'] }}">
                                                        @endif
                                                            <label class="form-check-label" for="permission_{{ $m['id'] }}">{{ $m['nama'] }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            <hr style="border-width: 10px">
                            <div class="form-group row">
                                <div class="col-sm-2">Pilih Area</div>
                                <div class="col-sm-10">
                                    <div class="row">
                                        @foreach($area as $a)
                                            <div class="col-sm-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="area_{{ $a->id }}" name="area_permission[]" value="{{ $a->id }}">
                                                    <label class="form-check-label" for="area_{{ $a->id }}">{{ $a->nama }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 10px">
                            <button type="submit" class="btn btn-primary btn-block">Daftarkan Akun</button>
                            <small id="emailHelp" class="form-text text-muted">
                                Perhatian: <strong>Admin memiliki kewenangan untuk merubah Menu Permission dan Area Permission yang dapat anda akses.</strong>
                                <br>
                                <strong>Untuk mempercepat proses pendaftaran, silahkan check Menu Permission dan Area Permission yang sesuai dengan kebutuhan anda.</strong>
                            </small>
                            <hr style="border-width: 10px">

{{--                            <a href="index.html" class="btn btn-google btn-user btn-block">--}}
{{--                                <i class="fab fa-google fa-fw"></i> Register with Google--}}
{{--                            </a>--}}
{{--                            <a href="index.html" class="btn btn-facebook btn-user btn-block">--}}
{{--                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook--}}
{{--                            </a>--}}
                        </form>
{{--                        <hr>--}}
{{--                        <div class="text-center">--}}
{{--                            <a class="small" href="forgot-password.html">Forgot Password?</a>--}}
{{--                        </div>--}}
                        <div class="text-center">
                            <a class="small" href="{{ url('dashboard/login') }}">Anda ingin login?</a>
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

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<script>
    const formRegister = $('#formRegister');
    formRegister.submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: "{{ url('dashboard/master/user/permission') }}",
            method: "post",
            data: {username: username},
            success: function(result) {
                var data = JSON.parse(result);
                let permission = data.permission;
                let area = data.area;
                permission.forEach(function(val, i) {
                    $('#permission_'+val['id_menu']).prop('checked',true);
                });
                area.forEach(function(val, i) {
                    $('#area_'+val['id_area']).prop('checked',true);
                });
            }
        });
    })
</script>

</body>

</html>
