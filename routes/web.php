<?php

use App\Http\Controllers\Home;
use App\Http\Controllers\Item;
use App\Http\Controllers\PaketRab;
use App\Http\Controllers\Rab;
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

Route::get('/', [Home::class, 'index']);

Route::controller(Item::class)->group(function () {
    Route::get('/barang', 'index');
    Route::get('/barang/add', 'add');
    Route::get('/barang/edit/{id}', 'edit');
    Route::get('/barang/{id}', 'show');

    Route::post('/barang', 'store');
    Route::put('/barang/{id}', 'store');
    Route::delete('/barang/{id}', 'delete');
});

Route::controller(Rab::class)->group(function () {
    Route::get('/rab', 'index');
    Route::get('/rab/add', 'add');
    Route::get('/rab/edit/{id}', 'edit');
    Route::get('/rab/{id}', 'show');

    Route::post('/rab', 'store');
    Route::put('/rab/{id}', 'store');
    Route::delete('/rab/{id}', 'delete');
});

Route::controller(PaketRab::class)->group(function () {
    Route::get('/paket', 'index');
    Route::get('/paket/add', 'add');
    Route::get('/paket/edit/{id}', 'edit');
    Route::get('/paket/{id}', 'show');

    Route::post('/paket', 'store');
    Route::put('/paket/{id}', 'store');
    Route::delete('/paket/{id}', 'delete');
});
