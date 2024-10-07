<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContract extends Model
{
    use HasFactory;

     protected $fillable = [
        'contract_id',
        'contract_type_id', 
        'customer_id', 
        'contract_number', 
        'contract_date', 
        'thang_giao_hang', 
        'san_pham', 
        'loai_pallet', 
        'thi_truong', 
        'don_vi_xuat_thuong_mai', 
        'ban_cho_ben_thu_3', 
        'count_contract', 
        'file_scan_pdf',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

    public function contract_type()
	{
		return $this->belongsTo(ContractType::class);
	}
    
}