<?php
return [

    /*
|--------------------------------------------------------------------------
| Header Page
|--------------------------------------------------------------------------
*/
    'home' => 'Home',
    'projects' => 'Projects',
    'about' => 'About',
    'contact' => 'Contact',
    'quick_analysis' => 'Quick Analysis',
    'rights' => 'All rights reserved',


    'brand_full' => 'ANFIS Cost Estimation Framework',
    'brand_medium' => 'ANFIS Cost Estimation',
    'brand_short' => 'ANFIS',
    'brand_subtitle' => 'Neuro-Fuzzy Model for Road Projects',

    /*
|--------------------------------------------------------------------------
| Footer Page
|--------------------------------------------------------------------------
*/

    'footer_dev_contact_title'   => 'Contact the Developer (Sajjad Al-Haidari)',
    'footer_owner_contact_title' => 'Contact the Project Owner (Ali Saad)',
    'footer_phone'               => 'Phone',
    'footer_instagram'           => 'Instagram',
    'footer_built_by'            => 'Developed by',
    'footer_dev_name'            => 'Sajjad Al-Haidari',
    'footer_owner'               => 'Project Owner',
    'footer_owner_name'          => 'Ali Saad',
    'footer_date'                => 'Development Date',
    'footer_build_date'          => '2026-02-14',
    'footer_rights'              => 'All rights reserved',

    /*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/

    'home_ministry' => 'Ministry of Higher Education and Scientific Research',
    'home_college' => 'College of Engineering',
    'home_university' => 'University of Karbala',
    'home_project_label' => 'Research Project',
    'home_research_title' => 'Modeling the Maintenance Costs of Road Projects in Karbala Governorate using Fuzzy Neural Network',
    'home_research_subtitle' => 'An academic framework to estimate and analyze maintenance costs using an Adaptive Neuro-Fuzzy approach.',
    'home_student_label' => 'Researcher Name',
    'home_student_name' => 'ALI SAAD AHMED',
    'home_supervisor_label' => 'Supervisor',
    'home_supervisor_name' => 'Assist. Prof. Dr.Gafel Kareem Aswed',
    'home_new_project' => 'New Project',
    'home_about_project' => 'About the Project',
    'home_footer_note' => 'This interface is designed for academic demonstration and research presentation purposes.',


    /*
|--------------------------------------------------------------------------
| Project Page
|--------------------------------------------------------------------------
*/
    'project_badge' => 'Project Setup',
    'create_project_title' => 'Create New Project',
    'create_project_subtitle' => 'Enter the basic project details to start the calculation workflow.',

    'project_info' => 'Project Information',
    'project_info_hint' => 'Fill the fields accurately to ensure better results later.',

    'project_title' => 'Project Title',
    'project_title_ph' => 'e.g., Karbala Main Road Maintenance',

    'governorate' => 'Governorate',
    'governorate_ph' => 'e.g., Karbala',

    'road_name' => 'Road Name',
    'road_name_ph' => 'e.g., Karbala – Najaf Highway',

    'maintenance_date' => 'Maintenance Date',
    'maintenance_tip' => 'Tip: Accurate dates improve HTS and pavement-age coding later.',

    'create_project_btn' => 'Create Project',
    'back_home' => 'Back to Home',

    'engineering_note_title' => 'Engineering Note',
    'engineering_note_body' => 'This model estimates maintenance cost using engineering inputs and a fixed ANFIS-compatible coding scheme.',

    'research_project' => 'Research Project',

    /*
|--------------------------------------------------------------------------
| inputs Page
|--------------------------------------------------------------------------
*/


    'project_created_success' => 'Project created successfully ✅',
    'inputs_saved_temp' => 'Inputs saved temporarily ✅ (calculation + final DB save will be wired in the next task)',
    'inputs_title' => 'Model Inputs (13)',
    'inputs_subtitle' => 'Enter values according to the coding table below. Values are submitted as coded numbers.',
    'project_id' => 'Project ID',
    'coding_table_title' => 'Coding Table',
    'coding_table_tip' => 'Values are stored as numeric codes in DB while shown as descriptive labels to the user.',
    'desc' => 'Description',
    'unit_coding' => 'Unit / Coding',
    'choose' => 'Choose...',
    'back' => 'Back',
    'calculate' => 'Calculate',

    'badge' => [
        'required' => 'Required',
    ],

    'units' => [
        'square_meter' => 'Square meter',
        'centimeter' => 'Centimeter',
    ],

    'help' => [
        'square_meter' => 'Enter area in square meters.',
        'centimeter' => 'Enter thickness in centimeters.',
    ],

    'coding' => [
        'pavement_age' => '1 = New, 2 = Medium, 3 = Old',
        'exist_none' => '1 = Exist, 0 = None',
        'road_class' => '1 = Main, 2 = Secondary',
        'road_condition' => '1 = Fair, 2 = Poor, 3 = Very Poor',
        'low_med_high' => '1 = Low, 2 = Medium, 3 = High',
        'maintenance_type' => '1 = Preventive, 2 = Routine, 3 = Emergency',
        'soil_strength' => '1 = Weak, 2 = Medium, 3 = Strong',
        'pavement_type' => '1 = Asphalt, 2 = Mix (Asphalt + Concrete)',
        'hts_days' => 'Number of days exceeding 45°C',
    ],

    'options' => [
        'new' => 'New',
        'medium' => 'Medium',
        'old' => 'Old',
        'exist' => 'Exist',
        'none' => 'None',
        'main' => 'Main',
        'secondary' => 'Secondary',
        'fair' => 'Fair',
        'poor' => 'Poor',
        'very_poor' => 'Very Poor',
        'low' => 'Low',
        'high' => 'High',
        'preventive' => 'Preventive',
        'routine' => 'Routine',
        'emergency' => 'Emergency',
        'weak' => 'Weak',
        'strong' => 'Strong',
        'asphalt' => 'Asphalt',
        'mix' => 'Mix (Asphalt + Concrete)',
    ],

    'inputs' => [
        'pavement_area' => 'Pavement Area',
        'pavement_age' => 'Pavement Age',
        'median_islands' => 'Median Islands',
        'asphalt_thickness' => 'Asphalt Thickness',
        'hts' => 'High Temperature Severity (HTS)',
        'road_class' => 'Road Classification',
        'road_condition' => 'Road Condition (PCI)',
        'aadt_heavy' => 'AADT for Heavy-Loaded Vehicles',
        'drainage_system' => 'Drainage System',
        'maintenance_type' => 'Maintenance Type',
        'soil_strength' => 'Soil Strength',
        'pavement_type' => 'Pavement Type',
        'traffic_volume' => 'Traffic Volume (AADT)',
    ],

    'inputs_form_title' => 'Inputs',
    'inputs_form_tip' => 'Choose carefully. Submitted values are numeric coded values.',

    'hts_how_title' => 'How to calculate HTS:',
    'hts_formula_placeholder' => 'I will place your official HTS formula text here once you send it.',



];
