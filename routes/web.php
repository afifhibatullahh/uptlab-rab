<?php

use App\Http\Controllers\Api\SatuanController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Home;
use App\Http\Controllers\Item;
use App\Http\Controllers\JenisItem;
use App\Http\Controllers\JenisRab;
use App\Http\Controllers\Laboratorium;
use App\Http\Controllers\ManajemenUser;
use App\Http\Controllers\PaketRab;
use App\Http\Controllers\Rab;
use App\Http\Controllers\Satuan;
use App\Http\Middleware\isLogin;
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

Route::middleware([isLogin::class])->group(function () {
    Route::get('/login', [Auth::class, 'index'])->withoutMiddleware([isLogin::class]);
    Route::post('/login/auth', [Auth::class, 'login'])->withoutMiddleware([isLogin::class]);
    Route::get('/logout', [Auth::class, 'logout']);

    Route::get('/', [Home::class, 'index']);

    Route::controller(Item::class)->group(function () {
        Route::get('/item', 'index');
        Route::get('/item/{id}', 'show');
    });

    Route::controller(Satuan::class)->group(function () {
        Route::get('/satuan', 'index');
        Route::get('/satuan/{id}', 'show');
    });

    Route::controller(JenisItem::class)->group(function () {
        Route::get('/jenis', 'index');
        Route::get('/jenis/{id}', 'show');
    });

    Route::controller(JenisRab::class)->group(function () {
        Route::get('/jenisrab', 'index');
        Route::get('/jenisrab/{id}', 'show');
    });

    Route::controller(Laboratorium::class)->group(function () {
        Route::get('/laboratorium', 'index');
        Route::get('/laboratorium/{id}', 'show');
    });

    Route::controller(Rab::class)->group(function () {
        Route::get('/rab', 'index');
        Route::get('/rab/add', 'add');
        Route::get('/rab/{id}', 'show');
        Route::get('/rab/edit/{id}', 'edit');
    });

    Route::controller(PaketRab::class)->group(function () {
        Route::get('/paketrab', 'index');
        Route::get('/paketrab/add/', 'add');
        Route::get('/paketrab/{id}', 'show');
        Route::get('/paketrab/edit/{id}', 'edit');
    });

    Route::controller(ManajemenUser::class)->group(function () {
        Route::get('/users', 'users');
        Route::get('/user/add/', 'addUser');
        Route::post('/user/store/', 'storeUser');
        Route::delete('/user/delete/{id}', 'deleteUser');
        Route::get('/account', 'account');
        Route::get('/account/edit', 'editAccount');
        Route::post('/account/update', 'updateAccount');
        Route::post('/account/updatepassword', 'updatePassword');
    });
});
