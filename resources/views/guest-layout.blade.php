<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nabungan') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:justify-center sm:pt-0 bg-[#F4F6FB]">
        <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-md overflow-hidden rounded-2xl">
            {{ $slot }}
        </div>
        <p class="mt-6 text-[#6B84B8] font-bold">VaultTrack <span class="font-normal">| PREMIUM SAVINGS</span></p>
    </div>
</body>
</html>