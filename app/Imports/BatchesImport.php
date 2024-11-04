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
        
        $id_lo = $rows[0]; 
        $hangdat = $rows[8]; 
        $ns2017 = $rows[1];  
        $ns2018 = $rows[2];  
        $ns2019 = $rows[3];  
        $ns2020 = $rows[4];  
        $ns2021 = $rows[5];  
        $ns2022 = $rows[6];  
        $ns2023 = $rows[7];

        $lo = Plot::where('id_lo', $id_lo)->first();  

        if ($lo) {  
            $lo->hangdat = $hangdat;
            $lo->ns2017 = $ns2017;
            $lo->ns2018 = $ns2018;
            $lo->ns2019 = $ns2019;
            $lo->ns2020 = $ns2020;
            $lo->ns2021 = $ns2021;
            $lo->ns2022 = $ns2022;
            $lo->ns2023 = $ns2023;

            $lo->save();
        } 

        return null;  
    }  
}