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


class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyName = 'B.H.C.K'; 
        
        $company = Company::where('code', $companyName)->first();

        
        if ($company) {
            $batches = $company->batches; 
        } else {
            $batches = collect(); 
        }

        $shipments = Shipment::whereHas('contract', function($query) {
            $query->where('supplier', 'BHCK');
        })->orderBy('id', 'desc')->get();

        // $shipments = Shipment::all();

        // dd($contracts);

        if (Gate::allows('khoBHCK') || Gate::allows('admin') ) {
            return view('admin.shipments.BHCK.index' , compact('batches', 'shipments', 'companyName'));
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
        return redirect()->route('shipments.index')->with('success', 'Xuất hàng thành công');
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

        $companyName = 'B.H.C.K'; 
        
        $company = Company::where('code', $companyName)->first();

        if ($company) {
            $batches = $company->batches->filter(function($batch) {
                return $batch->checked == 1 && $batch->exported == 0;
            });
        } else {
            $batches = collect();
        }

        $wares = Warehouse::whereIn('name', ['A1-BHCK', 'A2-BHCK', 'A3-BHCK', 'B1-BHCK', 'B2-BHCK', 'B3-BHCK','X3T-BHCK', 'X6T-BHCK'])
        ->orderBy('id', 'asc')
        ->get()
        ->groupBy('name'); 


        if (Gate::allows('khoBHCK') || Gate::allows('admin') ) {
            return view('admin.shipments.BHCK.edit' , compact('order', 'batches', 'wares', 'company'));
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

    public function updateField(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        
        $request->validate([
            'ma_xuat' => 'string|nullable',
            'ngay_xuat' => 'date|nullable',
            'ngay_nhan_hang' => 'date|nullable',
            'ngay_dong_cont' => 'date|nullable',
            'pdf' => 'file|mimes:pdf|nullable',
        ]);

        
        if ($request->has('ma_xuat')) {
            $shipment->ma_xuat = $request->input('ma_xuat');
        }
        if ($request->has('ngay_xuat')) {
            $shipment->ngay_xuat = $request->input('ngay_xuat');
        }
        if ($request->has('ngay_nhan_hang')) {
            $shipment->ngay_nhan_hang = $request->input('ngay_nhan_hang');
        }

        if ($request->has('ngay_dong_cont')) {
            $shipment->ngay_dong_cont = $request->input('ngay_dong_cont');
        }

        if ($request->has('so_hop_dong')) {  
            $shipment->so_hop_dong = $request->input('so_hop_dong');
        }

        if ($request->hasFile('pdf')) {
            
            if ($shipment->pdf) {
                $oldFilePath = public_path('contract_orders/' . $shipment->pdf);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); 
                }
            }

            $fileName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('contract_orders'), $fileName); 
            $shipment->pdf = $fileName;
        }

        $shipment->save();

        return response()->json(['success' => true]);
    }

    public function exportBatches(Request $request)
    {
        // dd($request->all());


      
        $shipmentId = $request->input('shipment_id');
        $batchAndBale = $request->input('batch_and_bale'); 

        $batchAndBaleArray = json_decode($batchAndBale, true);

        // dd($batchAndBaleArray);

        foreach ($batchAndBaleArray as $item) {
            $batch = Batch::where('batch_code', $item['batch_id'])->first();
            if($batch){
                $batch->banh_con_lai = $batch->bale_count - $item['bale_count'];
                $batch->user_id = $request->customer_id;

                $batch->exported = $batch->banh_con_lai == 0 ? 1 : 0;
                $batch->storage_location = $batch->warehouse ? $batch->warehouse->code : "";

                $warehouse = $batch->warehouse;

                if($warehouse && $batch->banh_con_lai == 0){
                    $warehouse->batch_id = null;
                    $warehouse->save();
                    
                    $batch->warehouse_id = null;


                }
                
                $batch->save();


                
                // dd($batch->warehouse, $batch);
            }
        }

        $shipment = Shipment::findOrFail($shipmentId);

        $shipment->lo_hang = $batchAndBaleArray;
        $shipment->status = 1;
        $shipment->save();


        if($request->com == 'BHCK'){
            return redirect()->route('shipments.index')->with('success', 'Xuất hàng thành công');
        }

        return redirect()->route('shipmentsCRCK2.index')->with('success', 'Xuất hàng thành công');

        
    }
}