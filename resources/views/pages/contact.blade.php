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
                        ? 'هذه صفحة تواصل تجريبية. كل المعلومات حالياً وهمية وتكدر تعدلها لاحقاً.'
                        : 'This is a demo contact page. All information is placeholder and can be updated later.'
                    }}
                </p>
            </div>

            <span class="ui-badge">
                {{ app()->getLocale()==='ar' ? 'ستاتك' : 'Static' }}
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
                                ? 'قسم/كلية (وهمي حالياً)'
                                : 'Department/College (placeholder)'
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'العنوان' : 'Address' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
                            {{ app()->getLocale()==='ar'
                                ? 'كربلاء، العراق (عنوان وهمي)'
                                : 'Karbala, Iraq (placeholder address)'
                            }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 000 000 0000
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            info@example.edu
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 700 000 0000
                        </span>
                    </div>
                </div>

                <div class="mt-5 pt-4 ui-divider"></div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="#" class="ui-btn-primary w-full">
                        <span class="ico ico-mail"></span>
                        {{ app()->getLocale()==='ar' ? 'رابط المقترحات' : 'Suggestions Link' }}
                    </a>
                    <a href="#" class="ui-btn-outline w-full">
                        <span class="ico ico-info"></span>
                        {{ app()->getLocale()==='ar' ? 'صفحة الجامعة' : 'University Page' }}
                    </a>
                </div>

                <p class="ui-help mt-4">
                    {{ app()->getLocale()==='ar'
                        ? 'ملاحظة: استبدل الشعار والمعلومات لاحقاً.'
                        : 'Note: Replace logo and details later.'
                    }}
                </p>
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
                                ? 'باحث/طالب دراسات عليا (وهمي حالياً)'
                                : 'Researcher / Postgraduate (placeholder)'
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الاختصاص' : 'Field' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
                            {{ app()->getLocale()==='ar'
                                ? 'هندسة مدنية / صيانة طرق (وهمي)'
                                : 'Civil Engineering / Road Maintenance (placeholder)'
                            }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 000 111 2222
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            ali.saad@example.com
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 700 111 2222
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

                <p class="ui-help mt-4">
                    {{ app()->getLocale()==='ar'
                        ? 'هذه بيانات تجريبية فقط.'
                        : 'These are placeholders only.'
                    }}
                </p>
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
                                ? 'مطور الواجهة والباك-إند (وهمي حالياً)'
                                : 'Frontend & Backend developer (placeholder)'
                            }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الاسم' : 'Name' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ app()->getLocale()==='ar' ? 'سجاد (وهمي)' : 'Sajjad (placeholder)' }}
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'الهاتف' : 'Phone' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 000 333 4444
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'البريد' : 'Email' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            dev@example.com
                        </span>
                    </div>

                    <div class="ui-row">
                        <span class="ui-label">{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            +964 700 333 4444
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

                <p class="ui-help mt-4">
                    {{ app()->getLocale()==='ar'
                        ? 'ضيف روابطك الحقيقية لاحقاً.'
                        : 'Add your real links later.'
                    }}
                </p>
            </div>

        </div>

        <div class="ui-divider my-6"></div>

        <div class="ui-surface p-6">
            <div class="ui-h2">{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}</div>
            <p class="ui-p mt-2">
                {{ app()->getLocale()==='ar'
                    ? 'هذه الصفحة مصممة لتكون متناسقة مع نظام الـ UI في المشروع (كارد/سيرفس/ألوان). بعدين بس بدّل النصوص والروابط.'
                    : 'This page matches your project UI system (cards/surfaces/colors). Later, just replace the texts and links.'
                }}
            </p>
        </div>

    </div>
</section>
@endsection
