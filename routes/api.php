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
    'middleware' => 'api',
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

Route::resource('/permissions', 'App\Http\Controllers\PermissionController')
    ->middleware(['jwt.verify', 'role:root'])
    ->only(['index', 'show']);

Route::group([
    'middleware' => ['api', 'jwt.verify', 'role:root'],
    'prefix' => 'roles',
], function ($router) {
    $router->resource('/', 'App\Http\Controllers\RoleController')
        ->only(['index', 'show']);
    $router->post('/assign', 'App\Http\Controllers\RoleController@assign');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'authors',
], function ($router) {
    $router->resource('/', 'App\Http\Controllers\AuthorController')
        ->only(['index', 'store']);
    $router->put('/{author}', 'App\Http\Controllers\AuthorController@update');
    $router->delete('/{author}', 'App\Http\Controllers\AuthorController@destroy')
        ->middleware(['permission:Delete author']);
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'publishers',
], function ($router) {
    $router->resource('/', 'App\Http\Controllers\PublisherController')
        ->only(['index', 'store']);
    $router->put('/{publisher}', 'App\Http\Controllers\PublisherController@update');
    $router->delete('/{publisher}', 'App\Http\Controllers\PublisherController@destroy')
        ->middleware(['permission:Delete publisher']);
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'editors',
], function ($router) {
    $router->resource('/', 'App\Http\Controllers\EditorController')
    ->only(['index', 'store', 'update']);
    $router->put('/{editor}', 'App\Http\Controllers\EditorController@update');
    $router->delete('/{editor}', 'App\Http\Controllers\EditorController@destroy')
        ->middleware(['permission:Delete publisher']);
});

Route::resource('/users', 'App\Http\Controllers\UserController')
    ->middleware(['api', 'jwt.verify', 'role:admin|root'])
    ->only(['index', 'show']);
