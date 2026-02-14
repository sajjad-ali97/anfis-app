<footer class="mt-auto border-t ui-glass transition-colors duration-300">

    <div class="ui-container py-6">

        {{-- ===== TOP: Developer / Owner (no cards) ===== --}}
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Developer --}}
            <div class="text-center md:text-start">
                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ __('ui.footer_dev_contact_title') }}
                </div>

                {{-- row 2: phone + whatsapp + instagram (horizontal) --}}
                <div class="mt-2 flex flex-wrap items-center justify-center md:justify-start gap-x-5 gap-y-2 text-sm text-gray-700 dark:text-gray-200">

                    <div class="inline-flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ui.footer_phone') }}:</span>
                        <a href="tel:+9647700000000" class="font-semibold hover:underline">
                            +964 773 225 0410
                        </a>

                        <a href="https://wa.me/9647732250410" target="_blank" rel="noopener"
                           class="ui-btn-ghost px-2 py-1 rounded-lg"
                           aria-label="WhatsApp">
                            {{-- WhatsApp icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="h-4 w-4 text-gray-800 dark:text-gray-100">
                                <path d="M12.04 2C6.55 2 2.09 6.34 2.09 11.68c0 1.89.57 3.74 1.64 5.33L2 22l5.2-1.64c1.52.8 3.23 1.22 4.96 1.22 5.49 0 9.95-4.34 9.95-9.68C22.11 6.34 17.54 2 12.04 2Zm0 17.86c-1.55 0-3.06-.41-4.37-1.18l-.31-.18-3.09.98.99-2.96-.2-.3a7.97 7.97 0 0 1-1.31-4.54c0-4.35 3.66-7.9 8.29-7.9 4.63 0 8.29 3.55 8.29 7.9 0 4.35-3.66 7.9-8.29 7.9Z"/>
                            </svg>
                            <span class="text-xs font-semibold">WhatsApp</span>
                        </a>
                    </div>

                    <div class="inline-flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ui.footer_instagram') }}:</span>
                        <a href="https://instagram.com/sa.ale97" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 font-semibold hover:underline">
                        @sa.ale97
                        </a>
                    </div>

                </div>
            </div>

            {{-- Owner --}}
            <div class="text-center md:text-end">
                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ __('ui.footer_owner_contact_title') }}
                </div>

                {{-- row 2: phone + instagram (horizontal) --}}
                <div class="mt-2 flex flex-wrap items-center justify-center md:justify-end gap-x-5 gap-y-2 text-sm text-gray-700 dark:text-gray-200">

                    <div class="inline-flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ui.footer_phone') }}:</span>
                        <a href="tel:+9647725245669" class="font-semibold hover:underline">
                            +964 772 524 5669
                        </a>
                    </div>

                    <div class="inline-flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ui.footer_instagram') }}:</span>
                        <a href="https://instagram.com/your_owner_username" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 font-semibold hover:underline">
                           
                            @aliSaad
                        </a>
                    </div>

                </div>
            </div>

        </div>

        {{-- ===== Divider ===== --}}
        <div class="mt-5 ui-divider"></div>

        {{-- ===== Bottom: left info / right logos ===== --}}
        <div class="mt-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            {{-- Bottom Left: horizontal info --}}
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-6 gap-y-2
                        text-xs text-gray-500 dark:text-gray-400">

                <div class="whitespace-nowrap">
                    {{ __('ui.footer_built_by') }}:
                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('ui.footer_dev_name') }}
                    </span>
                </div>

                <div class="whitespace-nowrap">
                    {{ __('ui.footer_owner') }}:
                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('ui.footer_owner_name') }}
                    </span>
                </div>

                <div class="whitespace-nowrap">
                    {{ __('ui.footer_date') }}:
                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('ui.footer_build_date') }}
                    </span>
                </div>

                <div class="whitespace-nowrap">
                    © {{ now()->year }} {{ __('ui.footer_rights') }}
                </div>
            </div>

            {{-- Bottom Right: ONLY logos (no socials between) --}}
            <div class="flex items-center justify-center md:justify-end gap-4">
                <img src="{{ asset('images/uni/uok.png') }}" alt="University of Karbala" class="h-9 w-auto opacity-95">
                <img src="{{ asset('images/uni/engineering.png') }}" alt="College of Engineering - UOK" class="h-9 w-auto opacity-95">
            </div>

        </div>

    </div>
</footer>
