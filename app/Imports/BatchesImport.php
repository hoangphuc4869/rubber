<?php

namespace App\Imports;

namespace App\Imports;  

use App\Models\Batch;  
use App\Models\Warehouse;  
use Maatwebsite\Excel\Concerns\ToModel;  
use Illuminate\Support\Facades\Log;
use App\Models\Plot;  

class BatchesImport implements ToModel  
{  
    public function model(array $rows)  
    {  
        
        $ware = $rows[1]; 
        $batch = $rows[2]; 


        $ware_item = Warehouse::where('code', $ware)->first();  
        $batch_item = Batch::where('batch_code', $batch)->first(); 

        // dd($ware_item, $batch_item, $ware, $batch); 


        if ($ware_item && $batch_item) {  

            $curing_batch_ware = Batch::where('warehouse_id', $ware_item->id)->first();

            if($curing_batch_ware && $curing_batch_ware->id != $batch_item->id){
                $curing_batch_ware->warehouse_id = null;
                $curing_batch_ware->save();
            }
            $ware_item->batch_id = $batch_item->id;
            $batch_item->warehouse_id = $ware_item->id;

            $ware_item->save();
            $batch_item->save();
        }

        if ($ware_item && $batch_item == null) {  

            $curing_batch_in_ware = Batch::where('warehouse_id', $ware_item->id)->first();

            if($curing_batch_in_ware){
                $curing_batch_in_ware->warehouse_id = null;
                $curing_batch_in_ware->save();
            }
            $ware_item->batch_id = null;
            $ware_item->save();
        } 

        return null;  
    }  
}