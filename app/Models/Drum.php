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
    ];

    public function rolling() {
        return $this->belongsTo(Rolling::class, 'rolling_code');
    }

    public function bale(){
        return $this->hasOne(Bale::class);
    }

    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}