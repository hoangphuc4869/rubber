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
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables; 

class RollingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = CuringArea::where('containing', '>', 0)
            ->whereNotIn('code', ['NLTMMD', 'MDCR', 'MDBH'])
            ->get();

        // dd(Rolling::orderBy('id', 'desc')->first()->rubbers()->first());

        $dates = Rubber::select('or_time')->where('input_status', 1)->distinct()->get();

        // dd($dates);
        $curing_houses = CuringHouse::all();
        $curing_areas = CuringArea::all();

        $cv_crck = CuringHouse::whereIn('code', ['NLCVNT1', 'NLCVNT2', 'NLCVNT3', 'NLCVNT6'])->sum('containing');
        $cv_bhck = CuringHouse::whereIn('code', ['NLCVNT4', 'NLCVNT5', 'NLCVNT7', 'NLCVNT8'])->sum('containing');
        $cv_tm = CuringHouse::whereIn('code', ['NLCVTM'])->sum('containing');
        $cv_tnsr = CuringHouse::whereIn('code', ['NLCVTNSR'])->sum('containing');

        $rollings = Rolling::all();

        if (Gate::allows('canvat') || Gate::allows('admin') ) {
            return view('admin.rolling.index' , compact('areas', 'dates', 'curing_houses', 'rollings', 'curing_areas', 'cv_crck', 'cv_bhck', 'cv_tm', 'cv_tnsr'));

        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

    }

    public function getDataCanvat(Request $request)
    {
        $canvat = Rolling::with(['house', 'area']) 
            ->select([
                'id',
                'date',               // Ngày gia công
                'code',               // Mã cán vắt
                'status',             // Trạng thái gia công
                'time',               // Thời gian gia công
                'curing_area_id',            // Mã khu vực
                'curing_house_id',           // Mã nhà ủ
                'weight_to_roll',      // Khối lượng cán vắt
                'date_curing',        // Ngày gia công ủ
                'timeRoll',       // Thời gian cán vắt
                'remaining',       // Thời gian cán vắt
                'location',       // Thời gian cán vắt
            ]);

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $canvat->where('date', $date);
        }

        if ($request->has('status') && $request->status !== null) {
            if ($request->status == 2) {
                $canvat->where('status', 0)->where('remaining', '>', 0);              
            } else if ($request->status == 0) {
                $canvat->where('status', $request->status)->where('remaining', null);   
            } else {
                $canvat->where('status', $request->status)->where('remaining', 0);   
            }
        }

        if ($request->has('area') && $request->area) {
            $canvat->where('curing_area_id', $request->area);
        }

        $result = $canvat->get();

        return DataTables::of($result)
            ->addColumn('house_code', function ($canvat) {
                return $canvat->house ? $canvat->house->code . ($canvat->location ? '-'.$canvat->location : "") : '';
            })
            ->addColumn('area_code', function ($canvat) {
                return $canvat->area ? $canvat->area->code : '';
            })
            ->editColumn('date', function ($canvat) {
                return \Carbon\Carbon::parse($canvat->date)->format('d-m-Y'); 
            })
            ->editColumn('time', function ($canvat) {
                return \Carbon\Carbon::parse($canvat->time)->format('H:i'); 
            })
            ->editColumn('date_curing', function ($canvat) {
                return \Carbon\Carbon::parse($canvat->date_curing)->format('d-m-Y'); 
            })

            
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->except('curing_house_id', 'curing_area_id', 'date_curing');

        // dd($request->all());
        
        $area = CuringArea::findOrFail($request->curing_area_id);
        

        if($request->weight_to_roll > $area->containing){
            return redirect()->back()->with('roll_fail', 'Khối lượng cán lớn hơn khối lượng hiện có. Vui lòng kiểm tra lại!');
        }
      
        $command = new Rolling;
        $command->fill($data);
        $command->curing_house_id = $request->curing_house_id;
        $command->curing_area_id = $request->curing_area_id;
        $command->date_curing = $request->date_curing;
        $command->location = $request->location;

        $command->code =  now()->timestamp;
        $command->save();

        $command->area->containing = max(0, $command->area->containing - $data['weight_to_roll']);
        $command->area->save(); 

        $command->house->containing = max(0, $command->house->containing + $data['weight_to_roll']);
        $command->house->save(); 

        $rubbers = Rubber::where('receiving_place_id', $area->id)->where('input_status', 1)->where('date', $request->date_curing)->get();

        foreach ($rubbers as $rubber) {
            $rubber->rubber_warehouse_id = $command->id;
            $rubber->save();
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
      
        // return redirect()->route('rolling.index')->with('delete_success', 'Xóa thành công');
    }

    public function delete_items(Request $request)
    {
        
        $items = explode(',', $request->drums);

        foreach ($items as $item) {
            $rubbers = Rubber::where('rubber_warehouse_id', $item)->get();
            foreach ($rubbers as $rubber) {

                $rubber->rubber_warehouse_id = null;
                $rubber->save();
            }
            $rolling = Rolling::findOrFail($item);
            
            if($rolling->status == 1 || $rolling->remaining > 0){

                return redirect()->back()->with('roll_fail', 'Nguyên liệu đã được sử dụng, không thể xóa!' );
               
            }
            else {
                $rolling->area->containing = $rolling->area->containing + $rolling->weight_to_roll;
                $rolling->house->containing = max(0, $rolling->house->containing - $rolling->weight_to_roll);
                $rolling->area->save();
                $rolling->house->save();
                $rolling->delete();
            }


        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );

    }
}