<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\BhckWarehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Shipment;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $wares = Warehouse::whereIn('name', ['A1-BHCK', 'A2-BHCK', 'A3-BHCK', 'B1-BHCK', 'B2-BHCK', 'B3-BHCK','X3T-BHCK', 'X6T-BHCK'])
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('name'); 

        
        
        $warehouses = Warehouse::whereIn('name', ['A1-BHCK', 'A2-BHCK', 'A3-BHCK', 'B1-BHCK', 'B2-BHCK', 'B3-BHCK','X3T-BHCK', 'X6T-BHCK'])
        ->whereNull('batch_id')
            ->orderBy('id', 'asc')
            ->get();
            
        $customers = Customer::all();

        $companyName = 'BHCK'; 
        $company = Company::where('code', $companyName)->first();

        
        if ($company) {
            $batches = $company->batches()->orderBy('id', 'desc')->get(); 
        } else {
            $batches = collect(); 
        }

        
        $csr10_count = $company->batches()->where('expected_grade', 'CSR10')->sum('bale_count');

        // Đếm số lượng batch với expected_grade là CSR20
        $csr20_count = $company->batches()->where('expected_grade', 'CSR20')->sum('bale_count');



        $count = $batches->count();

        $total_bales = 0;

        foreach ($batches as $item) {
            $total_bales += $item->bale_count;
        }

        
        if (Gate::allows('khoBHCK') || Gate::allows('admin') ) {
            return view('admin.warehouses.index', compact('wares','batches', 'warehouses','customers', 'companyName', 'count', 'total_bales', 'csr10_count', 'csr20_count'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    public function indexCRCK()
    {
        
        $wares = Warehouse::whereIn('name', ['A1', 'A2', 'A3', 'B1', 'B2', 'B3','X3T', 'X6T'])
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('name'); 

        
        $warehouses = Warehouse::whereIn('name', ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'X3T', 'X6T'])
            ->whereNull('batch_id') 
            ->orderBy('id', 'asc')
            ->get();

        $customers = Customer::all();

        $companyName = 'CRCK2'; 
        $company = Company::where('code', $companyName)->first();

        
        if ($company) {
            $batches = $company->batches()->orderBy('id', 'desc')->get();
        } else {
            $batches = collect(); 
        }
        // dd($company->code, $warehouses);


        
        $csr10_count = $company->batches()->where('expected_grade', 'CSR10')->sum('bale_count');
        $csr20_count = $company->batches()->where('expected_grade', 'CSR20')->sum('bale_count');

        
        $count = $batches->count();

        $total_bales = 0;

        foreach ($batches as $item) {
            $total_bales += $item->bale_count;
        }

        if (Gate::allows('khoCRCK2') || Gate::allows('admin') ) {
            return view('admin.warehouses.index', compact('wares','batches', 'warehouses','customers', 'companyName', 'count', 'total_bales', 'csr10_count', 'csr20_count'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    public function indexTNSR()
    {
        
        $wares = Warehouse::whereIn('name', ['TNSR'])
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('name'); 

        
        $customers = Customer::all();

        $companyName = 'TNSR'; 
        $company = Company::where('code', $companyName)->first();

        
        if ($company) {
            $batches = $company->batches; 
        } else {
            $batches = collect(); 
        }

        $count = $batches->count();

        $warehouses = Warehouse::whereIn('name', ['TNSR'])
            ->orderBy('id', 'asc')
            ->get();
        
        $total_bales = 0;

        foreach ($batches as $item) {
            $total_bales += $item->bale_count;
        }
       

       
        $csr10_count = $company->batches()->where('expected_grade', 'CSR10')->sum('bale_count');
        $csr20_count = $company->batches()->where('expected_grade', 'CSR20')->sum('bale_count');

        
        if (Gate::allows('khoCRCK2') || Gate::allows('admin') ) {
            return view('admin.warehouses.index', compact('wares','batches', 'warehouses','customers', 'companyName', 'count', 'total_bales' , 'csr10_count', 'csr20_count'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // $request->validate([
        //    'name' => 'required|unique:warehouses,name'
        // ],[
        //     'name.unique' => 'Kho đã tồn tại'
        // ]);

            
            for ($row = 1; $row <= $request->rows; $row++) {
                
                for ($col = 1; $col <= 6; $col++) {
                    
                    $value = 'B3-' . $row . $col;

                    Warehouse::create([
                        
                        'name' => $request->name,
                        'code' => $value,
                    ]);
                }
            }
            
        

        return redirect()->back()->with('success', 'Thành công');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $items = Warehouse::where('name', $id)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        return redirect()->back()->with('delete_success', 'Xóa thành công');
    }


    public function change_location(Request $request) {  
        $validatedData = $request->validate([  
            'draggedItemId' => 'required|integer',  
            'targetItemId' => 'required|integer',  
        ]);  

        $draggedItemId = $validatedData['draggedItemId'];  
        $targetItemId = $validatedData['targetItemId'];  

        $draggedItem = Warehouse::find($draggedItemId);  
        $targetItem = Warehouse::find($targetItemId);  

        if ($draggedItem && $targetItem) {
            $batch = Batch::find($draggedItem->batch_id);

            if ($batch) {  
                if ($draggedItem->batch_id) {
                    $originalBatchId = $draggedItem->batch_id;
                    $draggedItem->batch_id = $targetItem->batch_id;
                    $targetItem->batch_id = $originalBatchId;

                    $batch->warehouse_id = $targetItem->id;

                    $targetItem->save();  
                    $batch->save();  
                    $draggedItem->save();  

                    return response()->json([
                        'success' => true,
                        'drag' => $draggedItem->batch_id,
                        'target' => $targetItem->batch_id
                    ]);  
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không có batch_id hợp lệ'
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy batch!'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy phần tử!'
            ], 404);  
        }  
    }

    public function store_location(Request $request) {  
        $batch_id = $request->batchId;  
        $lot_id = $request->slotId;  

        
        $batch = Batch::findOrFail($batch_id);  
        
        $targetItem = Warehouse::find($lot_id);  

        if ($targetItem) {  
            
            $oldWarehouseId = $batch->warehouse_id;  

           
            $batch->warehouse_id = $lot_id;   
            $batch->save();  

            
            $targetItem->batch_id = $batch_id;  
            $targetItem->save();  

            
            if ($oldWarehouseId !== $lot_id) {  
                $oldWarehouse = Warehouse::find($oldWarehouseId);  
                if ($oldWarehouse) {  
                    $oldWarehouse->batch_id = null; 
                    $oldWarehouse->save();  
                }  
            }  

            return response()->json([  
                'success' => true,  
                'message' => 'Lô đã được gán vào kho thành công!'  
            ]);  
        } else {  
            return response()->json([  
                'success' => false,  
                'message' => 'Không có batch_id để gán'  
            ], 400);  
        }  
    }

}