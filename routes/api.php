<?php

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\JenisItemController;
use App\Http\Controllers\Api\JenisRabController;
use App\Http\Controllers\Api\LaboratoriumController;
use App\Http\Controllers\Api\RabController;
use App\Http\Controllers\Api\SatuanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ItemController::class)->group(function () {
    Route::get('/items', 'index');
    Route::get('/items/show/{id}', 'show');
    Route::post('/items/store', 'store');
    Route::patch('/items/update/{id}', 'update');
    Route::delete('/items/delete/{id}', 'delete');
});

Route::controller(SatuanController::class)->group(function () {
    Route::get('/satuan', 'index');
    Route::get('/satuan/show/{id}', 'show');
    Route::post('/satuan/store', 'store');
    Route::patch('/satuan/update/{id}', 'update');
    Route::delete('/satuan/delete/{id}', 'delete');
});

Route::controller(JenisItemController::class)->group(function () {
    Route::get('/jenisitem', 'index');
    Route::get('/jenisitem/show/{id}', 'show');
    Route::post('/jenisitem/store', 'store');
    Route::patch('/jenisitem/update/{id}', 'update');
    Route::delete('/jenisitem/delete/{id}', 'delete');
});

Route::controller(JenisRabController::class)->group(function () {
    Route::get('/jenisrab', 'index');
    Route::get('/jenisrab/show/{id}', 'show');
    Route::post('/jenisrab/store', 'store');
    Route::patch('/jenisrab/update/{id}', 'update');
    Route::delete('/jenisrab/delete/{id}', 'delete');
});

Route::controller(LaboratoriumController::class)->group(function () {
    Route::get('/laboratorium', 'index');
    Route::get('/laboratorium/show/{id}', 'show');
    Route::post('/laboratorium/store', 'store');
    Route::patch('/laboratorium/update/{id}', 'update');
    Route::delete('/laboratorium/delete/{id}', 'delete');
});

Route::controller(RabController::class)->group(function () {
    Route::get('/rab', 'index');
    Route::get('/rab/show/{id}', 'show');
    Route::post('/rab/store', 'store');
    Route::post('/rab/exportrab', 'exportRab');
    Route::patch('/rab/update/{id}', 'update');
    Route::delete('/rab/delete/{id}', 'delete');
});
