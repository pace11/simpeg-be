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
use App\Http\Controllers\API\SpotifyNotifController;
use App\Http\Controllers\API\KeluargaController;
use App\Http\Controllers\API\PekerjaanController;
use App\Http\Controllers\API\PendidikanController;
use App\Http\Controllers\API\PendidikanKkController;
use App\Http\Controllers\API\StatusPerkawinanKkController;
use App\Http\Controllers\API\StatusHubunganKkController;
use App\Http\Controllers\API\JenisPekerjaanKkController;

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
    Route::get('user/{id}', [UserController::class, 'showById']);
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

    // keluarga
    Route::get('keluarga', [KeluargaController::class, 'index']);
    Route::get('keluarga/{id}', [KeluargaController::class, 'showById']);
    Route::post('keluarga', [KeluargaController::class, 'create']);
    Route::patch('keluarga/update/{id}', [KeluargaController::class, 'updateById']);
    Route::delete('keluarga/delete/{id}', [KeluargaController::class, 'deleteById']);

    // pekerjaan
    Route::get('pekerjaan', [PekerjaanController::class, 'index']);
    Route::get('pekerjaan/{id}', [PekerjaanController::class, 'showById']);
    Route::post('pekerjaan', [PekerjaanController::class, 'create']);
    Route::patch('pekerjaan/update/{id}', [PekerjaanController::class, 'updateById']);
    Route::delete('pekerjaan/delete/{id}', [PekerjaanController::class, 'deleteById']);

    // pendidikan
    Route::get('pendidikan', [PendidikanController::class, 'index']);
    Route::get('pendidikan/{id}', [PendidikanController::class, 'showById']);
    Route::post('pendidikan', [PendidikanController::class, 'create']);
    Route::patch('pendidikan/update/{id}', [PendidikanController::class, 'updateById']);
    Route::delete('pendidikan/delete/{id}', [PendidikanController::class, 'deleteById']);

    // pendidikan-kk
    Route::get('pendidikan-kk', [PendidikanKkController::class, 'index']);
    Route::get('pendidikan-kk/{id}', [PendidikanKkController::class, 'showById']);
    Route::post('pendidikan-kk', [PendidikanKkController::class, 'create']);
    Route::patch('pendidikan-kk/update/{id}', [PendidikanKkController::class, 'updateById']);
    Route::delete('pendidikan-kk/delete/{id}', [PendidikanKkController::class, 'deleteById']);

    // status-perkawinan-kk
    Route::get('status-perkawinan-kk', [StatusPerkawinanKkController::class, 'index']);
    Route::get('status-perkawinan-kk/{id}', [StatusPerkawinanKkController::class, 'showById']);
    Route::post('status-perkawinan-kk', [StatusPerkawinanKkController::class, 'create']);
    Route::patch('status-perkawinan-kk/update/{id}', [StatusPerkawinanKkController::class, 'updateById']);
    Route::delete('status-perkawinan-kk/delete/{id}', [StatusPerkawinanKkController::class, 'deleteById']);

    // status-hubungan-kk
    Route::get('status-hubungan-kk', [StatusHubunganKkController::class, 'index']);
    Route::get('status-hubungan-kk/{id}', [StatusHubunganKkController::class, 'showById']);
    Route::post('status-hubungan-kk', [StatusHubunganKkController::class, 'create']);
    Route::patch('status-hubungan-kk/update/{id}', [StatusHubunganKkController::class, 'updateById']);
    Route::delete('status-hubungan-kk/delete/{id}', [StatusHubunganKkController::class, 'deleteById']);

    // jenis-pekerjaan-kk
    Route::get('jenis-pekerjaan-kk', [JenisPekerjaanKkController::class, 'index']);
    Route::get('jenis-pekerjaan-kk/{id}', [JenisPekerjaanKkController::class, 'showById']);
    Route::post('jenis-pekerjaan-kk', [JenisPekerjaanKkController::class, 'create']);
    Route::patch('jenis-pekerjaan-kk/update/{id}', [JenisPekerjaanKkController::class, 'updateById']);
    Route::delete('jenis-pekerjaan-kk/delete/{id}', [JenisPekerjaanKkController::class, 'deleteById']);
});
