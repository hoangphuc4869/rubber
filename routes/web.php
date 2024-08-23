<?php

use App\Http\Controllers\Admin\BaleController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CuringAreaController;
use App\Http\Controllers\Admin\CuringHouseController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\HeatController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\RubberController;
use App\Http\Controllers\Admin\TruckController;
use App\Http\Controllers\Admin\RollingController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('admin.home');
})->name('home');

Route::get('/material', function () {
    return view('admin.material');
})->name('material');

Route::resources([
    'farms' => FarmController::class,
    'trucks' => TruckController::class,
    'curing_areas' => CuringAreaController::class,
    'curing_houses' => CuringHouseController::class,
    'rubber' => RubberController::class,
    'rolling' => RollingController::class,
    'machining' => MachineController::class,
    'heat' => HeatController::class,
    'producing' => BaleController::class,
    'batch' => BatchController::class,
    'warehouse' => WarehouseController::class,
]);

Auth::routes();

Route::post('/change-location', [WarehouseController::class, 'change_location']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');