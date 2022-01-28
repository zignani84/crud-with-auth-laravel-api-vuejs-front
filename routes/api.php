<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    /*
        Generates a token to user
    */
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    /*
        Register user in database
    */
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    /*
        Need a token of user to logout
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    /*
        Need a token of user to refresh token of user
    */
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');

    /*
        Need a token of user to show details of a user
    */
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->name('auth.user-profile');
});

Route::group([
    'middleware' => [
        'auth:api'
    ]
], function () {
Route::apiResources([
        'users'        => UserController::class
    ], 
    [
        'except' => ['store']
    ]
);
});

Route::group([
    'prefix' => 
        'users', 
    'middleware' => [
        'auth:api'
    ]
], function () {
Route::post('/create', [UserController::class, 'store'])->name('users.create');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Página não encontrada. Se o erro persistir, entre em contato com o suporte'], 404);
});
