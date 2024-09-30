<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = "contract";
    
    protected $fillable = [
		
    	'contract_type_id',

    	'so_ngay_hd',

    	'hd_goc_so',

    	'thang_giao_hang',

    	'customer_id',

    	'so_luong',

    	'san_pham',

    	'ngay_giao_hang',

    	'ngay_dong_cont',

    	'loai_pallet',

    	'lenh_xuat_hang',

    	'thi_truong',

    	'don_vi_xuat_thuong_mai',

    	'ban_cho_ben_thu_3',

    	'created_at',

    	'updated_at',

		'contract_number',
		'contract_date',
		'count_contract',
		'supplier'
    ];


	public function delivery_dates()
	{
		return $this->hasMany(DeliveryDate::class);
	}


	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

    public function contract_type()
	{
		return $this->belongsTo(ContractType::class);
	}

	public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}