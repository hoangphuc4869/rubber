<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
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
        // dd();
        $subContract = new Contract();

        $subContract->fill($request->all());
        $subContract->sub = 1;
        $subContract->save();

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