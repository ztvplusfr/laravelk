<?php

return [
    /*
    |--------------------------------------------------------------------------
    | TMDB API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'API The Movie Database (TMDB)
    | Obtenez votre clé API sur https://www.themoviedb.org/settings/api
    |
    */

    'api_key' => env('TMDB_API_KEY'),
    'base_url' => env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'),
    'image_base_url' => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p'),
    'language' => env('TMDB_LANGUAGE', 'fr-FR'),
    
    /*
    |--------------------------------------------------------------------------
    | Image Sizes
    |--------------------------------------------------------------------------
    |
    | Tailles d'images disponibles pour les affiches et photos
    |
    */
    'image_sizes' => [
        'poster' => [
            'w92' => 'w92',
            'w154' => 'w154',
            'w185' => 'w185',
            'w342' => 'w342',
            'w500' => 'w500',
            'w780' => 'w780',
            'original' => 'original',
        ],
        'backdrop' => [
            'w300' => 'w300',
            'w780' => 'w780',
            'w1280' => 'w1280',
            'original' => 'original',
        ],
        'profile' => [
            'w45' => 'w45',
            'w185' => 'w185',
            'h632' => 'h632',
            'original' => 'original',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration du cache pour les requêtes TMDB
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 heure en secondes
        'prefix' => 'tmdb_',
    ],
];

