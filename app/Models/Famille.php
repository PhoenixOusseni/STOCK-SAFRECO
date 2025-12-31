<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $fillable = [
        'code',
        'designation',
        'taux_amortissement',
    ];

    /**
     * Relation avec les articles
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'famille_id');
    }
}
