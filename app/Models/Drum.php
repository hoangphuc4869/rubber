<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drum extends Model
{
    use HasFactory;

    protected $fillable = [
        'rolling_code',
        'status',
        'code',
        'name',
        'date',
        'time',
        'rolling_code',
        'thickness',
        'trang_thai_com',
        'inpurity_removing',
        'time_to_dry',
        'validation',
        'remaining_bales'
    ];

    public function rolling() {
        return $this->belongsTo(Rolling::class, 'rolling_code');
    }

    public function bale(){
        return $this->hasOne(Bale::class);
    }

    // public function batch(){
    //     return $this->belongsTo(Batch::class);
    // }

    public function curing_house(){
        return $this->belongsTo(CuringHouse::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_drum')
                    ->withPivot('bale_count')
                    ->withTimestamps();
    }
}