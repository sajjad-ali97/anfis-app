@extends('layouts.app')
@section('title', __('ui.inputs_title'))

@section('content')
<section class="ui-section">
    <div class="ui-card p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="ui-h1">
                    {{ app()->getLocale()==='ar' ? 'مدخلات نموذج المشروع' : 'Project Model Inputs' }}
                </h1>

                <p class="ui-p mt-2">
                    {{ app()->getLocale()==='ar'
                        ? ('اسم المشروع: ' . $project->title)
                        : ('Project Name: ' . $project->title)
                    }}
                </p>
            </div>

            <div class="ui-badge">
                {{ app()->getLocale()==='ar'
                    ? ('المشروع رقم: #' . $project->id)
                    : ('Project #: #' . $project->id)
                }}
            </div>
        </div>



        <div class="mt-8 ui-divider"></div>

        {{-- Coding Table --}}
        <div class="mt-8">
             <h2 class="ui-h2 text-center">
                <span class="text-[rgb(var(--ui-accent))]">
                    {{ app()->getLocale()==='ar' ? 'جدول الترميز (Coding)' : 'Coding Table' }}
                </span>
            </h2>


            <p class="ui-p mt-3 text-center">
                {{ app()->getLocale()==='ar'
                    ? 'سيتم تخزين القيم بالقاعدة بصيغة أرقام ترميزية، بينما تُعرض للمستخدم بشكل وصفي.'
                    : 'Values are stored as numeric codes in DB while shown as descriptive labels to the user.'
                }}
            </p>

            <div class="mt-5 ui-table-wrap">
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th class="ui-th">
                                <span class="text-[rgb(var(--ui-accent))]">{{ __('ui.desc') }}</span>
                            </th>
                            <th class="ui-th">
                                <span class="text-[rgb(var(--ui-accent))]">{{ __('ui.unit_coding') }}</span>
                            </th>
                            <th class="ui-th">
                                <span class="text-[rgb(var(--ui-accent))]">{{ __('ui.desc') }}</span>
                            </th>
                            <th class="ui-th">
                                <span class="text-[rgb(var(--ui-accent))]">{{ __('ui.unit_coding') }}</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.pavement_area') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.units.square_meter') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.pavement_age') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.pavement_age') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.median_islands') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.exist_none') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.asphalt_thickness') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.units.centimeter') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.hts') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.hts_days') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.road_class') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.road_class') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.road_condition') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.road_condition') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.aadt_heavy') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.low_med_high') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.drainage_system') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.exist_none') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.maintenance_type') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.maintenance_type') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.soil_strength') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.soil_strength') }}</td>

                            <td class="ui-td">{{ __('ui.inputs.pavement_type') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.pavement_type') }}</td>
                        </tr>

                        <tr>
                            <td class="ui-td">{{ __('ui.inputs.traffic_volume') }}</td>
                            <td class="ui-td ui-td-secondary">{{ __('ui.coding.low_med_high') }}</td>

                            <td class="ui-td"></td>
                            <td class="ui-td ui-td-secondary"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 ui-divider"></div>

        {{-- Inputs --}}
        <div id="inputs" class="mt-8">
            <h2 class="ui-h2">{{ __('ui.inputs_form_title') }}</h2>
            <p class="ui-p mt-2">{{ __('ui.inputs_form_tip') }}</p>

            <form id="inputsForm" method="POST" action="{{ route('projects.inputs.store', $project) }}" class="mt-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                    {{-- 1 Pavement Area --}}
                    <div>
                        <label class="ui-label" for="pavement_area">{{ __('ui.inputs.pavement_area') }}</label>
                        <input id="pavement_area" name="pavement_area" type="number" step="0.01"
                               class="ui-input mt-2 border-[rgb(var(--ui-ring))]"
                               value="{{ old('pavement_area') }}" />
                        <p class="ui-help mt-2">{{ __('ui.help.square_meter') }}</p>
                        @error('pavement_area') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 2 Pavement Age --}}
                    <div>
                        <label class="ui-label" for="pavement_age">{{ __('ui.inputs.pavement_age') }}</label>
                        <select id="pavement_age" name="pavement_age" class="ui-select mt-2" required>
                            <option value="" disabled {{ old('pavement_age')==='' ? 'selected':'' }} class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('pavement_age')==1)>{{ __('ui.options.new') }}</option>
                            <option value="2" @selected(old('pavement_age')==2)>{{ __('ui.options.medium') }}</option>
                            <option value="3" @selected(old('pavement_age')==3)>{{ __('ui.options.old') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.pavement_age') }}</p>
                        @error('pavement_age') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 3 Median Islands --}}
                    <div>
                        <label class="ui-label" for="median_islands">{{ __('ui.inputs.median_islands') }}</label>
                        <select id="median_islands" name="median_islands" class="ui-select mt-2">
                            <option value="" disabled {{ old('median_islands')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('median_islands')==='1')>{{ __('ui.options.exist') }}</option>
                            <option value="0" @selected(old('median_islands')==='0')>{{ __('ui.options.none') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.exist_none') }}</p>
                        @error('median_islands') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 4 Asphalt Thickness --}}
                    <div>
                        <label class="ui-label" for="asphalt_thickness">{{ __('ui.inputs.asphalt_thickness') }}</label>
                        <input id="asphalt_thickness" name="asphalt_thickness" type="number" step="0.01"
                               class="ui-input mt-2 border-[rgb(var(--ui-ring))]"
                               value="{{ old('asphalt_thickness') }}" />
                        <p class="ui-help mt-2">{{ __('ui.help.centimeter') }}</p>
                        @error('asphalt_thickness') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 5 Road Classification --}}
                    <div>
                        <label class="ui-label" for="road_class">{{ __('ui.inputs.road_class') }}</label>
                        <select id="road_class" name="road_class" class="ui-select mt-2">
                            <option value="" disabled {{ old('road_class')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('road_class')==1)>{{ __('ui.options.main') }}</option>
                            <option value="2" @selected(old('road_class')==2)>{{ __('ui.options.secondary') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.road_class') }}</p>
                        @error('road_class') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 6 Road Condition (PCI) --}}
                    <div>
                        <label class="ui-label" for="road_condition">{{ __('ui.inputs.road_condition') }}</label>
                        <select id="road_condition" name="road_condition" class="ui-select mt-2">
                            <option value="" disabled {{ old('road_condition')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('road_condition')==1)>{{ __('ui.options.fair') }}</option>
                            <option value="2" @selected(old('road_condition')==2)>{{ __('ui.options.poor') }}</option>
                            <option value="3" @selected(old('road_condition')==3)>{{ __('ui.options.very_poor') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.road_condition') }}</p>
                        @error('road_condition') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 7 AADT Heavy-loaded --}}
                    <div>
                        <label class="ui-label" for="aadt_heavy">{{ __('ui.inputs.aadt_heavy') }}</label>
                        <select id="aadt_heavy" name="aadt_heavy" class="ui-select mt-2">
                            <option value="" disabled {{ old('aadt_heavy')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('aadt_heavy')==1)>{{ __('ui.options.low') }}</option>
                            <option value="2" @selected(old('aadt_heavy')==2)>{{ __('ui.options.medium') }}</option>
                            <option value="3" @selected(old('aadt_heavy')==3)>{{ __('ui.options.high') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.low_med_high') }}</p>
                        @error('aadt_heavy') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 8 Drainage System --}}
                    <div>
                        <label class="ui-label" for="drainage_system">{{ __('ui.inputs.drainage_system') }}</label>
                        <select id="drainage_system" name="drainage_system" class="ui-select mt-2">
                            <option value="" disabled {{ old('drainage_system')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('drainage_system')==='1')>{{ __('ui.options.exist') }}</option>
                            <option value="0" @selected(old('drainage_system')==='0')>{{ __('ui.options.none') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.exist_none') }}</p>
                        @error('drainage_system') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 9 Maintenance Type --}}
                    <div>
                        <label class="ui-label" for="maintenance_type">{{ __('ui.inputs.maintenance_type') }}</label>
                        <select id="maintenance_type" name="maintenance_type" class="ui-select mt-2">
                            <option value="" disabled {{ old('maintenance_type')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('maintenance_type')==1)>{{ __('ui.options.preventive') }}</option>
                            <option value="2" @selected(old('maintenance_type')==2)>{{ __('ui.options.routine') }}</option>
                            <option value="3" @selected(old('maintenance_type')==3)>{{ __('ui.options.emergency') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.maintenance_type') }}</p>
                        @error('maintenance_type') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 10 Soil Strength --}}
                    <div>
                        <label class="ui-label" for="soil_strength">{{ __('ui.inputs.soil_strength') }}</label>
                        <select id="soil_strength" name="soil_strength" class="ui-select mt-2">
                            <option value="" disabled {{ old('soil_strength')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('soil_strength')==1)>{{ __('ui.options.weak') }}</option>
                            <option value="2" @selected(old('soil_strength')==2)>{{ __('ui.options.medium') }}</option>
                            <option value="3" @selected(old('soil_strength')==3)>{{ __('ui.options.strong') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.soil_strength') }}</p>
                        @error('soil_strength') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 11 Pavement Type --}}
                    <div>
                        <label class="ui-label" for="pavement_type">{{ __('ui.inputs.pavement_type') }}</label>
                        <select id="pavement_type" name="pavement_type" class="ui-select mt-2">
                            <option value="" disabled {{ old('pavement_type')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('pavement_type')==1)>{{ __('ui.options.asphalt') }}</option>
                            <option value="2" @selected(old('pavement_type')==2)>{{ __('ui.options.mix') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.pavement_type') }}</p>
                        @error('pavement_type') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- 12 Traffic Volume --}}
                    <div>
                        <label class="ui-label" for="traffic_volume">{{ __('ui.inputs.traffic_volume') }}</label>
                        <select id="traffic_volume" name="traffic_volume" class="ui-select mt-2">
                            <option value="" disabled {{ old('traffic_volume')==='' ? 'selected':'' }}class="text-gray-500 dark:text-gray-300">{{ __('ui.choose') }}</option>
                            <option value="1" @selected(old('traffic_volume')==1)>{{ __('ui.options.low') }}</option>
                            <option value="2" @selected(old('traffic_volume')==2)>{{ __('ui.options.medium') }}</option>
                            <option value="3" @selected(old('traffic_volume')==3)>{{ __('ui.options.high') }}</option>
                        </select>
                        <p class="ui-help mt-2">{{ __('ui.coding.low_med_high') }}</p>
                        @error('traffic_volume') <p class="ui-help mt-2 text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- HTS note (full width, no input, display-only) --}}
                <div class="mt-8">
                    <div class="ui-surface p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="ui-label">{{ __('ui.inputs.hts') }}</div>
                                <p class="ui-help mt-1">{{ __('ui.coding.hts_days') }}</p>
                            </div>

                            <span class="ui-badge">
                                {{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}
                            </span>
                        </div>

                        <div class="mt-3 ui-row">
                            <div class="text-sm text-gray-600 dark:text-gray-300 leading-7">
                                <span class="font-semibold">
                                    {{ app()->getLocale()==='ar' ? 'طريقة حساب HTS:' : 'HTS Computation Method:' }}
                                </span>
                                <div class="mt-1 ui-muted">
                                    {{ app()->getLocale()==='ar'
                                        ? 'يتم احتساب مؤشر شدة الحرارة العالية (HTS) تلقائياً بالاعتماد على عمر الرصف وعدد الأيام التي تجاوزت فيها درجة الحرارة (40°C) ضمن بيانات دائرة الأنواء الجوية العراقية للفترة (2000–2025).'
                                        : 'HTS is computed automatically based on pavement age and the number of days with temperature exceeding 40°C, using Iraqi meteorological data for the period 2000–2025.'
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons (centered) --}}
                <div class="mt-10 flex items-center justify-center gap-4">
                    <a href="{{ route('projects.create') }}" class="ui-btn-outline ui-btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3">
                        <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
                      </svg>{{ __('ui.back') }}
                    </a>

                    <button type="submit" class="ui-btn-primary ui-btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.603 3.113A1.125 1.125 0 0 1 9 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113Z" clip-rule="evenodd" />
</svg>
{{ __('ui.calculate') }}
                    </button>
                </div>

            </form>
        </div>

        {{-- Auto focus to next input/select --}}
        <script>
        (function () {
            const form = document.getElementById('inputsForm');
            if (!form) return;

            const getFields = () => {
                const nodes = Array.from(form.querySelectorAll('input, select, textarea'));
                return nodes.filter(el => {
                    if (el.type === 'hidden') return false;
                    if (el.disabled) return false;
                    if (el.readOnly) return false;
                    return true;
                });
            };

            const focusNext = (current) => {
                const fields = getFields();
                const idx = fields.indexOf(current);
                if (idx === -1) return;
                const next = fields[idx + 1];
                if (next) next.focus();
            };

            form.addEventListener('change', (e) => {
                const el = e.target;
                if (!el || !(el.matches('input, select, textarea'))) return;
                if (el.tagName === 'SELECT') {
                    if (el.value !== '') focusNext(el);
                    return;
                }
                if (el.tagName === 'INPUT') {
                    if (el.value !== '' && el.type !== 'checkbox' && el.type !== 'radio') {
                        focusNext(el);
                    }
                }
            });
        })();
        </script>

    </div>
</section>
<script>
(function () {
    const form = document.getElementById('inputsForm');
    if (!form) return;

    const fields = () => Array.from(
        form.querySelectorAll('input:not([type="hidden"]):not([disabled]):not([readonly]), select:not([disabled]), textarea:not([disabled]):not([readonly])')
    );

    function focusNext(current){
        const list = fields();
        const i = list.indexOf(current);
        if (i >= 0 && list[i+1]) list[i+1].focus();
    }

    // للـ SELECT: بمجرد اختيار value
    form.addEventListener('change', (e) => {
        const el = e.target;
        if (!el) return;

        if (el.tagName === 'SELECT' && el.value !== '') {
            focusNext(el);
            return;
        }

        // للـ INPUT: بعد ما يصير change (يعني المستخدم غيّر القيمة وطلع)
        if (el.tagName === 'INPUT' && el.type !== 'checkbox' && el.type !== 'radio' && el.value !== '') {
            focusNext(el);
        }
    });

    // خيار إضافي: إذا تريدها “أسرع” على input (بمجرد يكتب)
    // خليه فقط للرقمي حتى ما يزعج النصوص
    form.addEventListener('input', (e) => {
        const el = e.target;
        if (!el || el.tagName !== 'INPUT') return;

        if (el.type === 'number' && el.value !== '' ) {
            // إذا تريد ينتقل فوراً بمجرد إدخال رقم، فعّل هذا السطر:
            // focusNext(el);
        }
    });
})();
</script>

@endsection
