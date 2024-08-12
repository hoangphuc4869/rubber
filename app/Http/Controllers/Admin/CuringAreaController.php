<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CuringArea;

class CuringAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curing_areas = CuringArea::all();
        return view('admin.curing_areas.index', compact('curing_areas'));
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
            'code' => 'required|unique:curing_areas,code',
            'name' => 'required|unique:curing_areas,name',
        ], [
            'code.required' => 'Mã bãi ủ không được để trống.',
            'code.unique' => 'Mã bãi ủ đã tồn tại.',
            'name.required' => 'Tên bãi ủ không được để trống.',
            'name.unique' => 'Tên bãi ủ đã tồn tại.',
        ]);

        $curing_area = new CuringArea;
        $curing_area->fill($data);
        $curing_area->save();

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
        $curing_area = CuringArea::findOrFail($id);
        $curing_areas = CuringArea::all();
        return view('admin.curing_areas.edit', compact('curing_area', 'curing_areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'code' => 'required|unique:curing_areas,code,'. $id ,
            'name' => 'required|unique:curing_areas,name,'. $id,
        ], [
            'code.required' => 'Mã bãi ủ không được để trống.',
            'code.unique' => 'Mã bãi ủ đã tồn tại.',
            'name.required' => 'Tên bãi ủ không được để trống.',
            'name.unique' => 'Tên bãi ủ đã tồn tại.',
        ]);

        $curing_area = CuringArea::findOrFail($id);
        $curing_area->fill($data);
        $curing_area->save();

        return redirect()->back()->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = CuringArea::findOrFail($id);

        if($item) {
            $item->delete();
        }

        return redirect()->route('curing_areas.index')->with('delete_success', 'Xóa thành công' );
    }
}