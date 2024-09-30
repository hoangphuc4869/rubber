<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Farm;
use Illuminate\Support\Facades\Gate;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = Truck::all();
        $farms = Farm::all();

        if (Gate::allows('nguyenlieu') || Gate::allows('admin') ) {
            return view('admin.trucks.index', compact('trucks', 'farms'));
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
            'code' => 'required|unique:trucks,code',
            'name' => 'required|unique:trucks,name',
            
        ], [
            'code.required' => 'Biển số xe không được để trống.',
            'code.unique' => 'Biển số xe đã tồn tại.',
            'name.required' => 'Tên xe không được để trống.',
            'name.unique' => 'Tên xe đã tồn tại.'
           
        ]);

        
        $truck = new Truck;
        $truck->fill($data);
        $truck->save();

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
        $truck = Truck::findOrFail($id);
        $trucks = Truck::all();
        $farms = Farm::all();

        if (Gate::allows('nguyenlieu') || Gate::allows('admin') ) {
            return view('admin.trucks.edit', compact('trucks', 'truck', 'farms'));
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
            'code' => 'required|unique:trucks,code',
            'name' => 'required|unique:trucks,name',
            
        ], [
            'code.required' => 'Biển số xe không được để trống.',
            'code.unique' => 'Biển số xe đã tồn tại.',
            'name.required' => 'Tên xe không được để trống.',
            'name.unique' => 'Tên xe đã tồn tại.'
           
        ]);


        
        $truck =  Truck::findOrFail($id);
        $truck->fill($data);
        $truck->save();

        return redirect()->back()->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Truck::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('trucks.index')->with('delete_success', 'Xóa thành công' );
    }
}