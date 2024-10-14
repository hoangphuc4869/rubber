<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\Bale;
use App\Models\Batch;
use Illuminate\Support\Facades\Gate;


class BaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drums = Drum::where('status' , 5)->where('baled', null)->orderBy('date', 'desc')->get();
        $bales = Bale::all();

        if (Gate::allows('6t') || Gate::allows('admin')  || Gate::allows('3t')) {
            return view('admin.bales.index', compact('drums', 'bales'));
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
        $data = $request->all();

        // dd($data);
        $request->validate([
            'drums.*' => 'nullable', 
            'drums' => ['required', function ($attribute, $value, $fail) {
                
                $filtered = array_filter(explode(',', $value), function ($item) {
                    return !empty($item);
                });
                if (empty($filtered)) {
                    $fail('fail' ,'Vui lòng chọn thùng từ bảng phía trên');
                }
            }],
        ]);


        $drums = explode(',', $data['drums']);

        foreach ($drums as $drum) {
            
            $item = Drum::findOrFail($drum);
            $item->baled = 1;
            $item->save();
            $bale = new Bale;
            $bale->fill($data);
            $bale->drum_id = $item->id;
            $bale->save();

            $item->bale_id = $bale->id;
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
    public function updateB(Request $request)
    {
        // dd($request->all());
        $bale = Drum::findOrFail($request->id)->bale;
        if ($bale) {
            $bale->number_of_bales = $request->bale_count;
            $bale->cut_check = $request->sample_cut;
            $bale->press_temperature = $request->pressing_temp;
            $bale->evaluation = $request->evaluation;
            $bale->save();
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->back()->with('error', 'Bale not found');
        }
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

    public function delete_items(Request $request)
    {
        
        $items = explode( ',', $request->drums);

        // dd($items);

        foreach ($items as $item) {
           
            $bale = Bale::find($item);
            $batch = Batch::find($bale->drum->batch_id);
            $drum = Drum::findOrFail($bale->drum->id);

            if($drum) {
                $drum->baled = null;
                // $drum->remaining_bales = 0;
                $drum->save();
                if($bale){
                    $bale->delete();
                }
                if($batch){
                    $batch->delete();
                }
                
            }
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );

    }

    public function updateBales(Request $request)
    {
        $ids = explode(',', $request->ids);

       
        $updatedBales = [];

        if ($ids) {
            foreach ($ids as $id) {
                $drum = Drum::findOrFail($id);

                if ($request->bale_count) {
                    $drum->bale->number_of_bales = $request->bale_count;
                }

                if ($request->sample_cut) {
                    $drum->bale->cut_check = $request->sample_cut;
                }

                if ($request->pressing_temp) {
                    $drum->bale->press_temperature = $request->pressing_temp;
                }

                if ($request->evaluation) {
                    $drum->bale->evaluation = $request->evaluation;
                }

                $drum->bale->save();

                $updatedBales[] = [
                    'id' => $drum->id,
                    'bale_count' => $drum->bale->number_of_bales,
                    'sample_cut' => $drum->bale->cut_check,
                    'pressing_temp' => $drum->bale->press_temperature,
                    'evaluation' => $drum->bale->evaluation,
                ];
            }


            return response()->json([
                'message' => 'Cập nhật thành công',
                'updated_bales' => $updatedBales
            ], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy bành'], 404);
        }
    }


    
}