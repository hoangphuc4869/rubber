<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\Bale;


class BaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drums = Drum::where('status' , 1)->where('baled', null)->orderBy('date', 'desc')->get();
        $bales = Bale::all();
        return view('admin.bales.index', compact('drums', 'bales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drums = Drum::where('status' , 1)->where('baled', null)->orderBy('date', 'desc')->get();
        $bales = Bale::all();
        $bales_to_pack = Bale::where('batch_code', null)->get();

        $lastBatch = Bale::orderBy('batch_number', 'desc')->first();

        $startIndex = $lastBatch ? $lastBatch->batch_number : 0;
        return view('admin.bales.package', compact('drums', 'bales', 'bales_to_pack', 'startIndex'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'drums.*' => 'nullable', 
            'drums' => ['required', function ($attribute, $value, $fail) {
                
                $filtered = array_filter($value, function ($item) {
                    return !empty($item);
                });
                if (empty($filtered)) {
                    $fail('fail' ,'Vui lòng chọn thùng từ bảng phía trên');
                }
            }],
        ]);


        $drums = explode(',', $data['drums'][0]);

        foreach ($drums as $drum) {
            
            $item = Drum::findOrFail($drum);
            $item->baled = 1;
            $item->save();
            $bale = new Bale;
            $bale->fill($data);
            $bale->drum_id = $item->id;
            $bale->save();
            
        }

        return redirect()->back()->with('success', 'Thành công');
    }

    public function store_batch(Request $request)
    {
        $data = $request->all();
      
        $drums = $data['drums_to_pack'];

        foreach ($drums as $drum) {
            
            $item = Bale::findOrFail($drum);
            
            $item->fill($data);

            $item->batch_code = now()->timestamp . '_' .  sprintf('%03d', $data['batch_number']);

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
        $bale = Bale::findOrFail($id);
        $item = Drum::findOrFail($bale->drum->id);
        if($item) {
            $item->baled = null;
            $item->save();
            $bale->delete();
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }

    public function destroy_batch(string $id)
    {
        $item = Bale::findOrFail($id);
        if($item) {
            $item->expected_grade = null;
            $item->batch_number = null;
            $item->batch_code = null;
            $item->sample_cut_number = null;
            $item->packaging_type = null;
            $item->storage_location = null;
            $item->save();
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }
}