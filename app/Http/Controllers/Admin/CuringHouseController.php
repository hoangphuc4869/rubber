<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CuringHouse;

class CuringHouseController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curing_houses = CuringHouse::all();
        return view('admin.curing_houses.index', compact('curing_houses'));
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
            'code' => 'required|unique:curing_houses,code',
            'name' => 'required|unique:curing_houses,name',
        ], [
            'code.required' => 'Mã nhà ủ không được để trống.',
            'code.unique' => 'Mã nhà ủ đã tồn tại.',
            'name.required' => 'Tên nhà ủ không được để trống.',
            'name.unique' => 'Tên nhà ủ đã tồn tại.',
        ]);

        $curing_house = new CuringHouse;
        $curing_house->fill($data);
        $curing_house->save();

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
        $curing_house = CuringHouse::findOrFail($id);
        $curing_houses = CuringHouse::all();
        return view('admin.curing_houses.edit', compact('curing_house', 'curing_houses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'code' => 'required|unique:curing_houses,code,' . $id,
            'name' => 'required|unique:curing_houses,name,'. $id,
        ], [
            'code.required' => 'Mã nhà ủ không được để trống.',
            'code.unique' => 'Mã nhà ủ đã tồn tại.',
            'name.required' => 'Tên nhà ủ không được để trống.',
            'name.unique' => 'Tên nhà ủ đã tồn tại.',
        ]);

        $curing_house = CuringHouse::findOrFail($id);
        $curing_house->fill($data);
        $curing_house->save();

        return redirect()->back()->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = CuringHouse::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('curing_houses.index')->with('delete_success', 'Xóa thành công' );
    }
}