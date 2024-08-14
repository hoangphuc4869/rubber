<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuringArea;
use App\Models\CuringHouse;
use App\Models\Rolling;
use Illuminate\Http\Request;
use App\Models\Rubber;
use Illuminate\Support\Facades\DB;
use App\Models\Farm;

class RollingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Rubber::select('receiving_place_id')->distinct()->get();
        $dates = Rubber::select('date')->distinct()->get();
        $curing_houses = CuringHouse::all();

        $rollings = Rolling::all();
        return view('admin.rolling.index' , compact('areas', 'dates', 'curing_houses', 'rollings'));
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
        
        $data = $request->all();
        // dd($data);
        $area = CuringArea::findOrFail($data['curing_area']);
        $house = CuringHouse::findOrFail($data['curing_house']);
        // dd($house->code);
        
        $rubbers = Rubber::where('receiving_place_id', $area->id)->where('date', $data['date_curing'])->get();
        // dd($rubbers[0]);
        foreach ($rubbers as $rubber) {
            $rubber->status = 1;
            $rubber->save();
        }

        $command = new Rolling;
        $command->fill($data);
        $command->curing_house = $house->code;
        $command->curing_area = $area->code;
        $command->code =  $house->code . $area->code;
        $command->save();
        return redirect()->back()->with('success ','thành công');
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
        //
    }
}