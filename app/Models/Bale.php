<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bale extends Model
{
    use HasFactory;

    protected $fillable = [
        'press_temperature',
        'number_of_bales',
        'batch_number',
        'batch_code',
        'weight',
        'cut_check',
        'evaluation',
        'expected_grade',
        'sample_cut_number',
        'packaging_type',
        'storage_location',
        'date',
        'time',
    ];

    public function drum(){
        return $this->belongsTo(Drum::class);
    }
}