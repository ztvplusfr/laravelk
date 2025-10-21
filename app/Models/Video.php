<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'episode_id',
        'embed_url',
        'quality',
        'language',
        'subtitles',
        'is_ready',
        'is_processing',
        'is_active',
    ];

    protected $casts = [
        'subtitles' => 'array',
        'is_ready' => 'boolean',
        'is_processing' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec le film
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Relation avec l'épisode
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    /**
     * Scope pour les vidéos actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les vidéos prêtes
     */
    public function scopeReady($query)
    {
        return $query->where('is_ready', true);
    }

    /**
     * Scope pour les vidéos en cours de traitement
     */
    public function scopeProcessing($query)
    {
        return $query->where('is_processing', true);
    }

    /**
     * Scope pour les vidéos de films
     */
    public function scopeForMovies($query)
    {
        return $query->whereNotNull('movie_id');
    }

    /**
     * Scope pour les vidéos d'épisodes
     */
    public function scopeForEpisodes($query)
    {
        return $query->whereNotNull('episode_id');
    }

    /**
     * Scope par qualité
     */
    public function scopeByQuality($query, $quality)
    {
        return $query->where('quality', $quality);
    }

    /**
     * Scope par langue
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Relation avec l'historique
     */
    public function history()
    {
        return $this->hasMany(History::class);
    }
}