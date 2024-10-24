<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuringHouse;
use App\Models\CuringArea;
use App\Models\Rolling;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\DrumPerDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ResetTime;
use Illuminate\Support\Facades\Gate;

use Yajra\DataTables\Facades\DataTables; 


class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::orderBy('date', 'asc')->get();
        $houses_containing = CuringHouse::where('containing', '>' , 0)->get();
        $houses = CuringHouse::all();
        $areas = CuringArea::whereIn('code', ['NLTMMD', 'MDBH', 'MDCR'])->get();

        // dd($areas);
        $reset = ResetTime::first();

        $drums = Drum::orderBy('date', 'desc')->get();

        
        
        
        $drums_per_day_3tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 3)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $drums_per_day_6tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 6)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $reset_time = ResetTime::first()->time; 
        list($resetHour, $resetMinute) = explode(':', $reset_time);

        $currentTime = Carbon::now();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

    
        if ($currentTime->hour < $resetHour || ($currentTime->hour == $resetHour && $currentTime->minute < $resetMinute)) {
            $date = $yesterday->format('d/m/Y');
        } else {
            $date = $today->format('d/m/Y');
        }


        $drums = Drum::all();

        if (Gate::allows('6t') || Gate::allows('admin')  || Gate::allows('3t')) {
            return view('admin.machine.index' , compact( 'areas', 'houses_containing', 'reset', 'rollings', 'drums', 'drums_per_day_3tan', 'houses', 'drums_per_day_6tan', 'date', 'drums' ));

        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        
    }

    public function getDataGiaconghat(Request $request)
    {
        $gchat = Drum::with(['bale', 'batches', 'rolling', 'curing_house']) 
            ->select([
                'id',
                'name',               
                'date',               
                'status',             
                'name',              
                'heated_start',            
                'link',          
                'thickness',     
                'trang_thai_com',        
                'impurity_removing',      
                'supervisor',       
                'rolling_code',       
                'curing_house_id',   
                'curing_area_id',   
                'location'    
            ]);

        // dd($request->date);

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $gchat->where('date', $date);
        }

        if ($request->has('area') && $request->area) {
            $gchat->where('curing_house_id', $request->area);
        }

        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'cho':
                    // Trạng thái Chờ xử lý nhiệt
                    $gchat->where('status', 0);
                    break;
                case 'da':
                    // Trạng thái Đã xử lý nhiệt
                    $gchat->where('status', 5)->whereDoesntHave('bale');
                    break;
                case 'dang':
                    // Trạng thái Đang xử lý nhiệt
                    $gchat->where('status', 1);
                    break;
                case 'giao':
                    // Trạng thái Giao ca
                    $gchat->where('status', 2);
                    break;
                case 'doi':
                    // Trạng thái Đổi ca
                    $gchat->where('status', 3);
                    break;
                case 'ep':
                    // Trạng thái Đã ép kiện
                    $gchat->where('status', 5)->whereHas('bale')->whereDoesntHave('batches');
                    break;
                case 'lo':
                    // Trạng thái Đã đóng lô
                    $gchat->where('status', 5)->whereHas('bale')->whereHas('batches');
                    break;
                default:
                    break;
            }
        }

        if ($request->has('link') && $request->link) {
            $gchat->where('link', $request->link);
        }

        // dd($gchat->rolling);

        return DataTables::of($gchat)
            ->addColumn('rolling_date', function ($gchat) {
                return $gchat->rolling ? \Carbon\Carbon::parse($gchat->rolling->date)->format('d-m-Y') : '';
            })
            ->addColumn('house_code', function ($gchat) {
                if($gchat->curing_house){
                    return $gchat->curing_house->code . ($gchat->location ? "-" . $gchat->location : "");
                }
                else {
                    return $gchat->curing_area->code . ($gchat->curing_area->location ? "-" . $gchat->location : "");
                }
            })
            // ->editColumn('date', function ($gchat) {
            //     return \Carbon\Carbon::parse($gchat->date)->format('d-m-Y'); 
            // })
            ->editColumn('heated_start', function ($gchat) {
                return $gchat->heated_start ? \Carbon\Carbon::parse($gchat->heated_start)->format('H:i') : ""; 
            })
            ->editColumn('date', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->date)->format('d-m-Y'); 
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
        $reset_time = ResetTime::first()->time; 
        list($resetHour, $resetMinute) = explode(':', $reset_time);

        // dd($request->all());

        $currentTime = Carbon::now();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

    
        if ($currentTime->hour < $resetHour || ($currentTime->hour == $resetHour && $currentTime->minute < $resetMinute)) {
            $date = $yesterday->format('Y/m/d');
        } else {
            $date = $today->format('Y/m/d');
        }

        $existingDrumsCount = Drum::whereDate('date', $request->date)->where('link', $request->input('link') )->count();

        
        $startNumber = $existingDrumsCount + 1;

        $drumsCount = $request->input('drums');
        
        if($request->curing_house == 11 || $request->curing_house == 21 || $request->curing_house == 22){
            $area = CuringArea::where('id', $request->curing_house )->first();
            // dd($area);
            if($area){
                if($request->weight > $area->containing) {
                    return redirect()->back()->with('roll_fail', 'Khối lượng gia công lớn hơn khối lượng hiện có');
                }
                $area->containing -= $request->weight;
                $area->save();

            }
        }

        for ($i = $startNumber; $i < $startNumber + $drumsCount; $i++) {

            $drum = new Drum();
            if($request->curing_house == 11 || $request->curing_house == 21 || $request->curing_house == 22){
                $drum->curing_area_id = $request->curing_house;
            }
            else {
                $drum->curing_house_id = $request->curing_house;
            }
            
            $drum->link = $request->input('link');
            $drum->date = $request->date;
            // $drum->time = $request->input('time');
            $drum->impurity_removing = $request->input('impurity_removing');
            $drum->thickness = $request->input('thickness');
            $drum->trang_thai_com = $request->input('trang_thai_com');
            $drum->code = now()->timestamp . '_' . $request->input('link') . $i; 
            $drum->name = $i;
            $drum->location = $request->location;
            $drum->rolling_code = $request->rolling_code;
            $drum->supervisor = Auth::user()->name;
            $drum->save();
        }

        if($request->rolling_code){
            $weight = Rolling::findOrFail($request->rolling_code);

            if($weight->remaining == null){
                $weight->remaining = $weight->weight_to_roll - $request->weight;
            }
            else {
                $weight->remaining -= $request->weight;
            }

            if($weight->remaining !== null && $weight->remaining == 0){
                $weight->status = 1;
            }
            
            $weight->save();

            $house = $weight->house;

            $house->containing -= $request->weight;
            
            $house->save();


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
        $item = Drum::findOrFail($id);

        if($item && $item->status ==0) {
            $item->delete();
        }

        return redirect()->route('machining.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        foreach ($items as $item) {
            
            $drum = Drum::findOrFail($item);
            if($drum && $drum->status == 0){
                $drum->delete();
            }
    

        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );

    }

    public function getDrumDetails($id)
    {
        $drum = Drum::find($id);
        return response()->json($drum);
    }

    
        


    public function updateDrumDetails(Request $request)
    {

        $drums = explode(',', $request->drumsEdit);

        foreach ($drums as $drumId) {
            $drum = Drum::find($drumId);

            // dd($drum->batches);

           if ($drum && $drum->batches()->count() == 0) {
                
                if ($request->filled('link')) {
                    $drum->link = $request->link;
                }

                // if ($request->filled('curing_house')) {
                //     $drum->curing_house_id = $request->curing_house;
                // }

                if ($request->filled('impurity_removing')) {
                    $drum->impurity_removing = $request->impurity_removing;
                }

                if ($request->filled('thickness')) {
                    $drum->thickness = $request->thickness;
                }

                if ($request->filled('trang_thai_com')) {
                    $drum->trang_thai_com = $request->trang_thai_com;
                }

                $drum->save();
            } else {
                return redirect()->back()->with('roll_fail', 'Không thể chỉnh sửa các thùng đã có lô');
            }
        }

        return redirect()->back()->with('success', 'Chỉnh sửa thành công');
    }



}