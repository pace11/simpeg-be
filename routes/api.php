<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AgamaController;
use App\Http\Controllers\API\GolonganController;

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

Route::post('register',  [UserController::class, 'register']);
Route::post('login',  [UserController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function() {

    // logout / detail user
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('user/me', [UserController::class, 'me']);

    // Agama
    Route::get('agama', [AgamaController::class, 'index']);
    Route::get('agama/{id}', [AgamaController::class, 'showById']);
    Route::post('agama', [AgamaController::class, 'create']);
    Route::patch('agama/update/{id}', [AgamaController::class, 'updateById']);
    Route::delete('agama/delete/{id}', [AgamaController::class, 'deleteById']);

    // golongan
    Route::get('golongan', [GolonganController::class, 'index']);
    Route::get('golongan/{id}', [GolonganController::class, 'showById']);
    Route::post('golongan', [GolonganController::class, 'create']);
    Route::patch('golongan/update/{id}', [GolonganController::class, 'updateById']);
    Route::delete('golongan/delete/{id}', [GolonganController::class, 'deleteById']);
});
