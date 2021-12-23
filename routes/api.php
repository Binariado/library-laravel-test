<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => ['jwt.verify']], function() {

// });

Route::group([
    'prefix' => 'auth',
], function ($router) {

    $router->group([
        'middleware' => 'jwt.verify',
    ], function ($router) {
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
        Route::get('me', 'App\Http\Controllers\AuthController@me');
    });

    $router->post('login', 'App\Http\Controllers\AuthController@login');
    $router->post('register', 'App\Http\Controllers\AuthController@register');
});
