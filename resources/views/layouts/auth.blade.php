<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.partials.css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container">
                    <div class="logo-container">
                        <div class="logo">
                            SAF
                        </div>
                        <h2 class="system-title">Sistema</h2>
                        <p class="system-subtitle">Academico Financiero</p>
                    </div>
                    @yield('content')
                    @if (Route::has('password.request'))
                        <div class="support-link d-none">
                            <a href="{{ route('password.request') }}">
                                <i class="fas fa-question-circle mr-1"></i>
                                Olvidó su contraseña?
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.javascript')
    @stack('javascript')
</body>

</html>
