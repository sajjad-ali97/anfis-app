@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'تواصل' : 'Contact')

@section('content')
<section class="ui-section">
    <div class="ui-card p-6 sm:p-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="ui-h1">{{ app()->getLocale()==='ar' ? 'التواصل' : 'Contact' }}</h1>
                <p class="ui-p mt-2">
                    {{ app()->getLocale()==='ar'
                        ? ' معلومات التواصل أدناه .'
                        : 'Contact information below.'
                    }}
                </p>
            </div>

            <span class="ui-badge">
                {{ app()->getLocale()==='ar' ? 'ثابتة' : 'Static' }}
            </span>
        </div>

        <div class="ui-divider my-6"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- ===== University Card ===== --}}
            <div class="ui-card p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0">
                        <div class="ui-surface p-3">
                            <span class="ico ico-road"></span>
                        </div>
                    </div>

                    <div class="min-w-0">
                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ app()->getLocale()==='ar' ? 'جامعة كربلاء' : 'University of Karbala' }}
                        </div>
                        <div class="ui-muted mt-1">
                            {{ app()->getLocale()==='ar'
                                ? 'كلية الهندسة/قسم الهندسة المدنية'
                                : 'Faculty of Engineering/Department of Civil Engineering'
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'العنوان' : 'Address' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
                            {{ app()->getLocale()==='ar'
                                ? 'كربلاء، العراق (فريحة)'
                                : 'Karbala, Iraq (Feriha)'
                            }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                             +964 781 074 7747
                        </span>
                    </div>

                 <div class="ui-row">
    <span class="ui-label">
        {{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}
    </span>

    <a href="mailto:civil.engineering@uokerbala.edu.iq"
       class="text-sm font-semibold text-gray-900 dark:text-white hover:underline">
        civil.engineering@uokerbala.edu.iq
    </a>
</div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 781 074 7747
                        </span>
                    </div>
                </div>

                <div class="mt-5 pt-4 ui-divider"></div>

                <div class="mt-4 flex flex-col gap-2">
                  <a href="mailto:eng.civil.coor@uokerbala.edu.iq" class="ui-btn-primary w-full">
    <span class="ico ico-mail"></span>
    {{ app()->getLocale()==='ar' ? 'رابط المقترحات' : 'Suggestions Link' }}
</a>
                   <a href="https://eng.uokerbala.edu.iq/wp/%d9%82%d8%b3%d9%85-%d8%a7%d9%84%d9%87%d9%86%d8%af%d8%b3%d8%a9-%d8%a7%d9%84%d9%85%d8%af%d9%86%d9%8a%d8%a9-4/"
   target="_blank"
   rel="noopener noreferrer"
   class="ui-btn-outline w-full">
    <span class="ico ico-info"></span>
    {{ app()->getLocale()==='ar' ? 'صفحة الجامعة' : 'University Page' }}
</a>
                </div>


            </div>

            {{-- ===== Researcher Card ===== --}}
            <div class="ui-card p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0">
                        <div class="ui-surface p-3">
                            <span class="ico ico-info"></span>
                        </div>
                    </div>

                    <div class="min-w-0">
                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ app()->getLocale()==='ar' ? 'الباحث: علي سعد' : 'Researcher: Ali Saad' }}
                        </div>
                        <div class="ui-muted mt-1">
                            {{ app()->getLocale()==='ar'
                                ? 'باحث/طالب دراسات عليا)'
                                : 'Researcher / Postgraduate '
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الاختصاص' : 'Field' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
                            {{ app()->getLocale()==='ar'
                                ? 'هندسة مدنية / صيانة طرق '
                                : 'Civil Engineering / Road Maintenance '
                            }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 773 538 7902
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            ali.saad@gmail.com
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 773 538 7902
                        </span>
                    </div>
                </div>

                <div class="mt-5 pt-4 ui-divider"></div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="#" class="ui-btn-primary w-full">
                        <span class="ico ico-mail"></span>
                        {{ app()->getLocale()==='ar' ? 'إرسال رسالة' : 'Send Message' }}
                    </a>
                    <a href="#" class="ui-btn-ghost w-full">
                        <span class="ico ico-info"></span>
                        {{ app()->getLocale()==='ar' ? 'معلومات إضافية' : 'More Info' }}
                    </a>
                </div>


            </div>

            {{-- ===== Developer Card ===== --}}
            <div class="ui-card p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0">
                        <div class="ui-surface p-3">
                            <span class="ico ico-folder"></span>
                        </div>
                    </div>

                    <div class="min-w-0">
                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ app()->getLocale()==='ar' ? 'المبرمج' : 'Developer' }}
                        </div>
                        <div class="ui-muted mt-1">
                            {{ app()->getLocale()==='ar'
                                ? 'مطور الواجهة والباك-إند'
                                : 'Frontend & Backend developer'
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الاسم' : 'Name' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ app()->getLocale()==='ar' ? 'المهندس سجاد الحيدري': 'eng Sajjad Alhidary' }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 772 225 0410
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            dev@mail.com
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 773 225 0410
                        </span>
                    </div>
                </div>

                <div class="mt-5 pt-4 ui-divider"></div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="#" class="ui-btn-primary w-full">
                        <span class="ico ico-mail"></span>
                        {{ app()->getLocale()==='ar' ? 'تواصل' : 'Contact' }}
                    </a>
                    <a href="#" class="ui-btn-outline w-full">
                        <span class="ico ico-info"></span>
                        {{ app()->getLocale()==='ar' ? 'GitHub / Portfolio' : 'GitHub / Portfolio' }}
                    </a>
                </div>

            </div>

        </div>

        <div class="ui-divider my-6"></div>

        <div class="ui-surface p-6">
            <div class="ui-h2">{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}</div>
            <p class="ui-p mt-2">
                {{ app()->getLocale()==='ar'
                    ? 'كل الطرق العلمية المستخدمة في هذا الموقع مستندة على البحث العلمي للطالب .'
                    : 'All scientific methods used on this site are based on student scientific research.'
                }}
            </p>
        </div>

    </div>
</section>
@endsection
