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

        // // Lấy danh sách tên cột từ bảng plots
        // $columns = Schema::getColumnListing('plots');

        // // Lọc các cột có tiền tố 'ns'
        // $nsColumns = collect($columns)->filter(function($column) {
        //     return Str::startsWith($column, 'ns');
        // });

        // // Lấy dữ liệu của các cột `ns` từ tất cả các bản ghi
        // $nsData = $plots->map(function($plot) use ($nsColumns) {
        //     return $plot->only($nsColumns->toArray());
        // });

        // dd($nsData);

        return view('admin.plots.index', compact('plots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.plots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->all();

        // Tạo một đối tượng Plot mới
        $plot = new Plot();

        // Gán dữ liệu vào đối tượng
        $plot->tenlo = $data['tenlo'];
        $plot->farm_id = $data['farm_id'];
        $plot->dientich = $data['dientich'];
        $plot->giong = $data['giong'];
        $plot->hangdat = $data['hangdat'];
        $plot->namtrong = $data['namtrong'];
        $plot->namcao = $data['namcao'];
        $plot->tongcaycao = $data['tongcaycao'];
        $plot->matdocaycao = $data['matdocaycao'];
        $plot->tong_kmc = $data['tong_kmc'];
        $plot->to_nt = $data['to_nt'];
        $plot->lat_cao = $data['lat_cao'];
        $toado = explode(',', $request->input('toado'));
        $plot->x = isset($toado[0]) ? $toado[0] : "";
        $plot->y = isset($toado[1]) ? $toado[1] : "";
        

        for ($year = 2017; $year <= 2023; $year++) {
            $plot->{'ns' . $year} = $data['ns' . $year];
        }


        $plot->geojson = $data['geojson'];

        
        $plot->save();

        return redirect()->back()->with('success', 'Thêm mới lô thành công!');
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
        $plot = Plot::findOrFail($id);

        return view('admin.plots.edit', compact('plot'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $plot = Plot::find($id);

        if ($plot) {

            $plot->tenlo = $request->input('tenlo');
            $plot->farm_id = $request->input('farm_id');
            $plot->dientich = $request->input('dientich');
            $plot->giong = $request->input('giong');
            $plot->hangdat = $request->input('hangdat');
            $plot->namtrong = $request->input('namtrong');
            $plot->namcao = $request->input('namcao');
            $plot->tongcaycao = $request->input('tongcaycao');
            $plot->matdocaycao = $request->input('matdocaycao');
            $plot->tong_kmc = $request->input('tong_kmc');
            $plot->to_nt = $request->input('to_nt');
            $plot->lat_cao = $request->input('lat_cao');
            
            $toado = explode(',', $request->input('toado'));
            $plot->x = isset($toado[0]) ? $toado[0] : "";
            $plot->y = isset($toado[1]) ? $toado[1] : "";

            $plot->ns2017 = $request->input('ns2017');
            $plot->ns2018 = $request->input('ns2018');
            $plot->ns2019 = $request->input('ns2019');
            $plot->ns2020 = $request->input('ns2020');
            $plot->ns2021 = $request->input('ns2021');
            $plot->ns2022 = $request->input('ns2022');
            $plot->ns2023 = $request->input('ns2023');
            
            $plot->geojson = $request->input('geojson');

            $plot->save();

            
            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } else {
            
            return redirect()->back()->with('error', 'Không tìm thấy lô để cập nhật!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plot = Plot::find($id);

        if($plot) {
            $plot->delete();
        }

        return redirect()->back()->with('success', 'Xóa thành công!');

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