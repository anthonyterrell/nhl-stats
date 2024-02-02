<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="apple-touch-icon" href="https://assets.nhle.com/logos/nhl/svg/CHI_light.svg">

        @vite(['resources/js/app.js'])
    </head>

    <body class="antialiased bg-slate-100">
        {{ $slot }}
    </body>
</html>
