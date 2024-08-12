<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function rubbers() {
        return $this->hasMany(Rubber::class, 'farm_id');
    }
}