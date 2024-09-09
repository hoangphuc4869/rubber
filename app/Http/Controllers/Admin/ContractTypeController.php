<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractType;

class ContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = ContractType::all();
        return view('admin.contract_type.index', compact('types'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = ContractType::all();
        return view('admin.contract_type.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $type = new ContractType;
        $type->fill($data);
        $type->save();
        
        return redirect()->route('contract-type.index')->with('success', 'Tạo mới thành công');
        
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
        $type = ContractType::findOrFail($id);

        return view('admin.contract_type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        
        $customer = ContractType::findOrFail($id);
        $customer->fill($data);
        $customer->save();
        
        return redirect()->route('contract-type.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ContractType::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('contract-type.index')->with('delete_success', 'Xóa thành công' );
    }
}