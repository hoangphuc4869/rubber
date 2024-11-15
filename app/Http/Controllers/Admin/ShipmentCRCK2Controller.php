<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Shipment;
use App\Models\Batch;
use Illuminate\Support\Facades\Gate;
use App\Models\Warehouse;

class ShipmentCRCK2Controller extends Controller
{
    public function index()
    {
        $companyName = 'C.R.C.K.2'; 
        
        $company = Company::where('code', $companyName)->first();

        
        if ($company) {
            $batches = $company->batches; 
        } else {
            $batches = collect(); 
        }

        $shipments = Shipment::whereHas('contract', function($query) {
            $query->where('supplier', 'CRCK2');
        })->orderBy('id', 'desc')->get();

        // $shipments = Shipment::all();

        // dd($contracts);

        if (Gate::allows('khoCRCK2') || Gate::allows('admin') ) {
            return view('admin.shipments.CRCK2.index' , compact('batches', 'shipments', 'companyName'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(explode(',', $request->input('batches')));
        $batchIds = explode(',', $request->input('batches')); 

        
        Batch::whereIn('id', $batchIds)->update(['exported' => 1,'shipment_id' => $request->shipment_id]);

        
        $batches = Batch::whereIn('id', $batchIds)->with('warehouse')->get();
        
        foreach ($batches as $batch) {
            if ($batch->warehouse) {
                $batch->warehouse->batch_id = null; 
                $batch->shipment->status = 1;
                $batch->shipment->save();
                $batch->warehouse->save();
            }
        }



        return redirect()->route('shipmentsCRCK2.index')->with('success', 'Xuất hàng thành công');
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
        $order = Shipment::findOrFail($id); 

        $companyName = 'C.R.C.K.2'; 
        
        $company = Company::where('code', $companyName)->first();

        if ($company) {
            $batches = $company->batches->filter(function($batch) {
                return $batch->checked == 1 && $batch->exported == 0;
            });
        } else {
            $batches = collect();
        }

        $wares = Warehouse::whereIn('name', ['A1', 'A2', 'A3', 'B1', 'B2', 'B3','X3T', 'X6T', 'BU6T'])
        ->orderBy('id', 'asc')
        ->get()
        ->groupBy('name'); 

        if (Gate::allows('khoCRCK2') || Gate::allows('admin') ) {
            return view('admin.shipments.CRCK2.edit' , compact('order', 'batches', 'wares','company'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        
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
        //
    }

    public function updateShipment(Request $request)
    {
        $item = Shipment::find($request->id); 
        if ($item) {
            $item->customer_status = $request->status;
            $item->note = $request->note;
            $item->save();
            return response()->json(['message' => 'Cập nhật thành công!']);
        }
        return response()->json(['message' => 'Không tìm thấy đơn hàng!'], 404);
    }
}