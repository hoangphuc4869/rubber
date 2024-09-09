<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rolling extends Model
{
    use HasFactory;

    protected $table = 'rubber_warehouses';

    protected $fillable = [
        'date',
        'code',
        'time',
        'curing_area',
        'curing_house',
        'date_curing',
        'weight_to_roll',
        'impurity_removing'
    ];

    public function rubbers()
    {
        return $this->hasMany(Rubber::class);
    }

    public function drums()
    {
        return $this->hasMany(Drum::class);
    }

    public function house()
    {
        return $this->belongsTo(CuringHouse::class, 'curing_house_id');
    }

    public function area()
    {
        return $this->belongsTo(CuringArea::class,'curing_area_id');
    }
}