<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AgamaController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\GolonganController;
use App\Http\Controllers\API\JabatanController;
use App\Http\Controllers\API\PegawaiController;
use App\Http\Controllers\API\PesananController;
use App\Http\Controllers\API\KeturunanController;
use App\Http\Controllers\API\PendidikanTerakhirController;
use App\Http\Controllers\API\SpotifyNotifController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\LikesController;
use App\Http\Controllers\API\RepliesController;
use App\Http\Controllers\API\NotificationsController;
use App\Http\Controllers\API\NotesController;

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

// produk
Route::get('produk', [ProdukController::class, 'index']);
Route::get('produk/{id}', [ProdukController::class, 'showById']);

// spotify notif w/o auth
Route::get('spotify-notif/active', [SpotifyNotifController::class, 'checkActive']);

// Notes w/o auth
Route::get('notes', [NotesController::class, 'index']);
Route::get('notes/{id}', [NotesController::class, 'showById']);
Route::post('notes', [NotesController::class, 'create']);
Route::patch('notes/update/{id}', [NotesController::class, 'updateById']);
Route::delete('notes/delete/{id}', [NotesController::class, 'deleteById']);

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

    // pesanan
    Route::get('pesanan', [PesananController::class, 'index']);
    Route::get('pesanan/cart', [PesananController::class, 'cart']);
    Route::get('pesanan/cart/count', [PesananController::class, 'countCart']);
    Route::post('pesanan/cart/add', [PesananController::class, 'addCart']);
    Route::post('pesanan/cart/process', [PesananController::class, 'processCart']);
    Route::post('pesanan/finish', [PesananController::class, 'finish']);
    Route::delete('pesanan/cart/delete/{id}', [PesananController::class, 'deleteCartById']);

    // spotify notif
    Route::get('spotify-notif', [SpotifyNotifController::class, 'index']);
    Route::post('spotify-notif', [SpotifyNotifController::class, 'create']);
    Route::get('spotify-notif/{id}', [SpotifyNotifController::class, 'showById']);
    Route::patch('spotify-notif/update/{id}', [SpotifyNotifController::class, 'updateById']);
    Route::post('spotify-notif/deactivate/{id}', [SpotifyNotifController::class, 'deactivateById']);

    // Posts
    Route::get('posts', [PostsController::class, 'index']);
    Route::get('posts/{user_id}', [PostsController::class, 'showByUserId']);
    Route::post('post', [PostsController::class, 'create']);
    Route::get('post/{id}', [PostsController::class, 'showById']);
    Route::patch('post/update/{id}', [PostsController::class, 'updateById']);
    Route::delete('post/delete/{id}', [PostsController::class, 'deleteById']);

    // Likes
    Route::post('likes/post/{id}', [LikesController::class, 'create']);
    Route::get('likes/post/{id}', [LikesController::class, 'showById']);
    Route::post('unlikes/post/{id}', [LikesController::class, 'deleteById']);

    // Replies
    Route::post('replies/post/{id}', [RepliesController::class, 'create']);
    Route::get('replies/post/{id}', [RepliesController::class, 'showById']);
    Route::delete('replies/delete/{id}', [RepliesController::class, 'deleteById']);

    // Notifications
    Route::get('notifications', [NotificationsController::class, 'index']);

});
