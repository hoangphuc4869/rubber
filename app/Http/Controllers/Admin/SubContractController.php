<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubContract;

class SubContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'acvn';
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
        // dd($request->all());
        $subContract = new SubContract();
        $subContract->contract_type_id = $request->contract_type_id;
        $subContract->customer_id = $request->customer_id;
        $subContract->contract_number = $request->contract_number;
        $subContract->contract_date = $request->contract_date;
        $subContract->thang_giao_hang = $request->thang_giao_hang;
        $subContract->san_pham = $request->san_pham;
        $subContract->loai_pallet = $request->loai_pallet;
        $subContract->thi_truong = $request->thi_truong;
        $subContract->don_vi_xuat_thuong_mai = $request->don_vi_xuat_thuong_mai;
        $subContract->ban_cho_ben_thu_3 = $request->ban_cho_ben_thu_3;
        $subContract->count_contract = $request->count_contract;
        $subContract->contract_id = $request->contract_id;

        if ($request->hasFile('file_scan_pdf')) {
            $file = $request->file('file_scan_pdf');
            $destinationPath = public_path('sub-contracts');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $subContract->file_scan_pdf = 'sub-contracts/' . $filename;
        }

        $subContract->save();

        return redirect()->back()->with('success', 'Cập nhật hợp đồng thành công!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
        $item = SubContract::findOrFail($id);

        if ($item) {

            if ($item->file_scan_pdf) {
                $filePath = public_path($item->file_scan_pdf);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $item->delete();
        }

        return redirect()->back()->with('delete_success', 'Xóa thành công');
    }

}