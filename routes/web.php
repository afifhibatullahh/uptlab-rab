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
    Route::get('/item', 'index');
    Route::get('/item/{id}', 'show');
});

Route::controller(Rab::class)->group(function () {
    Route::get('/rab', 'index');
    Route::get('/rab/{id}', 'show');
});

Route::controller(PaketRab::class)->group(function () {
    Route::get('/paket', 'index');
    Route::get('/paket/{id}', 'show');
});
