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
use Yajra\DataTables\Facades\DataTables; 
use Illuminate\Support\Facades\DB;

class RubberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $nguyenlieu = Rubber::query();
            return DataTables::of($nguyenlieu)->make(true); 
        }

       
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

        
        if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC')) {
            return view('admin.rubber.index', compact(
                'trucks', 'farms', 'curing_areas', 'rubbers', 'companies',
                'mu_dong_chen_crck', 'mu_dong_chen_bhck', 'mu_dong_chen_tm', 'mu_dong_chen_tnsr',
                'mu_day_crck', 'mu_day_bhck', 'mu_day_tm'
            ));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    public function getNguyenLieuData(Request $request)
    {
        
        $nguyenlieu = Rubber::with(['truck', 'farm.company', 'curing_area'])
            ->select([
                'id',
                DB::raw("DATE_FORMAT(STR_TO_DATE(time_ve, '%d-%m-%Y %H:%i:%s'), '%d/%m/%Y') as time_ve_date"),
                DB::raw("DATE_FORMAT(STR_TO_DATE(time_ve, '%d-%m-%Y %H:%i:%s'), '%H:%i') as time_ve_time"),
                'input_status',
                'status',
                'fresh_weight',
                'truck_name',
                'farm_name',
                'farm_id',
                'receiving_place_id',
                'latex_type',
                'tai_xe',
                'material_age',
                'drc_percentage',
                'dry_weight',
                'material_condition',
                'impurity_type',
                'grade',
                'note'

            ]);

        // dd($request);
        
        if ($request->has('date') && $request->date) {
    
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

            $nguyenlieu->where(DB::raw("DATE(STR_TO_DATE(time_ve, '%d-%m-%Y %H:%i'))"), '=', $date);
        }

        if ($request->has('status') && $request->status !== null) {

            $nguyenlieu->where('input_status', $request->status);
        }

        // dd($nguyenlieu->first());

        return DataTables::of($nguyenlieu)
            ->addColumn('company_code', function ($nguyenlieu) {
                return $nguyenlieu->farm && $nguyenlieu->farm->company
                    ? $nguyenlieu->farm->company->code
                    : '';
            })
            ->addColumn('area_name', function ($nguyenlieu) {
                return $nguyenlieu->curing_area
                    ? $nguyenlieu->curing_area->code
                    : '';
            })
            ->make(true);
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
        $rubber->curing_area->containing += $request->dry_weight;
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


            if ($rubber->input_status == 0) {
                $rubber->curing_area->containing += $request->dry_weight;
                $rubber->input_status = 1;
            }


            // if($rubber->input_status == 0) {

            //     $rubber->curing_area->containing += $request->dry_weight;
            //     $rubber->input_status = 1;
                
            // }
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
                $item->curing_area->containing -= $item->dry_weight;
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
                $rubber->curing_area->containing -= $rubber->dry_weight;
                $rubber->curing_area->save();
            }
           
            $rubber->delete();

        }
        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );

    }

    public function getDRCAndWeight(Request $request)
    {
        
        // dd($request->all());
        $ids = $request->ids;
        $results = []; 

        foreach ($ids as $id) {
           
            $rubber = Rubber::findOrFail($id);

            if ($rubber) {
                
                $drcPercentage = round($request->drc, 2);
                $rubber->drc_percentage = $drcPercentage;

                
                $dryWeight = round($rubber->fresh_weight * $drcPercentage / 100, 2);
                $rubber->dry_weight = $dryWeight;

                $rubber->save();

                $results[] = [
                    'id' => $rubber->id,
                    'drc' => $drcPercentage,
                    'dry_weight' => $dryWeight,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'DRC updated successfully!',
            'results' => $results, 
        ]);
        
    }

}