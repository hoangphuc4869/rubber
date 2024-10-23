<?php

use App\Http\Controllers\Api\BatchFindApi;
use App\Http\Controllers\Api\LoginApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\MaterialController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [LoginApi::class, 'loginApi']);
Route::post('/logout', [LoginApi::class, 'logoutApi']);



Route::get('/user', function (Request $request) {
    $users = User::all();
    return $request->all();
})->middleware('auth:sanctum');



Route::post('/insert-material', [MaterialController::class, 'insert'])->middleware('auth:sanctum');
Route::get('/find-batch', [BatchFindApi::class, 'findBatch'])->name('batch.find');
// Route::get('/test-api', [BatchFindApi::class, 'proxyApiTest']);
Route::post('/test-api', [BatchFindApi::class, 'showData']);