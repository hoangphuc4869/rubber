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


class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyName = 'BHCK'; 
        
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

        $companyName = 'BHCK'; 
        
        $company = Company::where('code', $companyName)->first();

        if ($company) {
            $batches = $company->batches;
        } else {
            $batches = collect();
        }

        if (Gate::allows('khoBHCK') || Gate::allows('admin') ) {
            return view('admin.shipments.BHCK.edit' , compact('order', 'batches'));
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
            'pdf' => 'file|mimes:pdf|max:2048|nullable',
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


}