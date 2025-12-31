<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bureau extends Model
{
    protected $guarded = [

    ];

    public function depot()
    {
        return $this->belongsTo(Depot::class, 'depot_id');
    }
}
