<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Rubber extends Model
{
    use HasFactory, HasApiTokens;

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
        'grade',
        'date',
        'time',
        'supervisor',
        'truck_name',
        'farm_name',
        'or_time',
        'input_status',
        'package_code',
        'trong_luong_vao',
        'trong_luong_ra',
        'khoi_luong_phieu',
        'tai_xe',
        'kho',
        'note',
        'loai_phieu'
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

    public function rubber_warehouse()
    {
        return $this->belongsTo(Rolling::class, 'rubber_warehouse_id');
    }
}