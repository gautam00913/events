<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="Gautier DJOSSOU <gautierdjossou@gmail.com>">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="images/jpeg" href="{{ asset('images/e-event-icon.jpeg') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('build/assets/app.4b36baa3.css') }}">

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body>
        <div class="font-sans text-white bg-purple-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
