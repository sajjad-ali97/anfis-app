@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'المشاريع' : 'Projects')

@section('content')
<section class="ui-section">
    <div class="ui-card p-6 sm:p-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="ui-h1">{{ app()->getLocale()==='ar' ? 'المشاريع' : 'Projects' }}</h1>
                <p class="ui-p mt-2">
                    {{ app()->getLocale()==='ar'
                        ? 'هنا قائمة بكل المشاريع المحفوظة ويمكنك عرض تقرير كل مشروع.'
                        : 'Here is a list of saved projects. You can open a report for any project.'
                    }}
                </p>
            </div>

            <span class="ui-badge">
                {{ app()->getLocale()==='ar' ? 'العدد:' : 'Count:' }}
                {{ $projects->count() }}
            </span>
        </div>

        <div class="ui-divider my-6"></div>

        @if($projects->isEmpty())
            <div class="ui-surface p-6 text-center">
                <div class="ui-h2">{{ app()->getLocale()==='ar' ? 'لا توجد مشاريع' : 'No projects yet' }}</div>
                <p class="ui-p mt-2">
                    {{ app()->getLocale()==='ar'
                        ? 'بعد ماكو مشاريع محفوظة. سوي مشروع جديد وارجع لهنا.'
                        : 'There are no saved projects yet. Create one and come back.'
                    }}
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($projects as $project)
                    <div class="ui-card p-5 flex flex-col">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $project->title }}
                                </div>
                                <div class="ui-muted mt-1">
                                    #{{ $project->id }}
                                </div>
                            </div>

                            <span class="ui-badge">
                                {{ app()->getLocale()==='ar' ? 'مشروع' : 'Project' }}
                            </span>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="ui-row">
                                <span class="ui-label">
                                    {{ app()->getLocale()==='ar' ? 'المحافظة' : 'Governorate' }}
                                </span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $project->governorate }}
                                </span>
                            </div>

                            <div class="ui-row">
                                <span class="ui-label">
                                    {{ app()->getLocale()==='ar' ? 'اسم الطريق' : 'Road Name' }}
                                </span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white truncate max-w-[55%] text-right">
                                    {{ $project->road_name }}
                                </span>
                            </div>

                            <div class="ui-row">
                                <span class="ui-label">
                                    {{ app()->getLocale()==='ar' ? 'تاريخ الصيانة' : 'Maintenance Date' }}
                                </span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ optional($project->maintenance_date)->format('Y-m-d') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 ui-divider"></div>

                        <div class="mt-4 flex items-center gap-2">
                            <a
                                href="{{ route('projects.report', $project) }}"
                                class="ui-btn-primary w-full"
                            >
                                <span class="ico ico-folder"></span>
                                {{ app()->getLocale()==='ar' ? 'عرض التقرير' : 'View Report' }}
                            </a>

                            {{-- زر اختياري ثاني إذا تحب لاحقاً --}}
                            {{-- <a href="#" class="ui-btn-outline">...</a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
