<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'season_id',
        'name',
        'description',
        'still_path',
        'episode_number',
        'air_date',
        'runtime',
        'rating',
        'vote_count',
        'tmdb_id',
        'is_active',
    ];

    protected $casts = [
        'air_date' => 'date',
        'is_active' => 'boolean',
        'rating' => 'decimal:1',
    ];

    /**
     * Relation avec la série
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Relation avec la saison
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Relation avec les vidéos
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Obtenir l'URL complète du still
     */
    public function getStillUrlAttribute(): string
    {
        if ($this->still_path) {
            return config('tmdb.image_base_url') . 'w500' . $this->still_path;
        }
        return asset('images/no-still.jpg');
    }

    /**
     * Scope pour les épisodes actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les épisodes d'une série
     */
    public function scopeForSeries($query, $seriesId)
    {
        return $query->where('series_id', $seriesId);
    }

    /**
     * Scope pour les épisodes d'une saison
     */
    public function scopeForSeason($query, $seasonId)
    {
        return $query->where('season_id', $seasonId);
    }
}