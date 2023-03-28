<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AgamaController;
use App\Http\Controllers\API\GolonganController;
use App\Http\Controllers\API\JabatanController;
use App\Http\Controllers\API\PegawaiController;
use App\Http\Controllers\API\KeturunanController;
use App\Http\Controllers\API\PendidikanTerakhirController;

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
Route::post('forgot-password',  [UserController::class, 'forgotPassword']);
Route::group(['middleware' => 'auth:api'], function() {

    // logout / detail user
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('user/me', [UserController::class, 'me']);
    Route::post('update-password', [UserController::class, 'updatePassword']);

    // Keturunan
    Route::get('keturunan', [KeturunanController::class, 'index']);
    Route::get('keturunan/{id}', [KeturunanController::class, 'showById']);
    Route::post('keturunan', [KeturunanController::class, 'create']);
    Route::patch('keturunan/update/{id}', [KeturunanController::class, 'updateById']);
    Route::delete('keturunan/delete/{id}', [KeturunanController::class, 'deleteById']);
    Route::post('keturunan/restore/{id}', [KeturunanController::class, 'restoreById']);

    // Pendidikan Terakhir
    Route::get('pendidikan-terakhir', [PendidikanTerakhirController::class, 'index']);
    Route::get('pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'showById']);
    Route::post('pendidikan-terakhir', [PendidikanTerakhirController::class, 'create']);
    Route::patch('pendidikan-terakhir/update/{id}', [PendidikanTerakhirController::class, 'updateById']);
    Route::delete('pendidikan-terakhir/delete/{id}', [PendidikanTerakhirController::class, 'deleteById']);
    Route::post('pendidikan-terakhir/restore/{id}', [PendidikanTerakhirController::class, 'restoreById']);

    // Agama
    Route::get('agama', [AgamaController::class, 'index']);
    Route::get('agama/{id}', [AgamaController::class, 'showById']);
    Route::post('agama', [AgamaController::class, 'create']);
    Route::patch('agama/update/{id}', [AgamaController::class, 'updateById']);
    Route::delete('agama/delete/{id}', [AgamaController::class, 'deleteById']);
    Route::post('agama/restore/{id}', [AgamaController::class, 'restoreById']);

    // golongan
    Route::get('golongan', [GolonganController::class, 'index']);
    Route::get('golongan/{id}', [GolonganController::class, 'showById']);
    Route::post('golongan', [GolonganController::class, 'create']);
    Route::patch('golongan/update/{id}', [GolonganController::class, 'updateById']);
    Route::delete('golongan/delete/{id}', [GolonganController::class, 'deleteById']);
    Route::post('golongan/restore/{id}', [GolonganController::class, 'restoreById']);

    // jabatan
    Route::get('jabatan', [JabatanController::class, 'index']);
    Route::get('jabatan/{id}', [JabatanController::class, 'showById']);
    Route::post('jabatan', [JabatanController::class, 'create']);
    Route::patch('jabatan/update/{id}', [JabatanController::class, 'updateById']);
    Route::delete('jabatan/delete/{id}', [JabatanController::class, 'deleteById']);
    Route::post('jabatan/restore/{id}', [JabatanController::class, 'restoreById']);

    // pegawai
    Route::get('pegawai', [PegawaiController::class, 'index']);
    Route::get('pegawai/charts', [PegawaiController::class, 'charts']);
    Route::get('pegawai/{id}', [PegawaiController::class, 'showById']);
    Route::post('pegawai', [PegawaiController::class, 'create']);
    Route::patch('pegawai/update/{id}', [PegawaiController::class, 'updateById']);
    Route::delete('pegawai/delete/{id}', [PegawaiController::class, 'deleteById']);
    Route::post('pegawai/restore/{id}', [PegawaiController::class, 'restoreById']);
});              
