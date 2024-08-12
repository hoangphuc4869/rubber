<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuringArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function rubbers() {
        return $this->hasMany(Rubber::class, 'receiving_place_id');
    }
}