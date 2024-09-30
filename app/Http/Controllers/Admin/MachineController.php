<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuringHouse;
use App\Models\Rolling;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\DrumPerDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ResetTime;
use Illuminate\Support\Facades\Gate;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        $houses_containing = CuringHouse::where('containing', '>' , 0)->get();
        $houses = CuringHouse::all();
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

        if (Gate::allows('hat') || Gate::allows('admin') ) {
            return view('admin.machine.index' , compact('houses_containing', 'reset', 'rollings', 'drums', 'drums_per_day_3tan', 'houses', 'drums_per_day_6tan', 'date', 'drums' ));

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
        $reset_time = ResetTime::first()->time; 
        list($resetHour, $resetMinute) = explode(':', $reset_time);

        $currentTime = Carbon::now();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

    
        if ($currentTime->hour < $resetHour || ($currentTime->hour == $resetHour && $currentTime->minute < $resetMinute)) {
            $date = $yesterday->format('Y/m/d');
        } else {
            $date = $today->format('Y/m/d');
        }

        $existingDrumsCount = Drum::whereDate('date', $date)->where('link', $request->input('link') )->count();

        
        $startNumber = $existingDrumsCount + 1;

        $drumsCount = $request->input('drums');

    
        for ($i = $startNumber; $i < $startNumber + $drumsCount; $i++) {
            $drum = new Drum();
            $drum->curing_house_id = $request->input('curing_house');
            $drum->link = $request->input('link');
            $drum->date = $date;
            // $drum->time = $request->input('time');
            $drum->impurity_removing = $request->input('impurity_removing');
            $drum->thickness = $request->input('thickness');
            $drum->trang_thai_com = $request->input('trang_thai_com');
            $drum->code = now()->timestamp . '_' . $request->input('link') . $i; 
            $drum->name = $i;
            $drum->rolling_code = $request->rolling_code;
            $drum->supervisor = Auth::user()->name;
            $drum->save();
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

        if($item) {
            $item->delete();
        }

        return redirect()->route('machining.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        // dd($items);

        foreach ($items as $item) {
           
            Drum::findOrFail($item)->delete();


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
        $drum = Drum::find($request->drum_id);
        $drum->link = $request->link;
        $drum->impurity_removing = $request->impurity_removing;
        $drum->thickness = $request->thickness;
        $drum->trang_thai_com = $request->trang_thai_com;
        $drum->save();

        return redirect()->back()->with('success', 'Chỉnh sửa thành công' );

    }


}