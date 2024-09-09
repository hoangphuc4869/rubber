<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuringArea;
use App\Models\Farm;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Rubber;
use App\Models\Company;

class RubberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = Truck::all();
        $farms = Farm::all();
        $curing_areas = CuringArea::all();
        $companies = Company::all();
        $rubbers = Rubber::orderBy('date', 'desc')->get();
        // dd($rubbers[0]);
        return view('admin.rubber.index', compact('trucks', 'farms', 'curing_areas', 'rubbers', 'companies'));
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
        // dd($request->all());
        $data = $request->all();
        $rubber = new Rubber;

        $rubber->fill($data);
        $rubber->curing_area->containing += $request->fresh_weight;
        $rubber->curing_area->save();
        $rubber->save();
        
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
        $trucks = Truck::all();
        $farms = Farm::all();
        $curing_areas = CuringArea::all();
        $rubbers = Rubber::orderBy('date', 'desc')->get();
        $rubber = Rubber::findOrFail($id);
        return view('admin.rubber.edit', compact('trucks', 'farms', 'curing_areas', 'rubbers', 'rubber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $rubber = Rubber::findOrFail($id);
        
        $rubber->curing_area->containing -= $rubber->fresh_weight;
        $rubber->curing_area->containing += $request->fresh_weight;
        // dd($rubber->curing_area->containing,  $rubber->fresh_weight);
        $rubber->curing_area->save();
        $rubber->fill($data);
        $rubber->save();
        
        return redirect()->back()->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Rubber::findOrFail($id);

        if($item) {
            $item->curing_area->containing -= $item->fresh_weight;
            $item->curing_area->save();
            $item->delete();
        }

        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        foreach ($items as $item) {
            $rubber = Rubber::findOrFail($item);
            $rubber->curing_area->containing -= $rubber->fresh_weight;
            $rubber->curing_area->save();
            $rubber->delete();

        }
        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );

    }
}