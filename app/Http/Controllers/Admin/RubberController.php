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
use App\Models\Plot;

class RubberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // if ($request->ajax()) {
        //     $nguyenlieu = Rubber::query();
        //     return DataTables::of($nguyenlieu)->make(true); 
        // }

       
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


        $nguon_nguyen_lieu = Rubber::select('farm_name')->distinct()->orderBy('farm_name', 'asc')->get();

        
        if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC')) {
            return view('admin.rubber.index', compact(
                'trucks', 'farms', 'curing_areas', 'rubbers', 'companies',
                'mu_dong_chen_crck', 'mu_dong_chen_bhck', 'mu_dong_chen_tm', 'mu_dong_chen_tnsr',
                'mu_day_crck', 'mu_day_bhck', 'mu_day_tm', 'nguon_nguyen_lieu'
            ));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    public function getNguyenLieuData(Request $request)
    {
        
        $nguyenlieu = Rubber::with(['truck', 'farm.company', 'curing_area', 'plots'])
            ->select([
                'id',
                'time_ve',
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
                'note',
                'location'

            ]);

        // dd($request);
        
        if ($request->has('date') && $request->date) {
    
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

            $nguyenlieu->where(DB::raw("DATE(STR_TO_DATE(time_ve, '%d-%m-%Y %H:%i'))"), '=', $date);
        }

        if ($request->has('status') && $request->status !== null) {

            $nguyenlieu->where('input_status', $request->status);
        }

        if ($request->has('from') && $request->from !== null) {

            if($request->from == 'tm'){
                $nguyenlieu->where('farm_id', 9);
            }
            else {
                $nguyenlieu->where('farm_name', $request->from);
            }
        }

        if ($request->has('type') && $request->type !== null) {
            if($request->type == "mdc"){
                $nguyenlieu->whereNotIn('latex_type', ['MỦ DÂY','THU MUA MD']);
            }
            else {
                $nguyenlieu->whereIn('latex_type', ['MỦ DÂY','THU MUA MD']);
            }
        }

        // dd($nguyenlieu->first());


        $totalFreshWeight = $nguyenlieu->sum('fresh_weight');
        $totalDryWeight = $nguyenlieu->sum('dry_weight');

        $result = $nguyenlieu->get();
        
        return DataTables::of($result)
            ->addColumn('company_code', function ($nguyenlieu) {
                return $nguyenlieu->farm && $nguyenlieu->farm->company
                    ? $nguyenlieu->farm->company->code
                    : '';
            })
            ->addColumn('time_ve_date', function ($nguyenlieu) {
                return \Carbon\Carbon::parse($nguyenlieu->time_ve)->format('d-m-Y') ;
            })
            ->addColumn('time_ve_time', function ($nguyenlieu) {
                return \Carbon\Carbon::parse($nguyenlieu->time_ve)->format('H:i') ;
            })
            
             ->addColumn('sum_fresh', function ($nguyenlieu) use ($totalFreshWeight) {
                    return $totalFreshWeight;
                })

                ->addColumn('sum_dry', function ($nguyenlieu) use ($totalDryWeight) {
                    return $totalDryWeight;
                })
                ->addColumn('area_name', function ($nguyenlieu) {
                    if ($nguyenlieu->curing_area) {
                        return $nguyenlieu->curing_area->code . ($nguyenlieu->location ? "-" . $nguyenlieu->location : "");
                    }
                    return '';
                })
                ->addColumn('plots', function ($nguyenlieu) {
                    if ($nguyenlieu->plots && $nguyenlieu->plots->count()) {
                        $plotNumbers = $nguyenlieu->plots->pluck('tenlo')->toArray();
                        
                        // Limit the display to only the first 4 plots (2 per line)
                        $visiblePlots = array_slice($plotNumbers, 0, 4);
                        $displayText = implode(', ', $visiblePlots);
                        $remainingCount = count($plotNumbers) - 4;
                        
                        // Join the full list of plots and notes for the tooltip
                        $fullPlotsList = implode(', ', $plotNumbers);
                        $notes = $nguyenlieu->note;

                        // If more than 4 plots, add "..." and show full details in tooltip
                        if ($remainingCount > 0) {
                            $displayText .= '...';
                        }

                        // Return the truncated plots with a tooltip showing full details
                        return '<span class="plot-tooltip" data-toggle="tooltip" title="' . e($fullPlotsList) . '">'
                            . $displayText . '</span>';
                    }
                    return '';
                })
                ->rawColumns(['plots'])
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

        if (in_array($rubber->farm_id, [1, 2, 3, 4, 5, 6, 7, 8])) {

            $plots = Plot::where('farm_id', $rubber->farm_id)->get();
            
        } else {
            $plots = collect();
        }

        $groupedPlots = DB::table('plot_rubber')
            ->select('rubber_id', 'to_nt', 'lat_cao', DB::raw('GROUP_CONCAT(plot_id) as plot_ids'))
            ->where('rubber_id', $rubber->id) 
            ->groupBy('rubber_id', 'to_nt', 'lat_cao')
            ->get();

        // dd($groupedPlots);



        if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC') ) {
            return view('admin.rubber.edit', compact('trucks', 'farms', 'curing_areas', 'rubbers', 'rubber', 'plots', 'groupedPlots'));
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

        $rubber = Rubber::findOrFail($id);

        if($rubber->input_status !== 1){
            if ($request->input('save_btn') === 'save') {
                $rubber->fill($data);

                $rubber->input_status = 2; //trạng thái chờ thủ hko
                $rubber->save();
                return redirect()->route('rubber.index')->with('success', 'Lưu thành công');
            } 
            elseif ($request->input('confirm_btn') === 'confirm') {

                if(!$request->location){
                    return redirect()->back()->with('roll_fail', 'Vui lòng cập nhật vị trí');
                }
                $rubber->fill($data);

                
                $rubber->curing_area->containing += $request->dry_weight;
                $rubber->input_status = 1;
                
                
                $rubber->save();

                $rubber->curing_area->save();
                return redirect()->route('rubber.index')->with('success', 'Xác nhận thành công');
            }
            elseif ($request->input('deny_btn') === 'deny') {
                
                // $rubber->drc_percentage = null;
                // $rubber->dry_weight = null;
                // $rubber->material_age = null;
                // $rubber->material_condition = null;
                // $rubber->impurity_type = null;
                // $rubber->grade = null;
                // $rubber->note = null;

                $rubber->update_change += 1; 
                
                $rubber->input_status = 3; //trạng thái thông tin sai
                
                $rubber->save();
                
                return redirect()->route('rubber.index')->with('success', 'Yêu cầu thành công');
            }
        }
        else {
            return redirect()->route('rubber.index')->with('roll_fail', 'Không thể cập nhật mục này');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Rubber::findOrFail($id);

        if($item) {
            // if($item->input_status == 1){
            //     $item->curing_area->containing -= $item->dry_weight;
            //     $item->curing_area->save();
            //     $item->input_status = 0;
            // }
            // $item->drc_percentage = null;
            // $item->dry_weight = null;
            // $item->material_age = null;
            // $item->material_condition = null;
            // $item->impurity_type = null;
            // $item->grade = null;

            // $item->save();

        }

        return redirect()->route('rubber.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        foreach ($items as $item) {
            $rubber = Rubber::findOrFail($item);
            if($rubber->input_status == 1) {
                return redirect()->back()->with('roll_fail', 'Không thể xóa nguyên liệu đã được xác nhận!' );
            }
            
            $rubber->drc_percentage = null;
            $rubber->dry_weight = null;
            $rubber->material_age = null;
            $rubber->material_condition = null;
            $rubber->impurity_type = null;
            $rubber->grade = null;
            $rubber->note = null;

            $rubber->save();
            
            // $rubber->delete();

        }
        return redirect()->back()->with('delete_success', 'Xóa thông tin dữ liệu thành công' );

    }

    public function getDRCAndWeight(Request $request)
    {

        $ids = $request->selectedIds;
        $results = []; 

        foreach ($ids as $id) {
            $rubber = Rubber::findOrFail($id);

            if ($rubber && $rubber->input_status !== 1) {
                
                $drcPercentage = round($request->drc, 2);
                $rubber->drc_percentage = $drcPercentage;

                
                $dryWeight = round($rubber->fresh_weight * $drcPercentage / 100, 2);
                $rubber->dry_weight = $dryWeight;

                if ($request->filled('tuoingyenlieu')) {
                $rubber->material_age = $request->tuoingyenlieu;
                }
                if ($request->filled('tinhtrangnguyenlieu')) {
                    $rubber->material_condition = $request->tinhtrangnguyenlieu;
                }
                if ($request->filled('tapchat')) {
                    $rubber->impurity_type = $request->tapchat;
                }
                if ($request->filled('phanhang')) {
                    $rubber->grade = $request->phanhang;
                }
                if ($request->filled('ghichu')) {
                    $rubber->note = $request->ghichu;
                }

                $rubber->input_status = 2;
                $rubber->save();

                $results[] = [
                    'id' => $rubber->id,
                    'drc' => $drcPercentage,
                    'dry_weight' => $dryWeight,
                    'tuoingyenlieu' => $rubber->material_age, 
                    'tinhtrangnguyenlieu' => $rubber->material_condition, 
                    'tapchat' => $rubber->impurity_type, 
                    'phanhang' => $rubber->grade, 
                    'ghichu' => $rubber->note,
                    'status' => 'Chờ xác nhận'
                ];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chỉnh sửa mục này',
                ]);
            }
        }


        // dd($results);

        return response()->json([
            'success' => true,
            'message' => 'DRC và các thông số khác được cập nhật thành công',
            'results' => $results,
        ]);
    }


}