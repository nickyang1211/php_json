<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParseController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HelperController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ParseController::class)
    ->group(function () {
        Route::get('/parse', 'parse');
});

Route::controller(CollectionController::class)
    ->prefix('collection')
    ->group(function () {
        Route::get('/filter', 'filter');
        Route::get('/pluck', 'pluck');
        Route::get('/contains', 'contains');
        Route::get('/groupby', 'groupby');
        Route::get('/sortby', 'sortby');
        Route::get('/partition', 'partition');
        Route::get('/reject', 'reject');
        Route::get('/where', 'where');
        Route::get('/wherein', 'wherein');
        Route::get('/chunk', 'chunk');
        Route::get('/count', 'count');
        Route::get('/first', 'first');
        Route::get('/firstwhere', 'firstwhere');
    });
    
Route::controller(HelperController::class)
    ->group(function () {
        Route::post('/call-url', 'helper');
});