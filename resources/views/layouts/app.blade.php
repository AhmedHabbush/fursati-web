<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>{{ config('app.name', 'Fursati') }}</title>

    <!-- Fonts -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

{{-- Navigation --}}
@include('layouts.navigation')

{{-- Optional Page Header --}}
@hasSection('header')
    <header class="bg-white shadow">
        <div class="container mx-auto max-w-7xl py-6 px-4">
            @yield('header')
        </div>
    </header>
@endif

{{-- Page Content --}}
<main class="container mx-auto flex-1 px-4 py-6 max-w-7xl">
    @yield('content')
</main>

</body>
</html>
