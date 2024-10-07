<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;

    protected $table = "contract_type";

    protected $fillable = [
        'name',
        'type',
        'code'
    ];

    public function contract_type()
	{
		return $this->hasMany(Contract::class);
	}

    public function contract_type_sub()
	{
		return $this->hasMany(Contract::class);
	}
}