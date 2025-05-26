<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SAF') }} - @yield('title')</title>
    @include('layouts.partials.css')
</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')
        <div class="main-panel">
            <div class="content">
                @yield('content')
            </div>
            @include('layouts.partials.footer')
        </div>
        @if (session('status'))
            <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
                data-msg="{{ session('status.msg') }}">
        @endif
    </div>

    @include('layouts.partials.javascript')
    @stack('scripts')

</body>

</html>
