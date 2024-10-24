<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckUserLoggedIn;
use App\Models\Batch;
use App\Models\Rubber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class BatchFindApi extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckUserLoggedIn::class)->except(['login']);
    }
    public function findBatch(Request $request)
    {
        $batchCode = $request->input('batch_code');

        $batch = Batch::with('drums.rolling.area.farm')->where('batch_code', $batchCode)->first();

        if($batch){
            if ($batch?->user_id !== Auth::user()->id && Auth::user()->type != 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lô của người ta má ơi',
                ], 403);
            }
            else {
                $response = [
                    'nhamay' => 'NHÀ MÁY CHẾ BIẾN MỦ STOUNG',
                    'congty' => 'Đang cập nhật',
                    'ma_lo' => $batch->batch_code,
                    'khoiluongbanh' => "35kg",
                    'khoiluonglohang' => 'Đang cập nhật',
                    'ngaycanvat' => 'Đang cập nhật',
                    'nongtruong' => 'Đang cập nhật',
                    'ngaytiepnhanmu' => 'Đang cập nhật',
                    'loaimu' => 'Đang cập nhật',
                    'tong_so_chuyen' => 'Đang cập nhật',
                ];


                if ($batch->drums) {
                
                    $drum = $batch->drums->first();
                    $farm = optional($drum->rolling->area->farm);
                    $area = optional($drum->rolling->area);

                    $type = ($area && !in_array($area->code, ['MDCR', 'MDBH', 'NLTMMD'])) ? "Mủ đông chén" : "Mủ dây";

                    if ($farm) {

                        $response['ngaysansxuat'] = Carbon::parse($batch->date)->format('Y-m-d') ?? 'Đang cập nhật';
                        $response['khoiluonglohang'] = $batch->bale_count * 35 /1000 . "(tons/tấn)";
                        $response['nongtruong'] = $farm->name ?? 'Đang cập nhật';
                        $response['congty'] = optional($batch->company)->name ?? 'Đang cập nhật';
                        $response['ngaytiepnhanmu'] = $drum->rolling ? Carbon::parse(optional($drum->rolling)->date_curing)->format('Y-m-d') : "Đang cập nhật";
                        $response['loaimu'] = $type;
                        $response['ngaycanvat'] = $drum->rolling ? Carbon::parse(optional($drum->rolling)->date)->format('Y-m-d') : "Đang cập nhật";


                        $rubbers = $batch->drums[0]?->rolling?->rubbers()->orderBy('package_code', 'asc')->get();

                        $trucksArray = [];
                        $truckCounts = []; 

                        foreach ($rubbers as $index => $rubber) {
                            
                            $plots = $rubber->plots->map(function ($plot) {
                                return [
                                    'lo_vung_trong' => $plot->tenlo,
                                    'id_lo' => $plot->id_lo,
                                    'du_an' => $plot->duAn,
                                    'to' => $plot->to_nt,
                                    'lat_cao' => $plot->lat_cao,
                                    'nam_trong' => $plot->namtrong,
                                    'nam_cao' => $plot->namcao,
                                    'tuoi_cao' => $plot->tuoicao,
                                    'giong_cay' => $plot->giong,
                                    'tong_cay_cao' => $plot->tongcaycao, 
                                    'mat_do_cay_cao' => $plot->matdocaycao, 
                                    'tong_kmc' => $plot->tong_kmc, 
                                    'toa_do' => [
                                        'x' => $plot->x,
                                        'y' => $plot->y,
                                        'geojson' => json_decode($plot->geojson)
                                    ],
                                    
                                ];
                            })->toArray(); 

                            
                            $truckName = $rubber->truck_name;

                            if (!isset($truckCounts[$truckName])) {
                                $truckCounts[$truckName] = 0; 
                            }
                            $truckCounts[$truckName]++; 

                            $trucksArray[] = [
                                'truck_name' => $truckName,
                                'thoi_gian_vao' => $rubber->time_di ? Carbon::createFromFormat('d-m-Y H:i', $rubber->time_di)->format('Y-m-d H:i') : null,
                                'thoi_gian_ra' => $rubber->time_ve ? Carbon::createFromFormat('d-m-Y H:i', $rubber->time_ve)->format('Y-m-d H:i') : null,
                                'so_chuyen' => $truckCounts[$truckName],
                                'latex_receive_date' => $rubber->time_ve ? Carbon::createFromFormat('d-m-Y H:i', $rubber->time_ve)->format('Y-m-d') : null,
                                'vung_trong' => $plots,
                            ];
                        }

                        $trucksCollection = collect($trucksArray);
                        $response['trucksArray'] = $trucksArray;
                        $response['tong_so_chuyen'] = $trucksCollection->count();
                    }
                }
                $token = "30dd7d4f-bbd4-4c23-b7df-13e5a9e1055f";

                $response_test = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                    'Content-Type' => 'application/json',
                ])->get("https://kcs.chusekptrubber.vn/api/show-factory-code?factoryCode={$batchCode}");

                if ($response_test->successful()) {

                    $data = $response_test->json();
                    $response['results_test'] = $data['results'];
                } else {

                    $response['results_test'] = [
                        'status' => 0,
                        'message' => 'hông biết nữa',
                    ];
                }

            }
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'không có thấy lô này nha má, kiểm tra lại dùm'
            ]);
            
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
        $finalResult = [
            'original_data' => $data,
            'processed_result' => $result,
        ];
        return response()->json($finalResult, $response->status());
    }
    public function showData(Request $request)
    {
        $batchCode = $request->input('batch_code');

        $findBatchRequest = new Request();
        $findBatchRequest->merge(['batch_code' => $batchCode]);

        $findBatchResponse = $this->findBatch($findBatchRequest)->getData(true);
        $findBatchData = $findBatchResponse['data'] ?? [];

        $proxyApiTestRequest = new Request();
        $proxyApiTestRequest->merge(['code' => $batchCode]);

        $proxyApiTestResponse = $this->proxyApiTest($proxyApiTestRequest)->getData(true);
        $proxyApiTestData = $proxyApiTestResponse['processed_result'] ?? [];
        // Kết hợp dữ liệu của cả hai hàm
        $response = [
            'InforBatch' => $findBatchData,
            'proxyApiTest' => $proxyApiTestData
        ];

        return response()->json([
            'status' => 'success',
            'data' => $response
        ]);
    }


    // protected function findBatchData($batchCode)
    // {
    //     $batch = Batch::with('drums.rolling.area.farm')->where('batch_code', $batchCode)->first();
    //     $response = [
    //         'nhamay' => 'NHÀ MÁY CHẾ BIẾN MỦ STOUNG',
    //         'congty' => 'Đang cập nhật',
    //         'ngaysanxuat' => 'Đang cập nhật',
    //         'khoiluongbanh' => 35,
    //         'khoiluonglohang' => 'Đang cập nhật',
    //         'ngaycanvat' => 'Đang cập nhật',
    //         'nongtruong' => 'Đang cập nhật',
    //         'ngaytiepnhanmu' => 'Đang cập nhật',
    //         'loaimu' => 'Đang cập nhật',
    //         'sochuyen' => 'Đang cập nhật',
    //     ];

    //     if ($batch && $batch->drums) {
    //         $drum = $batch->drums->first();
    //         $farm = optional($drum->rolling->area->farm);
    //         $area = optional($drum->rolling->area);
    //         $type = ($area && !in_array($area->code, ['MDCR', 'MDBH', 'NLTMMD'])) ? "Mủ đông chén" : "Mủ dây";

    //         if ($farm) {
    //             $response['ngaysansxuat'] = Carbon::parse($batch->date)->format('d-m-Y') ?? 'Đang cập nhật';
    //             $response['khoiluonglohang'] = $batch->bale_count * 35;
    //             $response['nongtruong'] = $farm->name ?? 'Đang cập nhật';
    //             $response['congty'] = optional($batch->company)->name ?? 'Đang cập nhật';
    //             $response['ngaytiepnhanmu'] = $drum->rolling ? Carbon::parse(optional($drum->rolling)->date_curing)->format('d-m-Y') : "Đang cập nhật";
    //             $response['loaimu'] = $type;
    //             $response['ngaycanvat'] = $drum->rolling ? Carbon::parse(optional($drum->rolling)->date)->format('d-m-Y') : "Đang cập nhật";

    //             $rubbers = $batch->drums[0]?->rolling?->rubbers()->get();
    //             $plotsArray = [];
    //             $trucksArray = [];

    //             foreach ($rubbers as $rubber) {
    //                 $plots = $rubber->plots;

    //                 $trucksArray[] = [
    //                     'rubber_id' => $rubber->id,
    //                     'truck_name' => $rubber->truck_name,
    //                     'time_di' => $rubber->time_di,
    //                     'time_ve' => $rubber->time_ve,
    //                     'plots' => $rubber->plots->pluck('tenlo')->unique()->toArray(),
    //                 ];

    //                 foreach ($plots as $plot) {
    //                     $plotsArray[] = [
    //                         'rubber_id' => $rubber->id,
    //                         'plot_id' => $plot->id,
    //                         'id_lo' => $plot->id_lo,
    //                         'farm_id' => $plot->farm_id,
    //                         'tenlo' => $plot->tenlo,
    //                         'namtrong' => $plot->namtrong,
    //                         'giong' => $plot->giong,
    //                         'dientich' => $plot->dientich,
    //                         'namcao' => $plot->namcao,
    //                         'to_nt' => $plot->to_nt,
    //                         'tuoicao' => $plot->tuoicao,
    //                         'lat_cao' => $plot->lat_cao,
    //                         'duAn' => $plot->duAn,
    //                         'x' => $plot->x,
    //                         'y' => $plot->y,
    //                         'geojson' => $plot->geojson,
    //                         'tongcaycao' => $plot->tongcaycao,
    //                         'matdocaycao' => $plot->matdocaycao,
    //                         'tong_kmc' => $plot->tong_kmc,
    //                     ];
    //                 }
    //             }

    //             $trucksCollection = collect($trucksArray);
    //             $response['plotsArray'] = $plotsArray;
    //             $response['trucksArray'] = $trucksArray;
    //             $response['sochuyen'] = $trucksCollection->count();
    //         }
    //     }

    //     return $response;
    // }

    // protected function proxyApiTestData($batchCode)
    // {
    //     $token = "30dd7d4f-bbd4-4c23-b7df-13e5a9e1055f";

    //     $response = Http::withHeaders([
    //         'Authorization' => "Bearer {$token}",
    //         'Content-Type' => 'application/json',
    //     ])->get("https://kcs.chusekptrubber.vn/api/show-factory-code?factoryCode={$batchCode}");

    //     $data = $response->json();
    //     $result = [
    //         'date_request' => $data['results']['date_request'] ?? "Đang cập nhật",
    //         'date_test_end' => $data['results']['testing_result_svr']['date_test_end'] ?? "Đang cập nhật",
    //         'rank' => $data['results']['testing_result_svr']['rank'] ?? "Đang cập nhật",
    //         'status' => isset($data['results']['status'])
    //             ? ($data['results']['status'] == 1 ? "Đạt" : ($data['results']['status'] == 0 ? "Không đạt" : "Chưa kiểm nghiệm"))
    //             : "Đang cập nhật",
    //         'avg_dirt' => $data['results']['testing_result_svr']['avg_dirt'] ?? "Đang cập nhật",
    //         'avg_ash' => $data['results']['testing_result_svr']['avg_ash'] ?? "Đang cập nhật",
    //         'avg_volatile' => $data['results']['testing_result_svr']['avg_volatile'] ?? "Đang cập nhật",
    //         'avg_nitro' => $data['results']['testing_result_svr']['avg_nitro'] ?? "Đang cập nhật",
    //         'avg_po' => $data['results']['testing_result_svr']['avg_po'] ?? "Đang cập nhật",
    //         'avg_pri' => $data['results']['testing_result_svr']['avg_pri'] ?? "Đang cập nhật",
    //         'avg_viscosity' => $data['results']['testing_result_svr']['avg_viscosity'] ?? "Đang cập nhật",
    //     ];

    //     return $result;
    // }
}