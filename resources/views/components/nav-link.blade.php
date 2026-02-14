@props([
    'active' => false,
    'icon' => null,   // تمرر svg هنا
])

@php
$base =
    'group relative inline-flex items-center gap-2 rounded-lg px-2.5 py-2 '.
    'text-sm font-medium leading-none transition-all duration-200 '.
    'focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60';

$inactive =
    'text-gray-900 hover:text-black hover:bg-black/5 '.
    'dark:text-white/90 dark:hover:text-white dark:hover:bg-white/10';

$activeCls =
    'text-gray-900 dark:text-white';

@endphp

<a {{ $attributes->merge(['class' => $base.' '.($active ? $activeCls : $inactive)]) }}>
    @if($icon)
        <span class="inline-flex h-4 w-4 shrink-0 items-center justify-center translate-y-[0.5px] opacity-90 group-hover:opacity-100 transition">
            {!! $icon !!}
        </span>
    @endif

    <span class="whitespace-nowrap">
        {{ $slot }}
    </span>

    {{-- Underline: بعرض العنصر بالكامل (أيقونة + نص) --}}
    <span
        class="pointer-events-none absolute left-2.5 right-2.5 -bottom-[2px]
               h-[2px] rounded-full bg-indigo-500/0
               transition-all duration-300
               group-hover:bg-indigo-500/60
               {{ $active ? 'bg-indigo-500 dark:bg-indigo-400' : '' }}">
    </span>
</a>
