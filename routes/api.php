<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginAPIController;
use App\Http\Controllers\RegisterAPIController;
use App\Http\Controllers\ShortUrlAPIController;
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
Route::post('/login',[LoginAPIController::class,'login']);
Route::post('/register',[RegisterAPIController::class,'registration']);
Route::post('/short',[ShortUrlAPIController::class,'shortUrl']);
Route::post('/shorten',[ShortUrlAPIController::class,'getShortenedUrl']);
