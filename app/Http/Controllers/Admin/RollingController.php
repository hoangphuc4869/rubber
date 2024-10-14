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
        // $command->date_curing = '2024/09/30';
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
        $item = Rolling::findOrFail($id);
        $rubbers = Rubber::where('status', $item->id)->get();

        if($item) {
            foreach ($rubbers as $rubber) {
                $rubber->status = 0;
                
                $rubber->save();
            }
            $item->area->containing += $item->weight_to_roll;
            $item->house->containing = max(0, $item->house->containing - $item->weight_to_roll);
            $item->area->save();
            $item->house->save();
            $item->delete();
        }
        return redirect()->route('rolling.index')->with('delete_success', 'Xóa thành công');
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        foreach ($items as $item) {
            $rubbers = Rubber::where('status', $item)->get();
            foreach ($rubbers as $rubber) {
                $rubber->status = 0;
                $rubber->save();
            }
            $rolling = Rolling::findOrFail($item);
            $rolling->area->containing = $rolling->area->containing + $rolling->weight_to_roll;
            $rolling->house->containing = max(0, $rolling->house->containing - $rolling->weight_to_roll);
            $rolling->area->save();
            $rolling->house->save();
            $rolling->delete();


        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );

    }
}