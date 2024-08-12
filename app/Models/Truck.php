<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'farm_id'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function rubbers() {
        return $this->hasMany(Rubber::class, 'truck_id');
    }
}