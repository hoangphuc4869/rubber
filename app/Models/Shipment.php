<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_xuat',
        'loai_hang',
        'so_luong',
        'contract_id',
        'ngay_xuat',
    ];

   
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'shipment_id');
    }
}