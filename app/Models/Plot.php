<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    use HasFactory;

    public function farm() {
        return $this->belongsTo(Farm::class);
    }

    public function rubbers()
    {
        return $this->belongsToMany(Rubber::class, 'plot_rubber')
                    ->withPivot('to_nt', 'lat_cao')
                    ->withTimestamps();
    }
}