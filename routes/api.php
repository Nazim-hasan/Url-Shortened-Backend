<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginAPIController;
use App\Http\Controllers\RegisterAPIController;
use App\Http\Controllers\ShortUrlAPIController;
use App\Http\Controllers\AdminAPIController;
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
Route::post('/logout',[LoginAPIController::class,'logout']);
Route::post('/register',[RegisterAPIController::class,'registration']);
Route::post('/short',[ShortUrlAPIController::class,'shortUrl']);
Route::get('/getURL/{short}',[ShortUrlAPIController::class,'getShortenedUrl']);
Route::post('/spammingLimit',[AdminAPIController::class,'spammingLimit']);
Route::get('/spammingLimit',[AdminAPIController::class,'getSpammingLimit']);
Route::post('/waitingTime',[AdminAPIController::class,'waitingTime']);
Route::get('/waitingTime',[AdminAPIController::class,'getWaitingTime']);
