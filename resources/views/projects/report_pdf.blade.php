@php
  $dir = $isAr ? 'rtl' : 'ltr';
  $align = $isAr ? 'right' : 'left';
  $muted = '#5b6472';
@endphp
<!doctype html>
<html lang="{{ $isAr ? 'ar' : 'en' }}" dir="{{ $dir }}">
<head>
  <meta charset="utf-8">

  <style>
    /* ===== Page ===== */
    @page {
      margin: 14mm 12mm 16mm 12mm;
    }

    body{
      font-family: cairo, sans-serif;
      font-size: 11pt;
      color: #0f172a; /* slate-900 */
      direction: {{ $dir }};
      text-align: {{ $align }};
      line-height: 1.65;
    }

    /* ===== Helpers ===== */
    .muted{ color: {{ $muted }}; font-size: 9.8pt; }
    .hr{ height:1px; background:#e5e7eb; margin: 10pt 0; }
    .small{ font-size: 9.5pt; }
    .mt8{ margin-top:8pt; }
    .mt10{ margin-top:10pt; }
    .mt12{ margin-top:12pt; }
    .nowrap{ white-space:nowrap; }

    /* ===== Layout wrappers ===== */
    .page-wrap{
      background:#f6f8fc;
      border: 1px solid #e6eaf2;
      border-radius: 18px;
      padding: 14pt;
    }

    /* ===== Header Card ===== */
    .hero{
      background: #ffffff;
      border: 1px solid #e6eaf2;
      border-radius: 18px;
      padding: 14pt;
    }

    .hero-title{
      font-size: 20pt;
      font-weight: 800;
      margin: 4pt 0 2pt;
      letter-spacing: .2pt;
    }

    .hero-sub{
      margin: 0;
      color: {{ $muted }};
      font-size: 10pt;
    }

    .badges{
      margin-bottom: 6pt;
    }
    .badge{
      display:inline-block;
      padding: 4pt 10pt;
      border-radius: 999px;
      font-size: 9pt;
      font-weight: 700;
      border: 1px solid #dbe2f0;
      background:#f2f5fb;
      color:#27324a;
      margin-{{ $isAr ? 'left' : 'right' }}: 6pt;
    }

    .meta{
      margin-top: 8pt;
      padding-top: 8pt;
      border-top: 1px dashed #e5e7eb;
      font-size: 9.8pt;
      color: {{ $muted }};
    }

    /* ===== Cards ===== */
    .card{
      background:#ffffff;
      border: 1px solid #e6eaf2;
      border-radius: 18px;
      padding: 12pt;
      margin-top: 12pt;
      box-shadow: 0 6px 18px rgba(15,23,42,.06);
      page-break-inside: avoid;
    }

    .card-h{
      font-size: 13.5pt;
      font-weight: 800;
      margin: 0 0 8pt;
    }

    .card-kicker{
      font-size: 9.5pt;
      color: {{ $muted }};
      margin-top: -2pt;
    }

    /* ===== Two columns using table ===== */
    .grid{
      width:100%;
      border-collapse: separate;
      border-spacing: 10pt;
      table-layout: fixed;
    }
    .grid td{ vertical-align: top; }

    .field{
      border: 1px solid #e6eaf2;
      border-radius: 14px;
      padding: 10pt;
      background:#fbfcff;
    }
    .field-label{
      color: {{ $muted }};
      font-size: 9.5pt;
      font-weight: 700;
      margin-bottom: 2pt;
    }
    .field-val{
      font-size: 11.2pt;
      font-weight: 700;
      color:#0f172a;
    }

    /* ===== Table ===== */
    table.data{
      width:100%;
      border-collapse: collapse;
      margin-top: 8pt;
      overflow: hidden;
      border-radius: 14px;
      border: 1px solid #e6eaf2;
    }
    table.data thead th{
      background:#f2f5fb;
      color:#1f2a44;
      font-weight: 800;
      font-size: 10.2pt;
      padding: 9pt 10pt;
      border-bottom: 1px solid #e6eaf2;
      text-align: {{ $align }};
    }
    table.data tbody td{
      padding: 9pt 10pt;
      border-bottom: 1px solid #eef2f7;
      font-size: 10.4pt;
      text-align: {{ $align }};
    }
    table.data tbody tr:nth-child(even) td{
      background:#fbfcff;
    }
    .num{ text-align: {{ $isAr ? 'left' : 'right' }}; direction:ltr; }

    /* ===== Result box ===== */
    .result-box{
      border-radius: 18px;
      padding: 14pt;
      border: 1px solid #e6eaf2;
      background: linear-gradient(180deg,#ffffff 0%, #fbfcff 100%);
    }
    .result-label{
      color: {{ $muted }};
      font-size: 10pt;
      font-weight: 800;
      margin: 0;
    }
    .result-value{
      font-size: 24pt;
      font-weight: 900;
      margin: 4pt 0 6pt;
      letter-spacing: .3pt;
    }

    .pill{
      display:inline-block;
      border-radius: 999px;
      padding: 5pt 10pt;
      font-size: 9.5pt;
      font-weight: 800;
      background:#eef2ff;
      color:#3730a3;
      border:1px solid #dbe2f0;
    }

    /* ===== Charts ===== */
    .chart-wrap{
      border: 1px solid #e6eaf2;
      border-radius: 18px;
      padding: 10pt;
      background:#ffffff;
      page-break-inside: avoid;
    }
    .chart-title{
      font-size: 11pt;
      font-weight: 900;
      margin: 0;
    }
    .chart-sub{
      margin: 2pt 0 8pt;
      color: {{ $muted }};
      font-size: 9.4pt;
    }
    img.chart-img{
      width: 100%;
      border-radius: 14px;
      border: 1px solid #eef2f7;
      padding: 6pt;
      background:#fbfcff;
    }

    /* ===== Reasons ===== */
    .reason{
      border: 1px solid #e6eaf2;
      border-radius: 16px;
      padding: 10pt;
      background:#ffffff;
      margin-top: 10pt;
      page-break-inside: avoid;
    }
    .reason b{ font-weight: 900; }

    /* ===== Footer note ===== */
    .note{
      color: {{ $muted }};
      font-size: 9.4pt;
      margin-top: 6pt;
    }

    /* ===== Page breaks ===== */
    .page-break{ page-break-before: always; }

  </style>
</head>
<body>

  <div class="page-wrap">

    {{-- HERO --}}
    <div class="hero">
      <div class="badges">
        <span class="badge">ANFIS</span>
        <span class="badge">XAI</span>
      </div>

      <div class="hero-title">{{ $isAr ? 'تقرير المشروع' : 'Project Report' }}</div>
      <p class="hero-sub">
        {{ $isAr ? 'يعرض هذا التقرير نتائج النموذج والتحليل التفسيري للمشروع.' : 'This report shows model outputs and explanatory analysis.' }}
      </p>

      <div class="meta">
        {{ $isAr ? 'تاريخ التقرير:' : 'Report Date:' }}
        <span class="nowrap">{{ $reportDate->format('Y-m-d H:i') }}</span>
        &nbsp;—&nbsp;
        {{ $isAr ? 'رقم المشروع:' : 'Project ID:' }} <b>#{{ $project->id }}</b>
        &nbsp;—&nbsp;
        {{ $isAr ? 'رقم الحساب:' : 'Calculation ID:' }} <b>#{{ $calculation->id }}</b>
      </div>
    </div>

    {{-- Project info --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'معلومات المشروع' : 'Project Information' }}</div>

      <table class="grid">
        <tr>
          <td>
            <div class="field">
              <div class="field-label">{{ $isAr ? 'اسم المشروع' : 'Project Title' }}</div>
              <div class="field-val">{{ $project->title ?? '-' }}</div>
            </div>
          </td>
          <td>
            <div class="field">
              <div class="field-label">{{ $isAr ? 'المحافظة' : 'Governorate' }}</div>
              <div class="field-val">{{ $project->governorate ?? '-' }}</div>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="field">
              <div class="field-label">{{ $isAr ? 'اسم الطريق' : 'Road Name' }}</div>
              <div class="field-val">{{ $project->road_name ?? '-' }}</div>
            </div>
          </td>
          <td>
            <div class="field">
              <div class="field-label">{{ $isAr ? 'تاريخ الصيانة' : 'Maintenance Date' }}</div>
              <div class="field-val">{{ $project->maintenance_date?->format('Y-m-d') ?? '-' }}</div>
            </div>
          </td>
        </tr>
      </table>
    </div>

    {{-- Inputs --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'مدخلات النموذج (13)' : 'Model Inputs (13)' }}</div>
      <div class="card-kicker">{{ $isAr ? 'تم تحويل الأكواد إلى نصوص لسهولة القراءة داخل التقرير.' : 'Codes are mapped into readable labels for this report.' }}</div>

      <table class="data">
        <thead>
          <tr>
            <th style="width:60%">{{ $isAr ? 'المتغير' : 'Variable' }}</th>
            <th style="width:40%">{{ $isAr ? 'القيمة' : 'Value' }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($inputsTable as $row)
            <tr>
              <td>{{ $row['label'] }}</td>
              <td class="num">{{ $row['value'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Results summary --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'النتائج' : 'Results' }}</div>

      <div class="result-box">
        <p class="result-label">{{ $isAr ? 'الكلفة الكلية المقدّرة' : 'Estimated Total Cost' }}</p>
        <div class="result-value">
          {{ number_format((int)$calculation->estimated_cost) }}
          <span style="font-size:11pt; font-weight:700; color:{{ $muted }};">{{ $isAr ? 'دينار' : 'IQD' }}</span>
        </div>

        @if($topLabel)
          <div class="mt8">
            <span class="pill">{{ $isAr ? 'أعلى عامل تأثيرًا' : 'Top Influencer' }}</span>
            <span style="font-weight:900; margin-{{ $isAr ? 'right' : 'left' }}: 8pt;">
              {{ $topLabel }}
            </span>
            <span class="muted">({{ number_format((float)$topPct,2) }}%)</span>
          </div>
        @endif

        @if($summary)
          <div class="mt10" style="color:#0f172a;">
            {{ $summary }}
          </div>
        @endif
      </div>
    </div>

    {{-- Charts (two columns like your screenshot) --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'الرسوم البيانية' : 'Charts' }}</div>

      <table class="grid">
        <tr>
          {{-- In RTL: right column first visually, but table order is fine because dir=rtl --}}
          <td>
            <div class="chart-wrap">
              <p class="chart-title">{{ $isAr ? 'Sensitivity (Impact %)' : 'Sensitivity (Impact %)' }}</p>
              <p class="chart-sub">{{ $isAr ? 'المدخلات الأكثر تأثيرًا على الكلفة.' : 'Most influential inputs on cost.' }}</p>
              @if($barPng)
                <img class="chart-img" src="{{ $barPng }}" alt="Bar Chart">
              @else
                <div class="muted">{{ $isAr ? 'لا يوجد مخطط حالياً.' : 'Chart is not available.' }}</div>
              @endif
            </div>
          </td>

          <td>
            <div class="chart-wrap">
              <p class="chart-title">{{ $isAr ? 'Gauge (A Index)' : 'Gauge (A Index)' }}</p>
              <p class="chart-sub">{{ $isAr ? 'A = الكلفة/المساحة ضمن رينجات.' : 'A = cost/area within predefined ranges.' }}</p>
              @if($gaugePng)
                <img class="chart-img" src="{{ $gaugePng }}" alt="Gauge">
              @else
                <div class="muted">{{ $isAr ? 'لا يوجد مخطط حالياً.' : 'Chart is not available.' }}</div>
              @endif
            </div>
          </td>
        </tr>
      </table>

      <div class="note">
        {{ $isAr ? 'ملاحظة: تم تصدير الرسوم كصور (JPEG) لضمان التوافق داخل PDF.' : 'Note: Charts are exported as JPEG images for PDF compatibility.' }}
      </div>
    </div>

    {{-- Reasons --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'الأسباب' : 'Reasons' }}</div>
      <div class="card-kicker">{{ $isAr ? 'تفسير مختصر وفق XAI.' : 'Short explanation based on XAI.' }}</div>

      @if(!empty($reasons))
        @foreach($reasons as $idx => $r)
          <div class="reason">
            <b>{{ $isAr ? 'سبب' : 'Reason' }} {{ $idx + 1 }}:</b>
            <div class="mt8">{{ $r }}</div>
          </div>
        @endforeach
      @else
        <div class="muted">{{ $isAr ? 'لا توجد أسباب حالياً.' : 'No reasons available yet.' }}</div>
      @endif
    </div>

    {{-- Methodology --}}
    <div class="card">
      <div class="card-h">{{ $isAr ? 'منهجية الحساب' : 'Methodology' }}</div>

      <table class="data">
        <tbody>
          <tr>
            <td style="width:22%"><b>ANFIS</b></td>
            <td>{{ $isAr ? 'تم استخدام نموذج ANFIS لتقدير الكلفة اعتماداً على 13 مدخلاً.' : 'ANFIS estimates cost based on 13 inputs.' }}</td>
          </tr>
          <tr>
            <td><b>Gauge</b></td>
            <td>{{ $isAr ? 'تم حساب مؤشر A = الكلفة/المساحة وتصنيفه ضمن رينجات محددة.' : 'A = cost/area and classified within predefined ranges.' }}</td>
          </tr>
          <tr>
            <td><b>Sensitivity</b></td>
            <td>{{ $isAr ? 'تم تحليل الحساسية عبر قياس أثر المدخلات كنسبة مئوية.' : 'Sensitivity measures each input impact percentage.' }}</td>
          </tr>
          <tr>
            <td><b>XAI</b></td>
            <td>{{ $isAr ? 'تم توليد تفسير نصي يربط أعلى المؤثرات بتصنيف الكلفة النهائي.' : 'Text explanation links top influencers to the final cost class.' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div> {{-- /page-wrap --}}
</body>
</html>
