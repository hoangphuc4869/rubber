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
use Illuminate\Support\Facades\Auth;

class ContractCRCK2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::where('supplier', 'CRCK2')->get();

        if (Gate::allows('admin') ||  Gate::allows('contractCRCK2')) {
            return view('admin.contract.CRCK2.index', compact('contracts'));
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
        $customers = Customer::where('company', 'CRCK2')->get();

        if (Gate::allows('admin') ||  Gate::allows('contractCRCK2')   ) {
            return view('admin.contract.CRCK2.create', compact('types', 'customers'));
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
        
        $contract->supplier = 'CRCK2';


       
        if ($request->has('thang_giao_hang')) {
            $contract->thang_giao_hang = implode(',', $request->thang_giao_hang); 
        }

        if ($request->hasFile('file_scan_pdf')) {
            $file = $request->file('file_scan_pdf');
            $destinationPath = public_path('sub-contracts');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $contract->file_scan_pdf = 'sub-contracts/' . $filename;
        }

        $contract->save();
        return redirect()->route('contractCRCK2.index')->with('success', 'Tạo hợp đồng thành công!');
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
        $user = auth::user();

        $types = ContractType::all();
        $customers = Customer::where('company', 'BHCK')->get();

        
        $contract = Contract::findOrFail($id);

        $subContracts = Contract::where('sub', 1)->where('hd_goc_so', $contract->contract_number)->get();

        if (Gate::allows('admin') ||  Gate::allows('contractCRCK2')) {
            return view('admin.contract.CRCK2.edit', compact('types', 'customers', 'contract', 'subContracts'));
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

        if ($request->has('thang_giao_hang')) {
            $contract->thang_giao_hang = implode(',', $request->thang_giao_hang); 
        }

        if ($request->hasFile('file_scan_pdf')) {
            $file = $request->file('file_scan_pdf');
            $destinationPath = public_path('sub-contracts');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $contract->file_scan_pdf = 'sub-contracts/' . $filename;
        }
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
                $shipment->so_hop_dong = $delivery['so_hop_dong'];
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

        return redirect()->route('contractCRCK2.index')->with('delete_success', 'Xóa thành công' );
    }
}