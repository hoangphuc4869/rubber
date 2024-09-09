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

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        $houses = CuringHouse::all();
        $drums = Drum::orderBy('date', 'desc')->get();
        
        
        $drums_per_day_3tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 3)
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
        ->where('link', 6)
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $today = now()->format('d/m/Y');

        return view('admin.machine.index' , compact('rollings', 'drums', 'drums_per_day_3tan', 'houses', 'drums_per_day_6tan', 'today'));
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

        // dd($request->all());

        $house = CuringHouse::findOrFail($request->curing_house);

        if($request->weight_to_roll > $house->containing){
            return redirect()->back()->with('roll_fail', 'Khối lượng gia công lớn hơn khối lượng hiện có. Vui lòng kiểm tra lại!');
        }
        else {
            $house->containing = max(0, $house->containing - $request->weight_to_roll);
            $house->save();
        }

        $rollings = Rolling::where('curing_house_id', $request->curing_house)
                            ->where('status', '!=', 1)
                            ->orderby('id', 'asc')
                            ->get();

        $remainingWeight = $request->weight_to_roll;

        
        foreach ($rollings as $rolling) {
            
            $rolling->handled += $remainingWeight;

            if ($rolling->handled < $rolling->weight_to_roll) {
                $rolling->status = 2; 
                $remainingWeight = 0; 
            } else {
                $rolling->status = 1; 

                $remainingWeight = $rolling->handled - $rolling->weight_to_roll;
                
                $rolling->handled = $rolling->weight_to_roll;
                
            }

            $rolling->save();

            if ($remainingWeight <= 0) {
                break;
            }
        }


        // dd($house);


        $lastDrum = Drum::where('date', $data['date'])->where('link', $request->link)
                        ->orderBy('last_index', 'desc')
                        ->first();

        $startIndex = $lastDrum ? $lastDrum->last_index : 0;

    

        $numbers = range($startIndex + 1, $startIndex + $data['drums']);

        

        foreach ($numbers as $index => $item) {

            $drum = new Drum;
            $drum->name = $item;
            $drum->curing_house_id = $request->curing_house;
            $drum->last_index = $item;
            $drum->date = $data['date'];
            $drum->time = $data['time'];
            $drum->code = now()->timestamp . '_' .$request->link . $item;
            $drum->link = $request->link == 3 ? 3 : 6;
            $drum->supervisor = Auth::user()->name;
            $drum->impurity_removing = $data['impurity_removing'];
            $drum->thickness = $data['thickness'];
            $drum->trang_thai_com = $data['trang_thai_com'];
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