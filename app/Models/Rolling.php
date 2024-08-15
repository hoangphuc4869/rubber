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
        'date_curing'
    ];

    public function rubbers()
    {
        return $this->hasMany(Rubber::class);
    }

    public function drums()
    {
        return $this->hasMany(Drum::class);
    }
}