<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rolling;
use Illuminate\Http\Request;
use App\Models\Drum;


class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        return view('admin.machine.index' , compact('rollings'));
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
        $numbers = range(1, $data['drums']);
        foreach ($numbers as $index => $item) {
           $drum = new Drum;
           $drum->rolling_code = $data['rolling_code'];
           $drum->name = $index + 1;
           $drum->last_index = $index + 1;
           $drum->code = 'ma thung';
           $drum->date = $data['date'];
           $drum->time = $data['time'];
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
        //
    }
}