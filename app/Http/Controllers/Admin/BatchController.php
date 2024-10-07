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

        // dd($request);
        $requestedIds = explode(',', $request->drums[0]); 
        $ids = array_unique($requestedIds);

        // dd($ids); 

        $curing_house = Drum::findOrFail($ids[0])->curing_house;
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

        
        $curing_house->containing -= $bale_count * 35;

        if ($curing_house->containing < 0) {
            $curing_house->containing = 0;
        }

        $curing_house->save();


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
            
            foreach ($batch->drums as $drum) {
                $drum->remaining_bales = 0;
                $drum->save(); 
            }
            $batch->delete();
        }
        
        return redirect()->back()->with('delete_success', 'Xóa thành công');
    }


    

    
}

 