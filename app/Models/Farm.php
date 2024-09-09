<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'company_id'];

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function rubbers() {
        return $this->hasMany(Rubber::class, 'farm_id');
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function curing_areas() {
        return $this->hasMany(CuringArea::class, 'farm_id');
    }
}