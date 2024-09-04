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

Route::get('/exported-list', [BatchController::class, 'list'])->name('exported-list');


Auth::routes();

Route::post('/change-location', [WarehouseController::class, 'change_location']);
Route::post('/delete-all', [BatchController::class, 'delete_all']);
Route::post('/export', [WarehouseController::class, 'export'])->name('wexport');

Route::delete('/delete-rubber-items', [RubberController::class, 'delete_items'])->name('rubber-delete-items');
Route::delete('/delete-rolling-items', [RollingController::class, 'delete_items'])->name('rolling-delete-items');
Route::delete('/delete-machining-items', [MachineController::class, 'delete_items'])->name('machining-delete-items');
Route::delete('/delete-heat-items', [HeatController::class, 'delete_items'])->name('heat-delete-items');
Route::delete('/delete-bale-items', [BaleController::class, 'delete_items'])->name('bale-delete-items');
Route::delete('/delete-batch-items', [BatchController::class, 'delete_items'])->name('batch-delete-items');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');