<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\MaterialController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [MaterialController::class, 'login']);



Route::get('/user', function (Request $request) {
    $users = User::all();
    return $request->all();
})->middleware('auth:sanctum');



Route::post('/insert-material', [MaterialController::class, 'insert'])->middleware('auth:sanctum');