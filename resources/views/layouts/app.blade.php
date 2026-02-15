@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ANFIS')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    (function () {
        const saved = localStorage.getItem('theme');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;


        const useDark = saved ? (saved === 'dark') : true;

        if (useDark) document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
    })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300">

    @include('partials.header')


<main class="flex-1 bg-[rgb(var(--ui-surface))]">
    <div class="ui-container">
        <div class="ui-page">
            @yield('content')
        </div>
    </div>
</main>





    {{-- <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            @yield('content')
        </div>
    </main> --}}

    @include('partials.footer')

</body>
</html>
