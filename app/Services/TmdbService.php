<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;
    protected $imageBaseUrl;
    protected $language;

    public function __construct()
    {
        $this->apiKey = config('tmdb.api_key');
        $this->baseUrl = config('tmdb.base_url');
        $this->imageBaseUrl = config('tmdb.image_base_url');
        $this->language = config('tmdb.language');
    }

    /**
     * Vérifier si l'API TMDB est configurée
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && $this->apiKey !== 'your_tmdb_api_key_here';
    }

    /**
     * Faire une requête à l'API TMDB
     */
    public function makeRequest(string $endpoint, array $params = []): array
    {
        if (!$this->isConfigured()) {
            throw new \Exception('Clé API TMDB non configurée. Veuillez définir TMDB_API_KEY dans votre fichier .env');
        }

        $params['api_key'] = $this->apiKey;
        $params['language'] = $this->language;

        $cacheKey = 'tmdb_' . md5($endpoint . serialize($params));
        
        return Cache::remember($cacheKey, config('tmdb.cache.ttl', 3600), function () use ($endpoint, $params) {
            try {
                $response = Http::timeout(30)->get($this->baseUrl . $endpoint, $params);
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                Log::error('Erreur API TMDB', [
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new \Exception('Erreur API TMDB: ' . $response->status());
                
            } catch (\Exception $e) {
                Log::error('Exception TMDB', ['message' => $e->getMessage()]);
                throw $e;
            }
        });
    }

    /**
     * Rechercher des films
     */
    public function searchMovies(string $query, int $page = 1): array
    {
        return $this->makeRequest('/search/movie', [
            'query' => $query,
            'page' => $page,
        ]);
    }

    /**
     * Rechercher des séries TV
     */
    public function searchTvShows(string $query, int $page = 1): array
    {
        return $this->makeRequest('/search/tv', [
            'query' => $query,
            'page' => $page,
        ]);
    }

    /**
     * Obtenir les détails d'un film
     */
    public function getMovieDetails(int $movieId): array
    {
        return $this->makeRequest("/movie/{$movieId}");
    }

    /**
     * Obtenir les détails d'une série TV
     */
    public function getTvShowDetails(int $tvId): array
    {
        return $this->makeRequest("/tv/{$tvId}");
    }

    /**
     * Obtenir les films populaires
     */
    public function getPopularMovies(int $page = 1): array
    {
        return $this->makeRequest('/movie/popular', ['page' => $page]);
    }

    /**
     * Obtenir les séries TV populaires
     */
    public function getPopularTvShows(int $page = 1): array
    {
        return $this->makeRequest('/tv/popular', ['page' => $page]);
    }

    /**
     * Obtenir les films à venir
     */
    public function getUpcomingMovies(int $page = 1): array
    {
        return $this->makeRequest('/movie/upcoming', ['page' => $page]);
    }

    /**
     * Obtenir les films en cours de diffusion
     */
    public function getNowPlayingMovies(int $page = 1): array
    {
        return $this->makeRequest('/movie/now_playing', ['page' => $page]);
    }

    /**
     * Obtenir les séries TV en cours de diffusion
     */
    public function getOnTheAirTvShows(int $page = 1): array
    {
        return $this->makeRequest('/tv/on_the_air', ['page' => $page]);
    }

    /**
     * Obtenir l'URL complète d'une image
     */
    public function getImageUrl(string $path, string $size = 'w500'): string
    {
        if (empty($path)) {
            return $this->getDefaultImageUrl();
        }
        
        return $this->imageBaseUrl . $size . $path;
    }

    /**
     * Obtenir l'URL de l'image par défaut
     */
    public function getDefaultImageUrl(): string
    {
        return asset('images/no-poster.jpg');
    }

    /**
     * Obtenir les genres de films
     */
    public function getMovieGenres(): array
    {
        return $this->makeRequest('/genre/movie/list');
    }

    /**
     * Obtenir les genres de séries TV
     */
    public function getTvGenres(): array
    {
        return $this->makeRequest('/genre/tv/list');
    }

    /**
     * Tester la connexion à l'API
     */
    public function testConnection(): array
    {
        try {
            $response = $this->makeRequest('/configuration');
            return [
                'success' => true,
                'message' => 'Connexion TMDB réussie',
                'data' => $response
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur de connexion TMDB: ' . $e->getMessage()
            ];
        }
    }
}
