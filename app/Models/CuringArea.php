<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuringArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'farm_id'];

    public function rubbers() {
        return $this->hasMany(Rubber::class, 'receiving_place_id');
    }

    public function rollings() {
        return $this->hasMany(Rolling::class, 'receiving_place_id');
    }

    public function farm() {
        return $this->belongsTo(Farm::class);
    }

    public function setYourColumnAttribute($value)
    {
        $this->attributes['containing'] = $value < 0 ? 0 : $value;
    }
}