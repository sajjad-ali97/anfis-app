@extends('layouts.app')

@section('title', app()->getLocale()==='ar' ? 'نتائج الحساب' : 'Results')

@section('content')
@php
    $locale = app()->getLocale();
    $isAr = $locale === 'ar';

    $project = $calculation->project;
    $gauge = $calculation->gauge;
    $sens  = $calculation->sensitivity;
    $exp   = $calculation->explanation;

    $gaugeRanges = $gauge?->ranges_json ?? [];
    $barData = $sens?->bar_data ?? [];

    $reasons = $isAr ? ($exp?->reasons_ar ?? []) : ($exp?->reasons_en ?? []);
    $summary = $isAr ? ($exp?->summary_ar ?? '') : ($exp?->summary_en ?? '');

    // Plotly-ready arrays
    $barLabels = array_map(fn($r) => $isAr ? ($r['label_ar'] ?? ($r['key'] ?? '')) : ($r['label_en'] ?? ($r['key'] ?? '')), $barData);
    $barValues = array_map(fn($r) => (float)($r['impact_percent'] ?? 0), $barData);

    // Gauge values
    $aValue = $gauge?->a ?? 0;
    $gMin = $gauge?->min ?? 0;
    $gMax = $gauge?->max ?? 100;
    $labelKey = $gauge?->label_key ?? '';
    $labelTxt = $gauge?->label ?? $labelKey;

    // Range used (optional UI)
    $ru = $gauge?->range_used ?? ['min'=>null,'max'=>null,'color'=>null];
@endphp

<section class="ui-section" >
 <div id="top" class="ui-card p-6 sm:p-8">
    {{-- Header --}}
    <div class="ui-card p-6 sm:p-8">


        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                <h1 class="ui-h1">
                    {{ $isAr ? 'نتائج الحساب' : 'Calculation Results' }}
                </h1>
                <p class="ui-p mt-2">
                    {{ $isAr ? 'المشروع رقم' : 'Project #' }}:
                    <span class="font-semibold text-gray-900 dark:text-white">#{{ $project->id }}</span>
                    @if($project->road_name)
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="text-gray-700 dark:text-gray-200">{{ $project->title }}</span>
                    @endif
                </p>
                @if($project->governorate || $project->maintenance_date)
                    <p class="ui-muted mt-1">
                        @if($project->governorate)
                            {{ $isAr ? 'المحافظة' : 'Governorate' }}: {{ $project->governorate }}
                        @endif
                        @if($project->governorate && $project->maintenance_date)
                            <span class="mx-2">•</span>
                        @endif
                        @if($project->maintenance_date)
                            {{ $isAr ? 'تاريخ الصيانة' : 'Maintenance date' }}:
                            {{ $project->maintenance_date->format('Y-m-d') }}
                        @endif
                    </p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                {{-- Advanced toggle --}}
              <a href="#advanced-details"
   class="ui-btn-outline ui-btn-lg">
    <span class="ico ico-info"></span>
    <span>{{ $isAr ? 'تفاصيل متقدمة' : 'Advanced details' }}</span>
</a>


                {{-- Report button --}}
                <a class="ui-btn-primary ui-btn-lg"
                   href="{{ route('projects.report', $calculation->id) }}">
                    <span class="ico ico-folder"></span>
                    <span>{{ $isAr ? 'عرض التقرير' : 'View Report' }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Top cards: Cost + Gauge info --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cost card --}}
        <div class="ui-card p-6 sm:p-8 lg:col-span-1">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <div class="ui-label">{{ $isAr ? 'الكلفة التقديرية' : 'Estimated Cost' }}</div>
                    <div class="mt-2 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ number_format((int)($calculation->estimated_cost ?? 0)) }}
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                            {{ $isAr ? 'دينار' : 'IQD' }}
                        </span>
                    </div>
                </div>

                <div class="ui-surface px-4 py-3">
                    <div class="ui-label">{{ $isAr ? 'A (دينار/م²)' : 'A (IQD/m²)' }}</div>
                    <div class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format((float)$aValue, 2) }}
                    </div>
                    <div class="ui-muted mt-1">
                        {{ $isAr ? 'مستوى الكلفة' : 'Cost level' }}:
                        <span class="font-semibold text-gray-800 dark:text-gray-100">
                            {{ $labelTxt }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Range hint --}}
            @if(isset($ru['min'], $ru['max']))
                <div class="mt-4 ui-row">
                    <div class="min-w-0">
                        <div class="ui-label">{{ $isAr ? 'نطاق المستوى الحالي' : 'Current band range' }}</div>
                        <div class="ui-p mt-1">
                            {{ number_format((int)$ru['min']) }} – {{ number_format((int)$ru['max']) }}
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $isAr ? 'دينار/م²' : 'IQD/m²' }}
                            </span>
                        </div>
                    </div>
                    <span class="ui-badge" style="border-left:4px solid {{ $ru['color'] ?? '#6366f1' }};">
                        {{ $labelKey }}
                    </span>
                </div>
            @endif

            {{-- Summary --}}
            <div class="mt-5 ui-surface p-5">
                <div class="ui-label">{{ $isAr ? 'ملخص' : 'Summary' }}</div>
                <p class="ui-p mt-2 whitespace-pre-line">{{ $summary ?: ($isAr ? 'لا يوجد تفسير متاح حالياً.' : 'No explanation available yet.') }}</p>
            </div>

              @php
                    $isAr = app()->getLocale() === 'ar';

                    $sens = $calculation->sensitivity;

                    // تحويل مرن إلى array
                    if (is_object($sens) && method_exists($sens, 'toArray')) {
                        $sensArr = $sens->toArray();
                    } elseif (is_object($sens) && isset($sens->payload)) {
                        $sensArr = json_decode($sens->payload, true) ?? [];
                    } elseif (is_array($sens)) {
                        $sensArr = $sens;
                    } else {
                        $sensArr = [];
                    }

                    $top = $sensArr['top_influencers'] ?? $sensArr['bar_data'] ?? [];
                    $top1 = $top[0] ?? null;
                @endphp

                @if($top1)
                <div class="mt-4 ui-surface p-5">
                    <div class="ui-h2 mb-3">
                        {{ $isAr ? 'أكثر عامل تأثيراً' : 'Most Influential Factor' }}
                    </div>

                    @php
                        $label = $isAr
                            ? ($top1['label_ar'] ?? $top1['key'])
                            : ($top1['label_en'] ?? $top1['key']);

                        $pct = (float)($top1['impact_percent'] ?? 0);
                        $width = max(0, min(100, $pct));
                    @endphp

                    <div class="ui-row items-start">
                        <div class="flex-1 min-w-0">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $label }}
                            </div>

                            <div class="mt-3 h-2 w-full rounded-full bg-black/10 dark:bg-white/10 overflow-hidden">
                                <div class="h-full rounded-full"
                                    style="width: {{ $width }}%;
                                            background: linear-gradient(90deg, rgb(var(--ui-accent)), rgb(var(--ui-ring)));">
                                </div>
                            </div>

                            <div class="mt-2 ui-muted">
                                {{ $isAr
                                    ? 'يمثل هذا العامل أعلى نسبة تأثير على الكلفة التقديرية.'
                                    : 'This factor has the highest relative influence on the estimated cost.' }}
                            </div>
                        </div>

                        <div class="text-xl font-bold text-gray-900 dark:text-white ml-4">
                            {{ number_format($pct, 2) }}%
                        </div>
                    </div>
                </div>
                @endif

        </div>

        {{-- Gauge Plotly --}}
        <div class="ui-card p-6 sm:p-8 lg:col-span-2">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="ui-h2">{{ $isAr ? 'مؤشر الكلفة (Gauge)' : 'Cost Gauge' }}</h2>
                    <p class="ui-p mt-2">
                        {{ $isAr
                            ? 'يعرض المؤشر A (الكلفة لكل متر مربع) ضمن الرينجات المعرفة.'
                            : 'Shows A index (cost per m²) within the defined ranges.'
                        }}
                    </p>
                </div>
                <span class="ui-badge">
                    {{ $isAr ? 'A = الكلفة/المساحة' : 'A = cost/area' }}
                </span>
            </div>

          <div class="mt-5 ui-surface p-4 sm:p-6">

            {{-- Old Gauge (Plotly Indicator) + Overlay --}}
            <div class="relative">
                <div id="gaugeChart" class="w-full" style="height: 340px;"></div>

                {{-- A Overlay (Always readable) --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none translate-y-10 sm:translate-y-8">

                    <div class="text-center">
                        <div class="text-4xl sm:text-5xl font-semibold tracking-tight
                                    text-gray-900 dark:text-white
                                    drop-shadow-[0_0_10px_rgba(99,102,241,0.30)]">
                            {{ number_format((float)$aValue, 2) }}
                        </div>
                        <div class="text-sm mt-1 text-gray-600 dark:text-gray-300">
                            {{ $isAr ? 'دينار / م²' : 'IQD / m²' }}
                        </div>

                        {{-- Current level badge --}}
                        <div class="mt-2 inline-flex items-center gap-2 ui-badge">
                            <span class="h-2.5 w-2.5 rounded-full"
                                style="background: {{ $ru['color'] ?? '#6366f1' }};"></span>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $labelTxt }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="mt-4 ui-surface p-4">
                <div class="ui-label mb-3">{{ $isAr ? 'تقسيم المستويات' : 'Levels' }}</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach(($gaugeRanges ?? []) as $r)
                        <div class="ui-row">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="h-3.5 w-3.5 rounded-full shrink-0"
                                    style="background: {{ $r['color'] ?? '#6366f1' }};"></span>

                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $r['label'] ?? ($r['key'] ?? '') }}
                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                            ({{ $r['key'] ?? '' }})
                                        </span>
                                    </div>
                                    <div class="ui-muted">
                                        {{ number_format((int)($r['min'] ?? 0)) }} – {{ number_format((int)($r['max'] ?? 0)) }}
                                        {{ $isAr ? 'د/م²' : 'IQD/m²' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

</div>



        </div>
    </div>

    @php
  $isAr = app()->getLocale()==='ar';

  // هاي يفترضها موجودة عندك من السيرفس
  // $barLabels : labels (Arabic/English already)
  // $barValues : values (impact_percent)
@endphp

{{-- =========================
    Bar Chart Section (Modern)
========================== --}}
<section class="ui-section mt-8">
  <div class="ui-card p-6 sm:p-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <div class="flex items-center gap-2">
          <span class="ui-badge">XAI</span>
          <h2 class="ui-h2">
            {{ $isAr ? 'تحليل التأثير' : 'Impact Analysis' }}
            <span class="text-gray-500 dark:text-gray-400 text-sm"> (Bar Chart)</span>
          </h2>
        </div>
        <p class="ui-p mt-2">
          {{ $isAr
              ? 'نسبة التأثير هي حساسية تقريبية ضمن اختبارات التغيير المحددة.'
              : 'Impact percentages are approximate sensitivities under the defined perturbation tests.' }}
        </p>
      </div>

      <a href="#reasons"
         class="ui-btn-outline ui-btn">
        {{ $isAr ? 'الانتقال للأسباب' : 'Jump to Reasons' }}
      </a>
    </div>

    {{-- Chart Surface --}}
    <div class="mt-6 ui-surface p-4 sm:p-6">
      <div id="barChart" class="w-full" style="height: 420px;"></div>

      {{-- Sub legend small note --}}
      <div class="mt-4 flex flex-wrap items-center gap-2">
        <span class="ui-badge">
          {{ $isAr ? 'أعلى القيم = الأكثر تأثيراً' : 'Higher = more impact' }}
        </span>
        <span class="ui-badge">
          {{ $isAr ? 'الترتيب تنازلياً' : 'Sorted descending' }}
        </span>
      </div>
    </div>

  </div>
</section>



{{-- =========================
    Reasons Section (Below)
========================== --}}
<section id="reasons" class="ui-section mt-8">
  <div class="ui-card p-6 sm:p-8">
    <div class="flex items-center gap-2">
      <span class="ui-badge">XAI</span>
      <h2 class="ui-h2">{{ $isAr ? 'الأسباب وشرح مختصر' : 'Reasons & Short Explanation' }}</h2>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
          ? 'أهم العوامل المؤثرة حسب التحليل، مع اتجاه التأثير بشكل مبسط.'
          : 'Most influential factors from the analysis, with a simplified direction of impact.' }}
    </p>

    @php
      $reasons = $isAr
          ? ($calculation->explanation?->reasons_ar ?? [])
          : ($calculation->explanation?->reasons_en ?? []);
    @endphp

    <div class="mt-6 space-y-4">
      @forelse($reasons as $r)
        <div class="ui-surface p-5">
          <div class="text-sm text-gray-900 dark:text-white leading-7 whitespace-pre-line">
            {{ $r }}
          </div>
        </div>
      @empty
        <div class="ui-muted">
          {{ $isAr ? 'لا توجد أسباب حالياً.' : 'No reasons available yet.' }}
        </div>
      @endforelse
    </div>
  </div>
</section>

{{-- =========================
    Advanced Details Section
========================== --}}
<div id="advanced-details" class="mt-10 scroll-mt-24">
  <div class="ui-card p-6 sm:p-8">
    <div class="flex items-start justify-between gap-3">
      <div>
        <h2 class="ui-h2">{{ $isAr ? 'تفاصيل متقدمة (Debug JSON)' : 'Advanced Details (Debug JSON)' }}</h2>
        <p class="ui-p mt-2">
          {{ $isAr
              ? 'هذه البيانات مخصّصة للتدقيق العلمي (XAI) ومراجعة خطوات التحليل.'
              : 'These payloads are for scientific debugging (XAI) and analysis traceability.' }}
        </p>
      </div>

      <a href="#top" class="ui-btn-ghost">
        <span class="ico ico-back"></span>
        <span>{{ $isAr ? 'للأعلى' : 'Back to top' }}</span>
      </a>
    </div>

    <div class="ui-divider my-6"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- 1) Gauge Debug --}}
      <div class="ui-surface p-5">
        <div class="flex items-center justify-between gap-3">
          <div class="min-w-0">
            <div class="ui-label">{{ $isAr ? 'Cost Gauge' : 'Cost Gauge' }}</div>
            <div class="ui-muted mt-1">
              {{ $isAr ? 'يعرض A ضمن الرينجات المعرفة.' : 'Shows A index within the defined ranges.' }}
            </div>
          </div>
          <span class="ui-badge">JSON</span>
        </div>

        <pre class="mt-4 ui-surface p-4 overflow-auto text-xs text-gray-800 dark:text-gray-100"
             style="max-height: 420px;">{{ json_encode($calculation->gauge?->toArray() ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
      </div>

      {{-- 2) Sensitivity Debug --}}
      <div class="ui-surface p-5">
        <div class="flex items-center justify-between gap-3">
          <div class="min-w-0">
            <div class="ui-label">{{ $isAr ? 'Sensitivity debug_payload' : 'Sensitivity debug_payload' }}</div>
            <div class="ui-muted mt-1">
              {{ $isAr ? 'تفاصيل الاختبارات (delta / direction / worst value).' : 'Test details (delta / direction / worst value).' }}
            </div>
          </div>
          <span class="ui-badge">JSON</span>
        </div>

        <pre class="mt-4 ui-surface p-4 overflow-auto text-xs text-gray-800 dark:text-gray-100"
             style="max-height: 420px;">{{ json_encode($calculation->sensitivity?->debug_payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
      </div>

      {{-- 3) Explanation Debug --}}
      <div class="ui-surface p-5">
        <div class="flex items-center justify-between gap-3">
          <div class="min-w-0">
            <div class="ui-label">{{ $isAr ? 'Explanation debug_payload' : 'Explanation debug_payload' }}</div>
            <div class="ui-muted mt-1">
              {{ $isAr ? 'تفاصيل اختيار الأسباب وربطها بالـ Gauge.' : 'Reason selection details and gauge linkage.' }}
            </div>
          </div>
          <span class="ui-badge">JSON</span>
        </div>

        <pre class="mt-4 ui-surface p-4 overflow-auto text-xs text-gray-800 dark:text-gray-100"
             style="max-height: 420px;">{{ json_encode($calculation->explanation?->debug_payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
      </div>

    </div>
  </div>
</div>

</section>

{{-- Plotly CDN (تقدر تنقله للـ layout إذا تحب) --}}
<script src="https://cdn.plot.ly/plotly-2.30.0.min.js"></script>

<script>
(function(){
    const isDark = document.documentElement.classList.contains('dark');

    // ===== Shared colors =====
    const textColor = isDark ? 'rgba(248,250,252,0.95)' : 'rgba(15,23,42,0.92)';
    const axisColor = isDark ? 'rgba(248,250,252,0.85)' : 'rgba(15,23,42,0.75)';
    const gridColor = isDark ? 'rgba(255,255,255,0.14)' : 'rgba(15,23,42,0.10)';
    const paperBg = 'rgba(0,0,0,0)';
    const plotBg  = 'rgba(0,0,0,0)';

    const isAr = @json(app()->getLocale()==='ar');

    // ===== Helpers =====
    const clamp = (v, a, b) => Math.max(a, Math.min(b, v));

    const fmtK = (n) => {
        const num = Number(n || 0);
        if (Math.abs(num) >= 1000) {
            const k = num / 1000;
            const dp = (num % 1000 === 0) ? 0 : 1;
            return k.toFixed(dp) + 'k';
        }
        return String(num);
    };

    // ========= Gauge =========
    const gaugeRanges = @json($gaugeRanges);
    const ranges = Array.isArray(gaugeRanges) ? gaugeRanges : [];

    const aValueFinal = Number(@json((float)$aValue));
    const gMin = Number(@json((int)$gMin));
    const gMax = Number(@json((int)$gMax));

    const steps = ranges.map(r => ({
        range: [Number(r.min ?? 0), Number(r.max ?? 0)],
        color: String(r.color ?? '#6366f1')
    }));

    const barColor = isDark ? "rgba(129,140,248,0.98)" : "rgba(99,102,241,0.92)";

    // ===== Arc position math =====
    const angleFromValue = (val) => {
        const clampedVal = clamp(Number(val), gMin, gMax);
        const pct = (gMax === gMin) ? 0 : (clampedVal - gMin) / (gMax - gMin);
        return Math.PI * (1 - pct); // left=π, right=0
    };

    const arcPoint = (val, radius=0.50) => {
        const cx = 0.5;
        const cy = 0.52;
        const a = angleFromValue(val);
        return {
            x: cx + radius * Math.cos(a),
            y: cy + radius * Math.sin(a),
        };
    };

    // ===== Annotations =====
    const rangeAnnotations = [];

    // numbers for each range start
    ranges.forEach((r) => {
        const start = Number(r.min ?? gMin);
        const pNum = arcPoint(start, 0.52);

        rangeAnnotations.push({
            xref: 'paper',
            yref: 'paper',
            x: pNum.x,
            y: pNum.y,
            text: fmtK(start),
            showarrow: false,
            font: { size: 12, color: axisColor, family: 'inherit' },
            align: 'center',
        });
    });

    // last max number
    if (ranges.length) {
        const lastMax = Number(ranges[ranges.length - 1].max ?? gMax);
        const pMax = arcPoint(lastMax, 0.52);
        rangeAnnotations.push({
            xref: 'paper',
            yref: 'paper',
            x: pMax.x,
            y: pMax.y,
            text: fmtK(lastMax),
            showarrow: false,
            font: { size: 12, color: axisColor, family: 'inherit' },
            align: 'center',
        });
    }

    // label at midpoint of each colored range
    ranges.forEach((r) => {
        const min = Number(r.min ?? gMin);
        const max = Number(r.max ?? gMax);
        const mid = (min + max) / 2;

        const pLbl = arcPoint(mid, 0.42);

        rangeAnnotations.push({
            xref: 'paper',
            yref: 'paper',
            x: pLbl.x,
            y: pLbl.y,
            text: String(r.label ?? r.key ?? ''),
            showarrow: false,
            font: { size: 11, color: textColor, family: 'inherit' },
            align: 'center',
        });
    });

    // ===== Gauge data =====
    const gaugeData = [{
        type: "indicator",
        mode: "gauge",
        value: gMin,
        gauge: {
            axis: {
                range: [gMin, gMax],
                showticklabels: false,
                ticks: '',
                tickcolor: axisColor,
                tickfont: { color: axisColor, size: 12 },
                gridcolor: gridColor,
                linecolor: gridColor,
            },
            bar: { color: barColor, thickness: 0.35 },
            bgcolor: "rgba(0,0,0,0)",
            borderwidth: 0,
            steps: steps
        },
        domain: { x: [0, 1], y: [0, 1] }
    }];

    const gaugeLayout = {
        paper_bgcolor: paperBg,
        plot_bgcolor: plotBg,
        margin: { t: 18, r: 10, b: 10, l: 10 },
        font: { color: textColor, family: 'inherit' },
        annotations: rangeAnnotations
    };

    const gaugeEl = document.getElementById('gaugeChart');
    if (gaugeEl) {
        Plotly.newPlot(gaugeEl, gaugeData, gaugeLayout, {
            displayModeBar: false,
            responsive: true
        }).then(() => {

            // ===== Smooth Animation (min -> A) =====
            const duration = 1800; // ↑ زيد الرقم حتى يصير أبطأ
            const fps = 60;
            const stepsCount = Math.max(30, Math.floor(duration / (1000 / fps)));

            let i = 0;
            const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

            const tick = () => {
                i++;
                const t = easeOutCubic(i / stepsCount);
                const cur = gMin + (aValueFinal - gMin) * t;

                Plotly.restyle(gaugeEl, { value: [cur] }, [0]);

                if (i < stepsCount) requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);

            // Glow
            const svg = gaugeEl.querySelector('svg');
            if (svg) {
                svg.style.filter = isDark
                    ? 'drop-shadow(0 0 12px rgba(99,102,241,0.28))'
                    : 'drop-shadow(0 0 10px rgba(99,102,241,0.18))';
            }
        });
    }

    // ========= Modern Colored Bar Chart =========
const barLabels = @json($barLabels);
const barValues = @json($barValues);

// ألوان متدرجة احترافية (Indigo / Blue / Violet mix)
const paletteLight = [
  '#6366f1', '#3b82f6', '#8b5cf6', '#06b6d4', '#10b981',
  '#f59e0b', '#ef4444', '#ec4899', '#14b8a6', '#a855f7'
];

const paletteDark = [
  '#818cf8', '#60a5fa', '#a78bfa', '#22d3ee', '#34d399',
  '#fbbf24', '#f87171', '#f472b6', '#2dd4bf', '#c084fc'
];

const palette = isDark ? paletteDark : paletteLight;

// نكرر الألوان إذا عدد الأعمدة أكثر
const barColors = barValues.map((_, i) => palette[i % palette.length]);

const barData = [{
    type: 'bar',
    x: barLabels,          // نخليها عمودية مثل الصورة
    y: barValues,
    marker: {
        color: barColors,
        line: {
            width: 0
        }
    },
    hovertemplate: '%{x}<br>%{y:.2f}%<extra></extra>',
}];

const barLayout = {
    paper_bgcolor: paperBg,
    plot_bgcolor: plotBg,
    margin: { t: 20, r: 20, b: 80, l: 60 },
    xaxis: {
        tickfont: { color: textColor },
        tickangle: -20
    },
    yaxis: {
        title: '{{ $isAr ? "نسبة التأثير (%)" : "Impact (%)" }}',
        gridcolor: gridColor,
        tickfont: { color: textColor },
        titlefont: { color: textColor }
    },
    font: { color: textColor, family: 'inherit' }
};

const barEl = document.getElementById('barChart');
if (barEl) {
    Plotly.newPlot(barEl, barData, barLayout, {
        displayModeBar: false,
        responsive: true
    }).then(() => {
        // Animation تصاعدي ناعم
        Plotly.animate(barEl, {
            data: [{ y: barValues }]
        }, {
            transition: { duration: 1200, easing: 'cubic-in-out' },
            frame: { duration: 1200 }
        });
    });
}

    }

)();
</script>






@endsection
