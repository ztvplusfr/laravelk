<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id',
    ];

    /**
     * Relation polymorphique avec Movie ou Series
     */
    public function watchable()
    {
        return $this->morphTo();
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
