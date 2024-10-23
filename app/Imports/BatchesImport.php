<?php

namespace App\Imports;

namespace App\Imports;  

use App\Models\Batch;  
use App\Models\Warehouse;  
use Maatwebsite\Excel\Concerns\ToModel;  
use Illuminate\Support\Facades\Log;  

class BatchesImport implements ToModel  
{  
    public function model(array $rows)  
    {  
        // Lấy thông tin tương ứng  
        $ware_name = $rows[1]; 
        $code = $rows[2];  

        $batch = Batch::where('batch_code', $code)->first();  
        $ware = Warehouse::where('code', $ware_name)->first();  

        // dd($batch, $ware, $ware_name, $code);

        // Nếu cả batch và warehouse đều tồn tại  
        if ($batch && $ware) {  
            try {  
                $batch->warehouse_id = $ware->id;  
                $ware->batch_id = $batch->id;  

                // Lưu các bản ghi  
                $batch->save();  
                $ware->save();  

                Log::info("Successfully updated Batch and Warehouse", ['batch_id' => $batch->id, 'warehouse_id' => $ware->id]);  
            } catch (\Exception $e) {  
                Log::error("Error saving Batch or Warehouse: " . $e->getMessage());  
            }  
        } else {  
            Log::warning("Batch or Warehouse not found", ['batch_code' => $code, 'warehouse_code' => $ware_name]);  
        }  

        return null;  
    }  
}