<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wares1 = Warehouse::where('stack', 1)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares2 = Warehouse::where('stack', 2)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares3 = Warehouse::where('stack', 3)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares4 = Warehouse::where('stack', 4)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        return view('admin.warehouses.create', compact('wares1','wares2','wares3','wares4'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
           'name' => 'required|unique:warehouses,name'
        ],[
            'name.unique' => 'Kho đã tồn tại'
        ]);

        for($i = 1; $i <= 4; $i++){
            
            for ($row = 1; $row <= $request->rows; $row++) {
                
                for ($col = 1; $col <= 6; $col++) {
                    
                    $value = $request->name . '-' . $row . $col;

                    Warehouse::create([
                        'name' => $request->name,
                        'code' => $value,
                        'stack' => $i,
                    ]);
                }
            }
            
        }

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
        //
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
        $items = Warehouse::where('name', $id)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        return redirect()->back()->with('delete_success', 'Xóa thành công');
    }
}