<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables; 


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();

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

    public function getCustomers(Request $request)
    {
        $query = Customer::query();

        if ($request->has('company') && !empty($request->company)) {
            $query->where('company', $request->company);
        }

        if ($request->has('loaiKH') && !empty($request->loaiKH)) {
            $query->where('type', $request->loaiKH);
        }

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return '<a href="/customers/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
                        <form action="/customers/' . $row->id . '" method="POST" style="display:inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->make(true);
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
        // dd($user->customer->contracts[0]->subcontracts);

        $users = $customer->users;

        if (Gate::allows('contractBHCK') || Gate::allows('contractCRCK2') || Gate::allows('admin') ) {
            return view('admin.customers.edit', compact('customer', 'users'));
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
        // dd($request->all());
        $customer = Customer::findOrFail($id);
        $customer->fill($data);
        $customer->save();

        // $request->validate([
        //     'acc_name' => 'required|string|max:255',
        //     'acc_email' => 'required|string|email|max:255|unique:users,email',
        //     'acc_password' => 'required',
        // ]);

        
        if($request->acc_name && $request->acc_email && $request->acc_password ){
            $user = User::create([
                'name' => $request->acc_name,
                'email' => $request->acc_email,
                'password' => bcrypt($request->acc_password), 
            ]);

            $user->type = 1;
            $user->customer_id = $customer->id;
            $user->save();
            
            $user->roles()->attach($request->roles);
        }
        
        return redirect()->back()->with('success', 'Cập nhật thành công');
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