<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Fursati')</title>

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-…"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<body class="flex h-screen bg-gray-100 overflow-hidden">

<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-gray-200 overflow-auto p-6">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-8">Fursati</h1>
        <nav class="space-y-4">
            <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                <i class="fas fa-briefcase w-6"></i>
                <span class="mr-3">وظائف</span>
            </a>
            <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                <i class="fas fa-bookmark w-6"></i>
                <span class="mr-3">المحفوظات</span>
            </a>
            <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                <i class="fas fa-cog w-6"></i>
                <span class="mr-3">الإعدادات</span>
            </a>
            <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                <i class="fas fa-user-circle w-6"></i>
                <span class="mr-3">الملف</span>
            </a>
        </nav>
    </div>
</aside>

<!-- Main content -->
<main class="flex-1 overflow-auto p-8">
    @yield('content')
</main>
</body>
</html>
