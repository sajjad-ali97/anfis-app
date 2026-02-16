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
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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

@if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 7000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
        class="fixed top-16 inset-x-0 flex justify-center z-50 px-4"
        aria-live="polite"
    >
        <div
            class="ui-card ui-glass-strong shadow-2xl w-full max-w-xl
                   px-6 py-4 border border-black/10 dark:border-white/10"
            style="border-left: 4px solid rgb(var(--ui-accent));"
        >
            <div class="flex items-start gap-3">
                {{-- Icon --}}
                <div class="mt-0.5 shrink-0 rounded-xl p-2"
                     style="background: color-mix(in srgb, rgb(var(--ui-accent)) 14%, transparent);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor"
                         class="h-5 w-5"
                         style="color: rgb(var(--ui-accent));">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.28-2.97a.75.75 0 1 0-1.06-1.06l-3.72 3.72-1.22-1.22a.75.75 0 0 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.06 0l4.25-4.25Z" clip-rule="evenodd"/>
                    </svg>
                </div>

                {{-- Text --}}
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ app()->getLocale()==='ar' ? 'تم بنجاح' : 'Success' }}
                    </div>
                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ session('success') }}
                    </div>
                </div>

                {{-- Close --}}
                <button type="button"
                        @click="show=false"
                        class="ml-auto shrink-0 rounded-xl p-2 ui-btn-ghost"
                        aria-label="Close">
                    ✕
                </button>
            </div>

            {{-- Progress bar --}}
            <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-black/5 dark:bg-white/5">
                <div class="h-full"
                     style="width:100%;
                            background: linear-gradient(90deg, rgb(var(--ui-accent)), rgb(var(--ui-ring)));
                            animation: toastbar 7s linear forwards;">
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes toastbar {
            from { width:100%; }
            to { width:0%; }
        }
    </style>
@endif



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
