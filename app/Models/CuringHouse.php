<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuringHouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function rollings() {
        return $this->hasMany(Rolling::class, 'receiving_place_id');
    }

    public function drums() {
        return $this->hasMany(Drum::class);
    }

    public function setYourColumnAttribute($value)
    {
        $this->attributes['containing'] = $value < 0 ? 0 : $value;
    }
}