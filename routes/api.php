<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test', fn()=>env('APP_NAME'));

Route::get('language/{locale}', function ($locale) {
    if (in_array($locale,config('app.available_locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return true;
    }
    app()->setLocale(config('app.locale'));
    return false;
});
