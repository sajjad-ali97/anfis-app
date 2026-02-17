@extends('layouts.app')
@section('title', __('ui.results_title', ['id' => $project->id]))

@section('content')
<section class="ui-section">
    <div class="ui-card p-6 sm:p-8">
        <h1 class="ui-h1">
            {{ app()->getLocale()==='ar' ? 'نتيجة حساب الكلفة' : 'Cost Result' }}
        </h1>

        <p class="ui-p mt-2">
            {{ app()->getLocale()==='ar'
                ? ('المشروع رقم: #' . $project->id)
                : ('Project #: #' . $project->id)
            }}
        </p>

        <div class="mt-8 ui-surface p-6 text-center">
            <div class="ui-label">
                {{ app()->getLocale()==='ar' ? 'الكلفة التقديرية' : 'Estimated Cost' }}
            </div>

            <div class="mt-3 text-3xl sm:text-4xl font-semibold tracking-tight">
                {{ number_format((float)($cost ?? 0), 0) }}
                <span class="text-sm text-gray-500 dark:text-gray-400">IQD</span>
            </div>
        </div>

        <div class="mt-10 flex items-center justify-center gap-4">
            <a href="{{ route('projects.inputs.create', $project) }}" class="ui-btn-outline ui-btn-lg">
                {{ app()->getLocale()==='ar' ? 'رجوع للمدخلات' : 'Back to Inputs' }}
            </a>
        </div>
    </div>
</section>
@endsection
