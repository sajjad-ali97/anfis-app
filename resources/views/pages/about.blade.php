@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'حول المشروع' : 'About the Project')

@section('content')
@php
  $isAr = app()->getLocale() === 'ar';
@endphp

<section class="ui-section">
  <div class="ui-card p-6 sm:p-8">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">
      <div class="min-w-0">
        <h1 class="ui-h1">{{ $isAr ? 'حول المشروع (شرح علمي تفصيلي)' : 'About the Project (Detailed Scientific Documentation)' }}</h1>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'هذه الصفحة تُوثّق الفكرة العلمية للنظام وتحويله من MATLAB إلى نظام ويب، وتشرح بالتفصيل آلية عمل خدمات الحساب (ANFIS/XAI) مع المراجع.'
            : 'This page documents the scientific idea, the MATLAB-to-web conversion, and provides a detailed explanation of the computational services (ANFIS/XAI) with references.'
          }}
        </p>
      </div>

      <span class="ui-badge">{{ $isAr ? 'توثيق' : 'Documentation' }}</span>
    </div>

    <div class="ui-divider my-6"></div>

    {{-- ===== 0) Scientific Idea ===== --}}
    <div class="ui-surface p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '0) الفكرة العلمية للمشروع' : '0) Scientific Idea of the Project' }}</h2>
        <span class="ui-badge">ANFIS + XAI</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'يبني المشروع نظاماً لتقدير كلفة صيانة الطرق اعتماداً على نموذج ANFIS (Adaptive Neuro-Fuzzy Inference System) من نوع Sugeno FIS، ثم يضيف طبقة تفسير (XAI) لتوضيح “لماذا” أعطى النموذج هذه النتيجة، وليس فقط “كم” هي الكلفة.'
          : 'The project builds a road-maintenance cost estimation system using ANFIS (Adaptive Neuro-Fuzzy Inference System) based on a Sugeno FIS, then adds an explainability (XAI) layer to clarify “why” the model produced a given cost—not only “what” the cost is.'
        }}
      </p>

      <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="ui-row">
          <span class="ui-label">{{ $isAr ? 'المخرجات' : 'Outputs' }}</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
            {{ $isAr
              ? 'الكلفة (IQD) + تصنيف Gauge + Bar Chart + تفسير نصّي'
              : 'Cost (IQD) + Gauge class + Bar Chart + Text Explanation'
            }}
          </span>
        </div>

        <div class="ui-row">
          <span class="ui-label">{{ $isAr ? 'الهدف البحثي' : 'Research goal' }}</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white text-right">
            {{ $isAr
              ? 'توثيق تحويل نموذج MATLAB إلى نظام ويب قابل للاستخدام'
              : 'Document the conversion of a MATLAB model into a usable web system'
            }}
          </span>
        </div>
      </div>

      <p class="ui-p mt-4">
        {{ $isAr
          ? 'نموذج ANFIS قُدّم أساساً بواسطة Jang (1993) كنظام يدمج الشبكات العصبية مع منطق ضبابي (FIS) باستخدام تعلم هجين (Hybrid Learning) لبناء mapping بين المدخلات والمخرجات انطلاقاً من بيانات تدريب وقواعد if-then. أمّا Sugeno FIS فهو مناسب للنمذجة لأنه ينتج مخرجات على شكل دوال (غالباً خطية) في consequents مما يدعم interpolation داخل فضاء المدخلات.'
          : 'ANFIS was introduced by Jang (1993) as a framework that combines neural networks with fuzzy inference (FIS) using a hybrid learning procedure to construct an input-output mapping from data and if-then rules. Sugeno FIS is well-suited for modeling because it uses functional (often linear) consequents, supporting interpolation in the input space.'
        }}
      </p>

      <div class="mt-4 ui-surface p-4">
        <div class="ui-label">{{ $isAr ? 'مراجع أساسية' : 'Key references' }}</div>
        <ul class="mt-2 space-y-2 ui-p">
          <li>
            • {{ $isAr ? 'ورقة ANFIS الأصلية (Jang 1993).' : 'Original ANFIS paper (Jang, 1993).' }}
            <span class="ui-muted">
              —
              <a class="underline" href="https://www.dca.ufrn.br/~meneghet/FTP/anfis%2093.pdf" target="_blank" rel="noopener">PDF</a>
            </span>
          </li>
          <li>
            • {{ $isAr ? 'توثيق Sugeno FIS في MathWorks.' : 'MathWorks Sugeno FIS documentation.' }}
            <span class="ui-muted">
              —
              <a class="underline" href="https://www.mathworks.com/help/fuzzy/sugfis.html" target="_blank" rel="noopener">MathWorks</a>
            </span>
          </li>
        </ul>
      </div>
    </div>

    {{-- ===== 1) HTS Service ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '1) شرح HTS Service بالتفصيل' : '1) Detailed Explanation of HTS Service' }}</h2>
        <span class="ui-badge">HTS</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'في هذا المشروع، HTS ليس اسماً لمعيار عالمي جاهز، بل هو “Proxy” هندسي (مؤشر بديل) لشدة الظروف الحرارية عبر الزمن. الفكرة: نجمع عدد الأيام شديدة الحرارة (فوق 40°C) خلال نافذة زمنية تمثل عمر الرصف قبل تاريخ الصيانة. كلما زاد التعرض الحراري عبر السنوات، زادت احتمالية تدهور خصائص الأسفلت (مثل التخدد rutting والتشوه).'
          : 'In this project, HTS is not a universal standard name; it is an engineering proxy (severity index). The idea is to aggregate the number of extremely hot days (above 40°C) over a time window representing pavement age prior to the maintenance date. Higher long-term thermal exposure increases the likelihood of asphalt distress (e.g., rutting and deformation).'
        }}
      </p>

      <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="ui-surface p-5">
          <div class="ui-label">{{ $isAr ? 'تعريف المدخلات والمنطق' : 'Inputs and logic' }}</div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'pavementAgeCode: كود عمر الرصف (1/2/3).' : 'pavementAgeCode: pavement age code (1/2/3).' }}</li>
            <li>• {{ $isAr ? 'maintenanceDate: تاريخ الصيانة (نستخرج منه سنة الصيانة).' : 'maintenanceDate: maintenance date (extract maintenance year).' }}</li>
            <li>• {{ $isAr ? 'HeatDay table: مخزن سنوي days_above_40.' : 'HeatDay table: yearly stored days_above_40.' }}</li>
          </ul>
        </div>

        <div class="ui-surface p-5">
          <div class="ui-label">{{ $isAr ? 'Mapping لعمر الرصف' : 'Pavement age mapping' }}</div>
          <div class="mt-3 space-y-2">
            <div class="ui-row">
              <span class="ui-label">{{ $isAr ? 'كود 1' : 'Code 1' }}</span>
              <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $isAr ? '6 سنوات' : '6 years' }}</span>
            </div>
            <div class="ui-row">
              <span class="ui-label">{{ $isAr ? 'كود 2' : 'Code 2' }}</span>
              <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $isAr ? '12 سنة' : '12 years' }}</span>
            </div>
            <div class="ui-row">
              <span class="ui-label">{{ $isAr ? 'كود 3' : 'Code 3' }}</span>
              <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $isAr ? '18 سنة' : '18 years' }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'المعادلة المطابقة للكود' : 'Equation matching the code' }}</div>

        <p class="ui-p mt-2">
          {{ $isAr
            ? 'نحسب سنة البداية startYear ثم نجمع days_above_40 من (startYear + 1) إلى maintenanceYear:'
            : 'We compute startYear and then sum days_above_40 from (startYear + 1) to maintenanceYear:'
          }}
        </p>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
startYear = maintenanceYear - yearsSpan

HTS = Σ_{y = startYear + 1 إلى maintenanceYear}  days_above_40(y)
        </pre>

        <p class="ui-p mt-3">
          {{ $isAr
            ? 'هذا يعادل منطق Laravel: whereBetween(year, [startYear+1, maintenanceYear]) ثم sum(days_above_40).'
            : 'This matches the Laravel logic: whereBetween(year, [startYear+1, maintenanceYear]) then sum(days_above_40).'
          }}
        </p>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'لماذا اخترنا 40°C؟ (مبرر علمي)' : 'Why 40°C? (Scientific justification)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'لأن مصادر بحثية تشير إلى أنه عند تجاوز الحرارة المحيطة 40°C قد تصل حرارة سطح الرصف إلى نطاق 65–75°C، وهذا يرفع مخاطر التخدد (rutting) والتشوه وانخفاض قدرة التحمل. لذلك “عدد الأيام فوق 40” يعد مؤشراً مبسطاً لكن ذا معنى لشدة التعرض الحراري عبر الزمن، خصوصاً لمناخ العراق/كربلاء.'
            : 'Because research reports that when ambient temperature exceeds 40°C, pavement surface temperature can reach ~65–75°C, significantly increasing the risk of rutting, deformation, and reduced load-bearing capacity. Therefore, counting “days above 40°C” becomes a meaningful simplified proxy for long-term thermal exposure—especially for Iraq/Karbala climate.'
          }}
        </p>

        <ul class="mt-3 space-y-2 ui-p">
          <li>
            • {{ $isAr ? 'مرجع يذكر نطاق 65–75°C عند >40°C ambient وارتباطه بالـ rutting.' : 'Source mentioning 65–75°C surface range when ambient >40°C and rutting risk.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.mdpi.com/1996-1944/18/20/4708" target="_blank" rel="noopener">MDPI (2025)</a>
            </span>
          </li>
          <li>
            • {{ $isAr ? 'وصف evalfis/منطق تقييم FIS (يهمنا لأن HTS يدخل لاحقاً للـ ANFIS).' : 'evalfis and FIS evaluation concept (HTS later becomes an ANFIS input).' }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.mathworks.com/help/fuzzy/mamfis.evalfis.html" target="_blank" rel="noopener">MathWorks evalfis</a>
            </span>
          </li>
        </ul>

        <p class="ui-help mt-3">
          {{ $isAr
            ? 'تنويه بحثي: HTS هنا Proxy مدروس وليس “اسم معيار عالمي”. الهدف: تمثيل شدة المناخ بحرارة/زمن بشكل رقمي قابل للإدخال للنموذج.'
            : 'Research note: HTS here is a designed proxy rather than a universal standard name. The goal is to represent climate severity (heat/time) numerically for the model.'
          }}
        </p>
      </div>
    </div>

    {{-- ===== 2) ANFIS Service ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '2) شرح AnfisService (حساب الكلفة) بالتفصيل العلمي' : '2) Detailed Scientific Explanation of AnfisService (Cost)' }}</h2>
        <span class="ui-badge">ANFIS</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'هذه الخدمة هي قلب المشروع: تنفّذ نفس pipeline الذي كان موجوداً في MATLAB. الفكرة الأساسية: (1) نُجري تحويلات على المدخلات (Log + Normalization) لتصبح مناسبة للنموذج، (2) نقيّم نظام Sugeno FIS (evalfis concept) لإنتاج yNorm، (3) نرجع yNorm إلى نطاقه الأصلي (Reverse normalization) ثم نُطبّق inverse log لإخراج الكلفة بالدينار.'
          : 'This service is the core of the project: it replicates the original MATLAB pipeline. In essence: (1) apply input transforms (Log + normalization), (2) evaluate a Sugeno FIS (evalfis concept) to obtain yNorm, (3) reverse normalization to restore the output scale, then apply inverse log to return the final cost in IQD.'
        }}
      </p>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '2.1) Log Transform: log10(x + 1)' : '2.1) Log Transform: log10(x + 1)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'نستخدم log10(x + 1) لتقليل تشتت القيم الكبيرة وتقريب التوزيع (تقليل skew) ولتحسين الاستقرار العددي قبل التطبيع والتقييم داخل النموذج. هذا شائع عندما تكون قيم المدخلات واسعة المدى.'
            : 'We use log10(x + 1) to compress large ranges, reduce skewness, and improve numerical stability before normalization and evaluation—common when inputs span wide numeric ranges.'
          }}
        </p>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
x_log = log10(x + 1)
        </pre>

        <p class="ui-help mt-3">
          {{ $isAr
            ? 'ملاحظة تنفيذية: الدالة log10_safe تحمي من قيم سالبة غير متوقعة حتى لا يتعطل التنفيذ.'
            : 'Implementation note: log10_safe protects against unexpected non-positive values to avoid runtime failures.'
          }}
        </p>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '2.2) Normalization: mapminmax (Apply) باستخدام PS_in' : '2.2) Normalization: mapminmax (Apply) using PS_in' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'بعد log، نطبّق تطبيعاً مطابقاً لإعدادات MATLAB (PS_in). في MATLAB، mapminmax يستطيع أن يعيد Process Settings (PS) ويُعاد استخدام نفس PS لاحقاً لتطبيع بيانات جديدة بنفس الطريقة، وهذا يضمن أن بيئة PHP تطبّق نفس التحويلات تماماً.'
            : 'After log transform, we apply the same MATLAB normalization using PS_in. In MATLAB, mapminmax can return process settings (PS) which can be reused to transform new data identically—ensuring the PHP implementation matches MATLAB exactly.'
          }}
        </p>

        <ul class="mt-3 space-y-2 ui-p">
          <li>• {{ $isAr ? 'PS_in.gain / xoffset / ymin / yrange تُستخدم لتحويل كل عنصر إلى النطاق المُستهدف.' : 'PS_in.gain / xoffset / ymin / yrange are used to map each feature to the target range.' }}</li>
          <li>• {{ $isAr ? 'أنت خزّنت هذه القيم في config(anfis.ps_in.*) لضمان الثبات.' : 'You stored these values in config(anfis.ps_in.*) for reproducibility.' }}</li>
        </ul>

        <div class="mt-4 ui-surface p-4">
          <div class="ui-label">{{ $isAr ? 'مرجع' : 'Reference' }}</div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'توثيق mapminmax في MathWorks يوضح فكرة تطبيع البيانات وإرجاع إعدادات PS لإعادة الاستخدام.'
              : 'MathWorks mapminmax documentation explains normalization and returning PS settings for reuse.'
            }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.mathworks.com/help/deeplearning/ref/mapminmax.html" target="_blank" rel="noopener">MathWorks mapminmax</a>
            </span>
          </p>
        </div>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '2.3) Sugeno FIS Evaluation (evalfis concept)' : '2.3) Sugeno FIS Evaluation (evalfis concept)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'هنا يتم تقييم نظام Sugeno FIS: تُحسب درجات الانتماء (membership) لكل قاعدة، ثم firing strengths (قوة تفعيل القواعد) وفق عامل AND (مثل prod)، ثم تُحسب مخرجات consequents (غالباً خطية)، وبعدها تُجمع بطريقة Sugeno لإنتاج yNorm. هذا مكافئ لمفهوم evalfis في MATLAB.'
            : 'Here we evaluate the Sugeno FIS: compute membership degrees per rule, compute rule firing strengths using an AND operator (e.g., product), compute consequent outputs (often linear), then aggregate in a Sugeno manner to produce yNorm—conceptually matching MATLAB evalfis.'
          }}
        </p>

        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
          <div class="ui-row">
            <span class="ui-label">{{ $isAr ? 'نوع النظام' : 'FIS type' }}</span>
            <span class="text-sm font-semibold text-gray-900 dark:text-white">Sugeno (Type-1)</span>
          </div>
          <div class="ui-row">
            <span class="ui-label">{{ $isAr ? 'المنطق' : 'Concept' }}</span>
            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $isAr ? 'evalfis' : 'evalfis' }}</span>
          </div>
        </div>

        <ul class="mt-3 space-y-2 ui-p">
          <li>
            • {{ $isAr ? 'توثيق Sugeno FIS.' : 'Sugeno FIS documentation.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.mathworks.com/help/fuzzy/sugfis.html" target="_blank" rel="noopener">MathWorks sugfis</a>
            </span>
          </li>
          <li>
            • {{ $isAr ? 'توثيق evalfis (تقييم FIS وإرجاع نتائج) - نستخدمه كمفهوم مرجعي.' : 'evalfis documentation (FIS evaluation) as a reference concept.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.mathworks.com/help/fuzzy/mamfis.evalfis.html" target="_blank" rel="noopener">MathWorks evalfis</a>
            </span>
          </li>
        </ul>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '2.4) Reverse Output Normalization + Inverse Log' : '2.4) Reverse Output Normalization + Inverse Log' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'بعد yNorm، نرجع الخرج إلى نطاقه الحقيقي باستخدام PS_out (Reverse mapminmax)، فينتج outLog. ثم نطبّق inverse log للحصول على الكلفة النهائية:'
            : 'After yNorm, we restore the original output scale using PS_out (reverse mapminmax) to get outLog. Then apply inverse log to obtain final cost:'
          }}
        </p>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
outLog = reverse_mapminmax(yNorm, PS_out)

cost = (10 ^ outLog) - 1
        </pre>

        <p class="ui-p mt-3">
          {{ $isAr
            ? 'بهذا أنت فعلياً أنجزت: Log → mapminmax → Sugeno eval → reverse mapminmax → inverse log، وهي سلسلة مطابقة للـ MATLAB.'
            : 'Thus you implemented: Log → mapminmax → Sugeno eval → reverse mapminmax → inverse log, mirroring MATLAB.'
          }}
        </p>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '2.5) لماذا هذا مهم بحثياً؟ (مبدأ التكرارية Reproducibility)' : '2.5) Why this matters (Reproducibility)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'القيمة البحثية هنا أنك لم “تعِد تدريب” النموذج في الويب، بل نقلت (conversion) نموذجاً مدرباً من MATLAB إلى PHP، مع الحفاظ على نفس التحويلات والمعلمات (fis + PS settings). هذا يجعل المقارنة MATLAB vs PHP ممكنة بدقة.'
            : 'Research value: you did not retrain the model on the web; you converted a trained MATLAB model into PHP while preserving the same transforms and parameters (fis + PS settings). This enables an accurate MATLAB vs PHP comparison.'
          }}
        </p>

        <div class="mt-3 ui-surface p-4">
          <div class="ui-label">{{ $isAr ? 'مرجع أساس: ANFIS' : 'Core reference: ANFIS' }}</div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'Jang (1993) يشرح معمارية ANFIS والتعلم الهجين وبناء mapping من بيانات التدريب.'
              : 'Jang (1993) describes ANFIS architecture, hybrid learning, and mapping construction from training data.'
            }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.dca.ufrn.br/~meneghet/FTP/anfis%2093.pdf" target="_blank" rel="noopener">Jang 1993 PDF</a>
            </span>
          </p>
        </div>
      </div>
    </div>

    {{-- ===== 3) Gauge ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '3) شرح CostGaugeService بالتفصيل العلمي' : '3) Detailed Scientific Explanation of CostGaugeService' }}</h2>
        <span class="ui-badge">Gauge</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'بعد الحصول على الكلفة الكلية (Total Cost)، نحتاج إلى تصنيفها بطريقة عادلة قابلة للمقارنة بين مشاريع مختلفة المساحات. لذلك استخدمنا مؤشر A = Cost per m² (كلفة لكل متر مربع). هذا أسلوب شائع كـ normalization أو parametric indicator حتى تكون المقارنات معقولة.'
          : 'After obtaining the total cost, we need a fair classification that remains comparable across projects with different areas. Therefore, we use an index A = cost per square meter (IQD/m²). This is a common normalization/parametric indicator for meaningful comparison.'
        }}
      </p>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'المعادلة الأساسية' : 'Core formula' }}</div>
        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
A = TotalCost / Area   (IQD per m²)
        </pre>
        <p class="ui-p mt-3">
          {{ $isAr
            ? 'الخدمة تتحقق أولاً أن المساحة > 0 ثم تحسب A وتطابقها مع ranges موجودة في config(cost_gauge.ranges).'
            : 'The service first validates Area > 0, computes A, then matches it against configured ranges in config(cost_gauge.ranges).'
          }}
        </p>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'منطق التصنيف (Ranges)' : 'Classification logic (Ranges)' }}</div>
        <ul class="mt-2 space-y-2 ui-p">
          <li>• {{ $isAr ? 'إذا A ضمن [min, max) نختار هذا الرينج.' : 'If A is within [min, max), select that range.' }}</li>
          <li>• {{ $isAr ? 'إذا A أقل من أول رينج → أول رينج.' : 'If A is below the first range → use the first range.' }}</li>
          <li>• {{ $isAr ? 'إذا A أعلى من آخر رينج → آخر رينج.' : 'If A exceeds the last range → use the last range.' }}</li>
          <li>• {{ $isAr ? 'النتيجة ترجع label_key + label + range_used + كل ranges حتى ترسم Gauge.' : 'Result returns label_key + label + range_used + full ranges for gauge rendering.' }}</li>
        </ul>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'مرجع للفكرة (Cost per m²)' : 'Reference (Cost per m² concept)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'مفهوم كلفة لكل متر مربع/وحدة مساحة يستخدم في تقديرات البناء/المشاريع كمعيار parametric للتطبيع والمقارنة.'
            : 'Cost per unit area is commonly used in cost estimation as a parametric normalization metric for comparison.'
          }}
          <span class="ui-muted">—
            <a class="underline" href="https://chop.raic.ca/chapter-4.2" target="_blank" rel="noopener">RAIC CHOP (Cost Planning)</a>
          </span>
        </p>
      </div>
    </div>

    {{-- ===== 4) Sensitivity ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '4) شرح SensitivityService بالتفصيل (OAT + Perturbation)' : '4) Detailed Explanation of SensitivityService (OAT + Perturbation)' }}</h2>
        <span class="ui-badge">XAI</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'هذه الخدمة تُخرج “نسبة تأثير” لكل من 7 مدخلات (مختارة من أصل 13). المنهج المتّبع هو One-At-a-Time (OAT): نغيّر عامل واحد فقط كل مرة ونراقب تغيّر خرج النموذج. هذه طريقة حساسية محلية (local) وبسيطة وواضحة للمستخدم.'
          : 'This service produces an “impact percentage” for 7 selected inputs (out of 13). The method is One-At-a-Time (OAT): change one factor at a time and observe the output change. This is a simple, local, user-friendly sensitivity approach.'
        }}
      </p>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'الخطوات الحسابية كما في الكود' : 'Step-by-step computation (as implemented)' }}</div>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
1) Base cost:
   C0 = f(x)

2) For each feature i:
   - If continuous: test (xi - 10%) and (xi + 10%)
   - If categorical: test all allowed values (except current)

3) Max absolute impact:
   Δi = max | f(x_test) - C0 |

4) Impact percentage:
   Impact%i = (Δi / C0) * 100

5) Sort descending -> bar chart + top influencers
        </pre>

        <p class="ui-p mt-3">
          {{ $isAr
            ? 'بالنهاية نرتّب النتائج تنازلياً حسب impact_percent ونأخذ أعلى top_n حتى ندعم تفسير ExplanationService.'
            : 'Finally, results are sorted by impact_percent (DESC). The top_n influencers are used to support the ExplanationService.'
          }}
        </p>
      </div>

      <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="ui-surface p-5">
          <div class="ui-label">{{ $isAr ? 'لماذا OAT عملياً؟' : 'Why OAT in practice?' }}</div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'واضح للمستخدم النهائي: “غيّرت هذا العامل فقط فصار الفرق كذا”.' : 'Clear to end users: “only this factor changed, and the output shifted by X”.' }}</li>
            <li>• {{ $isAr ? 'سريع وقابل للتطبيق بدون تدريب جديد.' : 'Fast and applicable without retraining.' }}</li>
            <li>• {{ $isAr ? 'مناسب كتفسير محلي Instance-based (لكل مشروع).' : 'Suitable as a local (instance-based) explanation per project.' }}</li>
          </ul>
        </div>

        <div class="ui-surface p-5">
          <div class="ui-label">{{ $isAr ? 'حدود الطريقة (Limitations)' : 'Limitations' }}</div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'قد لا تلتقط تداخلات العوامل (feature interactions) لأننا نغيّر عامل واحد فقط.' : 'May miss feature interactions because only one factor changes at a time.' }}</li>
            <li>• {{ $isAr ? 'تعتمد على حجم perturbation (مثلاً ±10%).' : 'Depends on the perturbation size (e.g., ±10%).' }}</li>
          </ul>

          <p class="ui-help mt-3">
            {{ $isAr
              ? 'هذه الحدود معروفة علمياً في تحليل الحساسية، لكنها تبقى مقبولة جداً للشرح والتفسير المحلي داخل نظام ويب.'
              : 'These limitations are well-known in sensitivity analysis, yet the method remains highly practical for local explainability in a web system.'
            }}
          </p>
        </div>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'مراجع علمية للفكرة' : 'Scientific references' }}</div>
        <ul class="mt-2 space-y-2 ui-p">
          <li>
            • {{ $isAr ? 'مفهوم OAT و“perturbations typically occur one at a time”.' : 'OAT concept and “perturbations typically occur one at a time”.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://www.sciencedirect.com/science/article/pii/S1364815220310112" target="_blank" rel="noopener">Razavi et al., 2021 (ScienceDirect)</a>
            </span>
          </li>
          <li>
            • {{ $isAr ? 'وصف حساسية “each input feature is perturbed one-at-a-time”.' : 'Statement: “each input feature is perturbed one-at-a-time”.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://link.springer.com/article/10.1186/s40537-021-00515-w" target="_blank" rel="noopener">Naik et al., 2021 (Springer)</a>
            </span>
          </li>
          <li>
            • {{ $isAr ? 'طرق XAI model-agnostic المعتمدة على perturbation ومراقبة تغير التنبؤ.' : 'Model-agnostic XAI methods based on perturbation and observing prediction changes.' }}
            <span class="ui-muted">—
              <a class="underline" href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10187774/" target="_blank" rel="noopener">Wikle et al., 2022 (PMC)</a>
            </span>
          </li>
        </ul>
      </div>
    </div>

    {{-- ===== 5) Explanation (NLG) ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? '5) شرح ExplanationService بالتفصيل (Rule/Template-based NLG)' : '5) Detailed Explanation of ExplanationService (Rule/Template-based NLG)' }}</h2>
        <span class="ui-badge">NLG</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'هذه الخدمة هي طبقة “اللغة” فوق الأرقام: تحوّل نتائج الحساب إلى تفسير مفهوم ومهني. علمياً هذا يسمى Data-to-Text / Natural Language Generation (NLG). طريقتك هنا Rule/Template-based: تستخدم قوالب جاهزة + قواعد اختيار الأسباب حسب أعلى المؤثرات.'
          : 'This service is the language layer over numbers: it converts computed results into a professional explanation. Scientifically, this is Data-to-Text / Natural Language Generation (NLG). Your approach is rule/template-based: it uses fixed templates plus rule-based selection of reasons from top influencers.'
        }}
      </p>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '5.1) المدخلات التي تعتمد عليها الخدمة' : '5.1) Inputs consumed by the service' }}</div>
        <ul class="mt-2 space-y-2 ui-p">
          <li>• {{ $isAr ? 'Gauge: التصنيف + قيمة A (كلفة/م²).' : 'Gauge: classification + A index (cost/m²).' }}</li>
          <li>• {{ $isAr ? 'Sensitivity: top_influencers + debug_payload (اتجاه التأثير، delta...).' : 'Sensitivity: top_influencers + debug_payload (direction, delta, ...).' }}</li>
          <li>• {{ $isAr ? 'inputsAssoc: القيم الحالية للمدخلات حتى نشرح “الحالة الحالية”.' : 'inputsAssoc: current input values to describe the current state.' }}</li>
        </ul>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '5.2) قواعد اختيار الأسباب (Reason Selection Rules)' : '5.2) Reason selection rules' }}</div>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
- min_influence_pct: أقل نسبة تأثير لقبول السبب
- max_reasons: الحد الأعلى لعدد الأسباب
- نمر على top_influencers:
    إذا pct >= minPct -> نولد سبب (AR + EN)
- إذا ماكو أسباب قوية -> fallback sentence
        </pre>

        <p class="ui-p mt-3">
          {{ $isAr
            ? 'الخدمة أيضاً تُحدد اتجاه التأثير (increase/decrease/neutral) بالاعتماد على delta = cost_after_change - base_cost، وتستخدم ذلك لصياغة جملة هندسية توضح هل القيمة الحالية أقل/أعلى كلفة من بدائلها ضمن نطاق الاختبار.'
            : 'The service also determines direction (increase/decrease/neutral) using delta = cost_after_change - base_cost, then uses that to craft an engineering sentence explaining whether the current value is cheaper or costlier than alternatives within the tested range.'
          }}
        </p>
      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? '5.3) لماذا Template-based NLG اختيار منطقي؟' : '5.3) Why template-based NLG is a good choice' }}</div>
        <ul class="mt-2 space-y-2 ui-p">
          <li>• {{ $isAr ? 'ثبات الصياغة الرسمية (مناسب للأكاديميا والتقارير).' : 'Consistent formal tone (good for academic reporting).' }}</li>
          <li>• {{ $isAr ? 'قابل للتدقيق: نعرف بالضبط من أين جاءت كل جملة (debug payload).' : 'Auditable: each sentence maps to specific data (debug payload).' }}</li>
          <li>• {{ $isAr ? 'قابل للصيانة: تغيير قالب أو قاعدة أسهل من تدريب نموذج لغوي.' : 'Maintainable: changing templates/rules is easier than training an NLG model.' }}</li>
          <li>• {{ $isAr ? 'يدعم لغتين بسهولة (AR/EN).' : 'Supports bilingual output easily (AR/EN).' }}</li>
        </ul>

        <div class="mt-4 ui-surface p-4">
          <div class="ui-label">{{ $isAr ? 'مراجع NLG' : 'NLG references' }}</div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>
              • {{ $isAr ? 'تعريف NLG (تحويل بيانات إلى نص).' : 'NLG definition (data-to-text generation).' }}
              <span class="ui-muted">—
                <a class="underline" href="https://www.ibm.com/think/topics/natural-language-generation" target="_blank" rel="noopener">IBM (NLG)</a>
              </span>
            </li>
            <li>
              • {{ $isAr ? 'ورقة عن Template-Based NLG وتطبيقه.' : 'Template-based NLG paper.' }}
              <span class="ui-muted">—
                <a class="underline" href="https://www.iaeng.org/IJCS/issues_v48/issue_1/IJCS_48_1_07.pdf" target="_blank" rel="noopener">IAENG PDF</a>
              </span>
            </li>
            <li>
              • {{ $isAr ? 'نقاش علمي حول قيمة Template-based NLG (ليس بالضرورة أدنى).' : 'Scientific discussion: template-based NLG is not necessarily inferior.' }}
              <span class="ui-muted">—
                <a class="underline" href="https://theune.personalweb.utwente.nl/PUBS/templates-squib.pdf" target="_blank" rel="noopener">van Deemter et al. PDF</a>
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- ===== Implementation & System Conversion ===== --}}
    <div class="mt-6 ui-card p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? 'Implementation & System Conversion (فصل التحويل من MATLAB إلى Web)' : 'Implementation & System Conversion (MATLAB → Web Chapter)' }}</h2>
        <span class="ui-badge">{{ $isAr ? 'فصل بحثي' : 'Research Chapter' }}</span>
      </div>

      <p class="ui-p mt-3">
        {{ $isAr
          ? 'هذا القسم يطبّق اقتراحاتك السابقة: ترتيب “فصل كامل” يوثق التحويل. النص هنا داخل الصفحة بشكل ستاتك، ويمكنك لاحقاً نسخه كما هو إلى تقرير الـ PDF أو الرسالة.'
          : 'This section implements your earlier suggestions: a full chapter-like structure documenting the conversion. The text is static in-page and can later be copied into the final thesis/PDF.'
        }}
      </p>

      <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- A) Architecture --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'A) معمارية النظام (Architecture)' : 'A) System Architecture' }}
          </div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'UI Layer: صفحات إدخال/نتائج/تقارير + مخططات Plotly.' : 'UI layer: input/results/reports pages + Plotly charts.' }}</li>
            <li>• {{ $isAr ? 'Service Layer: HtsService, AnfisService, CostGaugeService, SensitivityService, ExplanationService.' : 'Service layer: HtsService, AnfisService, CostGaugeService, SensitivityService, ExplanationService.' }}</li>
            <li>• {{ $isAr ? 'Data Layer: Projects/Calculations + HeatDay (HTS) + configs للـ PS settings.' : 'Data layer: Projects/Calculations + HeatDay (HTS) + configs for PS settings.' }}</li>
            <li>• {{ $isAr ? 'Report Layer: توليد PDF (ملخص + أسباب + مخططات).' : 'Report layer: PDF generation (summary + reasons + charts).' }}</li>
          </ul>
        </div>

        {{-- B) Data Flow --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'B) مخطط تدفق البيانات (Data Flow)' : 'B) Data Flow Diagram' }}
          </div>

          <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
User Inputs
   ↓
(1) HTS  ← HeatDay(year → days_above_40)
   ↓
Build ordered13 (V1..V13)
   ↓
(2) ANFIS predictCost → TotalCost
   ↓
(3) Gauge A = TotalCost/Area → label/range
   ↓
(4) Sensitivity OAT → impact% + top influencers
   ↓
(5) Explanation NLG → summary + reasons
   ↓
UI Charts + PDF Report
          </pre>
        </div>

        {{-- C) Training Metrics --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'C) Training Metrics (ضمن MATLAB)' : 'C) Training Metrics (in MATLAB)' }}
          </div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'هنا توثّق ما تم في MATLAB أثناء التدريب: نوع البيانات، عدد العينات، تقسيم Train/Validation، واختيار membership functions، وعدد القواعد، وخطأ التدريب (MSE/RMSE) على التدريب.'
              : 'Here you document the MATLAB training: dataset, sample count, train/validation split, membership function choices, rule count, and training error (MSE/RMSE).'
            }}
          </p>
          <p class="ui-help mt-3">
            {{ $isAr
              ? 'ملاحظة: تدريب ANFIS يتم وفق ما يشرحه Jang 1993 (Hybrid learning).'
              : 'Note: ANFIS training follows the hybrid learning described in Jang 1993.'
            }}
          </p>
        </div>

        {{-- D) Testing Metrics --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'D) Testing Metrics (MATLAB vs PHP)' : 'D) Testing Metrics (MATLAB vs PHP)' }}
          </div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'نفس 13 مدخل تُمرّر إلى MATLAB وPHP.' : 'Same 13 inputs fed to MATLAB and PHP.' }}</li>
            <li>• {{ $isAr ? 'مقارنة output النهائي (Cost) بعد inverse log.' : 'Compare final cost after inverse log.' }}</li>
            <li>• {{ $isAr ? 'حساب فرق مطلق/نسبي: |PHP − MATLAB| و %Error.' : 'Compute absolute/relative error: |PHP − MATLAB| and %Error.' }}</li>
          </ul>
        </div>

        {{-- E) HTS Validation --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'E) HTS Validation' : 'E) HTS Validation' }}
          </div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'توثيق صحة HTS يكون بإظهار: (1) مثال تاريخ صيانة، (2) startYear حسب الكود، (3) السنوات المشمولة، (4) مجموع days_above_40، مع لقطة من جدول HeatDay أو query output.'
              : 'HTS validation can be documented by showing: (1) a maintenance date example, (2) computed startYear per code, (3) included years, (4) the sum of days_above_40, with a screenshot from HeatDay table or query output.'
            }}
          </p>
        </div>

        {{-- F) Console Outputs --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'F) Console Outputs Screenshots' : 'F) Console Outputs Screenshots' }}
          </div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'ضمن التقرير، ضع Screenshots لأوامر CLI التي نفذتها لاختبار الخدمات (مثل anfis:test-gauge وغيرها) وبيّن أن النتائج ثابتة مع نفس المدخلات.'
              : 'In the report, include screenshots of CLI commands used to test services (e.g., anfis:test-gauge) and show stable results for the same inputs.'
            }}
          </p>
        </div>

        {{-- G) Gauge Logic --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'G) شرح Cost Gauge Logic' : 'G) Cost Gauge Logic' }}
          </div>
          <p class="ui-p mt-2">
            {{ $isAr
              ? 'أثبت أن التصنيف يعتمد على A (Cost/m²) وليس فقط TotalCost، واذكر رينجات الكونفگ ولماذا تم اختيارها (حسب سياق الدراسة/المشروع).'
              : 'Explain that classification is based on A (cost/m²), not only TotalCost. Include configured ranges and justify them based on study context.'
            }}
          </p>
        </div>

        {{-- H) MATLAB vs PHP Comparison --}}
        <div class="ui-surface p-5">
          <div class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $isAr ? 'H) مقارنة MATLAB vs PHP خطوة بخطوة' : 'H) MATLAB vs PHP Step-by-step Comparison' }}
          </div>
          <ul class="mt-2 space-y-2 ui-p">
            <li>• {{ $isAr ? 'Log: نفس المعادلة log10(x+1).' : 'Log: same equation log10(x+1).' }}</li>
            <li>• {{ $isAr ? 'PS_in: نفس gain/xoffset/ymin/yrange.' : 'PS_in: same gain/xoffset/ymin/yrange.' }}</li>
            <li>• {{ $isAr ? 'fis: نفس ملف الـ .fis (Sugeno rules).' : 'fis: same .fis file (Sugeno rules).' }}</li>
            <li>• {{ $isAr ? 'PS_out: نفس reverse normalization.' : 'PS_out: same reverse normalization.' }}</li>
            <li>• {{ $isAr ? 'Inverse log: (10^outLog) - 1.' : 'Inverse log: (10^outLog) - 1.' }}</li>
          </ul>
        </div>

      </div>

      <div class="mt-4 ui-surface p-5">
        <div class="ui-label">{{ $isAr ? 'مراجع عامة للتحويل/النشر كويب' : 'General references for “MATLAB → Web” concepts' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'هذه المراجع ليست “تحويلك أنت”، لكنها أمثلة رسمية على مفهوم نشر/استضافة تطبيقات MATLAB كويب، وتفيد كفكرة عامة في فصل التحويل.'
            : 'These references are not your specific conversion, but official examples of MATLAB web app hosting/concepts that can support the “conversion chapter” context.'
          }}
          <span class="ui-muted">—
            <a class="underline" href="https://www.mathworks.com/help/webappserver/index.html" target="_blank" rel="noopener">MathWorks Web App Server</a>
          </span>
        </p>
      </div>
    </div>

    {{-- ===== References (full list) ===== --}}
    <div class="mt-6 ui-surface p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="ui-h2">{{ $isAr ? 'المصادر (References)' : 'References' }}</h2>
        <span class="ui-badge">{{ $isAr ? 'روابط' : 'Links' }}</span>
      </div>

      <p class="ui-p mt-2">
        {{ $isAr
          ? 'كل الروابط التالية استخدمت لتدعيم الشرح العلمي داخل هذه الصفحة.'
          : 'The following links support the scientific statements in this page.'
        }}
      </p>

      <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.dca.ufrn.br/~meneghet/FTP/anfis%2093.pdf" target="_blank" rel="noopener">
          <span class="ui-label">ANFIS (Jang 1993)</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">PDF</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.mathworks.com/help/fuzzy/sugfis.html" target="_blank" rel="noopener">
          <span class="ui-label">Sugeno FIS</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">MathWorks</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.mathworks.com/help/fuzzy/mamfis.evalfis.html" target="_blank" rel="noopener">
          <span class="ui-label">evalfis</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">MathWorks</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.mathworks.com/help/deeplearning/ref/mapminmax.html" target="_blank" rel="noopener">
          <span class="ui-label">mapminmax</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">MathWorks</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.mdpi.com/1996-1944/18/20/4708" target="_blank" rel="noopener">
          <span class="ui-label">Pavement temp & rutting</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">MDPI</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.sciencedirect.com/science/article/pii/S1364815220310112" target="_blank" rel="noopener">
          <span class="ui-label">Sensitivity (OAT)</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">ScienceDirect</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://link.springer.com/article/10.1186/s40537-021-00515-w" target="_blank" rel="noopener">
          <span class="ui-label">OAT feature perturbation</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">Springer</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10187774/" target="_blank" rel="noopener">
          <span class="ui-label">Model-agnostic XAI</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">PMC</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.ibm.com/think/topics/natural-language-generation" target="_blank" rel="noopener">
          <span class="ui-label">NLG definition</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">IBM</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.iaeng.org/IJCS/issues_v48/issue_1/IJCS_48_1_07.pdf" target="_blank" rel="noopener">
          <span class="ui-label">Template-based NLG</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">PDF</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://theune.personalweb.utwente.nl/PUBS/templates-squib.pdf" target="_blank" rel="noopener">
          <span class="ui-label">Template-based NLG (discussion)</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">PDF</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://chop.raic.ca/chapter-4.2" target="_blank" rel="noopener">
          <span class="ui-label">Cost per area concept</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">RAIC</span>
        </a>

        <a class="ui-row hover:bg-black/5 dark:hover:bg-white/5 transition" href="https://www.mathworks.com/help/webappserver/index.html" target="_blank" rel="noopener">
          <span class="ui-label">MATLAB Web App Server</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">MathWorks</span>
        </a>
      </div>

      <p class="ui-help mt-4">
        {{ $isAr
          ? 'إذا تحب، أرتّب لك هذه المصادر بصيغة IEEE/APA داخل الصفحة أيضاً (ستاتك).'
          : 'If you want, I can format these references in IEEE/APA style inside the page as well (static).'
        }}
      </p>
    </div>

  </div>
  {{-- ===== Example Walkthrough ===== --}}
<div class="mt-6 ui-card p-6">
  <div class="flex items-center justify-between gap-3">
    <h2 class="ui-h2">{{ $isAr ? 'Example Walkthrough (مثال واحد خطوة بخطوة)' : 'Example Walkthrough (One End-to-End Example)' }}</h2>
    <span class="ui-badge">{{ $isAr ? 'مثال' : 'Example' }}</span>
  </div>

  <p class="ui-p mt-3">
    {{ $isAr
      ? 'هذا مثال واحد يوضح مرور البيانات عبر الخدمات الخمس: HTS → ANFIS → Gauge → Sensitivity → Explanation. الأرقام هنا لشرح المنطق، أما قيمة ANFIS الدقيقة فتتحدد بحسب PS settings وملف الـ FIS الموجود لديك.'
      : 'This single example shows the full pipeline: HTS → ANFIS → Gauge → Sensitivity → Explanation. Numbers are used to explain the logic, while the exact ANFIS value depends on your PS settings and FIS file.'
    }}
  </p>

  <div class="ui-divider my-6"></div>

  {{-- 0) Example Inputs --}}
  <div class="ui-surface p-5">
    <div class="text-base font-semibold text-gray-900 dark:text-white">
      {{ $isAr ? '0) مدخلات المثال' : '0) Example Inputs' }}
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'نفترض مشروع صيانة لطريق في كربلاء بتاريخ صيانة محدد ومساحة معقولة، مع كود عمر رصف متوسط. الهدف هو توضيح كيف تنتقل القيم داخل النظام.'
        : 'Assume a road-maintenance project with a specific maintenance date and a reasonable area, using a “medium” pavement age code. The goal is to show how values flow through the system.'
      }}
    </p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'تاريخ الصيانة' : 'Maintenance Date' }}</span>
        <span class="text-sm font-semibold text-gray-900 dark:text-white">2024-06-15</span>
      </div>
      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'كود عمر الرصف' : 'Pavement Age Code' }}</span>
        <span class="text-sm font-semibold text-gray-900 dark:text-white">
          {{ $isAr ? '2 (متوسط)' : '2 (Medium)' }}
        </span>
      </div>
      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'مساحة الصيانة (م²)' : 'Maintenance Area (m²)' }}</span>
        <span class="text-sm font-semibold text-gray-900 dark:text-white">12,000</span>
      </div>
      <div class="ui-row">
        <span class="ui-label">{{ $isAr ? 'المحافظة/الطريق (وصف)' : 'Gov/Road (label)' }}</span>
        <span class="text-sm font-semibold text-gray-900 dark:text-white">
          {{ $isAr ? 'كربلاء — طريق رئيسي (مثال)' : 'Karbala — Main Road (example)' }}
        </span>
      </div>
    </div>
  </div>

  {{-- 1) HTS --}}
  <div class="mt-4 ui-surface p-5">
    <div class="flex items-center justify-between gap-3">
      <div class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $isAr ? '1) حساب HTS (مثال رقمي)' : '1) HTS Calculation (Numeric Example)' }}
      </div>
      <span class="ui-badge">HTS</span>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'بما أن كود عمر الرصف = 2، إذن نافذة السنوات = 12 سنة. سنة الصيانة = 2024.'
        : 'Since pavement age code = 2, the window = 12 years. Maintenance year = 2024.'
      }}
    </p>

    <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
yearsSpan = 12
maintenanceYear = 2024
startYear = 2024 - 12 = 2012

HTS = sum(days_above_40) from (2013 .. 2024)
    </pre>

    <p class="ui-p mt-3">
      {{ $isAr
        ? 'نفترض أن مجموع الأيام فوق 40°C من 2013 إلى 2024 حسب جدول HeatDay يساوي: 980 يوم.'
        : 'Assume the total days above 40°C from 2013 to 2024 in HeatDay equals: 980 days.'
      }}
    </p>

    <div class="mt-3 ui-row">
      <span class="ui-label">HTS</span>
      <span class="text-sm font-semibold text-gray-900 dark:text-white">980</span>
    </div>

    <p class="ui-help mt-3">
      {{ $isAr
        ? 'هذا الرقم يدخل لاحقاً كواحد من مدخلات نموذج ANFIS (ضمن ordered13) حسب ترتيبك.'
        : 'This value becomes one of the ANFIS inputs (within ordered13) based on your ordering.'
      }}
    </p>
  </div>

  {{-- 2) ANFIS --}}
  <div class="mt-4 ui-surface p-5">
    <div class="flex items-center justify-between gap-3">
      <div class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $isAr ? '2) حساب الكلفة بـ ANFIS (مثال توضيحي للـ Pipeline)' : '2) ANFIS Cost (Illustrative Pipeline Example)' }}
      </div>
      <span class="ui-badge">ANFIS</span>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'ندخل 13 قيمة مرتبة ordered13 (V1..V13). سنعرض مثالاً مبسطاً لثلاث قيم فقط لشرح التحويلات، ثم نوضح كيف تُستنتج الكلفة.'
        : 'We feed 13 ordered inputs ordered13 (V1..V13). We show a simplified example for three values to illustrate transformations, then explain how the final cost is obtained.'
      }}
    </p>

    <div class="mt-3 ui-card p-4">
      <div class="ui-label">{{ $isAr ? 'مثال (3 مدخلات من أصل 13) لتوضيح التحويل' : 'Example (3 out of 13 inputs) to illustrate transforms' }}</div>

      <pre class="mt-2 text-sm whitespace-pre-wrap leading-6">
Assume three raw inputs (subset):
V3 (Area) = 12000
V7 (HTS)  = 980
V9 (Traffic) = 2   (categorical code as numeric)

Step A) log10(x+1):
log10(12000+1) ≈ 4.079
log10(980+1)   ≈ 2.992
log10(2+1)     ≈ 0.477

Step B) mapminmax apply (0..1):
xNorm = applyVector(xLog, PS_in)   // exact values depend on PS_in in your config

Step C) Sugeno eval:
yNorm = evaluateSugeno(xNorm)      // depends on FIS (.fis rules & parameters)

Step D) reverse output normalization:
outLog = reverseScalar(yNorm, PS_out)

Step E) inverse log:
cost = (10^outLog) - 1
      </pre>

      <p class="ui-help mt-3">
        {{ $isAr
          ? 'الأرقام الدقيقة لـ xNorm/yNorm/outLog تعتمد على PS_in/PS_out وملف الـ FIS لديك، لذلك هذا مثال توضيحي للمنهج وليس رقمك النهائي.'
          : 'Exact xNorm/yNorm/outLog depend on your PS_in/PS_out and FIS file, so this is a methodological illustration rather than your exact final value.'
        }}
      </p>
    </div>

    <p class="ui-p mt-4">
      {{ $isAr
        ? 'لإكمال المثال end-to-end سنفترض أن ANFIS أعطى الكلفة الكلية التالية لهذا المشروع: 540,000,000 دينار.'
        : 'To complete the end-to-end example, assume ANFIS produced the following total cost: 540,000,000 IQD.'
      }}
    </p>

    <div class="mt-3 ui-row">
      <span class="ui-label">{{ $isAr ? 'Total Cost (افتراضي للمثال)' : 'Total Cost (assumed for example)' }}</span>
      <span class="text-sm font-semibold text-gray-900 dark:text-white">540,000,000</span>
    </div>
  </div>

  {{-- 3) Gauge --}}
  <div class="mt-4 ui-surface p-5">
    <div class="flex items-center justify-between gap-3">
      <div class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $isAr ? '3) Gauge: حساب A وتصنيف الكلفة (مثال رقمي)' : '3) Gauge: Compute A and classify (Numeric Example)' }}
      </div>
      <span class="ui-badge">Gauge</span>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'نحسب A = TotalCost / Area حتى نقارن بين المشاريع بشكل عادل.'
        : 'We compute A = TotalCost / Area to compare projects fairly.'
      }}
    </p>

    <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
A = 540,000,000 / 12,000
  = 45,000  IQD/m²
    </pre>

    <div class="mt-3 ui-row">
      <span class="ui-label">A (IQD/m²)</span>
      <span class="text-sm font-semibold text-gray-900 dark:text-white">45,000</span>
    </div>

    <p class="ui-help mt-3">
      {{ $isAr
        ? 'بعدها الخدمة تطابق A مع ranges الموجودة في config(cost_gauge.ranges) لتحديد (واطئة/متوسطة/عالية...) ولون الرينج.'
        : 'Then the service matches A against config(cost_gauge.ranges) to determine the label (low/medium/high...) and range color.'
      }}
    </p>
  </div>

  {{-- 4) Sensitivity --}}
  <div class="mt-4 ui-surface p-5">
    <div class="flex items-center justify-between gap-3">
      <div class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $isAr ? '4) Sensitivity: نسبة التأثير للـ 7 مدخلات (مثال مبسط)' : '4) Sensitivity: Impact % for 7 inputs (Simplified Example)' }}
      </div>
      <span class="ui-badge">XAI</span>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'هنا سنعرض مثالين صغيرين داخل نفس المثال: عامل continuous (±10%) وعامل categorical (تجربة قيم). الفكرة: نأخذ أكبر فرق ونحوّله إلى نسبة.'
        : 'We show two micro-examples within the same pipeline: a continuous feature (±10%) and a categorical feature (test values). We take the maximum change and convert it to a percentage.'
      }}
    </p>

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">

      {{-- Continuous example --}}
      <div class="ui-card p-5">
        <div class="text-base font-semibold text-gray-900 dark:text-white">
          {{ $isAr ? 'مثال (Continuous): المساحة Area ±10%' : 'Example (Continuous): Area ±10%' }}
        </div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'BaseCost = 540,000,000. نختبر Area=10,800 و Area=13,200 ونقيس الفرق.'
            : 'BaseCost = 540,000,000. Test Area=10,800 and Area=13,200 and measure changes.'
          }}
        </p>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
Base cost C0 = 540,000,000

Test low  (Area -10%): newCost = 575,000,000   → diff = 35,000,000
Test high (Area +10%): newCost = 510,000,000   → diff = 30,000,000

Δ = max(diff) = 35,000,000
Impact% = (Δ / C0) * 100
        = (35,000,000 / 540,000,000) * 100
        ≈ 6.48%
        </pre>

        <div class="mt-3 ui-row">
          <span class="ui-label">{{ $isAr ? 'Impact%' : 'Impact%' }}</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">6.48%</span>
        </div>
      </div>

      {{-- Categorical example --}}
      <div class="ui-card p-5">
        <div class="text-base font-semibold text-gray-900 dark:text-white">
          {{ $isAr ? 'مثال (Categorical): نوع الطريق Road Type' : 'Example (Categorical): Road Type' }}
        </div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'نفترض RoadType الحالي = 2. نجرب القيم [1,3] ونختار أكبر فرق.'
            : 'Assume current RoadType = 2. Test values [1,3] and pick the maximum difference.'
          }}
        </p>

        <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
Base cost C0 = 540,000,000
Current RoadType = 2

Test RoadType = 1 → newCost = 520,000,000 → diff = 20,000,000
Test RoadType = 3 → newCost = 610,000,000 → diff = 70,000,000

Δ = 70,000,000
Impact% = (70,000,000 / 540,000,000) * 100
        ≈ 12.96%
        </pre>

        <div class="mt-3 ui-row">
          <span class="ui-label">{{ $isAr ? 'Impact%' : 'Impact%' }}</span>
          <span class="text-sm font-semibold text-gray-900 dark:text-white">12.96%</span>
        </div>
      </div>
    </div>

    <p class="ui-help mt-4">
      {{ $isAr
        ? 'هذه الأرقام مثال لشرح الحساب. داخل النظام الحقيقي، newCost يأتي من predictCost بعد تعديل قيمة العامل.'
        : 'These values are illustrative. In the real system, newCost is obtained by calling predictCost after modifying the feature.'
      }}
    </p>
  </div>

  {{-- 5) Explanation --}}
  <div class="mt-4 ui-surface p-5">
    <div class="flex items-center justify-between gap-3">
      <div class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $isAr ? '5) Explanation: كيف تولّدت الجمل؟ (مثال نصّي واحد)' : '5) Explanation: How sentences are generated (One text example)' }}
      </div>
      <span class="ui-badge">NLG</span>
    </div>

    <p class="ui-p mt-2">
      {{ $isAr
        ? 'نفترض أن الـ Gauge صنّف الحالة “متوسطة” وأن أعلى مؤثرين هما RoadType (≈12.96%) وArea (≈6.48%). هنا يظهر كيف تتحول هذه النتائج إلى Summary + Reasons وفق قوالب ثابتة واتجاه التأثير.'
        : 'Assume the Gauge classified the case as “Medium” and the top two influencers are RoadType (≈12.96%) and Area (≈6.48%). Below shows how the system generates a Summary + Reasons using templates and direction logic.'
      }}
    </p>

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
      <div class="ui-card p-5">
        <div class="ui-label">{{ $isAr ? 'Summary (AR)' : 'Summary (AR)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? 'التكلفة التقديرية ضمن مستوى (متوسطة)، وقيمة المؤشر A ≈ 45,000 دينار/م². الكلفة الكلية المقدّرة ≈ 540,000,000 دينار. بشكل عام، هذا التصنيف يتوافق مع تأثير خصائص الطريق والأحمال والبيئة على عمق التدخل المطلوب.'
            : '—'
          }}
        </p>
      </div>

      <div class="ui-card p-5">
        <div class="ui-label">{{ $isAr ? 'Summary (EN)' : 'Summary (EN)' }}</div>
        <p class="ui-p mt-2">
          {{ $isAr
            ? '—'
            : 'The estimated cost falls in the (Medium) level. The A index is ≈ 45,000 IQD/m², with a total estimated cost of ≈ 540,000,000 IQD. Overall, this classification aligns with how road characteristics, loading, and environment influence intervention depth.'
          }}
        </p>
      </div>
    </div>

    <div class="mt-4 ui-card p-5">
      <div class="ui-label">{{ $isAr ? 'Reasons (مختصر مثال)' : 'Reasons (short example)' }}</div>

      <pre class="mt-3 text-sm whitespace-pre-wrap leading-6">
• (Road Type) — approx. impact 12.96%.
  Changing this factor increased the cost compared to the current state.
  (Δ ≈ 70,000,000 IQD).

• (Area) — approx. impact 6.48%.
  Changing this factor affected the cost within the tested ±10% range.
  (Δ ≈ 35,000,000 IQD).
      </pre>

      <p class="ui-help mt-3">
        {{ $isAr
          ? 'لاحظ أن صياغة الجمل تأتي من: (1) label العامل من الكونفگ، (2) impact% من Sensitivity، (3) direction من debug_payload، ثم قالب Template ثابت.'
          : 'Note: Sentences are built from (1) feature labels from config, (2) impact% from Sensitivity, (3) direction from debug_payload, then a fixed template.'
        }}
      </p>
    </div>
  </div>

</div>
</section>
@endsection
