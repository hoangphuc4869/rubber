<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rolling;
use App\Models\Drum;

class HeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        $drums = Drum::where('status' , 1)->orderBy('date', 'desc')->get();
        
        
        $drums_per_day = Drum::where('status', 0)->select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        return view('admin.heat.index' , compact('rollings', 'drums', 'drums_per_day'));
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

        $drums = Drum::where('date', $data['drum_date'])->get();

        // dd($drums);


        foreach ($drums as $drum) {
           if($drum->status == 0){
            $drum->status = 1;
            $drum->heated_date = $data['date'];
            $drum->heated_time = $data['time'];
            $drum->save();
           }
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
            $item->heated_time = null;
            $item->heated_date = null;
            $item->status = 0;
            $item->save();
        }
        return redirect()->route('heat.index')->with('delete_success', 'Xóa thành công' );
    }
}