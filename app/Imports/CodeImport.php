<?php

namespace App\Imports;

use App\Models\Plot;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use App\Models\Batch;
use App\Models\Warehouse;

class CodeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $missingRecords = [];

    public function model(array $rows)
    {

        // dd($rows);
        $ware_name = $rows[1];
        $code = $rows[2];

        $batch = Batch::where('batch_code', $code )->first();
        $ware = Warehouse::where('code', $ware_name )->first();

        // dd( $ware_name, $code,  $batch, $ware);

        if ($batch && $ware) {
            $batch->warehouse_id = $ware->id;
            $ware->batch_id = $batch->id;
            $batch->save();
            $ware->save();
        }
    

        return null;
    }

    public function getMissingRecords()
    {
        return $this->missingRecords; 
    }
}