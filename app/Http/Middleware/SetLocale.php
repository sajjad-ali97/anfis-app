<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->cookie('locale', 'ar'); // default ar

        App::setLocale(in_array($locale, ['ar', 'en']) ? $locale : 'ar');


        return $next($request);
    }
}
