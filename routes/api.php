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

Route::apiResource('user', 'UserController');
Route::apiResource('role', 'RoleController');

Route::group([
    'prefix' => 'auth', 'namespace' => 'Auth'
], function () {
    Route::post('register', 'RegisterController')->name('auth.register');
    Route::post('regenerate', 'RegenerateOtpController')->name('auth.regenerate');
    Route::post('verification', 'VerificationController')->name('auth.verification');
    Route::post('update-password', 'UpdatePasswordController')->name('auth.update-password');
    Route::post('login', 'LoginController')->name('auth.login');
    Route::post('logout', 'LogoutController')->name('auth.logout');
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('post', 'PostController');
    Route::apiResource('comment', 'CommentController');Route::apiResource('kategori', 'KategoriController');
    Route::apiResource('barang', 'BarangController');
    Route::apiResource('transaksi', 'TransaksiController');    
});

    

