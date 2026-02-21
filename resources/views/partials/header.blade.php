<header
    x-data="{ open:false, scrolled:false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 12 })"
    :class="scrolled //hhhhhh
      ? 'ui-glass-strong shadow-sm'
      : 'ui-glass'
    "
    class="sticky top-0 z-50 border-b transition-all duration-300"
>

    <div class="ui-container">
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

                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
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

                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
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

                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
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

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
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
                   class="ui-btn-primary px-4 py-2">

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
                        class="ui-btn-outline px-3 py-2 text-sm">
                    <span id="themeIcon"></span>
                </button>

                {{-- Language --}}
                <a href="{{ route('lang.switch', app()->getLocale()==='ar' ? 'en' : 'ar') }}"
                   class="ui-btn-outline px-3 py-2 text-sm">
                    {{ app()->getLocale()==='ar' ? 'EN' : 'AR' }}
                </a>

                {{-- Mobile --}}
                <button type="button" @click="open = !open"
                        class="md:hidden ui-btn-outline px-3 py-2">
                    ☰
                </button>

            </div>
        </div>
    </div>

    {{-- ================= MOBILE MENU ================= --}}
    <div x-cloak x-show="open" x-transition
         class="md:hidden ui-divider bg-white/95 dark:bg-gray-900/95 backdrop-blur-md">
        <nav class="ui-container py-4 flex flex-col gap-2 text-sm font-medium">

            <a href="{{ route('home') }}" @click="open=false"
               class="rounded-xl px-3 py-3 hover:bg-black/5 dark:hover:bg-white/5
                      {{ request()->routeIs('home') ? 'text-black dark:text-white bg-black/5 dark:bg-white/5' : 'text-gray-800 dark:text-gray-100' }}">
                {{ __('ui.home') }}
            </a>

            <a href="{{ route('projects') }}" @click="open=false"
               class="rounded-xl px-3 py-3 hover:bg-black/5 dark:hover:bg-white/5
                      {{ request()->routeIs('projects') ? 'text-black dark:text-white bg-black/5 dark:bg-white/5' : 'text-gray-800 dark:text-gray-100' }}">
                {{ __('ui.projects') }}
            </a>

            <a href="{{ route('about') }}" @click="open=false"
               class="rounded-xl px-3 py-3 hover:bg-black/5 dark:hover:bg-white/5
                      {{ request()->routeIs('about') ? 'text-black dark:text-white bg-black/5 dark:bg-white/5' : 'text-gray-800 dark:text-gray-100' }}">
                {{ __('ui.about') }}
            </a>

            <a href="{{ route('contact') }}" @click="open=false"
               class="rounded-xl px-3 py-3 hover:bg-black/5 dark:hover:bg-white/5
                      {{ request()->routeIs('contact') ? 'text-black dark:text-white bg-black/5 dark:bg-white/5' : 'text-gray-800 dark:text-gray-100' }}">
                {{ __('ui.contact') }}
            </a>

            <a href="{{ route('quick.analysis') }}"
                @click="open=false"
                class="mt-2 ui-btn-primary px-4 py-3 w-full justify-center">
                {{ __('ui.quick_analysis') }}
             </a>

        </nav>
    </div>

</header>
