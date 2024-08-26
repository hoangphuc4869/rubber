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
        'batch_code',
        'batch_number',
        'date',
        'time'
    ];

    public function drums(){
        return $this->hasMany(Drum::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

}