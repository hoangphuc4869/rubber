<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rolling;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\DrumPerDay;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        $drums = Drum::orderBy('date', 'desc')->get();
        
        
        $drums_per_day = Drum::select('date')
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

        return view('admin.machine.index' , compact('rollings', 'drums', 'drums_per_day'));
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

        $lastDrum = Drum::where('date', $data['date'])
                        ->orderBy('last_index', 'desc')
                        ->first();

        $startIndex = $lastDrum ? $lastDrum->last_index : 0;

        $numbers = range($startIndex + 1, $startIndex + $data['drums']);
        foreach ($numbers as $index => $item) {
            $rolling = Rolling::findOrFail($data['rolling_code']);
            $rolling->status = 1;
            $rolling->save();
            $drum = new Drum;
            $drum->rolling_code = $data['rolling_code'];
            $drum->name = $item;
            $drum->last_index = $item;
            $drum->date = $data['date'];
            $drum->time = $data['time'];
            $drum->code = $rolling->curing_house . $rolling->curing_area . '_' . now()->timestamp . '_' . sprintf('%03d', $item);
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
}