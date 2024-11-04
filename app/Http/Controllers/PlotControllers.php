<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plot;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CodeImport;
use App\Models\Rubber;
use App\Exports\MissingRecordsExport;
use Illuminate\Support\Facades\Log;
use App\Models\Batch;
use App\Imports\BatchesImport;  

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PlotControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $plots = Plot::all();

        // Lấy danh sách tên cột từ bảng plots
        $columns = Schema::getColumnListing('plots');

        // Lọc các cột có tiền tố 'ns'
        $nsColumns = collect($columns)->filter(function($column) {
            return Str::startsWith($column, 'ns');
        });

        // Lấy dữ liệu của các cột `ns` từ tất cả các bản ghi
        $nsData = $plots->map(function($plot) use ($nsColumns) {
            return $plot->only($nsColumns->toArray());
        });

        dd($nsData);

        return view('admin.plots.index', compact('plots'));
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
        //
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

    public function import(Request $request)  
    {  
        // Xác thực tệp được tải lên  
        $request->validate([  
            'file' => 'required|mimes:xlsx,csv,xls',  
        ]);  

        // Nhập dữ liệu từ tệp  
        Excel::import(new BatchesImport, $request->file('file'));  

        return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công!');  
    }  



    public function queryPlots(Request $request)
    {

        $latcao = $request->lat_cao;

        $plots = Plot::where('farm_id', $request->farm)
            ->where('to_nt', $request->to_nt)
            ->where(function($query) use ($latcao) {
                foreach (explode(',', $latcao) as $val) {
                    $query->orWhere('lat_cao', 'like', '%' . trim($val) . '%');
                }
            })
            ->get();

        if ($plots->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No plots found',
            ]);
        }

        $rubber = Rubber::findOrFail($request->rubber_id);

        $syncData = [];
        foreach ($plots as $plot) {
            $syncData[$plot->id] = [
                'to_nt' => $plot->to_nt,
                'lat_cao' => $request->lat_cao
            ];
        }

        $rubber->plots()->attach($syncData);

        return response()->json([
            'success' => true,
            'plots' => $plots,
            'message' => 'Plots synced successfully!'
        ]);
    }

    public function removePlots(Request $request)
    {
    
        try {
            
            $rubber = Rubber::findOrFail($request->rubber_id);
            
            $plotIds = explode(',', $request->plot_id);

            $rubber->plots()->detach($plotIds);

            return response()->json([
                'success' => true,
                'message' => 'Plot(s) removed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove the plot: ' . $e->getMessage(),
            ]);
        }
    }

}