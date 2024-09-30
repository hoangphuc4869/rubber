<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'stack', 'batch_code', 'status', 'batch_id'];

    public function batches(){
        return $this->hasMany(Batch::class);
    }
}