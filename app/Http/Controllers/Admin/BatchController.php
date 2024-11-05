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
use Illuminate\Support\Facades\Auth;


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
                'bale_id',
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

        if ($request->has('nongtruong') && $request->nongtruong) {

            $nt = $request->nongtruong;
    
            $donggoi->where(function ($query) use ($nt) {
                $query->whereHas('curing_house.curing_area', function ($query) use ($nt) {
                    $query->where('code', $nt);
                })
                ->orWhereHas('curing_area', function ($query) use ($nt) {
                    $query->where('code', $nt);
                });
            });
        }

        $result = $donggoi->get();

        return DataTables::of($result)
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
                ? ($donggoi->curing_house ? $donggoi->curing_house->curing_area->code : "") 
                : ($donggoi->curing_area ? $donggoi->curing_area->code : "");
            })

            ->addColumn('end_time', function ($donggoi) {
                return $donggoi->heated_end ? \Carbon\Carbon::parse($donggoi->heated_end)->format('H:i') : "";
            })
            
            // ->editColumn('heated_end', function ($donggoi) {
            //     return $donggoi->heated_end ? \Carbon\Carbon::parse($donggoi->heated_end)->format('H:i') : ""; 
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

        if ($request->has('link') && $request->link) {
            $donggoi->where('link', $request->link);
        }

        if ($request->has('nongtruong') && $request->nongtruong) {

            $nt = $request->nongtruong;
    
            $donggoi->where(function ($query) use ($nt) {
                $query->whereHas('curing_house.curing_area', function ($query) use ($nt) {
                    $query->where('code', $nt);
                })
                ->orWhereHas('curing_area', function ($query) use ($nt) {
                    $query->where('code', $nt);
                });
            });
        }

        $result = $donggoi->get();

        return DataTables::of($result)
            ->addColumn('status', function ($donggoi) {
                return "Đã đóng lô";
            })
            
            ->addColumn('company', function ($donggoi) {
                return $donggoi->rolling 
                ? ($donggoi->curing_house ? $donggoi->curing_house->curing_area->code : "") 
                : ($donggoi->curing_area ? $donggoi->curing_area->code : "");
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
                'from_farm',                            
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

        if ($request->has('nongtruong') && $request->nongtruong) {
            $list->where('from_farm', $request->nongtruong);
        }


        $result = $list->get();

        return DataTables::of($result)
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
            ->addColumn('heated_end', function ($item) {
                 return $item->drums && $item->drums->isNotEmpty() 
                    ? $item->drums->last()->heated_end 
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
        $requestedIds = explode(',', $request->drums[0]); 
        $ids = array_unique($requestedIds);

        $farm_codes = [
            "NLNT1" => 'A',
            "NLNT2" => 'B',
            "NLNT3" => 'C',
            "NLNT6" => 'D',
            "NLNT4" => 'E',
            "NLNT5" => 'F',
            "NLNT7" => 'G',
            "NLNT8" => 'H',
            "NLTM" => 'I',
            "NLTNSR" => 'J',
            "MDBH" => 'EH',
            "MDCR" => 'AD',
            "NLTMMD" => 'II',
        ];

        $types = [
            "NLNT1" => 'Mủ đông chén',
            "NLNT2" => 'Mủ đông chén',
            "NLNT3" => 'Mủ đông chén',
            "NLNT6" => 'Mủ đông chén',
            "NLNT4" => 'Mủ đông chén',
            "NLNT5" => 'Mủ đông chén',
            "NLNT7" => 'Mủ đông chén',
            "NLNT8" => 'Mủ đông chén',
            "NLTM" => 'Mủ đông chén',
            "NLTNSR" => 'Mủ đông chén',
            "MDBH" => 'Mủ dây',
            "MDCR" => 'Mủ dây',
            "NLTMMD" => 'Mủ dây',
        ];

        $companies = [
            "NLNT1" => 2,
            "NLNT2" => 2,
            "NLNT3" => 2,
            "NLNT6" => 2,
            "NLNT4" => 1,
            "NLNT5" => 1,
            "NLNT7" => 1,
            "NLNT8" => 1,
            "NLTM" => 2,
            "NLTNSR" => 3,
            "MDBH" => 1,
            "MDCR" => 2,
            "NLTMMD" => 2,
        ];

        foreach ($ids as $id) {
            $drum = Drum::findOrFail($id);
            $current_time = \Carbon\Carbon::parse($drum->heated_date)->month;
            $nongtruong = $drum->curing_house ? $drum->curing_house->curing_area->code : $drum->curing_area->code;

            $farm_code = $farm_codes[$nongtruong] ?? null;
            $type = $types[$nongtruong] ?? null;
            $company_id = $companies[$nongtruong] ?? null;

            if ($farm_code) {
                $currentBatch = Batch::where('from_farm', $nongtruong)->where('link', $drum->link)
                                    ->orderBy('id', 'desc')
                                    ->first();
                $batch_number = 1;
                $remaining_bales = $drum->bale->number_of_bales;

                if ($currentBatch && $currentBatch->bale_count < 144 && $currentBatch->batch_month == $current_time) {
                    $needed_bales = 144 - $currentBatch->bale_count;

                
                    if ($remaining_bales <= $needed_bales) {
                        $currentBatch->bale_count += $remaining_bales;
                        $currentBatch->batch_month = \Carbon\Carbon::parse($drum->heated_date)->month;

                        $currentBatch->save();

                    
                        $currentBatch->drums()->attach($drum->id, ['bale_count' => $remaining_bales]);
                        $remaining_bales = 0;
                    } else {
                    
                        $currentBatch->bale_count = 144;
                        $currentBatch->bale_status = 1;
                        $currentBatch->save();

                    
                        $currentBatch->drums()->attach($drum->id, ['bale_count' => $needed_bales]);
                        $remaining_bales -= $needed_bales;
                    }
                }

                while ($remaining_bales > 0) {
                    
                    $batch_number = $currentBatch && $currentBatch->batch_month == $current_time ? $currentBatch->batch_number + 1 : 1;
                    
                    $newBatch = new Batch();
                    $newBatch->batch_code = date('y') . $farm_code . $drum->link . \Carbon\Carbon::parse($drum->heated_date)->format('m') . $batch_number;
                    $newBatch->expected_grade = $request->expected_grade;
                    $newBatch->sample_cut_number = $request->sample_cut_number;
                    $newBatch->packaging_type = $request->packaging_type;
                    $newBatch->from_farm = $nongtruong;
                    $newBatch->type = $type;
                    $newBatch->date = $request->date;
                    $newBatch->batch_month = \Carbon\Carbon::parse($drum->heated_date)->month;
                    $newBatch->batch_number = $batch_number;
                    $newBatch->time = $request->time;
                    $newBatch->link = $drum->link;
                    $newBatch->company_id = $company_id;


                    if ($remaining_bales >= 144) {
                        $newBatch->bale_count = 144;
                        $newBatch->bale_status = 1;
                        $newBatch->save();
                        $newBatch->drums()->attach($drum->id, ['bale_count' => 144]);
                        $remaining_bales -= 144;
                    } else {

                        $newBatch->bale_count = $remaining_bales;
                        $newBatch->bale_status = 0;
                        $newBatch->save();


                        $newBatch->drums()->attach($drum->id, ['bale_count' => $remaining_bales]);
                        $remaining_bales = 0;
                    }

                    $currentBatch = $newBatch;
                }
            }
        }
        return redirect()->back()->with('success', 'Tạo thành công');

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


    public function viewFindBatch()
    {
        $user= auth::user();
        dd($user->customer->contracts);

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

 