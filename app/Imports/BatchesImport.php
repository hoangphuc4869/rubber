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
            $ware_item->batch_id = $batch_item->id;
            $batch_item->warehouse_id = $ware_item->id;

            $ware_item->save();
            $batch_item->save();
        } 

        return null;  
    }  
}