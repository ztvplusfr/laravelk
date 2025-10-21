<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supabase Configuration
    |--------------------------------------------------------------------------
    |
    | Cette configuration contient les informations d'identification pour l'API Supabase.
    |
    */

    'storage' => [
        'bucket' => env('SUPABASE_STORAGE_BUCKET', 'ztvplusfr'),
        'endpoint' => env('SUPABASE_STORAGE_ENDPOINT', 'https://mnpcicsbeiryxbgovpxq.storage.supabase.co'),
        'public_url' => env('SUPABASE_STORAGE_PUBLIC_URL', 'https://mnpcicsbeiryxbgovpxq.storage.supabase.co/storage/v1/object/public'),
    ],
];
