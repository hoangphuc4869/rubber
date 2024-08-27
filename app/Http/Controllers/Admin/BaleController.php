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
}