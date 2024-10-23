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
use Yajra\DataTables\Facades\DataTables; 


use Illuminate\Support\Facades\Http;

class BatchController extends Controller
{
    
    public function index()
    {
        $drumsWithBatches = Drum::has('batches')->get();
        $drumsWithoutBatches = Drum::doesntHave('batches')->where('baled', 1)->get();


        $batches = Batch::all();

        // dd($drumsWithoutBatches[0]->rolling->area);

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

    public function getDataDongGoi(Request $request)
    {
        $donggoi = Drum::with(['bale', 'batches', 'rolling'])
            ->whereIn('status', [5])
            ->whereHas('bale')
            ->doesntHave('batches')
            ->select([
                'id',
                'name',               
                'date',               
                'status',             
                'heated_start',            
                'heated_date',            
                'heated_end',               
                'temp',               
                'temp2',               
                'time_to_dry',             
                'rolling_code',             
                'link',          
                'note',          
                'state',          
                'validation',          
                'oven',
                'curing_house_id',        
                'curing_area_id',        
                'supervisor',     
                'thickness',     
                'trang_thai_com',     
                    
            ]);

        // dd($donggoi->get());

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $donggoi->whereDate('heated_date', $date);
        }

        if ($request->has('link') && $request->link) {
            $donggoi->where('link', $request->link);
        }

        if ($request->has('company') && $request->company) {
            $companyCode = $request->company;

            $donggoi->whereHas('rolling.area.farm.company', function ($query) use ($companyCode) {
                $query->where('code', $companyCode);
            })
            ->orWhereHas('curing_area.farm.company', function ($query) use ($companyCode) {
                $query->where('code', $companyCode);
            });
        }

        

        // dd($donggoi->rolling);

        return DataTables::of($donggoi)
            ->addColumn('status', function ($donggoi) {
                return "Đã ép kiện";
            })
            ->addColumn('bale_number', function ($donggoi) {
                return $donggoi->bale->number_of_bales;
            })
            ->addColumn('remain', function ($donggoi) {
                return $donggoi->remaining_bales > 0 ? $donggoi->remaining_bales : $donggoi->bale?->number_of_bales;
            })
            ->addColumn('press_temperature', function ($donggoi) {
                return $donggoi->bale->press_temperature;
            })
            ->addColumn('weight', function ($donggoi) {
                return $donggoi->bale->weight;
            })
            ->addColumn('cut_check', function ($donggoi) {
                return $donggoi->bale->cut_check;
            })
            ->addColumn('evaluation', function ($donggoi) {
                return $donggoi->bale->evaluation;
            })
            ->addColumn('company', function ($donggoi) {
                return $donggoi->rolling 
                ? ($donggoi->curing_house ? $donggoi->curing_house->curing_area->farm->company->code : "") 
                : ($donggoi->curing_area ? $donggoi->curing_area->farm->company->code : "");
            })
            
            ->editColumn('heated_end', function ($donggoi) {
                return $donggoi->heated_end ? \Carbon\Carbon::parse($donggoi->heated_end)->format('H:i') : ""; 
            })
            // ->editColumn('heated_date', function ($donggoi) {
            //     return $donggoi->heated_date ? \Carbon\Carbon::parse($donggoi->heated_date)->format('d/m/Y') : ""; 
            // })
            ->editColumn('date', function ($donggoi) {
                return $donggoi->heated_date ? \Carbon\Carbon::parse($donggoi->heated_date)->format('d-m-Y') : "";
            })
            ->make(true);
    }

    public function getDataDongGoi2(Request $request)
    {
        $donggoi = Drum::with(['bale', 'batches', 'rolling'])
            ->whereHas('batches')
            ->select([
                'id',
                'name',               
                'date',               
                'status',             
                'heated_start',            
                'heated_date',            
                'heated_end',               
                'temp',               
                'temp2',               
                'time_to_dry',             
                'rolling_code',             
                'link',          
                'note',          
                'state',          
                'validation',          
                'oven',
                'curing_house_id',        
                'curing_area_id',        
                'supervisor',     
                'thickness',     
                'trang_thai_com',     
                    
            ]);

        // dd($donggoi->get());

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $donggoi->whereDate('heated_date', $date);
        }

        // if ($request->has('link') && $request->link) {
        //     $donggoi->where('link', $request->link);
        // }

        // if ($request->has('company') && $request->company) {
        //     $companyCode = $request->company;

        //     $donggoi->whereHas('rolling.area.farm.company', function ($query) use ($companyCode) {
        //         $query->where('code', $companyCode);
        //     })
        //     ->orWhereHas('curing_area.farm.company', function ($query) use ($companyCode) {
        //         $query->where('code', $companyCode);
        //     });
        // }

        

        // dd($donggoi->rolling);

        return DataTables::of($donggoi)
            ->addColumn('status', function ($donggoi) {
                return "Đã đóng lô";
            })
            
            ->addColumn('company', function ($donggoi) {
                return $donggoi->rolling 
                ? ($donggoi->curing_house ? $donggoi->curing_house->curing_area->farm->company->code : "") 
                : ($donggoi->curing_area ? $donggoi->curing_area->farm->company->code : "");
            })
            
            ->addColumn('heated_end_time', function ($donggoi) {
                return $donggoi->heated_end ? \Carbon\Carbon::parse($donggoi->heated_end)->format('H:i') : ""; 
            })
            
            ->editColumn('date', function ($donggoi) {
                return $donggoi->heated_date ? \Carbon\Carbon::parse($donggoi->heated_date)->format('d-m-Y') : "";
            })
            ->addColumn('batch_codes', function ($donggoi) {
                // dd($donggoi->batches->pluck('batch_code')->toArray());
                return implode(', ', $donggoi->batches->pluck('batch_code')->toArray());
            })
            ->addColumn('bale_counts', function ($donggoi) {
                return implode(', ', $donggoi->batches->map(function ($batch) {
                    return $batch->pivot->bale_count;
                })->toArray());
            })
            ->addColumn('type', function ($donggoi) {
                return $donggoi->curing_house ? 'MDC' : 'MD';
            })
             ->addColumn('press_temperature', function ($donggoi) {
                return $donggoi->bale->press_temperature;
            })
            ->addColumn('weight', function ($donggoi) {
                return $donggoi->bale->weight;
            })
            ->addColumn('cut_check', function ($donggoi) {
                return $donggoi->bale->cut_check;
            })
            ->addColumn('evaluation', function ($donggoi) {
                return $donggoi->bale->evaluation;
            })
            ->make(true);
    }

    public function getList(Request $request)
    {
        // Bắt đầu với Eloquent builder
        $list = Batch::with(['drums', 'company', 'warehouse'])
            ->select([
                'id',
                'bale_status',               
                'bale_count',               
                'expected_grade',               
                'link',               
                'batch_number',               
                'batch_code',               
                'checked',               
                'exported',               
                'sample_cut_number',               
                'packaging_type',               
                'time',               
                'company_id',               
                'warehouse_id',                                  
                'date',                                  
            ]);

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

            // Thêm điều kiện whereDate vào builder
            $list->whereHas('drums', function ($query) use ($date) {
                $query->whereDate('heated_date', '=', $date);
            });
        }

        if ($request->has('link') && $request->link) {
            $list->where('link', $request->link);
        }

        if ($request->has('company') && $request->company) {
            $list->where('company_id', $request->company);
        }

        // Lấy danh sách kết quả
        $result = $list->get();

        return DataTables::of($result)
            ->addColumn('company', function ($item) {
                return $item->company->code;
            })
            ->addColumn('from', function ($item) {
                return $item->drums && $item->drums->isNotEmpty() 
                    ? ($item->drums->last()->curing_house ? $item->drums->last()->curing_house->curing_area->farm->code : "") 
                    : "";
            })
            ->editColumn('date', function ($item) {
                return $item->drums && $item->drums->isNotEmpty() 
                    ? \Carbon\Carbon::parse($item->drums->last()->heated_date)->format('d-m-Y') 
                    : "";
            })
            ->editColumn('time', function ($item) {
                return $item->drums && $item->drums->isNotEmpty() 
                    ? \Carbon\Carbon::parse($item->drums->last()->heated_end)->format('H:i') 
                    : "";
            })
            ->make(true);
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
        dd($curing_house);
        
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
    // Lấy rubbers từ batch
    // $rubbers = Batch::where('batch_code', '24130931')->first();
    // $rubbers2 = Batch::where('batch_code', '2413106')->first();

    // dd($rubbers, $rubbers2);

    // // $trucksArray = [];

    // foreach ($rubbers as $rubber) {
    //     // Lấy các plots cho rubber hiện tại
    //     $groupedPlots = DB::table('plot_rubber')
    //         ->select('rubber_id', 'to_nt', 'lat_cao', DB::raw('GROUP_CONCAT(plot_id) as plot_ids'))
    //         ->where('rubber_id', $rubber->id) 
    //         ->groupBy('rubber_id', 'to_nt', 'lat_cao')
    //         ->get();

    //     $trucksArray[] = [
    //         'rubber_id' => $rubber->id,
    //         'truck_name' => $rubber->truck_name,
    //         'time_di' => $rubber->time_di,
    //         'time_ve' => $rubber->time_ve,
    //         'plots' => $rubber->plots->pluck('tenlo')->unique()->toArray()
    //     ];
    // }

    // dd($trucksArray);

    return view('admin.batch.find'); // Trả về biến đúng cách
}



    // lô -> nhiều thùng -> thùng đầu -> mã cán -> nt

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
            'plotsArray' => [],
            'trucksArray' => [],
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
                $response['Ngày cán vắt'] = $batch->drums[0]?->rolling ? Carbon::parse(optional($batch->drums[0]?->rolling)->date)->format('d-m-Y') : "Đang cập nhật";


                $rubbers = $batch->drums[0]?->rolling?->rubbers()->get();

                $plotsArray = [];
                $trucksArray = [];

                
                foreach ($rubbers as $rubber) {
                    
                    $plots = $rubber->plots; 

                    $trucksArray[] = [
                        'rubber_id' => $rubber->id,
                        'truck_name' => $rubber->truck_name,
                        'time_di' => $rubber->time_di,
                        'time_ve' => $rubber->time_ve,
                        'plots' => $rubber->plots->pluck('tenlo')->unique()->toArray(),
                    ];
                    
                    
                    foreach ($plots as $plot) {
                        $plotsArray[] = [
                            'rubber_id' => $rubber->id,  
                            'plot_id'   => $plot->id,    
                            'id_lo'   => $plot->id_lo,    
                            'farm_id'   => $plot->farm_id,    
                            'tenlo'   => $plot->tenlo,    
                            'namtrong'   => $plot->namtrong,    
                            'giong'   => $plot->giong,    
                            'dientich'   => $plot->dientich,    
                            'namcao' => $plot->namcao,  
                            'to_nt' => $plot->to_nt,  
                            'tuoicao' => $plot->tuoicao,  
                            'lat_cao' => $plot->lat_cao,  
                            'duAn' => $plot->duAn,  
                            'x' => $plot->x,  
                            'y' => $plot->y,  
                            'y' => $plot->y,  
                            'geojson' => $plot->geojson,
                            'tongcaycao' => $plot->tongcaycao,  
                            'matdocaycao' => $plot->matdocaycao,  
                            'tong_kmc' => $plot->tong_kmc,  
                        ];
                    }
                }

                // thùng->rolling->rubbers -> truck_name

                $response['plotsArray'] = $plotsArray;
                $response['trucksArray'] = $trucksArray;
                
                $response['Số xe'] = $rubbers->where('farm_id', $farm->id)->pluck('truck_name')->isNotEmpty() ? $rubbers->where('farm_id', $farm->id)->pluck('truck_name') : '';
                $response['Số chuyến'] = $rubbers->where('farm_id', $farm->id)->count() > 0 ? $rubbers->where('farm_id', $farm->id)->count() : 'Đang cập nhật';

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
                : "",

            'avg_ash' => isset($data['results']['testing_result_svr']['avg_ash']) 
                ? $data['results']['testing_result_svr']['avg_ash'] 
                : "",

            'avg_volatile' => isset($data['results']['testing_result_svr']['avg_volatile']) 
                ? $data['results']['testing_result_svr']['avg_volatile'] 
                : "",

            'avg_nitro' => isset($data['results']['testing_result_svr']['avg_nitro']) 
                ? $data['results']['testing_result_svr']['avg_nitro'] 
                : "",

            'avg_po' => isset($data['results']['testing_result_svr']['avg_po']) 
                ? $data['results']['testing_result_svr']['avg_po'] 
                : "",

            'avg_pri' => isset($data['results']['testing_result_svr']['avg_pri']) 
                ? $data['results']['testing_result_svr']['avg_pri'] 
                : "",
                
            'avg_viscosity' => isset($data['results']['testing_result_svr']['avg_viscosity']) 
                ? $data['results']['testing_result_svr']['avg_viscosity'] 
                : "",
        ];


        
        return response()->json($result, $response->status());
    }



    public function updateLots()
    {
        ini_set('max_execution_time', 1200); 
        $token = "30dd7d4f-bbd4-4c23-b7df-13e5a9e1055f"; 

        $batches_notChecked = Batch::where('checked', 0)->get();
        $responses = []; 
        foreach ($batches_notChecked as $item) {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Content-Type' => 'application/json',
            ])->get("https://kcs.chusekptrubber.vn/api/show-factory-code?factoryCode={$item->batch_code}");

            if ($response->successful()) {

                $data = $response->json();

                if (isset($data['results']['status']) && $data['results']['status'] == 1) {
                    $item->checked = 1; 
                    if (isset($data['results']['testing_result_svr'])) {
                        $item->expected_grade = $data['results']['testing_result_svr']['rank'] == '10_VRG' ? 'CSR10' : 'CSR20';
                    }

                    $item->save();
                }
                $responses[] = $data; 
            } else {

                $responses[] = [
                    'error' => $response->status(),
                    'message' => 'Failed to fetch data for batch: ' . $item->batch_code,
                ];
            }
        }

        // dd($responses);
        
        return redirect()->back()->with('delete_success', 'Cập nhật thành công');
    }





    
}

 