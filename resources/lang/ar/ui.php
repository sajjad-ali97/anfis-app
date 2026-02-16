<?php
return [


    /*
|--------------------------------------------------------------------------
| Header Page
|--------------------------------------------------------------------------
*/
    'home' => 'الرئيسية',
    'projects' => 'المشاريع',
    'about' => 'حول',
    'contact' => 'تواصل',
    'quick_analysis' => ' تحليل سريع',
    'rights' => 'جميع الحقوق محفوظة',

    'brand_full' => 'إطار تقدير الكلفة باستخدام ANFIS',
    'brand_medium' => 'تقدير الكلفة ANFIS',
    'brand_short' => 'ANFIS',
    'brand_subtitle' => 'نموذج عصبي-ضبابي تكيفي لمشاريع إنشاء الطرق',
    /*
|--------------------------------------------------------------------------
| Footer Page
|--------------------------------------------------------------------------
*/
    'footer_dev_contact_title'   => 'التواصل مع المبرمج-سجاد الحيدري',
    'footer_owner_contact_title' => 'التواصل مع مالك الموقع-علي سعد',
    'footer_phone'               => 'الهاتف',
    'footer_instagram'           => 'إنستغرام',
    'footer_built_by'            => 'تمت البرمجة بواسطة',
    'footer_dev_name'            => 'سجاد الحيدري',
    'footer_owner'               => 'مالك المشروع',
    'footer_owner_name'          => 'علي سعد',
    'footer_date'                => 'تاريخ البرمجة',
    'footer_build_date'          => '2026-02-14',
    'footer_rights'              => 'جميع الحقوق محفوظة',


    /*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/

    'home_ministry' => 'وزارة التعليم العالي والبحث العلمي',
    'home_college' => 'كلية الهندسة',
    'home_university' => 'جامعة كربلاء',
    'home_project_label' => 'مشروع بحثي',
    'home_research_title' => 'نمذجة تكاليف صيانة مشاريع الطرق في محافظة كربلاء باستخدام الشبكة العصبية الضبابية',
    'home_research_subtitle' => 'إطار أكاديمي لتقدير وتحليل تكاليف الصيانة بالاعتماد على منهجية ANFIS.',
    'home_student_label' => 'اسم الباحث',
    'home_student_name' => 'علي سعد احمد',
    'home_supervisor_label' => 'المشرف',
    'home_supervisor_name' => ' أ.م.د.غافل كريم اسود',
    'home_new_project' => 'مشروع جديد',
    'home_about_project' => 'حول المشروع',
    'home_footer_note' => 'هذه الواجهة معدّة للعرض الأكاديمي وتقديم نتائج البحث.',



    /*
|--------------------------------------------------------------------------
| Project Page
|--------------------------------------------------------------------------
*/

    'project_badge' => 'تهيئة المشروع',
    'create_project_title' => 'إنشاء مشروع جديد',
    'create_project_subtitle' => 'أدخل معلومات المشروع الأساسية للبدء بخطوات الحساب.',
    'project_info' => 'معلومات المشروع',
    'project_info_hint' => 'املأ الحقول التالية بدقة لضمان أفضل نتائج لاحقًا.',
    'project_title' => 'اسم المشروع',
    'project_title_ph' => 'مثال: صيانة الطريق الرئيسي - كربلاء',
    'governorate' => 'المحافظة',
    'governorate_ph' => 'مثال: كربلاء',
    'road_name' => 'اسم الطريق',
    'road_name_ph' => 'مثال: طريق كربلاء - النجف',
    'maintenance_date' => 'تاريخ الصيانة',
    'maintenance_tip' => 'ملاحظة: دقة التاريخ تساعد لاحقًا في حساب HTS وترميز عمر الرصف.',
    'create_project_btn' => 'إنشاء المشروع',
    'back_home' => 'العودة للرئيسية',
    'engineering_note_title' => 'ملاحظة هندسية',
    'engineering_note_body' => 'هذا النموذج يدعم تحليل كلفة الصيانة اعتمادًا على مدخلات هندسية وترميز ثابت متوافق مع ANFIS.',
    'research_project' => 'مشروع بحثي',



    /*
|--------------------------------------------------------------------------
| inputs Page
|--------------------------------------------------------------------------
*/


    'project_created_success' => 'تم إنشاء المشروع بنجاح ✅',
    'inputs_saved_temp' => 'تم حفظ المدخلات مؤقتاً ✅ (سيتم ربط الحساب والخزن النهائي بالمرحلة القادمة)',
    'inputs_title' => 'مدخلات النموذج (13)',
    'inputs_subtitle' => 'أدخل القيم حسب الجدول أدناه. سيتم إرسال القيم للمنظومة بصيغة الترميز.',
    'project_id' => 'معرّف المشروع',
    'coding_table_title' => 'جدول الترميز (Coding)',
    'coding_table_tip' => 'سيتم تخزين القيم بالقاعدة بصيغة أرقام ترميزية، بينما تُعرض للمستخدم بشكل وصفي.',
    'desc' => 'الوصف',
    'unit_coding' => 'الوحدة / الترميز',
    'choose' => 'اختر...',
    'back' => 'رجوع',
    'calculate' => 'احسب',

    'badge' => [
        'required' => 'مطلوب',
    ],

    'units' => [
        'square_meter' => 'متر مربع',
        'centimeter' => 'سنتيمتر',
    ],

    'help' => [
        'square_meter' => 'أدخل المساحة بالمتر المربع.',
        'centimeter' => 'أدخل السمك بالسنتيمتر.',
    ],

    'coding' => [
        'pavement_age' => '1 = جديد، 2 = متوسط، 3 = قديم',
        'exist_none' => '1 = موجود، 0 = غير موجود',
        'road_class' => '1 = رئيسي، 2 = ثانوي',
        'road_condition' => '1 = جيد، 2 = سيء، 3 = سيء جداً',
        'low_med_high' => '1 = منخفض، 2 = متوسط، 3 = عالي',
        'maintenance_type' => '1 = وقائي، 2 = روتيني، 3 = طارئ',
        'soil_strength' => '1 = ضعيف، 2 = متوسط، 3 = قوي',
        'pavement_type' => '1 = إسفلت، 2 = خليط (إسفلت + كونكريت)',
        'hts_days' => 'عدد الأيام التي تتجاوز 40°C',
    ],

    'options' => [
        'new' => 'جديد',
        'medium' => 'متوسط',
        'old' => 'قديم',
        'exist' => 'موجود',
        'none' => 'غير موجود',
        'main' => 'رئيسي',
        'secondary' => 'ثانوي',
        'fair' => 'جيد',
        'poor' => 'سيء',
        'very_poor' => 'سيء جداً',
        'low' => 'منخفض',
        'high' => 'عالي',
        'preventive' => 'وقائي',
        'routine' => 'روتيني',
        'emergency' => 'طارئ',
        'weak' => 'ضعيف',
        'strong' => 'قوي',
        'asphalt' => 'إسفلت',
        'mix' => 'خليط (إسفلت + كونكريت)',
    ],

    'inputs' => [
        'pavement_area' => 'مساحة الرصف (Pavement Area)',
        'pavement_age' => 'عمر الرصف (Pavement Age)',
        'median_islands' => 'الجزرات الوسطية (Median Islands)',
        'asphalt_thickness' => 'سمك الإسفلت (Asphalt Thickness)',
        'hts' => 'شدة الحرارة العالية (HTS)',
        'road_class' => 'تصنيف الطريق (Road Classification)',
        'road_condition' => 'حالة الطريق (PCI)',
        'aadt_heavy' => 'AADT للمركبات الثقيلة',
        'drainage_system' => 'نظام التصريف (Drainage System)',
        'maintenance_type' => 'نوع الصيانة (Maintenance Type)',
        'soil_strength' => 'قوة التربة (Soil Strength)',
        'pavement_type' => 'نوع الرصف (Pavement Type)',
        'traffic_volume' => 'حجم المرور (AADT / Traffic Volume)',
    ],

    'inputs_form_title' => 'الإدخالات',
    'inputs_form_tip' => 'اختر القيم بعناية. القيم المُرسلة ستكون بالترميز الرقمي.',

    'hts_how_title' => 'طريقة حساب HTS:',
    'hts_formula_placeholder' => 'سأضع هنا النص/الكليشة الخاصة بمعادلة HTS بعد أن ترسلها.',


];
