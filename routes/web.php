<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Main Pages
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/projects', 'pages.projects')->name('projects');
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
