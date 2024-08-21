<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\Bale;
use App\Models\Batch;
use App\Models\Warehouse;

class BatchController extends Controller
{
    
    public function index()
    {
        $drums = Drum::where('status' , 1)->where('baled', null)->orderBy('date', 'desc')->get();
        $batches = Batch::all();
        $drums_to_pack = Drum::where('batch_id', null)->get();
        $warehouses = Warehouse::all();

        // dd($bales_to_pack);

        $lastBatch = Bale::orderBy('batch_number', 'desc')->first();

        $startIndex = $lastBatch ? $lastBatch->batch_number : 0;
        return view('admin.batch.package', compact('drums', 'batches', 'drums_to_pack', 'startIndex', 'warehouses'));
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
   
        $drums = $data['drums_to_pack'];
        

        $batch = new Batch;
        $batch->fill($data);
        $batch->batch_code = now()->timestamp . '_' .  sprintf('%03d', $data['batch_number']);
        $batch->save();

        $warehouse = Warehouse::findOrFail($data['warehouse_id']);
        $warehouse->status = 1;
        $warehouse->batch_code = $batch->batch_code;
        $warehouse->save();


        foreach ($drums as $drum) {
            $item = Drum::findOrFail($drum);
            $item->batch_id = $batch->id;
            $item->save();
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
        $batch = Batch::findOrFail($id);
        $warehouse = Warehouse::findOrFail($batch->warehouse->id);
        $warehouse->status = 0;
        $warehouse->batch_code = null;
        $warehouse->save();
        $batch->save();


        if($batch) {
            $batch->delete();
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }
}