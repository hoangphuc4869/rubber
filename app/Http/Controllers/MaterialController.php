<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Models\Rubber;
use App\Models\Truck;
use App\Models\CuringArea;
use App\Models\CuringHouse;
use Illuminate\Support\Facades\Auth;
use App\Models\Plot;

class MaterialController extends Controller
{

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials, $request->remember)) {
    //         $user = Auth::user();
            
    //         $token = $user->createToken('Login')->plainTextToken;

    //         return response()->json(['token' => $token], 200);
    //     }

    //     return response()->json(['message' => 'Unauthorized'], 401);
    // }


    public function insert(Request $request)  
    {  
 
        $rubberRecords = $request->json()->all();  
        $rubberData = [];   
        $failedEntries = []; 


        $farm_map = [
            'N1' => 'NÔNG TRƯỜNG 1',
            'N2' => 'NÔNG TRƯỜNG 2',
            'N3' => 'NÔNG TRƯỜNG 3',
            'N4' => 'NÔNG TRƯỜNG 4',
            'N5' => 'NÔNG TRƯỜNG 5',
            'N6' => 'NÔNG TRƯỜNG 6',
            'N7' => 'NÔNG TRƯỜNG 7',
            'N8' => 'NÔNG TRƯỜNG 8',
            "TÂY NINH SR" => 'TNSR'
        ];

        foreach ($rubberRecords as $item) {  
            if($item['loai_phieu'] !== 'Phiếu Xuất'){

                if (empty($item['khoi_luong_mu']) || empty($item['gio_can_tong']) || empty($item['gio_can_bi'])) {
                    $failedEntries[] = $item['so_phieu'];
                    continue;
                }
                
                $existingRecord = Rubber::where('package_code', $item['so_phieu'])->first();  
            
                if ($existingRecord) {  
                    
                    if ($existingRecord->input_status === 0) {  
                        
                        $farm = $this->getFarmByNguonGoc($item['nguon_goc']);  
                        $curingArea = null; 
                        
                        if (in_array($item['chung_loai'], ["MỦ ĐÔNG CHÉN", "MĐC GIA CÔNG"])) {  
                            $curingArea = $this->getCuringAreaForMDC($item['nguon_goc']);  
                        } elseif (in_array($item['chung_loai'], ["MỦ DÂY", "THU MUA MD"])) {  
                            $curingArea = $this->getCuringAreaForMuday($item['nguon_goc']);  
                        } elseif ($item['chung_loai'] === "THU MUA MĐC") {  
                            $curingArea = CuringArea::where('code', 'NLTM')->first();  
                        }  

                        
                        $existingRecord->update([  
                            'or_time' => $item['thoi_gian'],   
                            'truck_name' => $item['bien_so_xe'],  
                            'farm_name' => isset($farm_map[$item['nguon_goc']]) ? $farm_map[$item['nguon_goc']] : $item['nguon_goc'],  
                            'fresh_weight' => $item['khoi_luong_mu'],  
                            'dry_weight' => $existingRecord->drc_percentage ? $item['khoi_luong_mu'] * $existingRecord->drc_percentage/100 : null,  
                            'latex_type' => $item['chung_loai'],   
                            'farm_id' => $farm ? $farm->id : null,  
                            'receiving_place_id' => $curingArea ? $curingArea->id : null,  
                            'trong_luong_vao' => $item['so_can_tong'],  
                            'trong_luong_ra' => $item['so_can_bi'],  
                            'khoi_luong_phieu' => $item['so_can_phieu'],  
                            'time_di' => $item['gio_can_tong'],  
                            'time_ve' => $item['gio_can_bi'],
                            'kho' =>  $item['kho'],
                            'tai_xe' =>  $item['tai_xe'],
                            'loai_phieu' =>  $item['loai_phieu'],
                            'lat_cao' =>  $item['lat_cao'],
                            'ten_lo' =>  $item['ten_lo'],
                            'updated_at' => now()
                        ]);  

                        if (in_array($existingRecord->farm_id, [1, 2, 3, 4, 5, 6, 7, 8]) && $existingRecord->lat_cao && $existingRecord->ten_lo) {

                            $latCaoItems = array_filter(array_map(function($item) {
                                return trim(preg_replace('/\x{A0}/u', '', $item));
                            }, explode(";", $existingRecord->lat_cao)));

                            // dd($latCaoItems);

                            $tenLoItems = array_filter(explode("-", $existingRecord->ten_lo));

                            $syncData = [];

                            foreach ($latCaoItems as $index => $latCaoItem) {

                                [$key, $value] = explode("-", $latCaoItem);
                                
                                $key = str_replace("T", "", $key);

                                $plots = Plot::where('farm_id', $existingRecord['farm_id'])
                                    ->where('to_nt', $key)
                                    ->where(function($query) use ($value) {
                                        foreach (explode(',', $value) as $val) {
                                            $query->orWhere('lat_cao', 'like', '%' . trim($val) . '%');
                                        }
                                    })
                                    ->get();

                                if($plots){
                                    
                                    foreach ($plots as $lo) {
                                        
                                        $syncData[$lo->id] = [
                                            'to_nt' => $key,
                                            'lat_cao' => $value, 
                                        ];
                                        
                                    }
                                }
                            }

                            $existingRecord->plots()->sync($syncData);
  
                        }

                    } else {  
                        
                        $failedEntries[] = $item['so_phieu'];  
                    }  
                    continue; 
                }  

                

                $data = [  
                    'status' => 0,  
                    'or_time' => $item['thoi_gian'],   
                    'truck_name' => $item['bien_so_xe'],  
                    'farm_name' => isset($farm_map[$item['nguon_goc']]) ? $farm_map[$item['nguon_goc']] : $item['nguon_goc'] ,  
                    'fresh_weight' => $item['khoi_luong_mu'],  
                    'latex_type' => $item['chung_loai'],   
                    'package_code' => $item['so_phieu'], 
                    'trong_luong_vao' => $item['so_can_tong'],
                    'trong_luong_ra' => $item['so_can_bi'],
                    'khoi_luong_phieu' => $item['so_can_phieu'],  
                    'time_di' => $item['gio_can_tong'],
                    'time_ve' => $item['gio_can_bi'],
                    'kho' =>  $item['kho'],
                    'tai_xe' =>  $item['tai_xe'],
                    'loai_phieu' =>  $item['loai_phieu'],
                    'lat_cao' =>  $item['lat_cao'],
                    'ten_lo' =>  $item['ten_lo'],
                    'created_at' => now(),  
                    'updated_at' => now()
                ];

            
                $farm = $this->getFarmByNguonGoc($item['nguon_goc']);  
                if ($farm) {  
                    $data['farm_id'] = $farm->id;  
                }  

                $curingArea = null;
                if (in_array($item['chung_loai'], ["MỦ ĐÔNG CHÉN", "MĐC GIA CÔNG"])) {  
                    $curingArea = $this->getCuringAreaForMDC($item['nguon_goc']);  
                } elseif (in_array($item['chung_loai'], ["MỦ DÂY", "THU MUA MD"])) {  
                    $curingArea = $this->getCuringAreaForMuday($item['nguon_goc']);  
                } elseif ($item['chung_loai'] === "THU MUA MĐC") {
                    $curingArea = CuringArea::where('code', 'NLTM')->first();  
                }

                if (isset($curingArea)) {  
                    $data['receiving_place_id'] = $curingArea ? $curingArea->id : null;  
                }  

                $rubberData[] = $data; 
            } 
        }  

    
        Rubber::insert($rubberData); 

        $insertedRubberIds = Rubber::whereIn('package_code', collect($rubberData)->pluck('package_code'))->get();

        if($insertedRubberIds){

            

            foreach ($insertedRubberIds as $rubber) {
                
                if (isset($rubber->time_ve)) {

                    $datePart = substr($rubber->time_ve, 0, 10);
                    $timePart = substr($rubber->time_ve, 11); 

                   
                    $rubber->date = \Carbon\Carbon::createFromFormat('d-m-Y', $datePart)->format('Y-m-d');
                    $rubber->time = $timePart;

                    $rubber->save();
                }

                if (in_array($rubber->farm_id, [1, 2, 3, 4, 5, 6, 7, 8]) && $rubber->lat_cao && $rubber->ten_lo) {

                    $latCaoItems = array_filter(array_map(function($item) {
                        return trim(preg_replace('/\x{A0}/u', '', $item));
                    }, explode(";", $rubber->lat_cao)));

                    $tenLoItems = array_filter(explode(" - ", $rubber->ten_lo));

                    $syncData = [];

                    foreach ($latCaoItems as $index => $latCaoItem) {

                        [$key, $value] = explode("-", $latCaoItem);
                        
                        $key = str_replace("T", "", $key);

                        $plots = Plot::where('farm_id', $rubber['farm_id'])
                            ->where('to_nt', $key)
                            ->where(function($query) use ($value) {
                                foreach (explode(',', $value) as $val) {
                                    $query->orWhere('lat_cao', 'like', '%' . trim($val) . '%');
                                }
                            })
                            ->get();
                        
                        if($plots){
                            foreach ($plots as $lo) {
                                $syncData[$lo->id] = [
                                    'to_nt' => $key,
                                    'lat_cao' => $value, 
                                ];
                            }
                        }
                    }
                    $rubber->plots()->attach($syncData);  
                }
            }
        }


        if(count($failedEntries) > 0){
            return response()->json([  
                'message' => 'Vui lòng kiểm tra lại',  
                'Phiếu lỗi' => $failedEntries,
            ]); 
        }
        else {
            return response()->json([  
                'message' => 'Dữ liệu đã được lưu thành công',  
                'data' => $rubberData
            ]); 
        }
         
    }


    private function getCuringAreaForMDC($nguon_goc)
    {
        $codes = [
            "N1" => 'NLNT1',
            "N2" => 'NLNT2',
            "N3" => 'NLNT3',
            "N4" => 'NLNT4',
            "N5" => 'NLNT5',
            "N6" => 'NLNT6',
            "N7" => 'NLNT7',
            "N8" => 'NLNT8',
            "TÂY NINH SR" => 'NLTNSR',
        ];

        if (isset($codes[$nguon_goc])) {
            return CuringArea::where('code', $codes[$nguon_goc])->first();
        } else {
            return CuringArea::where('code', 'NLTM')->first();
        }
    }

    private function getCuringAreaForMuday($nguon_goc)
    {
        $codes = [
            "N1" => 'MDCR',
            "N2" => 'MDCR',
            "N3" => 'MDCR',
            "N4" => 'MDBH',
            "N5" => 'MDBH',
            "N6" => 'MDCR',
            "N7" => 'MDBH',
            "N8" => 'MDBH',
        ];

        if (isset($codes[$nguon_goc])) {
            return CuringArea::where('code', $codes[$nguon_goc])->first();
        } else {
            return CuringArea::where('code', 'NLTMMD')->first();
        }
    }

    
    private function getFarmByNguonGoc($nguon_goc)
    {
        $farmCodes = [
            "N1" => 'NT1',
            "N2" => 'NT2',
            "N3" => 'NT3',
            "N4" => 'NT4',
            "N5" => 'NT5',
            "N6" => 'NT6',
            "N7" => 'NT7',
            "N8" => 'NT8',
            "TÂY NINH SR" => 'TNSR',
        ];

        if (isset($farmCodes[$nguon_goc])) {
            return Farm::where('code', $farmCodes[$nguon_goc])->first();
        }
        else {
            return Farm::where('code', 'TM')->first();
        }
    }

}