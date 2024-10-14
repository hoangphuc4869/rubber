<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        if (Gate::allows('contractBHCK') || Gate::allows('contractCRCK2') || Gate::allows('admin') ) {
            return view('admin.customers.index', compact('customers'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        if (Gate::allows('contractBHCK') || Gate::allows('contractCRCK2') || Gate::allows('admin') ) {
            return view('admin.customers.create', compact('customers'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $customer = new Customer;
        $customer->fill($data);
        $customer->save();
        
        return redirect()->route('customers.index')->with('success', 'Tạo mới thành công');
        
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
        $customer = Customer::findOrFail($id);

        if (Gate::allows('contractBHCK') || Gate::allows('contractCRCK2') || Gate::allows('admin') ) {
            return view('admin.customers.edit', compact('customer'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        
        $customer = Customer::findOrFail($id);
        $customer->fill($data);
        $customer->save();
        
        return redirect()->route('customers.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $item = Customer::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('customers.index')->with('delete_success', 'Xóa thành công' );
    }
}