@extends('layouts.app')

@section('title', __('ui.home'))

@section('content')
<section class="ui-section">
    <div class="ui-card p-6 sm:p-10">

        {{-- ===== Top Logos + Header Lines ===== --}}
        <div class="flex items-start justify-between gap-4">
            {{-- Left logo --}}
            <img
                src="{{ asset('images/uni/engineering.png') }}"
                alt="College of Engineering"
                class="h-12 sm:h-14 w-auto opacity-95"
            />

            {{-- Center titles --}}
            <div class="text-center flex-1">
                <div class="ui-muted">
                    {{ __('ui.home_ministry') }}
                </div>

                <div class="mt-2 text-lg sm:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {{ __('ui.home_college') }}
                </div>

                <div class="mt-1 text-sm sm:text-base font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('ui.home_university') }}
                </div>
            </div>

            {{-- Right logo --}}
            <img
                src="{{ asset('images/uni/uok.png') }}"
                alt="University of Karbala"
                class="h-12 sm:h-14 w-auto opacity-95"
            />
        </div>

        <div class="mt-6 ui-divider"></div>

        {{-- ===== Research Title (Hero) ===== --}}
        <div class="mt-6 text-center">
            <div class="ui-badge">
                {{ __('ui.home_project_label') }}
            </div>

            <h1 class="ui-h1 mt-4">
                {{ __('ui.home_research_title') }}
            </h1>

            <p class="ui-p mt-3 max-w-3xl mx-auto">
                {{ __('ui.home_research_subtitle') }}
            </p>
        </div>

        {{-- ===== People Info ===== --}}
        <div class="mt-8 grid gap-4 sm:gap-5">
            <div class="ui-surface p-5 sm:p-6">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('ui.home_student_label') }}
                </div>
                <div class="mt-2 text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('ui.home_student_name') }}
                </div>
            </div>

            <div class="ui-surface p-5 sm:p-6">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('ui.home_supervisor_label') }}
                </div>
                <div class="mt-2 text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('ui.home_supervisor_name') }}
                </div>
            </div>
        </div>

        {{-- ===== Action ===== --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('projects.create') }}"
               class="ui-btn-primary px-6 py-3">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
  <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
</svg> {{ __('ui.home_new_project') }}
            </a>

            <a href="{{ route('about') }}"
               class="ui-btn-outline px-6 py-3">
                {{ __('ui.home_about_project') }}
            </a>
        </div>

        {{-- ===== Footer Note ===== --}}
        <div class="mt-8 ui-divider"></div>

        <div class="mt-4 text-center text-xs text-gray-500 dark:text-gray-400">
            {{ __('ui.home_footer_note') }}
        </div>

    </div>
</section>
@endsection
