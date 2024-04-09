<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $local = config('app.locale');

        if (Session::has('locale')) {
            $local = Session::get('locale');
        }
        if ($request->hasHeader('X-localization')) {
            $local = $request->header('X-localization');
        }
        App::setLocale($local);

        return $next($request);
    }
}
