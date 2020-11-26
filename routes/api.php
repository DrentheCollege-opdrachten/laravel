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

Route::get('/search/user/email/{email?}', [\App\Http\Controllers\SearchController::class, 'searchForUserByMail']);

Route::get('/band/{bandId}/getUsers', [\App\Http\Controllers\BandController::class, 'getMembers']);

Route::get('/search/{name}', [\App\Http\Controllers\SearchController::class, 'searchBandAndUserByName']);
