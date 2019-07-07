<!DOCTYPE html>
<html>
<head>
    <title>Nasmoco Siliwangi - LOGIN</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/bulma-0.7.5/css/bulma.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .footer {
            padding: 1rem 1.5rem 1rem 3rem;
        }
    </style>
</head>
<body>
<section class="hero is-link is-bold is-fullheight">
    <div class="hero-head">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item has-text-weight-bold">
                        NASMOCO Kaligawe
                    </a>
                    <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                </div>
                <div id="navbarMenuHeroA" class="navbar-menu">
                    <div class="navbar-end">
                        <a class="navbar-item is-active">
                            Login
                        </a>
                        <a class="navbar-item">
                            Register
                        </a>
                        <a class="navbar-item">
                            Forget Password
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns">
                <div class="column is-4 is-offset-4">
                    <h1 class="title">
                        LOGIN
                    </h1>
                    <hr>
                    <form method="post" id="form-login">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input
                                        class="input is-primary has-text-centered is-medium"
                                        type="text"
                                        name="username"
                                        autocomplete="off"
                                        placeholder="e-mail / username"
                                        autofocus>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input
                                        class="input is-primary has-text-centered is-medium"
                                        type="password"
                                        name="password"
                                        autocomplete="off"
                                        placeholder="password">
                            </div>
                        </div>
                        <hr>
                        <div class="columns">
                            <div class="column">
                                <button
                                        class="button is-white is-outlined is-fullwidth"
                                        type="submit"
                                >Forget Password?</button>
                            </div>
                            <div class="column">
                                <button
                                        class="button is-success is-fullwidth"
                                        type="submit"
                                >LOGIN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <div class="columns">
            <div class="column has-text-left">
                NASMOCO Siliwangi
            </div><div class="column has-text-right">
                version 0.1.1
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/navbar.bulma.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#form-login').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('dashboard/login/check') }}",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: $(this).serialize(),
                success: function(result) {
                    window.location.href = "{{ url('dashboard') }}";
                }
            });
        })
    })
</script>
</body>
</html>