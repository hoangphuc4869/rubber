<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'expected_grade',
        'sample_cut_number',
        'packaging_type',
        'warehouse_id',
        'warehouse_bhck_id',
        'batch_code',
        'batch_number',
        'date',
        'time'
    ];

    // public function drums(){
    //     return $this->hasMany(Drum::class);
    // }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function bhckWarehouse()
    {
        return $this->belongsTo(BhckWarehouse::class, 'warehouse_bhck_id');
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function drums()
    {
        return $this->belongsToMany(Drum::class, 'batch_drum')
                    ->withPivot('bale_count')
                    ->withTimestamps();
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

}