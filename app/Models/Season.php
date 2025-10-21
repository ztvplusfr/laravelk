<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'name',
        'description',
        'poster_path',
        'season_number',
        'air_date',
        'episode_count',
        'tmdb_id',
        'is_active',
    ];

    protected $casts = [
        'air_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec la série
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Relation avec les épisodes
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * Obtenir l'URL complète du poster
     */
    public function getPosterUrlAttribute(): string
    {
        if ($this->poster_path) {
            return config('tmdb.image_base_url') . 'w500' . $this->poster_path;
        }
        return asset('images/no-poster.jpg');
    }

    /**
     * Scope pour les saisons actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les saisons d'une série
     */
    public function scopeForSeries($query, $seriesId)
    {
        return $query->where('series_id', $seriesId);
    }
}