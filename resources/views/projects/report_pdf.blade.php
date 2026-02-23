@php
  $dir   = $isAr ? 'rtl' : 'ltr';
  $align = $isAr ? 'right' : 'left';
  $muted = '#5b6472';

  // Logos (absolute paths for mPDF)
  $anfisLogo = public_path('images/hero.jpg');                // header left
  $kkLogo    = public_path('images/uni/kk.png');              // footer right
  $engLogo   = public_path('images/uni/engineering.png');     // footer right

  // Cover text
  $researchTitle = $isAr
    ? 'نمذجة كلفة صيانة مشاريع الطرق في محافظة كربلاء باستخدام الشبكات العصبية الضبابية'
    : 'Modeling the Maintenance Costs of Road Projects in Karbala Governorate using Fuzzy Neural Network';

  $researcher = 'ALI SAAD AHMED';
  $supervisor = 'Assist. Prof. Dr. Gafel Kareem Aswed';

  // charts (names you already send from report page)
  // IMPORTANT: keep SAME variable names you pass from controller
  $barImg   = $barPng   ?? null;
  $gaugeImg = $gaugePng ?? null;

  // reasons array
  $reasons = $isAr ? ($calculation->explanation?->reasons_ar ?? []) : ($calculation->explanation?->reasons_en ?? []);
  if (!is_array($reasons)) $reasons = [];

  // summary
  $summary = $isAr ? ($calculation->explanation?->summary_ar ?? '') : ($calculation->explanation?->summary_en ?? '');

  // top
  $top = $topOne ?? null;
  $topLabel = $top ? ($isAr ? ($top['label_ar'] ?? $top['key']) : ($top['label_en'] ?? $top['key'])) : null;
  $topPct   = $top ? (float)($top['impact_percent'] ?? 0) : null;
@endphp
<!doctype html>
<html lang="{{ $isAr ? 'ar' : 'en' }}" dir="{{ $dir }}">
<head>
  <meta charset="utf-8">

  <style>
    /* ===== mPDF Page with real header/footer spacing ===== */
    @page{
      margin: 26mm 12mm 22mm 12mm; /* top right bottom left */
      header: page-header;
      footer: page-footer;
    }

    body{
      font-family: cairo, sans-serif;
      font-size: 11pt;
      color:#0f172a;
      direction: {{ $dir }};
      text-align: {{ $align }};
      line-height: 1.6;
    }

    /* ===== Header / Footer (mPDF) ===== */
    .hdr, .ftr { width:100%; }
    .hdr td, .ftr td { vertical-align: middle; }

    .hdr{
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 3mm;
    }
    .ftr{
      border-top: 1px solid #e5e7eb;
      padding-top: 2.5mm;
      font-size: 9.5pt;
      color: {{ $muted }};
    }

    .hdr-left { width:28%; text-align: left; }
    .hdr-right{ width:72%; text-align: right; font-weight: 900; font-size: 10.5pt; }

    .logo-anfis{ height: 10mm; max-width: 40mm; object-fit: contain; }
    .logo-small{ height: 9mm; max-width: 18mm; object-fit: contain; }

    .ftr-left  { width:70%; text-align: {{ $align }}; }
    .ftr-right { width:30%; text-align: right; }

    .page-no{ white-space: nowrap; }

    /* ===== Layout ===== */
    .page{ page-break-after: always; }
    .page.last{ page-break-after: auto; }

    .center{ text-align:center; }
    .muted{ color: {{ $muted }}; }

    .title{ font-size: 18pt; font-weight: 900; margin: 0; }
    .sub{ font-size: 11pt; margin: 6pt 0 0; }

    /* ===== Cards ===== */
    .card{
      border:1px solid #e6eaf2;
      border-radius: 16px;
      padding: 12pt;
      margin-top: 10pt;
      background:#fff;
      page-break-inside: avoid;
    }
    .card-h{ font-size: 13.5pt; font-weight: 900; margin:0 0 8pt; }

    /* ===== Project fields (label فوق value مضبوط) ===== */
    .grid{ width:100%; border-collapse: separate; border-spacing: 10pt; table-layout: fixed; }
    .grid td{ vertical-align: top; }

    .field{
      border:1px solid #e6eaf2;
      border-radius: 14px;
      padding: 10pt;
      background:#fbfcff;
    }
    .field-label{
      display:block;
      font-size: 9.5pt;
      font-weight: 900;
      color: {{ $muted }};
      margin-bottom: 4pt;
    }
    .field-val{
      display:block;
      font-size: 11.5pt;
      font-weight: 900;
      color:#0f172a;
    }

    /* ===== Tables ===== */
    table.data{
      width:100%;
      border-collapse: collapse;
      margin-top: 8pt;
      border-radius: 14px;
      border: 1px solid #e6eaf2;
    }
    table.data thead th{
      background:#f2f5fb;
      color:#1f2a44;
      font-weight:900;
      font-size:10.2pt;
      padding: 9pt 10pt;
      border-bottom: 1px solid #e6eaf2;
      text-align: {{ $align }};
    }
    table.data tbody td{
      padding: 9pt 10pt;
      border-bottom: 1px solid #eef2f7;
      font-size:10.4pt;
      text-align: {{ $align }};
    }
    table.data tbody tr:nth-child(even) td{ background:#fbfcff; }
    .num{ text-align: {{ $isAr ? 'left' : 'right' }}; direction:ltr; }

    /* ===== Result box ===== */
    .result-box{
      border-radius: 16px;
      padding: 12pt;
      border: 1px solid #e6eaf2;
      background: #fbfcff;
    }
    .result-label{ color: {{ $muted }}; font-size: 10pt; font-weight: 900; margin: 0; }
    .result-value{ font-size: 24pt; font-weight: 900; margin: 4pt 0 8pt; }

    /* ===== Charts ===== */
    .chart-wrap{
      border: 1px solid #e6eaf2;
      border-radius: 16px;
      padding: 10pt;
      background:#fff;
      page-break-inside: avoid;
    }
    .chart-title{ font-size: 11pt; font-weight: 900; margin: 0; }
    .chart-sub{ margin: 2pt 0 8pt; color: {{ $muted }}; font-size: 9.4pt; }

    img.chart-img{
      width: 100%;
      border-radius: 12px;
      border: 1px solid #eef2f7;
      padding: 6pt;
      background:#fff; /* مهم: بياض */
    }

    /* ===== Bullets ===== */
    .bullets{
      margin: 0;
      padding-{{ $isAr ? 'right' : 'left' }}: 18pt;
    }
    .bullets li{ margin: 6pt 0; }

  </style>
</head>
<body>

  {{-- mPDF Header --}}
  <htmlpageheader name="page-header">
    <table class="hdr" cellpadding="0" cellspacing="0">
      <tr>
        <td class="hdr-left">
          @if(file_exists($anfisLogo))
            <img class="logo-anfis" src="{{ $anfisLogo }}" alt="ANFIS">
          @endif
        </td>
        <td class="hdr-right">
          {{ $project->title ?? ($isAr ? 'تقرير مشروع' : 'Project Report') }}
        </td>
      </tr>
    </table>
  </htmlpageheader>

  {{-- mPDF Footer --}}
  <htmlpagefooter name="page-footer">
    <table class="ftr" cellpadding="0" cellspacing="0">
      <tr>
        <td class="ftr-left">
          {{ $isAr ? 'الباحث:' : 'Researcher:' }} <b>{{ $researcher }}</b>
          &nbsp;|&nbsp;
          {{ $isAr ? 'المشرف:' : 'Supervisor:' }} <b>{{ $supervisor }}</b>
          &nbsp;|&nbsp;
          <span class="page-no">
            {{ $isAr ? 'الصفحة' : 'Page' }} {PAGENO} / {nbpg}
          </span>
        </td>
        <td class="ftr-right">
          @if(file_exists($kkLogo))
            <img class="logo-small" src="{{ $kkLogo }}" alt="KK">
          @endif
          @if(file_exists($engLogo))
            <img class="logo-small" src="{{ $engLogo }}" alt="ENG" style="margin-left:6pt;">
          @endif
        </td>
      </tr>
    </table>
  </htmlpagefooter>

  {{-- ===================== Page 1: Cover ===================== --}}
  <div class="page">
    <div class="center" style="margin-top: 18mm;">
      <div class="muted">{{ $isAr ? 'وزارة التعليم العالي والبحث العلمي' : 'Ministry of Higher Education and Scientific Research' }}</div>
      <div style="font-weight:900; margin-top:4pt;">
        {{ $isAr ? 'كلية الهندسة - جامعة كربلاء' : 'College of Engineering - University of Karbala' }}
      </div>

      <div style="margin-top:18mm;">
        <p class="title">{{ $researchTitle }}</p>
        <p class="sub muted">{{ $isAr ? 'سنة البحث: 2026' : 'Year: 2026' }}</p>
      </div>

      <div style="margin-top:26mm;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="width:50%; text-align: {{ $align }};">
              <div style="font-weight:900;">{{ $isAr ? 'اسم الباحث' : 'Researcher Name' }}</div>
              <div style="font-weight:900;">{{ $researcher }}</div>
            </td>
            <td style="width:50%; text-align: {{ $isAr ? 'left' : 'right' }};">
              <div style="font-weight:900;">{{ $isAr ? 'المشرف' : 'Supervisor' }}</div>
              <div style="font-weight:900;">{{ $supervisor }}</div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  {{-- ===================== Page 2: Project + Inputs ===================== --}}
  <div class="page">
    <div class="card">
      <div class="card-h">{{ $isAr ? 'معلومات المشروع' : 'Project Information' }}</div>

      <table class="grid">
        <tr>
          <td>
            <div class="field">
              <span class="field-label">{{ $isAr ? 'اسم المشروع' : 'Project Title' }}</span>
              <span class="field-val">{{ $project->title ?? '-' }}</span>
            </div>
          </td>
          <td>
            <div class="field">
              <span class="field-label">{{ $isAr ? 'المحافظة' : 'Governorate' }}</span>
              <span class="field-val">{{ $project->governorate ?? '-' }}</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="field">
              <span class="field-label">{{ $isAr ? 'اسم الطريق' : 'Road Name' }}</span>
              <span class="field-val">{{ $project->road_name ?? '-' }}</span>
            </div>
          </td>
          <td>
            <div class="field">
              <span class="field-label">{{ $isAr ? 'تاريخ الصيانة' : 'Maintenance Date' }}</span>
              <span class="field-val">{{ $project->maintenance_date?->format('Y-m-d') ?? '-' }}</span>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="card">
      <div class="card-h">{{ $isAr ? 'مدخلات النموذج (13)' : 'Model Inputs (13)' }}</div>

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
  </div>

  {{-- ===================== Page 3: Results + Charts ===================== --}}
  <div class="page">
    <div class="card">
      <div class="card-h">{{ $isAr ? 'النتائج' : 'Results' }}</div>

      <div class="result-box">
        <p class="result-label">{{ $isAr ? 'الكلفة الكلية المقدّرة' : 'Estimated Total Cost' }}</p>
        <div class="result-value">
          {{ number_format((int)$calculation->estimated_cost) }}
          <span style="font-size:11pt; font-weight:800; color:{{ $muted }};">{{ $isAr ? 'دينار' : 'IQD' }}</span>
        </div>

        @if(!empty($topLabel))
          <div class="muted">
            {{ $isAr ? 'أعلى عامل تأثيراً:' : 'Top Influencer:' }}
            <b style="color:#0f172a">{{ $topLabel }}</b>
            ({{ number_format((float)$topPct,2) }}%)
          </div>
        @endif

        @if(!empty($summary))
          <div style="margin-top:10pt;">{{ $summary }}</div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-h">{{ $isAr ? 'المخططات' : 'Charts' }}</div>

      <table class="grid">
        <tr>
          <td>
            <div class="chart-wrap">
              <p class="chart-title">{{ $isAr ? 'Sensitivity (Impact %)' : 'Sensitivity (Impact %)' }}</p>
              <p class="chart-sub">{{ $isAr ? 'المدخلات الأكثر تأثيراً على الكلفة.' : 'Most impactful inputs on cost.' }}</p>
              @if(!empty($barImg))
                <img class="chart-img" src="{{ $barImg }}" alt="Bar Chart">
              @else
                <div class="muted">{{ $isAr ? 'لا يوجد مخطط.' : 'No chart available.' }}</div>
              @endif
            </div>
          </td>

          <td>
            <div class="chart-wrap">
              <p class="chart-title">{{ $isAr ? 'Gauge (A Index)' : 'Gauge (A Index)' }}</p>
              <p class="chart-sub">{{ $isAr ? 'A = الكلفة/المساحة ضمن رينجات.' : 'A = cost/area within ranges.' }}</p>
              @if(!empty($gaugeImg))
                <img class="chart-img" src="{{ $gaugeImg }}" alt="Gauge">
              @else
                <div class="muted">{{ $isAr ? 'لا يوجد مخطط.' : 'No chart available.' }}</div>
              @endif
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>

  {{-- ===================== Page 4: Reasons ===================== --}}
  <div class="page">
    <div class="card">
      <div class="card-h">{{ $isAr ? 'الأسباب' : 'Reasons' }}</div>

      @if(!empty($reasons))
        <ul class="bullets">
          @foreach($reasons as $r)
            <li>{{ $r }}</li>
          @endforeach
        </ul>
      @else
        <div class="muted">{{ $isAr ? 'لا توجد أسباب حالياً.' : 'No reasons available yet.' }}</div>
      @endif
    </div>
  </div>

  {{-- ===================== Page 5: Methodology ===================== --}}
  <div class="page last">
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
            <td>{{ $isAr ? 'تم حساب مؤشر A = الكلفة/المساحة وتصنيفه ضمن رينجات محددة.' : 'A = cost/area classified into predefined ranges.' }}</td>
          </tr>
          <tr>
            <td><b>Sensitivity</b></td>
            <td>{{ $isAr ? 'تم تحليل الحساسية عبر قياس أثر المدخلات كنسبة مئوية.' : 'Sensitivity measures each input impact percentage.' }}</td>
          </tr>
          <tr>
            <td><b>XAI</b></td>
            <td>{{ $isAr ? 'تم توليد تفسير نصي يربط أعلى المؤثرات بتصنيف الكلفة النهائي.' : 'Text explanation links top influencers to final cost class.' }}</td>
          </tr>
        </tbody>
      </table>

      
    </div>
  </div>

</body>
</html>
