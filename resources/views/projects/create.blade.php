@extends('layouts.app')

@section('content')
<section  class="ui-section">
    <div class="ui-card overflow-hidden">

        {{-- HERO IMAGE (Full width داخل الكارد) --}}
        <div class="relative h-52 sm:h-64 md:h-72">
            <img
                src="{{ asset('images/Skills-to-Master-in-B.jpg') }}"
                alt="Project"
                class="absolute inset-0 h-full w-full object-cover"
            />

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/25 to-transparent"></div>

            {{-- Badge + Title --}}
            <div class="absolute inset-x-0 bottom-0 p-5 sm:p-7">
                <div class="flex items-center gap-2">
                    <span class="ui-badge text-white/90 bg-white/10 border-white/20">
                        {{ __('ui.project_badge') }}
                    </span>
                </div>

                <div class="mt-3">
                    <h1 class="text-xl sm:text-2xl font-semibold tracking-tight text-white">
                        {{ __('ui.create_project_title') }}
                    </h1>
                    <p class="mt-1 text-sm text-white/80">
                        {{ __('ui.create_project_subtitle') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- BODY --}}
        <div  id="create-project" class="p-5 sm:p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="ui-h2">{{ __('ui.project_info') }}</h2>
                    <p class="ui-p mt-1">{{ __('ui.project_info_hint') }}</p>
                </div>

                {{-- Small Civil Engineering Logo --}}
<div class="shrink-0">
  <div class="ui-surface h-12 w-12 rounded-2xl p-2 flex items-center justify-center overflow-hidden">
    <img
      src="{{ asset('images/hero.jpg') }}"
      alt="Civil"
      class="h-full w-full object-contain"
    />
  </div>
</div>

            </div>

            <div  class="ui-divider my-6"></div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="ui-label" for="title">{{ __('ui.project_title') }}</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        class="ui-input mt-2"
                        placeholder="{{ __('ui.project_title_ph') }}"
                        value="{{ old('title') }}"
                    />
                    @error('title')
                        <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Governorate --}}
                <div>
                    <label class="ui-label" for="governorate">{{ __('ui.governorate') }}</label>
                    <input
                        id="governorate"
                        name="governorate"
                        type="text"
                        class="ui-input mt-2"
                        placeholder="{{ __('ui.governorate_ph') }}"
                        value="{{ old('governorate') }}"
                    />
                    @error('governorate')
                        <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Road Name --}}
                <div>
                    <label class="ui-label" for="road_name">{{ __('ui.road_name') }}</label>
                    <input
                        id="road_name"
                        name="road_name"
                        type="text"
                        class="ui-input mt-2"
                        placeholder="{{ __('ui.road_name_ph') }}"
                        value="{{ old('road_name') }}"
                    />
                    @error('road_name')
                        <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Maintenance Date --}}
                <div>
                    <label class="ui-label" for="maintenance_date">{{ __('ui.maintenance_date') }}</label>
                    <input
    id="maintenance_date"
    name="maintenance_date"
    type="date"
    class="ui-input mt-2"
    value="{{ old('maintenance_date') }}"
    min="2000-01-01"
    max="2025-12-31"
/>

                    <p class="ui-help mt-2">{{ __('ui.maintenance_tip') }}</p>
                    @error('maintenance_date')
                        <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between pt-2">
                    <button type="submit" class="ui-btn-primary w-full sm:w-auto px-7">
                        {{ __('ui.create_project_btn') }}
                    </button>

                    <a href="{{ route('home') }}" class="ui-btn-outline w-full sm:w-auto px-7 text-center">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3">
                        <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
                      </svg>

                        {{ __('ui.back_home') }}
                    </a>
                </div>

                {{-- Engineering tagline --}}
                <div class="pt-4">
                    <div class="ui-row">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('ui.engineering_note_title') }}
                            </p>
                            <p class="ui-muted mt-1">
                                {{ __('ui.engineering_note_body') }}
                            </p>
                        </div>
                        <span class="ui-badge">{{ __('ui.research_project') }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
