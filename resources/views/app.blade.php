<!DOCTYPE html>
<html class='scroll-smooth' lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Food Court Main') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}


    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="resources/js/app.js"></script> --}}

    @inertiaHead
</head>

<style>
    @keyframes pulse{
        0% {scale: 1;}
        100% {scale: 1.1;}
    }
</style>

<body class="font-sans antialiased" style="margin: 0;padding: 0; height: 100vh;">
    <div id="init_page" style="width: 100%; height: 100%; margin: 0; overflow: hidden; display: flex; justify-content: center; align-items: center;">
        <img src="\storage\images\logo.webp" alt="" style="height: 50%; animation: pulse 2s infinite">
    </div>
    @inertia
</body>

</html>
