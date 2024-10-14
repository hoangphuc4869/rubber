<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drum;
use App\Models\Bale;
use App\Models\Batch;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Gate;
use App\Models\Company;
use App\Models\Rubber;
use App\Models\Plot;

use Illuminate\Support\Facades\Http;

class BatchController extends Controller
{
    
    public function index()
    {
        $drumsWithBatches = Drum::has('batches')->get();
        $drumsWithoutBatches = Drum::doesntHave('batches')->where('baled', 1)->get();


        $batches = Batch::all();

        $currentMonth = Carbon::now()->format('Y-m');

        $lastBatch = Batch::where('date', 'like', $currentMonth . '%')
                        ->orderBy('batch_number', 'desc')
                        ->first();

        $CRCK_batches = Batch::with('company')
            ->selectRaw('company_id, COUNT(*) as total_batches')
            ->where('company_id', 2)  
            ->where('date', 'like', $currentMonth . '%')
            ->groupBy('company_id')
            ->first();

        $BHCK_batches = Batch::with('company')
            ->selectRaw('company_id, COUNT(*) as total_batches')
            ->where('company_id', 1) 
            ->where('date', 'like', $currentMonth . '%')
            ->groupBy('company_id')
            ->first();    

        $TNSR_batches = Batch::with('company')
            ->selectRaw('company_id, COUNT(*) as total_batches')
            ->where('company_id', 8) 
            ->where('date', 'like', $currentMonth . '%')
            ->groupBy('company_id')
            ->first();      

        
        $startIndex = $lastBatch ? $lastBatch->batch_number : 0;

        if (Gate::allows('6t') || Gate::allows('admin') || Gate::allows('3t') ) {
            return view('admin.batch.package', compact('drumsWithoutBatches','drumsWithBatches', 'startIndex', 'CRCK_batches' , 'BHCK_batches' , 'TNSR_batches'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        
    }

    public function list()
    {
        $date = now(); 

        $month = $date->month; 
        $year = $date->year; 

        $batches = Batch::whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->get();

        // dd($batches);
        
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

        // dd($request);
        $requestedIds = explode(',', $request->drums[0]); 
        $ids = array_unique($requestedIds);

        // dd($ids); 

        $curing_house = Drum::findOrFail($ids[0])->curing_house;
        $curing_area = Drum::findOrFail($ids[0])->curing_area;
        // dd($curing_house);
        
        $ids_copy = array_unique($requestedIds);  

        $companyId = Company::where('code', $request->company)->first()->id;

        //  $incompleteBatch = Batch::where('company_id', $companyId)
        //         ->where('bale_count', '<', 144)
        //         ->whereMonth('created_at', Carbon::now()->month) 
        //         ->whereYear('created_at', Carbon::now()->year)  
        //         ->first();

        if($request->link == 3 ){

            $incompleteBatch = Batch::where('company_id', $companyId)
                ->where('bale_count', '<', 144)->where('link', 3)
                ->whereMonth('created_at', Carbon::now()->month) 
                ->whereYear('created_at', Carbon::now()->year)  
                ->first();
                
        }
        else {

            $incompleteBatch = Batch::where('company_id', $companyId)
                ->where('bale_count', '<', 144)->where('link', 6)
                ->whereMonth('created_at', Carbon::now()->month) 
                ->whereYear('created_at', Carbon::now()->year)  
                ->first();
                
        }

        // dd($incompleteBatch);

        if ($incompleteBatch) {
            $needed = 144 - $incompleteBatch->bale_count;
            $newDrums = [];  

            foreach ($ids as $key => $id) {  
                $drum = Drum::findOrFail($id);
                
                $incompleteBatch->bale_count += $drum->bale->number_of_bales;

                if ($incompleteBatch->bale_count > 144) {
                    $drum->remaining_bales = $incompleteBatch->bale_count - 144;
                } else {
                    $drum->remaining_bales = 0;
                    unset($ids[$key]); 
                }

                $drum->save();

                DB::table('batch_drum')->updateOrInsert(
                    [
                        'drum_id' => $drum->id, 
                        'batch_id' => $incompleteBatch->id,
                    ],
                    [
                        'bale_remaining' => $drum->remaining_bales,
                        'bale_count' => $drum->bale->number_of_bales - $drum->remaining_bales
                    ]
                );

                // dd($drum, $ids);


                if ($incompleteBatch->bale_count >= 144) {
                    $incompleteBatch->bale_status = 1; 
                    $incompleteBatch->bale_count = 144; 
                    break;
                }
            }

            $incompleteBatch->save();
        }

        // dd($incompleteBatch, $ids, $ids_copy);

        $currentMonth = Carbon::now()->format('Y-m');

        if($request->link == 3){
            
            $CRCK_batches = Batch::with('company')
            ->selectRaw('company_id, COUNT(*) as total_batches')
            ->where('company_id', 2)->where('link', 3)
            ->where('date', 'like', $currentMonth . '%')
            ->groupBy('company_id')
            ->first();

            $BHCK_batches = Batch::with('company')
                ->selectRaw('company_id, COUNT(*) as total_batches')
                ->where('company_id', 1)->where('link', 3)
                ->where('date', 'like', $currentMonth . '%')
                ->groupBy('company_id')
                ->first();   

            $TNSR_batches = Batch::with('company')
                ->selectRaw('company_id, COUNT(*) as total_batches')
                ->where('company_id', 8)->where('link', 3)
                ->where('date', 'like', $currentMonth . '%')
                ->groupBy('company_id')
                ->first();  
                
        } 

        if($request->link == 6){

             $CRCK_batches = Batch::with('company')
            ->selectRaw('company_id, COUNT(*) as total_batches')
            ->where('company_id', 2)->where('link', 6)
            ->where('date', 'like', $currentMonth . '%')
            ->groupBy('company_id')
            ->first();

            $BHCK_batches = Batch::with('company')
                ->selectRaw('company_id, COUNT(*) as total_batches')
                ->where('company_id', 1)->where('link', 6)
                ->where('date', 'like', $currentMonth . '%')
                ->groupBy('company_id')
                ->first();   

            $TNSR_batches = Batch::with('company')
                ->selectRaw('company_id, COUNT(*) as total_batches')
                ->where('company_id', 8)->where('link', 6)
                ->where('date', 'like', $currentMonth . '%')
                ->groupBy('company_id')
                ->first();
        }   

        $batch_number = 1;
        
        // $requestedIds = explode(',', $request->drums[0]);  
        $requiredRolls = 144;  
        if ($request->company == 'BHCK') {
            $batch_number = $BHCK_batches ? $BHCK_batches->total_batches + 1 : 1;
        } elseif ($request->company == 'CRCK2') {
            $batch_number = $CRCK_batches ? $CRCK_batches->total_batches + 1 : 1;
        } elseif ($request->company == 'TNSR') {
            $batch_number = $TNSR_batches ? $TNSR_batches->total_batches + 1 : 1;
        }
        
        $boxBatchData = []; 
        $remainingRolls = [];   
        
        $drums_with_company_and_largest_batch = Drum::whereHas('curing_house.curing_area.farm.company', function ($query) use ($request) {
            $query->where('code', $request->company);
        })
        ->where('link', $request->link) 
        ->with(['batches' => function ($query) {
            $query->orderByDesc('id');
        }])
        ->get();
        
        $drumIds = $drums_with_company_and_largest_batch->pluck('id');

        
        $batchDrumRecords = DB::table('batch_drum')
                            ->whereIn('drum_id', $drumIds)->where('bale_remaining', '>', 0)
                            ->get();

        $latestEntries = $batchDrumRecords->last();

        // dd($latestEntries);

        if($latestEntries){
            array_unshift($ids, $latestEntries->drum_id);
            $left_drum = Drum::findOrFail($latestEntries->drum_id);
            $left_drum->remaining_bales = $latestEntries->bale_remaining;
            $left_drum->save();
        }

        $remainData = [];

        // dd($ids,$ids_copy);

        foreach ($ids as $id) {  
            $drum = Drum::findOrFail($id);
            
            if ($drum->remaining_bales == 0) {
                $remaining = $drum->bale->number_of_bales;
            }
            else {
                $remaining = $drum->remaining_bales;
            }

            $remainingRolls[$id] = $remaining;
        }

        // dd($remainingRolls);


        $unprocessedIds = []; 
        $bale_count = 0; 

        while (true) {  
            $currentBatchRolls = 0;   
            $batchDrumData = [];
            $newBatchCreated = false;

            foreach ($ids as $id) {  
                $rollsAvailable = $remainingRolls[$id] ?? 0;   

                if ($rollsAvailable > 0) {  
                    if ($currentBatchRolls + $rollsAvailable >= $requiredRolls) {  
                        $neededRolls = $requiredRolls - $currentBatchRolls;  
                        $currentBatchRolls += $neededRolls;
                        $remainingRolls[$id] -= $neededRolls;

                        $batchDrumData[] = [  
                            'drum_id' => $id,
                            'bale_count' => $neededRolls,
                            'bale_remaining' => $remainingRolls[$id] ?? 0,
                        ];

                        $remainData[] = [  
                            'drum_id' => $id,
                            'bale_remaining' => $remainingRolls[$id] ?? 0,
                        ]; 

                        $newBatchCreated = true;

                        if ($currentBatchRolls >= $requiredRolls) { 
                            $currentBatch = new Batch;
                            $currentBatch->batch_code = date('y') . ($request->company == 'BHCK' ? '2' : ($request->company == 'TNSR' ? '3' : '1')) . $request->link . date('n') . $batch_number;
                            $currentBatch->expected_grade = $request->expected_grade;
                            $currentBatch->sample_cut_number = $request->sample_cut_number;
                            $currentBatch->packaging_type = $request->packaging_type;
                            $currentBatch->date = $request->date;
                            $currentBatch->link = $request->link;
                            $currentBatch->batch_number = $batch_number;  
                            $currentBatch->time = $request->time;
                            $currentBatch->company_id = Company::where('code', $request->company)->first()->id;  
                            $currentBatch->bale_count = $currentBatchRolls; 
                            $currentBatch->bale_status = $currentBatchRolls == $requiredRolls ? 1 : 0;
                            $currentBatch->save(); 

                            $bale_count += 144;

                            foreach ($batchDrumData as $data) {  
                                $boxBatchData[] = [  
                                    'batch_id' => $currentBatch->id,
                                    'drum_id' => $data['drum_id'],
                                    'bale_count' => $data['bale_count'],
                                    'bale_remaining' => $data['bale_remaining'],
                                ];
                            }  

                            $batch_number++; 
                            break 1;   
                        }  
                    } else {  
                        $currentBatchRolls += $rollsAvailable; 
                        // $remainData[] = [  
                        //     'drum_id' => $id,
                        //     'bale_remaining' => $remainingRolls[$id] ?? 0,
                        // ]; 
                        $remainingRolls[$id] = 0;

                        $batchDrumData[] = [  
                            'drum_id' => $id,  
                            'bale_count' => $rollsAvailable,  
                            'bale_remaining' => 0,
                        ];  
                    }  
                } else {
                
                    $unprocessedIds[] = $id;
                }
            }  

            if (!$newBatchCreated && $currentBatchRolls == 0) {  
                break;
            }
        }  
        
        if (!empty($boxBatchData)) {  
            DB::table('batch_drum')->insert($boxBatchData);  
        }

        foreach ($batchDrumData as $data) {
            DB::table('batch_drum')
                ->updateOrInsert(
                    [
                        'drum_id' => $data['drum_id'], 
                        'batch_id' => $data['batch_id']],
                    ['bale_remaining' => $data['bale_remaining']]
                );
        }


        $lastD = end($remainData);
        // dd($remainData);
        $drumsWithBatches = Drum::has('batches')->pluck('id')->toArray();
        $notInDrumsWithBatches = array_diff($unprocessedIds, $drumsWithBatches);

        if ($lastD && is_array($lastD)) {
            Drum::where('id', $lastD['drum_id'])->update(['remaining_bales' => $lastD['bale_remaining']]);
            if ($lastD['bale_remaining'] > 0) {      
                $notInDrumsWithBatches[] = $lastD['drum_id'];
            }
        }
        

        sort($notInDrumsWithBatches);

        // dd($notInDrumsWithBatches);

        $totalBales = 0;

        foreach ($notInDrumsWithBatches as $item) {
            $drum = Drum::findOrFail($item);

            
            $totalBales += $drum->remaining_bales > 0 ? $drum->remaining_bales : $drum->bale->number_of_bales;
            
            // $drum->remaining_bales = 0;
            $drum->save();


        }

        $newBatch = new Batch();
        $newBatch->batch_code = date('y') . ($request->company == 'BHCK' ? '2' : ($request->company == 'TNSR' ? '3' : '1')) . $request->link . date('n') . $batch_number;
        $newBatch->expected_grade = $request->expected_grade; 
        $newBatch->sample_cut_number = $request->sample_cut_number; 
        $newBatch->packaging_type = $request->packaging_type; 
        $newBatch->date = $request->date; 
        $newBatch->batch_number = $batch_number; 
        $newBatch->time = $request->time;
        $newBatch->link = $request->link;
        $newBatch->company_id = Company::where('code', $request->company)->first()->id;  
        $newBatch->bale_count = $totalBales; 
        $newBatch->bale_status = 0; 
        $newBatch->save();

        $bale_count += $newBatch->bale_count;

        
        foreach ($notInDrumsWithBatches as $item) {
            $drum = Drum::findOrFail($item);
            DB::table('batch_drum')->updateOrInsert(
                [
                    'drum_id' => $item,
                    'batch_id' => $newBatch->id 
                ],
                [
                    'bale_remaining' => 0, 
                    'bale_count' => $drum->remaining_bales > 0 ? $drum->remaining_bales : $drum->bale->number_of_bales
                ]
            );
            $drum->remaining_bales = 0;
        }

        
        if($curing_house){
            $remain = $curing_house->containing - ($bale_count * 35);

            $curing_house->containing -= $bale_count * 35;

            if ($curing_house->containing < 0) {
                $curing_house->containing = 0;
                $curing_house->exceed += abs($remain); 
            }

            $curing_house->save();
        }
        
        if($curing_area){
            $remain = $curing_area->containing - ($bale_count * 35);

            $curing_area->containing -= $bale_count * 35;

            if ($curing_area->containing < 0) {
                $curing_area->containing = 0;
                $curing_area->exceed += abs($remain);
            }

            $curing_area->save();
        }


        return redirect()->back()->with('success', 'Lô đã được tạo thành công ' . $bale_count);  
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
            foreach ($batch->drums as $drum) {
                $drum->remaining_bales = 0;
                $drum->save();
            }
            $batch->delete();
        }
        return redirect()->back()->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        $items = explode(',', $request->drums);

        

        foreach ($items as $item) {
            $batch = Batch::findOrFail($item);

            // $curing_house = $batch->drums[0]->curing_house;
            // $curing_area = $batch->drums[0]->curing_area;
            
            foreach ($batch->drums as $drum) {
                $drum->remaining_bales = 0;
                $drum->save(); 
            }

            // if($curing_house){
            //     $curing_house->containing += $batch->bale_count * 35;
            //     $curing_house->save();
            // }

            // if($curing_area){
            //     $curing_area->containing += $batch->bale_count * 35;
            //     $curing_area->save();
            // }
            $batch->delete();
        }
        
        return redirect()->back()->with('delete_success', 'Xóa thành công');
    }


    public function viewFindBatch()
    {
        return view('admin.batch.find');
    }



    public function findBatch(Request $request)
    {
        $batchCode = $request->input('batch_code');
        $batch = Batch::where('batch_code', $batchCode)->first();

        $response = [
            'Nhà máy sản xuất' => 'NHÀ MÁY CHẾ BIẾN MỦ STOUNG',
            'Công ty sản xuất' => 'Đang cập nhật',
            'Ngày sản xuất' => 'Đang cập nhật',
            'Khối lượng bành' => 35,
            'Khối lượng lô hàng' => 'Đang cập nhật',
            'Ngày cán vắt' => 'Đang cập nhật',
            'Nông trường' => 'Đang cập nhật',
            'Ngày tiếp nhận mủ' => 'Đang cập nhật',
            'Loại mủ' => 'Đang cập nhật',
            'Số xe' => '',
            'Số chuyến' => 'Đang cập nhật',
            'Tọa độ' => '',
            'plots' => [],
        ];

        if ($batch && isset($batch->drums[0])) {
            $farm = optional($batch->drums[0]?->rolling?->area->farm);
            $area = optional($batch->drums[0]?->rolling?->area);

            $type = ($area && !in_array($area->code, ['MDCR', 'MDBH', 'NLTMMD'])) ? "Mủ đông chén" : "Mủ dây";

            if ($farm) {
                $response['Công ty sản xuất'] = optional($batch->company)->name ?? 'Đang cập nhật';
                $response['Ngày sản xuất'] = Carbon::parse($batch->date)->format('d-m-Y');
                $response['Khối lượng lô hàng'] = $batch->bale_count * 35;
                $response['Nông trường'] = $farm->name ?? 'Đang cập nhật';
                $response['Ngày tiếp nhận mủ'] = $batch->drums[0]?->rolling ? Carbon::parse(optional($batch->drums[0]?->rolling)->date_curing)->format('d-m-Y') : "Đang cập nhật";
                $response['Loại mủ'] = $type;

                // Tìm các plots
                $plots = $farm->plots()->get()->map(function ($plot) {
                    return [
                        'id' => $plot->id,
                        'tenlo' => $plot->tenlo,
                        'namtrong' => $plot->namtrong,
                        'dientich' => $plot->dientich,
                        'giong' => $plot->giong,
                        'tongsocay' => $plot->tongsocay,
                        'cayhuuhieu' => $plot->cayhuuhieu,
                        'khonghuuhieu' => $plot->khonghuuhieu,
                        'hotrong' => $plot->hotrong,
                        'toado' => $plot->toado,
                    ];
                })->toArray();

                $response['plots'] = $plots;

                $rubbers = Rubber::where('date', $batch->drums[0]?->rolling?->date_curing)->get();
                $response['Số xe'] = $rubbers->where('farm_id', $farm->id)->pluck('truck_name')->isNotEmpty() ? $rubbers->where('farm_id', $farm->id)->pluck('truck_name') : '';
                $response['Số chuyến'] = $rubbers->where('farm_id', $farm->id)->count() > 0 ? $rubbers->where('farm_id', $farm->id)->count() : 'Đang cập nhật';

                $plot_map = "";
                if ($farm && $farm->id) {
                    switch ($farm->id) {
                        case 1:
                            $plot_map = 'https://experience.arcgis.com/experience/c7fd133ed2e040c7a1a4da2d87ff97cc';
                            break;
                        case 2:
                            $plot_map = 'https://experience.arcgis.com/experience/eb50e5662a3f48cfa87f084d46cd4c58';
                            break;
                        case 3:
                            $plot_map = 'https://experience.arcgis.com/experience/d9f79e22f99f4c6b8cb6fec7517ca266';
                            break;
                        case 4:
                            $plot_map = 'https://experience.arcgis.com/experience/38db7edf94864a1492c462a77cdaf2cd';
                            break;
                        case 5:
                            $plot_map = 'https://experience.arcgis.com/experience/288fad0b651641a8a4700c4a10d5673b';
                            break;
                        case 6:
                            $plot_map = 'https://experience.arcgis.com/experience/cd1da90d93594777b4047f06f0378f91';
                            break;
                        case 7:
                            $plot_map = 'https://experience.arcgis.com/experience/5091e52aaf154025afa43ec994c465f2';
                            break;
                        case 8:
                            $plot_map = 'https://experience.arcgis.com/experience/3600c167fe8f429caf6b7d625f57abbf';
                            break;
                        default:
                            $plot_map = '';
                    }
                }
                $response['Tọa độ'] = $plot_map;
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $response
        ]);
    }



    public function proxyApiTest(Request $request)
    {
        $batchCode = $request->input('code');
        $token = "30dd7d4f-bbd4-4c23-b7df-13e5a9e1055f"; 

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
        ])->get("https://kcs.chusekptrubber.vn/api/show-factory-code?factoryCode={$batchCode}");

       
        $data = $response->json();

       
        $result = [
            'date_request' => $data['results']['date_request'] ?? "Đang cập nhật",
            'date_test_end' => $data['results']['testing_result_svr']['date_test_end'] ?? "Đang cập nhật",
            'rank' => $data['results']['testing_result_svr']['rank'] ?? "Đang cập nhật",
            'status' => isset($data['results']['status']) 
                ? ($data['results']['status'] == 1 ? "Đạt" : ($data['results']['status'] == 0 ? "Không đạt" : "Chưa kiểm nghiệm")) 
                : "Đang cập nhật",

            'avg_dirt' => isset($data['results']['testing_result_svr']['avg_dirt']) 
                ? $data['results']['testing_result_svr']['avg_dirt'] 
                : "Đang cập nhật",

            'avg_ash' => isset($data['results']['testing_result_svr']['avg_ash']) 
                ? $data['results']['testing_result_svr']['avg_ash'] 
                : "Đang cập nhật",

            'avg_volatile' => isset($data['results']['testing_result_svr']['avg_volatile']) 
                ? $data['results']['testing_result_svr']['avg_volatile'] 
                : "Đang cập nhật",

            'avg_nitro' => isset($data['results']['testing_result_svr']['avg_nitro']) 
                ? $data['results']['testing_result_svr']['avg_nitro'] 
                : "Đang cập nhật",

            'avg_po' => isset($data['results']['testing_result_svr']['avg_po']) 
                ? $data['results']['testing_result_svr']['avg_po'] 
                : "Đang cập nhật",

            'avg_pri' => isset($data['results']['testing_result_svr']['avg_pri']) 
                ? $data['results']['testing_result_svr']['avg_pri'] 
                : "Đang cập nhật",
                
            'avg_viscosity' => isset($data['results']['testing_result_svr']['avg_viscosity']) 
                ? $data['results']['testing_result_svr']['avg_viscosity'] 
                : "Đang cập nhật",
        ];

        
        return response()->json($result, $response->status());
    }

    


    

    
}

 