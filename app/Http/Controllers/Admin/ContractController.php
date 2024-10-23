<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Customer;
use App\Models\Shipment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::where('supplier', 'BHCK')->get();
        if (Gate::allows('admin') || Gate::allows('contractBHCK') ) {
            return view('admin.contract.BHCK.index', compact('contracts'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = ContractType::all();
        $customers = Customer::all();

        if (Gate::allows('admin') || Gate::allows('contractBHCK') ) {
            return view('admin.contract.BHCK.create', compact('types', 'customers'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('thang_giao_hang');

        $contract = new Contract;
        $contract->fill($data);
        
        $contract->supplier = 'BHCK';

       
        if ($request->has('thang_giao_hang')) {
            $contract->thang_giao_hang = json_encode($request->input('thang_giao_hang'));  
        }

        $contract->save();
        
        return redirect()->route('contract.index')->with('success', 'Tạo hợp đồng thành công!');
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
        $types = ContractType::all();
        $customers = Customer::all();
        
        $contract = Contract::findOrFail($id);

        $subContracts = $contract->subContracts();

        if (Gate::allows('admin') || Gate::allows('contractBHCK') ) {
            return view('admin.contract.BHCK.edit', compact('types', 'customers', 'contract', 'subContracts'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $id)
    {
        
        $contract = Contract::findOrFail($id);
        $contract->fill($request->all());
        $contract->save();

       
        $currentTotalAmount = $contract->shipments->sum('so_luong'); 
        $newTotalAmount = 0;

        
        if ($request->delivery_date) {
            foreach ($request->delivery_date as $delivery) {
                
                $newTotalAmount += $delivery['amount']; 
            }

            
            if (($currentTotalAmount + $newTotalAmount) > $request->count_contract) {
                return redirect()->back()->with(['exceed_count' => 'Tổng số lượng giao hàng vượt quá số lượng hợp đồng.']);
            }

            
            foreach ($request->delivery_date as $delivery) {
                $shipment = new Shipment;
                $shipment->ma_xuat = $delivery['shipping_order']; 
                $shipment->loai_hang = $delivery['type']; 
                $shipment->so_luong = $delivery['amount']; 
                // $shipment->so_hop_dong = $delivery['so_hop_dong'];
                $shipment->contract_id = $contract->id;

                
                if (isset($delivery['file']) && $delivery['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $delivery['file'];
                    $fileName = time() . '_' . $file->getClientOriginalName(); 
                    $file->move(public_path('contract_orders'), $fileName);
                    // $shipment->file_path = 'contract_orders/' . $fileName; 
                    $shipment->pdf = $fileName;
                }

                $shipment->ngay_xuat = $delivery['closing_date'];
                $shipment->ngay_nhan_hang = $delivery['receiving_date'];
                $shipment->save();
            }
        }

        return redirect()->back()->with('success', 'Cập nhật hợp đồng thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Contract::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('contract.index')->with('delete_success', 'Xóa thành công' );
    }

    public function shipment_destroy(string $id)
    {
        $item = Shipment::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }

    public function updateStatus(Request $request)
    {
        $contract = Contract::find($request->id);
        if ($contract) {
            $contract->trang_thai = $request->trang_thai;
            $contract->save();
            
            return response()->json(['message' => 'Cập nhật trạng thái thành công!']);
        }

        return response()->json(['message' => 'Hợp đồng không tồn tại!'], 404);
    }

    public function getSubContracts(Request $request)
    {
        $contract = Contract::findOrFail($request->contract_id);
        
        $subContracts = $contract->subContracts()->get(); 

        return response()->json([
            'contract' => $contract->contract_number,
            'subcontracts' => $subContracts,
        ]);
    }


}