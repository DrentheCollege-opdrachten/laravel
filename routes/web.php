<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',
    [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::post('/search',
    [\App\Http\Controllers\SearchController::class, 'searchBandAndUserByNameView'])
->name('search');

Auth::routes();

/**
 * get the user based on there id.
 * When no id is supplied it shows your profile
*/
Route::get('/user/{userId?}',
    [App\Http\Controllers\UserController::class, 'index'])
    ->name('user')
    ->where(['userId' => '[0-9]+']);


/**
 * change the user settings
 * when the url is accessed with a get request it shows the page
 * to edit the user settings but when it is submitted with a
 * post request it saves the changes to the database
 */
Route::get('/user/settings',
    [App\Http\Controllers\UserController::class, 'changeSettingsGet'])
    ->middleware('auth')
    ->name('user.settings');
Route::post('/user/settings',
    [App\Http\Controllers\UserController::class, 'changeSettingsPost'])
    ->middleware('auth')
    ->name('user.settings.submit');


/**
 * Show the band based on id.
 * when no ID is given it will redirect you to home page
 */
Route::get('/band/{bandId?}',
    [App\Http\Controllers\BandController::class, 'index'])
    ->name('band')
    ->where(['bandId' => '[0-9]+']);
/**
 * change the band settings
 * when the url is accessed with a get request it shows the page
 * to edit the bands settings but when it is submitted with a
 * post request it saves the changes to the database
 */

Route::get('/band/{bandId}/settings',
    [\App\Http\Controllers\BandController::class, 'changeSettingsGet'])
    ->where(['bandId' => '[0-9]+'])
    ->middleware('auth', 'inBand')
    ->name('bands.settings');
Route::post('/band/{bandId}/settings',
    [\App\Http\Controllers\BandController::class, 'changeSettingsPost'])
    ->where(['bandId' => '[0-9]+'])
    ->middleware('auth', 'inBand')
    ->name('bands.settings.submit');

/**
 * Routes to manipulate the band users
 */
Route::post('/band/{bandId}/addUser/{userId}',
    [\App\Http\Controllers\BandController::class, 'addBandUser'])
    ->where([
        'bandId' => '[0-9]+',
        'userId' => '[0-9]+',
        ])
    ->middleware('auth', 'inBand')
    ->name('addBandMember');
Route::delete('/band/{bandId}/deleteUser/{userId}',
    [\App\Http\Controllers\BandController::class, 'removeMember'])
    ->where([
        'bandId' => '[0-9]+',
        'userId' => '[0-9]+',
    ])
    ->middleware('auth', 'inBand')
    ->name('deleteBandMember');

/**
 * Create a new band
 */
Route::get('/band/create',
    [\App\Http\Controllers\BandController::class, 'createBandGet'])
    ->middleware('auth')
    ->name('createBand');
Route::post('/band/create',
        [\App\Http\Controllers\BandController::class, 'createBandPut'])
    ->middleware('auth')
    ->name('createBandSubmit');

/**
 * Create a post
 */

Route::post('/band/{bandId}/createPost',
    [\App\Http\Controllers\PostController::class, 'createPost'])
    ->middleware('auth', 'inBand')
    ->name('createPost');
Route::get('/band/{bandId}/deletePost/{postId}',
    [\App\Http\Controllers\PostController::class, 'deletePost'])
    ->middleware('auth', 'inBand')
    ->name('deletePost');

Route::get('/search/{name}', [\App\Http\Controllers\SearchController::class, 'searchBandAndUserByName']);
