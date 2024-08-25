<?php

use App\Http\Controllers\ApiDataChart;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getData', [ApiDataChart::class, "getNumber"]);

Route::get('/bukuslug', [BukuController::class, "checkSlug"]);

Route::get('/kategorislug', [KategoriController::class, "checkSlug"]);