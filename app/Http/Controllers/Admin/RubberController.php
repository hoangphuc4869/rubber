<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuringArea;
use App\Models\Farm;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Rubber;
use App\Models\Company;
use Illuminate\Support\Facades\Gate;

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

        $mu_dong_chen_crck = CuringArea::whereIn('code', ['NLNT1', 'NLNT2', 'NLNT3', 'NLNT6'])->sum('containing');
        $mu_dong_chen_bhck = CuringArea::whereIn('code', ['NLNT4', 'NLNT5', 'NLNT7', 'NLNT8'])->sum('containing');
        $mu_dong_chen_tm = CuringArea::whereIn('code', ['NLTM'])->sum('containing');
        $mu_dong_chen_tnsr = CuringArea::whereIn('code', ['NLTNSR'])->sum('containing');

        $mu_day_crck = CuringArea::whereIn('code', ['MDCR'])->sum('containing');
        $mu_day_bhck = CuringArea::whereIn('code', ['MDBH'])->sum('containing');
        $mu_day_tm = CuringArea::whereIn('code', ['NLTMMD'])->sum('containing');

        // dd($rubbers[0]);

        if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC') ) {
            return view('admin.rubber.index', compact('trucks', 'farms', 'curing_areas',
             'rubbers', 'companies', 'mu_dong_chen_crck',
              'mu_dong_chen_bhck','mu_dong_chen_tm', 'mu_dong_chen_tnsr'
              , 'mu_day_crck', 'mu_day_bhck' , 'mu_day_tm'));
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
        
        // dd($request->all());
        $data = $request->all();
        $rubber = new Rubber;

        $rubber->fill($data);
        $rubber->input_status = 1;
        $rubber->truck_name = '';
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

        if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC') ) {
            return view('admin.rubber.edit', compact('trucks', 'farms', 'curing_areas', 'rubbers', 'rubber'));
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
        // dd($data);

        if ($request->input('save_btn') === 'save') {
            $rubber = Rubber::findOrFail($id);
            $rubber->fill($data);
            $rubber->save();
            return redirect()->back()->with('success', 'Lưu thành công');
        } 
        elseif ($request->input('confirm_btn') === 'confirm') {
            $rubber = Rubber::findOrFail($id);
            $rubber->fill($data);

            if($rubber->input_status == 0){
                $rubber->curing_area->containing += $request->fresh_weight;
                $rubber->input_status = 1;
            }
            $rubber->save();

            
            $rubber->curing_area->save();
            return redirect()->back()->with('success', 'Xác nhận thành công');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Rubber::findOrFail($id);

        if($item) {
            if($item->input_status == 1){
                $item->curing_area->containing -= $item->fresh_weight;
                $item->curing_area->save();
                $item->input_status = 0;
            }
            $item->drc_percentage = null;
            $item->dry_weight = null;
            $item->material_age = null;
            $item->material_condition = null;
            $item->impurity_type = null;
            $item->grade = null;

            $item->save();

        }

        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        foreach ($items as $item) {
            $rubber = Rubber::findOrFail($item);
            if($rubber->input_status == 1) {
                $rubber->curing_area->containing -= $rubber->fresh_weight;
                $rubber->curing_area->save();
            }
           
            $rubber->delete();

        }
        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );

    }
}