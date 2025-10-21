<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_path',
        'backdrop_path',
        'release_date',
        'runtime',
        'rating',
        'vote_count',
        'status',
        'original_language',
        'original_title',
        'genres',
        'production_companies',
        'production_countries',
        'imdb_id',
        'tmdb_id',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'release_date' => 'date',
        'genres' => 'array',
        'production_companies' => 'array',
        'production_countries' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:1',
    ];

    /**
     * Relation avec les vidéos
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Obtenir l'URL complète du poster
     */
    public function getPosterUrlAttribute(): string
    {
        // Si l'URL est déjà complète, la retourner telle quelle
        if ($this->poster_path && (str_starts_with($this->poster_path, 'http://') || str_starts_with($this->poster_path, 'https://'))) {
            return $this->poster_path;
        }
        
        // Sinon, construire l'URL (pour compatibilité avec anciens enregistrements)
        if ($this->poster_path) {
            return config('tmdb.image_base_url') . 'w500' . $this->poster_path;
        }
        
        return asset('images/no-poster.jpg');
    }

    /**
     * Obtenir l'URL complète du backdrop
     */
    public function getBackdropUrlAttribute(): string
    {
        // Si l'URL est déjà complète, la retourner telle quelle
        if ($this->backdrop_path && (str_starts_with($this->backdrop_path, 'http://') || str_starts_with($this->backdrop_path, 'https://'))) {
            return $this->backdrop_path;
        }
        
        // Sinon, construire l'URL (pour compatibilité avec anciens enregistrements)
        if ($this->backdrop_path) {
            return config('tmdb.image_base_url') . 'w1280' . $this->backdrop_path;
        }
        
        return asset('images/no-backdrop.jpg');
    }

    /**
     * Scope pour les films actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les films en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope pour les films populaires
     */
    public function scopePopular($query)
    {
        return $query->orderBy('rating', 'desc')->orderBy('vote_count', 'desc');
    }

    /**
     * Scope pour les films récents
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    /**
     * Relation avec l'historique
     */
    public function history()
    {
        return $this->morphMany(History::class, 'watchable');
    }
}