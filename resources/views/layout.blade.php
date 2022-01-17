<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Application Name -->
    <title>{{ config('app.name', 'Laravel') . ' - ' . ($title ?? (strtolower(config('app.env')) === "prod" ? trans('layout.prod') : trans('layout.dev'))) }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.svg') }}"/>

    <!-- Styles -->
    @yield('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @yield('scripts')
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-neutral-700">

<!-- CONTENT -->
@yield('content')

</body>
</html>
