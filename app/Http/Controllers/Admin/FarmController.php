<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farms = Farm::all();
        $companies = Company::all();
        
        if (Gate::allows('nguyenlieu') || Gate::allows('admin')) {
            return view('admin.farms.index', compact('farms', 'companies'));
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
        
        $data = $request->validate([
            'code' => 'required|unique:farms,code',
            'name' => 'required|unique:farms,name',
            'company_id' => '',
        ], [
            'code.required' => 'Mã nông trường không được để trống.',
            'code.unique' => 'Mã nông trường đã tồn tại.',
            'name.required' => 'Tên nông trường không được để trống.',
            'name.unique' => 'Tên nông trường đã tồn tại.',
        ]);

        


        $farm = new Farm;
        $farm->fill($data);
        $farm->save();

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
        $farm = Farm::findOrFail($id);
        $farms = Farm::all();
        $companies = Company::all();


        if (Gate::allows('nguyenlieu') || Gate::allows('admin') ) {
            return view('admin.farms.edit', compact('farm', 'farms', 'companies'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'code' => 'required|unique:farms,code,' . $id,
            'name' => 'required|unique:farms,name,' . $id,
            'company_id' => '',
        ], [
            'code.required' => 'Mã nông trường không được để trống.',
            'code.unique' => 'Mã nông trường đã tồn tại.',
            'name.required' => 'Tên nông trường không được để trống.',
            'name.unique' => 'Tên nông trường đã tồn tại.',
        ]);

        $farm = Farm::findOrFail($id);
        $farm->fill($data);
        $farm->save();

        return redirect()->route('farms.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Farm::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('farms.index')->with('delete_success', 'Xóa thành công' );

    }
}