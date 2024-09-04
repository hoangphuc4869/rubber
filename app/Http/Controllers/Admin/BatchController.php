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
        $drums_to_pack = Drum::where('batch_id', null)->where('baled' , 1)->get();
        $warehouses = Warehouse::all();
        $bales = Bale::all();

        $wares1 = Warehouse::where('stack', 1)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares2 = Warehouse::where('stack', 2)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares3 = Warehouse::where('stack', 3)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');
        $wares4 = Warehouse::where('stack', 4)->select('*')->orderBy('id', 'desc') ->get()->groupBy('name');

        // dd($bales_to_pack);

        $lastBatch = Batch::orderBy('batch_number', 'desc')->first();

        $startIndex = $lastBatch ? $lastBatch->batch_number : 0;
        return view('admin.batch.package', compact('drums', 'batches', 'drums_to_pack', 'startIndex', 'warehouses', 'wares1', 'wares2', 'wares3', 'wares4', 'bales'));
    }

    public function list()
    {
        $batches = Batch::where('exported', 1)->orderBy('date_export', 'desc')->get();
        return view('admin.batch.list', compact('batches'));
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

        $request->validate([
            'warehouse_id' => 'required'
        ]);
   
        $drums = $data['drums_to_pack'];
    
        $batch = new Batch;
        $batch->fill($data);
        $batch->batch_code = now()->timestamp . '_' .  sprintf('%03d', $data['batch_number']);
        // $batch->warehouse->batch_code = ;
        $batch->save();

        $warehouse = Warehouse::findOrFail($data['warehouse_id']);
        $warehouse->batch_id = $batch->id;
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $batch = Batch::findOrFail($id);

        if($batch) {
            // $warehouse->warehouse->status = 0;
            $batch->delete();
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);


        foreach ($items as $item) {
            Batch::findOrFail($item)->delete();
           
        }
        
        return redirect()->back()->with('delete_success', 'Xóa thành công' );

    }

}