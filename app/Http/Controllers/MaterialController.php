<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Models\Rubber;
use App\Models\Truck;
use App\Models\CuringArea;
use App\Models\CuringHouse;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();
            
            $token = $user->createToken('Login')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }


    public function insert(Request $request)  
    {  
        $apiToken = session('api_token');  

        $rubberRecords = $request->json()->all();  
        $rubberData = [];   
        $failedEntries = []; 

        foreach ($rubberRecords as $item) {  
            
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
                        'farm_name' => $item['nguon_goc'],  
                        'fresh_weight' => $item['khoi_luong_mu'],  
                        'latex_type' => $item['chung_loai'],   
                        'farm_id' => $farm ? $farm->id : null,  
                        'receiving_place_id' => $curingArea ? $curingArea->id : null,  
                        'trong_luong_vao' => $item['so_can_tong'],  
                        'trong_luong_ra' => $item['so_can_bi'],  
                        'khoi_luong_phieu' => $item['so_can_phieu'],  
                        'time_di' => $item['gio_can_tong'],  
                        'time_ve' => $item['gio_can_bi'],
                        'kho' =>  $item['kho'],
                        'tai_xe' =>  $item['tai_xe']
                    ]);  
                } else {  
                    
                    $failedEntries[] = $item['so_phieu'];  
                }  
                continue; 
            }  

            $data = [  
                'status' => 0,  
                'or_time' => $item['thoi_gian'],   
                'truck_name' => $item['bien_so_xe'],  
                'farm_name' => $item['nguon_goc'],  
                'fresh_weight' => $item['khoi_luong_mu'],  
                'latex_type' => $item['chung_loai'],   
                'package_code' => $item['so_phieu'], 
                'trong_luong_vao' => $item['so_can_tong'],
                'trong_luong_ra' => $item['so_can_bi'],
                'khoi_luong_phieu' => $item['so_can_phieu'],  
                'time_di' => $item['gio_can_tong'],
                'time_ve' => $item['gio_can_bi'],
                'kho' =>  $item['kho'],
                'tai_xe' =>  $item['tai_xe']
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

    
        Rubber::insert($rubberData);  

        
        return response()->json([  
            'message' => 'Dữ liệu đã được lưu thành công',  
            'Phiếu không thể update' => $failedEntries,
            'data' => $rubberData
        ]);  
    }


    private function getCuringAreaForMDC($nguon_goc)
    {
        $codes = [
            "NÔNG TRƯỜNG 1" => 'NLNT1',
            "NÔNG TRƯỜNG 2" => 'NLNT2',
            "NÔNG TRƯỜNG 3" => 'NLNT3',
            "NÔNG TRƯỜNG 4" => 'NLNT4',
            "NÔNG TRƯỜNG 5" => 'NLNT5',
            "NÔNG TRƯỜNG 6" => 'NLNT6',
            "NÔNG TRƯỜNG 7" => 'NLNT7',
            "NÔNG TRƯỜNG 8" => 'NLNT8',
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
            "NÔNG TRƯỜNG 1" => 'MDCR',
            "NÔNG TRƯỜNG 2" => 'MDCR',
            "NÔNG TRƯỜNG 3" => 'MDCR',
            "NÔNG TRƯỜNG 4" => 'MDBH',
            "NÔNG TRƯỜNG 5" => 'MDBH',
            "NÔNG TRƯỜNG 6" => 'MDCR',
            "NÔNG TRƯỜNG 7" => 'MDBH',
            "NÔNG TRƯỜNG 8" => 'MDBH',
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
            "NÔNG TRƯỜNG 1" => 'NT1',
            "NÔNG TRƯỜNG 2" => 'NT2',
            "NÔNG TRƯỜNG 3" => 'NT3',
            "NÔNG TRƯỜNG 4" => 'NT4',
            "NÔNG TRƯỜNG 5" => 'NT5',
            "NÔNG TRƯỜNG 6" => 'NT6',
            "NÔNG TRƯỜNG 7" => 'NT7',
            "NÔNG TRƯỜNG 8" => 'NT8',
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