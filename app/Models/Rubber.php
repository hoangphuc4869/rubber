<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubber extends Model
{
    use HasFactory;

    protected $table = 'rubber';

    protected $fillable = [
        'status',
        'truck_id',
        'farm_id',
        'receiving_place_id',
        'latex_type',
        'material_age',
        'fresh_weight',
        'drc_percentage',
        'dry_weight',
        'material_condition',
        'impurity_type',
        'grade'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }

    public function curing_area()
    {
        return $this->belongsTo(CuringArea::class, 'receiving_place_id');
    }
}