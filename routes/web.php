<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;



/*
|--------------------------------------------------------------------------
| Main Pages
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/



Route::get('/lang/{locale}', function ($locale) {
    abort_unless(in_array($locale, ['ar', 'en']), 404);

    cookie()->queue('locale', $locale, 60 * 24 * 365); // سنة
    return back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Project Page
|--------------------------------------------------------------------------
*/

Route::get('/projects/create', [ProjectController::class, 'create'])
    ->name('projects.create');

Route::post('/projects', [ProjectController::class, 'store'])
    ->name('projects.store');

Route::get('/results/{calculation}', [ProjectController::class, 'results'])
    ->name('projects.results');


/*
|--------------------------------------------------------------------------
| inputs Page
|--------------------------------------------------------------------------
*/
Route::get('/projects/{project}/inputs', [ProjectController::class, 'inputsCreate'])
    ->name('projects.inputs.create');

Route::post('/projects/{project}/inputs', [ProjectController::class, 'inputsStore'])
    ->name('projects.inputs.store');

/*
|--------------------------------------------------------------------------
| report and pdf
|--------------------------------------------------------------------------
*/

Route::get('/projects/{project}/report', [ProjectController::class, 'report'])
    ->name('projects.report');

Route::post('/projects/{project}/report/pdf', [ProjectController::class, 'reportPdf'])
    ->name('projects.report.pdf');






Route::get('/debug/gd', function () {
    return response()->json([
        'php_version' => PHP_VERSION,
        'sapi' => PHP_SAPI,
        'gd_loaded' => extension_loaded('gd'),
        'functions' => [
            'imagecreatefrompng' => function_exists('imagecreatefrompng'),
            'imagecreatetruecolor' => function_exists('imagecreatetruecolor'),
        ],
        'gd_info' => function_exists('gd_info') ? gd_info() : null,
    ]);
});