<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PetFy') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased flex flex-col min-h-screen">

        @include('partials.nav')

        <div class="flex-1 flex flex-col sm:justify-center items-center pt-8 pb-12
                    bg-gradient-to-br from-petfy-light/20 to-petfy/10">

            <div class="w-full sm:max-w-md px-6 py-6 bg-white overflow-hidden sm:rounded-2xl"
                 style="box-shadow: 0 2px 24px rgba(33,147,176,0.13);">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
