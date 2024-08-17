<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrumPerDay extends Model
{
    use HasFactory;

    protected $table = 'drums_per_day';

    protected $fillable = [
        'date',
        'number'
    ];


}