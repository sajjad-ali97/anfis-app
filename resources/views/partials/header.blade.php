<header
    x-data="{ open:false, scrolled:false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 12 })"
    :class="scrolled
      ? 'bg-white/95 shadow-sm dark:bg-gray-900/95'
      : 'bg-white/80 backdrop-blur-md dark:bg-gray-900/80'
    "
    class="sticky top-0 z-50 border-b border-black/10 dark:border-white/10 transition-all duration-300"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- ================= BRAND ================= --}}
            <a href="{{ route('home') }}" class="flex items-center gap-4 min-w-0 group">

                <img src="{{ asset('images/brand/anfis-icon.svg') }}"
                     class="h-10 w-10 shrink-0"
                     alt="ANFIS Logo">

                <div class="flex flex-col leading-tight min-w-0">

                    <span class="hidden xl:block text-base font-semibold tracking-wide
                                 text-gray-900 dark:text-white">
                        {{ __('ui.brand_full') }}
                    </span>

                    <span class="hidden md:block xl:hidden text-base font-semibold tracking-wide truncate
                                 text-gray-900 dark:text-white">
                        {{ __('ui.brand_medium') }}
                    </span>

                    <span class="md:hidden text-base font-semibold tracking-wide
                                 text-gray-900 dark:text-white">
                        {{ __('ui.brand_short') }}
                    </span>

                    <span class="hidden xl:block text-xs
                                 text-gray-500 dark:text-gray-400">
                        {{ __('ui.brand_subtitle') }}
                    </span>

                </div>
            </a>


            {{-- ================= DESKTOP NAV ================= --}}
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">

                {{-- Home --}}
                <a href="{{ route('home') }}"
   class="group relative inline-flex items-center gap-2 px-2 py-2 transition-colors duration-200
          {{ request()->routeIs('home')
              ? 'text-black dark:text-white'
              : 'text-gray-800 hover:text-black dark:text-gray-100 dark:hover:text-white' }}">

  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
  <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
  <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
</svg>


    <span>{{ __('ui.home') }}</span>

    {{-- Underline: Hover + Active --}}
    <span class="absolute left-1/2 -translate-x-1/2 -bottom-[3px]
                 h-[2px] rounded-full
                 transition-all duration-300 ease-out
                 bg-black dark:bg-white
                 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}">
    </span>

    {{-- Soft Hover background --}}
    <span class="absolute inset-0 -z-10 rounded-xl opacity-0 transition-opacity duration-200
                 group-hover:opacity-100
                 bg-black/[0.04] dark:bg-white/[0.06]"></span>
</a>



                {{-- Projects --}}
               <a href="{{ route('projects') }}"
   class="group relative inline-flex items-center gap-2 px-2 py-2 transition-colors duration-200
          {{ request()->routeIs('projects')
              ? 'text-black dark:text-white'
              : 'text-gray-800 hover:text-black dark:text-gray-100 dark:hover:text-white' }}">

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
  <path d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 0 0-3-3h-3.879a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H6a3 3 0 0 0-3 3v3.162A3.756 3.756 0 0 1 4.094 9h15.812ZM4.094 10.5a2.25 2.25 0 0 0-2.227 2.568l.857 6A2.25 2.25 0 0 0 4.951 21H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-2.227-2.568H4.094Z" />
</svg>



    <span>{{ __('ui.projects') }}</span>

    <span class="absolute left-1/2 -translate-x-1/2 -bottom-[3px]
                 h-[2px] rounded-full
                 transition-all duration-300 ease-out
                 bg-black dark:bg-white
                 {{ request()->routeIs('projects') ? 'w-full' : 'w-0 group-hover:w-full' }}">
    </span>

    <span class="absolute inset-0 -z-10 rounded-xl opacity-0 transition-opacity duration-200
                 group-hover:opacity-100
                 bg-black/[0.04] dark:bg-white/[0.06]"></span>
</a>



                {{-- About --}}
               <a href="{{ route('about') }}"
   class="group relative inline-flex items-center gap-2 px-2 py-2 transition-colors duration-200
          {{ request()->routeIs('about')
              ? 'text-black dark:text-white'
              : 'text-gray-800 hover:text-black dark:text-gray-100 dark:hover:text-white' }}">

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
</svg>


    <span>{{ __('ui.about') }}</span>

    <span class="absolute left-1/2 -translate-x-1/2 -bottom-[3px]
                 h-[2px] rounded-full
                 transition-all duration-300 ease-out
                 bg-black dark:bg-white
                 {{ request()->routeIs('about') ? 'w-full' : 'w-0 group-hover:w-full' }}">
    </span>

    <span class="absolute inset-0 -z-10 rounded-xl opacity-0 transition-opacity duration-200
                 group-hover:opacity-100
                 bg-black/[0.04] dark:bg-white/[0.06]"></span>
</a>



                {{-- Contact --}}
             <a href="{{ route('contact') }}"
   class="group relative inline-flex items-center gap-2 px-2 py-2 transition-colors duration-200
          {{ request()->routeIs('contact')
              ? 'text-black dark:text-white'
              : 'text-gray-800 hover:text-black dark:text-gray-100 dark:hover:text-white' }}">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
  <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
  <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
</svg>


    <span>{{ __('ui.contact') }}</span>

    <span class="absolute left-1/2 -translate-x-1/2 -bottom-[3px]
                 h-[2px] rounded-full
                 transition-all duration-300 ease-out
                 bg-black dark:bg-white
                 {{ request()->routeIs('contact') ? 'w-full' : 'w-0 group-hover:w-full' }}">
    </span>

    <span class="absolute inset-0 -z-10 rounded-xl opacity-0 transition-opacity duration-200
                 group-hover:opacity-100
                 bg-black/[0.04] dark:bg-white/[0.06]"></span>
</a>



                {{-- Divider --}}
                <div class="mx-2 h-6 w-px bg-black/10 dark:bg-white/10"></div>


                {{-- Quick Analysis --}}
                <a href="#"
                   class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                          hover:bg-indigo-500 transition shadow-sm hover:shadow active:scale-[0.99]">

                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
  <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
</svg>


                    {{ __('ui.quick_analysis') }}
                </a>

            </nav>


            {{-- ================= RIGHT CONTROLS ================= --}}
            <div class="flex items-center gap-2">

                {{-- Theme --}}
                <button onclick="toggleTheme()"
                        class="rounded-xl border border-black/10 bg-black/5 px-3 py-2 text-sm
                               hover:bg-black/10 transition
                               dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">
                    <span id="themeIcon"></span>
                </button>

                {{-- Language --}}
                <a href="{{ route('lang.switch', app()->getLocale()==='ar' ? 'en' : 'ar') }}"
                   class="rounded-xl border border-black/10 bg-black/5 px-3 py-2 text-sm
                          hover:bg-black/10 transition
                          dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">

                    {{ app()->getLocale()==='ar' ? 'EN' : 'AR' }}
                </a>

                {{-- Mobile --}}
                <button @click="open = !open"
                        class="md:hidden rounded-xl border border-black/10 bg-black/5 px-3 py-2
                               hover:bg-black/10 transition
                               dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">
                    ☰
                </button>

            </div>
        </div>
    </div>
</header>
