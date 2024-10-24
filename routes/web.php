<?php

use App\Http\Controllers\Admin\BaleController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CertificatesController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ContractTypeController;
use App\Http\Controllers\Admin\CuringAreaController;
use App\Http\Controllers\Admin\CuringHouseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\HeatController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\RubberController;
use App\Http\Controllers\Admin\TruckController;
use App\Http\Controllers\Admin\RollingController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetTimeController;
use App\Models\Shipment;
use App\Models\User;
use App\Http\Controllers\Admin\ContractCRCK2Controller;
use App\Http\Controllers\Admin\ShipmentCRCK2Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlotControllers;
use App\Http\Controllers\Admin\ShipmentTNSRController;
use App\Http\Controllers\Admin\ContractTNSRController;
use App\Http\Controllers\Admin\SubContractController;
use App\Http\Controllers\Admin\ExportExcelController;


Route::middleware(['login'] )->group(function() {

    Route::get('/', [HomeController::class, 'index']);
    
    Route::resources([
        'farms' => FarmController::class,
        'companies' => CompanyController::class,
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
        'customers' => CustomerController::class,
        'contract' => ContractController::class,
        'contractCRCK2' => ContractCRCK2Controller::class,
        'contractTNSR' => ContractTNSRController::class,
        'contract-type' => ContractTypeController::class,
        'users' => UserController::class,
        'shipments' =>  ShipmentController::class,
        'shipmentsCRCK2' =>  ShipmentCRCK2Controller::class,
        'shipmentsTNSR' =>  ShipmentTNSRController::class,
        'plots' =>  PlotControllers::class,
        'sub-con' =>  SubContractController::class,
        'certificates' =>  CertificatesController::class,
    ]);
    

    
    

    


    Route::get('/list', [BatchController::class, 'list'])->name('list');

    Route::get('/BHCK/warehouses', [WarehouseController::class, 'index'])->name('warehouseBHCK');
    
    Route::get('/TNSR/warehouses', [WarehouseController::class, 'indexTNSR'])->name('warehouseTN');

    Route::get('/CRCK2/warehouses', [WarehouseController::class, 'indexCRCK'])->name('warehouseCRCK2');

    Route::delete('/shipment/{id}/destroy', [ContractController::class, 'shipment_destroy']);

    Route::post('/giao-ca', [HeatController::class, 'giaoCa'])->name('giao-ca');
    Route::post('/nhan-ca', [HeatController::class, 'nhanCa'])->name('nhan.ca');

    Route::put('/update-bale', [BaleController::class, 'updateB'])->name('update.bale');

    Route::post('/shipment/{id}/update', [ShipmentController::class, 'updateField']);

    Route::post('/adjust-dry-time', [HeatController::class, 'adjustDryTime'])->name('adjust-dry-time');





    
    
    // Route::get('/CRCR2/export', [ShipmentController::class, 'indexCRCK2'])->name('indexCRCK2');

    Route::get('/get-drum-details/{id}', [MachineController::class, 'getDrumDetails']);
    Route::post('/update-drum-details', [MachineController::class, 'updateDrumDetails']);


    Route::post('/update-drc', [RubberController::class, 'getDRCAndWeight'])->name('update.drc');

    Route::put('/update-bale', [BaleController::class, 'updateBales'])->name('update.bale');
    Route::delete('/reset-heat', [HeatController::class, 'heatReset'])->name('reset.drum');

    Route::get('/fill-excel', [ExportExcelController::class, 'fillExcel']);

    
    Route::get('/find', [BatchController::class, 'viewFindBatch'])->name('tracibility');
    
    Route::get('/find-batch', [BatchController::class, 'findBatch']);

    Route::get('/proxy/test', [BatchController::class, 'proxyApiTest']);



    Route::get('/get-nguyenlieu-data', [RubberController::class, 'getNguyenLieuData']);
    Route::get('/get-canvat-data', [RollingController::class, 'getDataCanvat']);
    Route::get('/get-giaconghat-data', [MachineController::class, 'getDataGiaconghat']);
    
    Route::get('/get-giacongnhiet-data', [HeatController::class, 'getDataNhiet']);
    Route::get('/get-giacongnhiet2-data', [HeatController::class, 'getDataNhiet2']);
    Route::get('/get-kho-data', [WarehouseController::class, 'getKhoData']);


    Route::get('/get-data-donggoi', [BatchController::class, 'getDataDongGoi']);
    Route::get('/get-data-donggoi2', [BatchController::class, 'getDataDongGoi2']);

    Route::get('/get-batch-list-data', [BatchController::class, 'getList']);


    Route::post('/import', [PlotControllers::class, 'import'])->name('import');

    Route::post('/query-plots', [PlotControllers::class, 'queryPlots']);
    Route::post('/remove-plots', [PlotControllers::class, 'removePlots'])->name('remove.plot');


    Route::get('/update-lots', [BatchController::class, 'updateLots']);

    


    

});

Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'handle_login'])->name('handle_login');



Route::get('/get-data', [HomeController::class, 'get_data']);
// Route::get('/createuser', [LoginController::class, 'createuser']);


Route::get('/forgot-password', [LoginController::class, 'forgotIndex'])->name('forgotIndex');
Route::post('/forgot-password', [LoginController::class, 'forgot'])->name('forgot');



Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




// Auth::routes();

Route::post('/change-location', [WarehouseController::class, 'change_location']);
Route::post('/store-location', [WarehouseController::class, 'store_location']);
Route::post('/delete-all', [BatchController::class, 'delete_all']);
Route::post('/export', [WarehouseController::class, 'export'])->name('wexport');

Route::delete('/delete-rubber-items', [RubberController::class, 'delete_items'])->name('rubber-delete-items');
Route::delete('/delete-rolling-items', [RollingController::class, 'delete_items'])->name('rolling-delete-items');
Route::delete('/delete-machining-items', [MachineController::class, 'delete_items'])->name('machining-delete-items');
Route::delete('/delete-heat-items', [HeatController::class, 'delete_items'])->name('heat-delete-items');
Route::delete('/delete-bale-items', [BaleController::class, 'delete_items'])->name('bale-delete-items');
Route::delete('/delete-batch-items', [BatchController::class, 'delete_items'])->name('batch-delete-items');

Route::post('/update-reset-time', [ResetTimeController::class, 'update']);

// Route::get('/update-lots', [ApiController::class, 'updateLots']);

Route::post('/update-contract-status', [ContractController::class, 'updateStatus']);

Route::post('/update-shipment', [ShipmentController::class, 'updateShipment']);


Route::post('/adjust-time', [HeatController::class, 'adjustTime'])->name('adjust-time');

Route::get('/export-excel', [ExportExcelController::class, 'index'])->name('export-excel');
Route::get('/download-excel', [ExportExcelController::class, 'export'])->name('download-excel');
Route::get('/download-tntl', [ExportExcelController::class, 'export_tntl'])->name('download-tntl');
Route::get('/download-cvtt', [ExportExcelController::class, 'export_cvtt'])->name('download-cvtt');
Route::get('/download-gchtt', [ExportExcelController::class, 'export_gchtt'])->name('download-gchtt');
Route::get('/download-gcntt', [ExportExcelController::class, 'export_gcntt'])->name('download-gcntt');
Route::get('/download-rl', [ExportExcelController::class, 'export_rl'])->name('download-rl');
Route::post('/download-bc', [ExportExcelController::class, 'export_bc'])->name('download-bc');

Route::get('/can-vat', [ExportExcelController::class, 'canVat'])->name('download-canVat');


Route::post('/u', [BatchController::class, 'u'])->name('u');










// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');