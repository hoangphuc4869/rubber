<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];
    

    public function farms()
	{
		return $this->hasMany(Farm::class);
	}

    public function batches()
	{
		return $this->hasMany(Batch::class);
	}

}