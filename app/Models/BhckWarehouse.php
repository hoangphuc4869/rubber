<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BhckWarehouse extends Model
{
    use HasFactory;

    protected $table = 'bhck_warehouse';

    protected $fillable = ['name', 'code', 'batch_id'];

    public function batch()
    {
        return $this->hasMany(Batch::class, 'warehouse_bhck_id');
    }
}