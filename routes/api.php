<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search/user/{field?}', [\App\Http\Controllers\UserController::class, 'searchForUser']);

Route::get('/band/addUser/{band_id}/{user_id}', [\App\Http\Controllers\BandController::class, 'addBandUser'])->middleware('auth', 'inBand');
