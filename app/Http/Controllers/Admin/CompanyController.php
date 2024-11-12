<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Gate;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        
        if (Gate::allows('nguyenlieu') || Gate::allows('admin') ) {
            return view('admin.companies.index', compact('companies'));
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
            'code' => 'required|unique:companies,code',
            'name' => 'required|unique:companies,name',
        ], [
            'code.required' => 'Mã công ty không được để trống.',
            'code.unique' => 'Mã công ty đã tồn tại.',
            'name.required' => 'Tên công ty không được để trống.',
            'name.unique' => 'Tên công ty đã tồn tại.',
        ]);

        $company = new Company;
        $company->fill($data);
        $company->save();

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
        $company = Company::findOrFail($id);
        $companies = Company::all();

        if (Gate::allows('nguyenlieu') || Gate::allows('admin') ) {
            return view('admin.companies.edit', compact('company', 'companies'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $data = $request->validate([
        //     'code' => 'required|unique:companies,code,'. $id ,
        //     'name' => 'required|unique:companies,name,'. $id,
        // ], [
        //     'code.required' => 'Mã bãi ủ không được để trống.',
        //     'code.unique' => 'Mã bãi ủ đã tồn tại.',
        //     'name.required' => 'Tên bãi ủ không được để trống.',
        //     'name.unique' => 'Tên bãi ủ đã tồn tại.',
        // ]);

        // $company = Company::findOrFail($id);
        // $company->fill($data);
        // $company->save();

        // return redirect()->back()->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $item = Company::findOrFail($id);

    //     if($item) {
    //         $item->delete();
    //     }

    //     return redirect()->route('companies.index')->with('delete_success', 'Xóa thành công' );
    // }
}