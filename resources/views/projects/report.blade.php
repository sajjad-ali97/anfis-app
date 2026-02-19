@extends('layouts.app')
@section('title', $isAr ? 'تقرير المشروع' : 'Project Report')

@section('content')
<div id="top"></div>

<section class="ui-section">
  <div class="ui-card p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
      <div class="min-w-0">
        <div class="flex items-center gap-2">
          <span class="ui-badge">ANFIS</span>
          <span class="ui-badge">XAI</span>
        </div>
        <h1 class="ui-h1 mt-2">{{ $isAr ? 'تقرير المشروع' : 'Project Report' }}</h1>
        <p class="ui-p mt-2">
          {{ $isAr ? 'يعرض هذا التقرير نتائج النموذج والتحليل التفسيري للمشروع.' : 'This report shows model outputs and XAI explanation for the project.' }}
        </p>
      </div>

      {{-- Export PDF --}}
      <form id="pdfForm" method="POST" action="{{ route('projects.report.pdf', $project) }}" class="shrink-0">
        @csrf
        <input type="hidden" name="gauge_png" id="gauge_png">
        <input type="hidden" name="bar_png" id="bar_png">

        <button type="button" id="btnExportPdf" class="ui-btn-primary ui-btn-lg w-full sm:w-auto">
          {{ $isAr ? 'تصدير PDF' : 'Export PDF' }}
        </button>
      </form>
    </div>

    <div class="ui-divider my-6"></div>

    {{-- Project Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'اسم المشروع' : 'Project Title' }}</span>
        <span class="text-sm font-semibold">{{ $project->title ?? '-' }}</span>
      </div>

      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'المحافظة' : 'Governorate' }}</span>
        <span class="text-sm font-semibold">{{ $project->governorate ?? '-' }}</span>
      </div>

      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'اسم الطريق' : 'Road Name' }}</span>
        <span class="text-sm font-semibold">{{ $project->road_name ?? '-' }}</span>
      </div>

      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'تاريخ الصيانة' : 'Maintenance Date' }}</span>
        <span class="text-sm font-semibold">{{ $project->maintenance_date?->format('Y-m-d') ?? '-' }}</span>
      </div>
    </div>

    <div class="ui-divider my-6"></div>

    {{-- Inputs Table --}}
    <h2 class="ui-h2">{{ $isAr ? 'مدخلات النموذج (13)' : 'Model Inputs (13)' }}</h2>
    <p class="ui-p mt-2">
      {{ $isAr ? 'تم تحويل الأكواد إلى نصوص لسهولة القراءة داخل التقرير.' : 'Codes are mapped to human-readable labels for reporting.' }}
    </p>

    <div class="ui-table-wrap">
      <table class="ui-table">
        <thead>
          <tr>
            <th class="ui-th">{{ $isAr ? 'المتغير' : 'Variable' }}</th>
            <th class="ui-th">{{ $isAr ? 'القيمة' : 'Value' }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($inputsTable as $row)
            <tr>
              <td class="ui-td">{{ $row['label'] }}</td>
              <td class="ui-td ui-td-secondary">{{ $row['value'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="ui-divider my-8"></div>

    {{-- Results --}}
    @php
      $summary = $isAr ? ($calculation->explanation?->summary_ar ?? '') : ($calculation->explanation?->summary_en ?? '');
    @endphp

    <h2 class="ui-h2">{{ $isAr ? 'النتائج' : 'Results' }}</h2>

    <div class="mt-4 ui-surface p-5">
      <div class="ui-label">{{ $isAr ? 'الكلفة الكلية المقدّرة' : 'Estimated Total Cost' }}</div>
      <div class="mt-2 text-3xl sm:text-4xl font-semibold text-gray-900 dark:text-white">
        {{ number_format((int)$calculation->estimated_cost) }}
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $isAr ? 'دينار' : 'IQD' }}</span>
      </div>

      @if($summary)
        <div class="mt-4 text-sm leading-7 text-gray-800 dark:text-gray-100 whitespace-pre-line">
          {{ $summary }}
        </div>
      @endif
    </div>

    {{-- Top Influencer --}}
    @php
      $top = $topOne;
      $topLabel = $top ? ($isAr ? ($top['label_ar'] ?? $top['key']) : ($top['label_en'] ?? $top['key'])) : null;
      $topPct = $top ? (float)($top['impact_percent'] ?? 0) : null;
    @endphp

    <div class="mt-5 ui-surface p-5">
      <div class="ui-label">{{ $isAr ? 'أعلى عامل تأثيراً' : 'Top Influencer' }}</div>
      @if($top)
        <div class="mt-2 flex items-center justify-between gap-3">
          <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $topLabel }}</div>
          <div class="ui-badge">{{ number_format($topPct, 2) }}%</div>
        </div>
      @else
        <div class="ui-muted mt-2">{{ $isAr ? 'غير متوفر' : 'N/A' }}</div>
      @endif
    </div>

    <div class="ui-divider my-8"></div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      {{-- Gauge --}}
      <div class="ui-surface p-5">
        <div class="flex items-center justify-between gap-3">
          <div class="min-w-0">
            <div class="ui-label">{{ $isAr ? 'Gauge (A Index)' : 'Gauge (A Index)' }}</div>
            <div class="ui-muted mt-1">{{ $isAr ? 'A = الكلفة/المساحة ضمن الرينجات.' : 'A = cost/area within predefined ranges.' }}</div>
          </div>
          <span class="ui-badge">{{ $calculation->gauge?->label ?? $calculation->gauge?->label_key ?? '' }}</span>
        </div>

        <div class="mt-4" id="gaugeChart" style="height:340px;"></div>

        {{-- Legend --}}
        <div class="mt-4 ui-surface p-4">
          <div class="ui-label mb-3">{{ $isAr ? 'تقسيم المستويات' : 'Levels' }}</div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach(($gaugeRanges ?? []) as $r)
              <div class="ui-row">
                <div class="flex items-center gap-3 min-w-0">
                  <span class="h-3.5 w-3.5 rounded-full shrink-0" style="background: {{ $r['color'] ?? '#6366f1' }};"></span>
                  <div class="min-w-0">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                      {{ $r['label'] ?? ($r['key'] ?? '') }}
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

      {{-- Bar --}}
      <div class="ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'Sensitivity (Impact %)' : 'Sensitivity (Impact %)' }}</div>
        <div class="ui-muted mt-1">{{ $isAr ? 'المدخلات الأكثر تأثيراً على الكلفة.' : 'Most impactful inputs on cost.' }}</div>
        <div class="mt-4" id="barChart" style="height:420px;"></div>
      </div>
    </div>

    <div class="ui-divider my-8"></div>

    {{-- Reasons --}}
    @php
      $reasons = $isAr ? ($calculation->explanation?->reasons_ar ?? []) : ($calculation->explanation?->reasons_en ?? []);
      if (!is_array($reasons)) $reasons = [];
    @endphp

    <h2 class="ui-h2">{{ $isAr ? 'الأسباب' : 'Reasons' }}</h2>
    <p class="ui-p mt-2">{{ $isAr ? 'تفسير مختصر وفق XAI.' : 'Short explanation based on XAI.' }}</p>

    <div class="mt-6 space-y-4">
      @forelse($reasons as $r)
        <div class="ui-surface p-5">
          <div class="text-sm text-gray-900 dark:text-white leading-7 whitespace-pre-line">{{ $r }}</div>
        </div>
      @empty
        <div class="ui-muted">{{ $isAr ? 'لا توجد أسباب حالياً.' : 'No reasons available yet.' }}</div>
      @endforelse
    </div>

    <div class="ui-divider my-8"></div>

    {{-- Methodology --}}
    <h2 class="ui-h2">{{ $isAr ? 'منهجية الحساب' : 'Methodology' }}</h2>
    <div class="mt-4 ui-surface p-5 text-sm leading-7 text-gray-800 dark:text-gray-100">
      <ul class="list-disc ms-5 space-y-2">
        <li>{{ $isAr ? 'تم استخدام نموذج ANFIS لتقدير الكلفة اعتماداً على 13 مدخلاً.' : 'ANFIS model estimates cost based on 13 inputs.' }}</li>
        <li>{{ $isAr ? 'تم حساب A = الكلفة/المساحة ثم تصنيفها ضمن رينجات (Gauge).' : 'A = cost/area then classified into gauge ranges.' }}</li>
        <li>{{ $isAr ? 'تم استخراج الحساسية عبر تغيير المدخلات وقياس تأثيرها كنسبة مئوية.' : 'Sensitivity is computed by perturbing inputs and measuring impact percentage.' }}</li>
        <li>{{ $isAr ? 'تم توليد تفسير نصي يربط أعلى المؤثرات بتصنيف الكلفة.' : 'Textual explanation links top influencers to final cost class.' }}</li>
      </ul>
    </div>

  </div>
</section>

{{-- Plotly --}}
<script src="https://cdn.plot.ly/plotly-2.35.2.min.js"></script>

<script>
(function () {
  // ===== Theme detect (fix your issue: always white) =====
  // نعتمد localStorage أولاً، وإذا ماكو نعتمد الكلاس على html
  const savedTheme = localStorage.getItem('theme');
  const isDark = savedTheme ? (savedTheme === 'dark') : document.documentElement.classList.contains('dark');

  // بالدارك أبيض، باللايت أسود (مثل ما طلبت)
  const textColor = isDark ? '#ffffff' : '#000000';
  const axisColor = isDark ? '#ffffff' : '#000000';
  const gridColor = isDark ? 'rgba(255,255,255,0.18)' : 'rgba(0,0,0,0.12)';
  const paperBg = 'rgba(0,0,0,0)';
  const plotBg  = 'rgba(0,0,0,0)';

  // ===== Gauge from PHP =====
  const ranges = Array.isArray(@json($gaugeRanges)) ? @json($gaugeRanges) : [];
  const aValueFinal = Number(@json((float)$aValue));
  const gMin = Number(@json((int)$gMin));
  const gMax = Number(@json((int)$gMax));

  const steps = ranges.map(r => ({
    range: [Number(r.min ?? 0), Number(r.max ?? 0)],
    color: String(r.color ?? '#6366f1')
  }));

  const barColor = isDark ? "rgba(129,140,248,0.98)" : "rgba(99,102,241,0.92)";

  const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
  const fmtK = (n) => {
    const num = Number(n || 0);
    if (Math.abs(num) >= 1000) return (num/1000).toFixed((num%1000===0)?0:1) + 'k';
    return String(num);
  };

  const angleFromValue = (val) => {
    const clampedVal = clamp(Number(val), gMin, gMax);
    const pct = (gMax === gMin) ? 0 : (clampedVal - gMin) / (gMax - gMin);
    return Math.PI * (1 - pct);
  };

  const arcPoint = (val, radius=0.50) => {
    const cx = 0.5, cy = 0.52;
    const a = angleFromValue(val);
    return { x: cx + radius * Math.cos(a), y: cy + radius * Math.sin(a) };
  };

  // annotations
  const ann = [];

  // numbers
  ranges.forEach((r) => {
    const start = Number(r.min ?? gMin);
    const p = arcPoint(start, 0.52);
    ann.push({ xref:'paper', yref:'paper', x:p.x, y:p.y, text: fmtK(start), showarrow:false, font:{size:12, color:axisColor} });
  });

  if (ranges.length) {
    const lastMax = Number(ranges[ranges.length - 1].max ?? gMax);
    const p = arcPoint(lastMax, 0.52);
    ann.push({ xref:'paper', yref:'paper', x:p.x, y:p.y, text: fmtK(lastMax), showarrow:false, font:{size:12, color:axisColor} });
  }

  // labels mid
  ranges.forEach((r) => {
    const min = Number(r.min ?? gMin), max = Number(r.max ?? gMax);
    const mid = (min + max)/2;
    const p = arcPoint(mid, 0.42);
    ann.push({ xref:'paper', yref:'paper', x:p.x, y:p.y, text: String(r.label ?? r.key ?? ''), showarrow:false, font:{size:11, color:textColor} });
  });

  const gaugeData = [{
    type: "indicator",
    mode: "gauge",
    value: gMin,
    gauge: {
      axis: { range:[gMin,gMax], showticklabels:false, ticks:'', gridcolor:gridColor, linecolor:gridColor },
      bar: { color: barColor, thickness: 0.35 },
      bgcolor: "rgba(0,0,0,0)",
      borderwidth: 0,
      steps: steps
    },
    domain: { x:[0,1], y:[0,1] }
  }];

  const gaugeLayout = {
    paper_bgcolor: paperBg,
    plot_bgcolor: plotBg,
    margin: { t: 18, r: 10, b: 10, l: 10 },
    font: { color: textColor, family:'inherit' },
    annotations: ann
  };

  const gaugeEl = document.getElementById('gaugeChart');
  if (gaugeEl) {
    Plotly.newPlot(gaugeEl, gaugeData, gaugeLayout, { displayModeBar:false, responsive:true }).then(() => {
      // smooth animate
      const duration = 2200;
      const fps = 60;
      const stepsCount = Math.max(30, Math.floor(duration / (1000 / fps)));
      let i = 0;
      const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

      const tick = () => {
        i++;
        const t = easeOutCubic(i / stepsCount);
        const cur = gMin + (aValueFinal - gMin) * t;
        Plotly.restyle(gaugeEl, { value:[cur] }, [0]);
        if (i < stepsCount) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    });
  }

  // ===== Bar chart (multi colors) =====
  const barLabels = @json($barLabels);
  const barValues = @json($barValues);

  const palette = isDark
    ? ['#818cf8','#60a5fa','#a78bfa','#22d3ee','#34d399','#fbbf24','#f87171','#f472b6','#2dd4bf','#c084fc']
    : ['#6366f1','#3b82f6','#8b5cf6','#06b6d4','#10b981','#f59e0b','#ef4444','#ec4899','#14b8a6','#a855f7'];

  const barColors = (Array.isArray(barValues) ? barValues : []).map((_, i) => palette[i % palette.length]);

  const barData = [{
    type: 'bar',
    x: barLabels,
    y: barValues,
    marker: { color: barColors },
    hovertemplate: '%{x}<br>%{y:.2f}%<extra></extra>',
  }];

  const barLayout = {
    paper_bgcolor: paperBg,
    plot_bgcolor: plotBg,
    margin: { t: 20, r: 20, b: 90, l: 70 },
    font: { color: textColor, family:'inherit' },
    xaxis: {
      tickfont: { color: axisColor, size: 12 },
      tickcolor: axisColor,
      tickangle: -20,
      linecolor: gridColor
    },
    yaxis: {
      title: '{{ $isAr ? "نسبة التأثير (%)" : "Impact (%)" }}',
      titlefont: { color: textColor, size: 13 },
      tickfont: { color: axisColor, size: 12 },
      tickcolor: axisColor,
      gridcolor: gridColor,
      zerolinecolor: gridColor,
      linecolor: gridColor
    }
  };

  const barEl = document.getElementById('barChart');
  if (barEl) {
    Plotly.newPlot(barEl, barData, barLayout, { displayModeBar:false, responsive:true }).then(() => {
      Plotly.animate(barEl, { data: [{ y: barValues }] }, {
        transition: { duration: 1200, easing: 'cubic-in-out' },
        frame: { duration: 1200 }
      });
    });
  }

  // ===== Export PDF: Plotly -> base64(JPEG) -> submit =====
  const btn = document.getElementById('btnExportPdf');
  const form = document.getElementById('pdfForm');

  // JPEG: أصغر حجم + بدون alpha (أفضل للمPDF)
  async function toJpeg(el, w, h) {
    if (!el) return '';
    return await Plotly.toImage(el, {
      format: 'jpeg',
      width: w,
      height: h,
      scale: 2,
      quality: 0.92
    });
  }

  if (btn && form) {
    btn.addEventListener('click', async () => {
      btn.disabled = true;
      btn.textContent = '{{ $isAr ? "جارٍ التصدير..." : "Exporting..." }}';

      try {
        // أبعاد محسّنة للطباعة داخل A4
        const gaugeImg = await toJpeg(gaugeEl, 1100, 620);
        const barImg   = await toJpeg(barEl,   1100, 620);

        document.getElementById('gauge_png').value = gaugeImg; // نفس الـ name، بس القيمة صارت jpeg
        document.getElementById('bar_png').value   = barImg;

        form.submit();
      } catch (e) {
        console.error(e);
        btn.disabled = false;
        btn.textContent = '{{ $isAr ? "تصدير PDF" : "Export PDF" }}';
        alert('{{ $isAr ? "صار خطأ أثناء تصدير PDF" : "PDF export failed" }}');
      }
    });
  }
})();
</script>
@endsection
