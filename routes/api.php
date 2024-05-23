<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParseController;
use App\Http\Controllers\CollectionController;
use App\Http\Helpers\HttpRequestHelper;

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

Route::post('/call-url', function (Request $request) {  
    $method = $request->input('method', 'GET');  
    $url = $request->input('url');  
    $options = $request->input('options', []);  
    
    // 调用 Helper 函数来发送请求  
    $result = HttpRequestHelper::sendRequest($method, $url, $options);  
    
    if (isset($result['error'])) {  
        return response()->json(['error' => $result['error']], 500);  
    }  
    
    return response()->json($result, $result['statusCode']);  
});