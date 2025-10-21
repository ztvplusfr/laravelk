<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Video;
use App\Services\TmdbService;

class AdminController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * Afficher le tableau de bord administrateur
     */
    public function dashboard()
    {
        // Vérifier que l'utilisateur est admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé. Seuls les administrateurs peuvent accéder à cette page.');
        }

        // Statistiques générales
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('created_at', '>=', now()->subDays(30))->count(),
                'admins' => User::where('role', 'admin')->count(),
            ],
            'movies' => [
                'total' => Movie::count(),
                'active' => Movie::where('is_active', true)->count(),
                'featured' => Movie::where('is_featured', true)->count(),
                'recent' => Movie::where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'series' => [
                'total' => Series::count(),
                'active' => Series::where('is_active', true)->count(),
                'featured' => Series::where('is_featured', true)->count(),
                'recent' => Series::where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'episodes' => [
                'total' => Episode::count(),
                'active' => Episode::where('is_active', true)->count(),
                'recent' => Episode::where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'videos' => [
                'total' => Video::count(),
                'ready' => Video::where('is_ready', true)->count(),
                'processing' => Video::where('is_processing', true)->count(),
                'active' => Video::where('is_active', true)->count(),
            ],
        ];

        // Contenu récent
        $recentMovies = Movie::with('videos')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentSeries = Series::with(['seasons', 'episodes'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Films et séries populaires
        $popularMovies = Movie::active()
            ->popular()
            ->limit(5)
            ->get();

        $popularSeries = Series::active()
            ->popular()
            ->limit(5)
            ->get();

        // Statistiques par mois (derniers 6 mois)
        $monthlyStats = $this->getMonthlyStats();

        return view('admin.dashboard', compact(
            'stats',
            'recentMovies',
            'recentSeries',
            'recentUsers',
            'popularMovies',
            'popularSeries',
            'monthlyStats'
        ));
    }

    /**
     * Obtenir les statistiques mensuelles
     */
    private function getMonthlyStats()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'movies' => Movie::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'series' => Series::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $months;
    }

    /**
     * Gérer les films
     */
    public function movies()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $movies = Movie::with('videos')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Movie::count(),
            'active' => Movie::where('is_active', true)->count(),
            'featured' => Movie::where('is_featured', true)->count(),
            'recent' => Movie::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.movies', compact('movies', 'stats'));
    }

    /**
     * Gérer les séries
     */
    public function series()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $series = Series::with(['seasons', 'episodes'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Series::count(),
            'active' => Series::where('is_active', true)->count(),
            'featured' => Series::where('is_featured', true)->count(),
            'recent' => Series::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.series', compact('series', 'stats'));
    }

    /**
     * Gérer les utilisateurs
     */
    public function users()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $users = User::orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'recent' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    /**
     * Page d'import TMDB
     */
    public function import()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        return view('admin.import');
    }

    /**
     * Tester la connexion TMDB
     */
    public function testTmdb()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $result = $this->tmdbService->testConnection();
        
        return response()->json($result);
    }

    /**
     * Rechercher du contenu sur TMDB
     */
    public function searchTmdb(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $query = $request->get('q');
        $type = $request->get('type', 'movie');

        if (empty($query)) {
            return response()->json(['error' => 'Requête vide'], 400);
        }

        try {
            if ($type === 'movie') {
                $results = $this->tmdbService->searchMovies($query);
            } else {
                $results = $this->tmdbService->searchTvShows($query);
            }

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Synchroniser tous les films avec TMDB
     */
    public function syncMovies(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $movies = Movie::whereNotNull('tmdb_id')->get();
            
            $updated = 0;
            $errors = [];

            foreach ($movies as $movie) {
                try {
                    // Récupérer les détails à jour depuis TMDB
                    $movieDetails = $this->tmdbService->getMovieDetails($movie->tmdb_id);

                    // Construire les URLs complètes des images
                    $posterUrl = null;
                    $backdropUrl = null;
                    
                    if (!empty($movieDetails['poster_path'])) {
                        $posterUrl = $this->tmdbService->getImageUrl($movieDetails['poster_path'], 'original');
                    }
                    
                    if (!empty($movieDetails['backdrop_path'])) {
                        $backdropUrl = $this->tmdbService->getImageUrl($movieDetails['backdrop_path'], 'original');
                    }

                    // Mettre à jour le film
                    $movie->update([
                        'title' => $movieDetails['title'] ?? $movie->title,
                        'description' => $movieDetails['overview'] ?? $movie->description,
                        'poster_path' => $posterUrl ?? $movie->poster_path,
                        'backdrop_path' => $backdropUrl ?? $movie->backdrop_path,
                        'release_date' => !empty($movieDetails['release_date']) ? $movieDetails['release_date'] : $movie->release_date,
                        'runtime' => $movieDetails['runtime'] ?? $movie->runtime,
                        'rating' => $movieDetails['vote_average'] ?? $movie->rating,
                        'vote_count' => $movieDetails['vote_count'] ?? $movie->vote_count,
                        'status' => $movieDetails['status'] ?? $movie->status,
                        'original_language' => $movieDetails['original_language'] ?? $movie->original_language,
                        'original_title' => $movieDetails['original_title'] ?? $movie->original_title,
                        'genres' => !empty($movieDetails['genres']) ? $movieDetails['genres'] : $movie->genres,
                        'production_companies' => !empty($movieDetails['production_companies']) ? $movieDetails['production_companies'] : $movie->production_companies,
                        'production_countries' => !empty($movieDetails['production_countries']) ? $movieDetails['production_countries'] : $movie->production_countries,
                        'imdb_id' => $movieDetails['imdb_id'] ?? $movie->imdb_id,
                    ]);

                    $updated++;
                } catch (\Exception $e) {
                    $errors[] = "Erreur pour '{$movie->title}': " . $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Synchronisation terminée : {$updated} film(s) mis à jour sur " . $movies->count(),
                'updated' => $updated,
                'total' => $movies->count(),
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la synchronisation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importer un film depuis TMDB
     */
    public function importMovie(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $tmdbId = $request->input('tmdb_id');

        if (empty($tmdbId)) {
            return response()->json(['error' => 'ID TMDB manquant'], 400);
        }

        try {
            // Vérifier si le film existe déjà
            $existingMovie = Movie::where('tmdb_id', $tmdbId)->first();
            if ($existingMovie) {
                return response()->json([
                    'error' => 'Ce film existe déjà dans votre base de données',
                    'movie' => $existingMovie
                ], 409);
            }

            // Récupérer les détails complets du film depuis TMDB
            $movieDetails = $this->tmdbService->getMovieDetails($tmdbId);

            // Construire les URLs complètes des images
            $posterUrl = null;
            $backdropUrl = null;
            
            if (!empty($movieDetails['poster_path'])) {
                $posterUrl = $this->tmdbService->getImageUrl($movieDetails['poster_path'], 'original');
            }
            
            if (!empty($movieDetails['backdrop_path'])) {
                $backdropUrl = $this->tmdbService->getImageUrl($movieDetails['backdrop_path'], 'original');
            }

            // Créer le film dans la base de données
            $movie = Movie::create([
                'title' => $movieDetails['title'] ?? 'Sans titre',
                'description' => $movieDetails['overview'] ?? null,
                'poster_path' => $posterUrl,
                'backdrop_path' => $backdropUrl,
                'release_date' => !empty($movieDetails['release_date']) ? $movieDetails['release_date'] : null,
                'runtime' => $movieDetails['runtime'] ?? null,
                'rating' => $movieDetails['vote_average'] ?? null,
                'vote_count' => $movieDetails['vote_count'] ?? 0,
                'status' => $movieDetails['status'] ?? 'released',
                'original_language' => $movieDetails['original_language'] ?? null,
                'original_title' => $movieDetails['original_title'] ?? null,
                'genres' => !empty($movieDetails['genres']) ? $movieDetails['genres'] : null,
                'production_companies' => !empty($movieDetails['production_companies']) ? $movieDetails['production_companies'] : null,
                'production_countries' => !empty($movieDetails['production_countries']) ? $movieDetails['production_countries'] : null,
                'imdb_id' => $movieDetails['imdb_id'] ?? null,
                'tmdb_id' => $tmdbId,
                'is_featured' => false,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Film importé avec succès',
                'movie' => $movie
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'import: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher le formulaire d'édition d'un film
     */
    public function editMovie($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $movie = Movie::with('videos')->findOrFail($id);
        
        return view('admin.edit-movie', compact('movie'));
    }

    /**
     * Mettre à jour un film
     */
    public function updateMovie(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $movie = Movie::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'poster_path' => 'nullable|url',
                'backdrop_path' => 'nullable|url',
                'release_date' => 'nullable|date',
                'runtime' => 'nullable|integer|min:0',
                'rating' => 'nullable|numeric|min:0|max:10',
                'status' => 'nullable|string',
                'original_language' => 'nullable|string|max:10',
                'original_title' => 'nullable|string|max:255',
                'imdb_id' => 'nullable|string|max:20',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
            ], [
                'title.required' => 'Le titre est obligatoire.',
                'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
                'poster_path.url' => 'L\'URL du poster doit être valide.',
                'backdrop_path.url' => 'L\'URL du backdrop doit être valide.',
                'release_date.date' => 'La date de sortie doit être une date valide.',
                'runtime.integer' => 'La durée doit être un nombre entier.',
                'runtime.min' => 'La durée doit être positive.',
                'rating.numeric' => 'La note doit être un nombre.',
                'rating.min' => 'La note doit être entre 0 et 10.',
                'rating.max' => 'La note doit être entre 0 et 10.',
            ]);

            // Mettre à jour le film
            $movie->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? $movie->description,
                'poster_path' => $validated['poster_path'] ?? $movie->poster_path,
                'backdrop_path' => $validated['backdrop_path'] ?? $movie->backdrop_path,
                'release_date' => $validated['release_date'] ?? $movie->release_date,
                'runtime' => $validated['runtime'] ?? $movie->runtime,
                'rating' => $validated['rating'] ?? $movie->rating,
                'status' => $validated['status'] ?? $movie->status,
                'original_language' => $validated['original_language'] ?? $movie->original_language,
                'original_title' => $validated['original_title'] ?? $movie->original_title,
                'imdb_id' => $validated['imdb_id'] ?? $movie->imdb_id,
                'is_featured' => $request->has('is_featured') ? true : false,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect()->route('admin.movies')
                ->with('success', "Le film '{$movie->title}' a été mis à jour avec succès.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Supprimer un film
     */
    public function deleteMovie($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $movie = Movie::findOrFail($id);
            $movieTitle = $movie->title;
            
            // Supprimer le film (les vidéos seront supprimées en cascade grâce à onDelete('cascade'))
            $movie->delete();

            return response()->json([
                'success' => true,
                'message' => "Le film '{$movieTitle}' a été supprimé avec succès."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher le formulaire d'édition d'une série
     */
    public function editSeries($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $series = Series::with(['seasons.episodes'])->findOrFail($id);
        
        return view('admin.edit-series', compact('series'));
    }

    /**
     * Mettre à jour une série
     */
    public function updateSeries(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $series = Series::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'poster_path' => 'nullable|url',
                'backdrop_path' => 'nullable|url',
                'first_air_date' => 'nullable|date',
                'last_air_date' => 'nullable|date',
                'number_of_seasons' => 'nullable|integer|min:0',
                'number_of_episodes' => 'nullable|integer|min:0',
                'rating' => 'nullable|numeric|min:0|max:10',
                'status' => 'nullable|string',
                'original_language' => 'nullable|string|max:10',
                'original_title' => 'nullable|string|max:255',
                'imdb_id' => 'nullable|string|max:20',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
            ], [
                'title.required' => 'Le titre est obligatoire.',
                'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
                'poster_path.url' => 'L\'URL du poster doit être valide.',
                'backdrop_path.url' => 'L\'URL du backdrop doit être valide.',
                'first_air_date.date' => 'La date de première diffusion doit être une date valide.',
                'last_air_date.date' => 'La date de dernière diffusion doit être une date valide.',
                'number_of_seasons.integer' => 'Le nombre de saisons doit être un nombre entier.',
                'number_of_seasons.min' => 'Le nombre de saisons doit être positif.',
                'number_of_episodes.integer' => 'Le nombre d\'épisodes doit être un nombre entier.',
                'number_of_episodes.min' => 'Le nombre d\'épisodes doit être positif.',
                'rating.numeric' => 'La note doit être un nombre.',
                'rating.min' => 'La note doit être entre 0 et 10.',
                'rating.max' => 'La note doit être entre 0 et 10.',
            ]);

            // Mettre à jour la série
            $series->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? $series->description,
                'poster_path' => $validated['poster_path'] ?? $series->poster_path,
                'backdrop_path' => $validated['backdrop_path'] ?? $series->backdrop_path,
                'first_air_date' => $validated['first_air_date'] ?? $series->first_air_date,
                'last_air_date' => $validated['last_air_date'] ?? $series->last_air_date,
                'number_of_seasons' => $validated['number_of_seasons'] ?? $series->number_of_seasons,
                'number_of_episodes' => $validated['number_of_episodes'] ?? $series->number_of_episodes,
                'rating' => $validated['rating'] ?? $series->rating,
                'status' => $validated['status'] ?? $series->status,
                'original_language' => $validated['original_language'] ?? $series->original_language,
                'original_title' => $validated['original_title'] ?? $series->original_title,
                'imdb_id' => $validated['imdb_id'] ?? $series->imdb_id,
                'is_featured' => $request->has('is_featured') ? true : false,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect()->route('admin.series')
                ->with('success', "La série '{$series->title}' a été mise à jour avec succès.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher le formulaire d'édition d'une saison
     */
    public function editSeason($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $season = Season::with(['series', 'episodes'])->findOrFail($id);
        
        return view('admin.edit-season', compact('season'));
    }

    /**
     * Mettre à jour une saison
     */
    public function updateSeason(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $season = Season::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'poster_path' => 'nullable|url',
                'air_date' => 'nullable|date',
                'episode_count' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'poster_path.url' => 'L\'URL du poster doit être valide.',
                'air_date.date' => 'La date de diffusion doit être une date valide.',
                'episode_count.integer' => 'Le nombre d\'épisodes doit être un nombre entier.',
                'episode_count.min' => 'Le nombre d\'épisodes doit être positif.',
            ]);

            // Mettre à jour la saison
            $season->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? $season->description,
                'poster_path' => $validated['poster_path'] ?? $season->poster_path,
                'air_date' => $validated['air_date'] ?? $season->air_date,
                'episode_count' => $validated['episode_count'] ?? $season->episode_count,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect()->route('admin.edit-series', $season->series_id)
                ->with('success', "La saison '{$season->name}' a été mise à jour avec succès.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher le formulaire d'édition d'un épisode
     */
    public function editEpisode($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $episode = Episode::with(['series', 'season', 'videos'])->findOrFail($id);
        
        return view('admin.edit-episode', compact('episode'));
    }

    /**
     * Mettre à jour un épisode
     */
    public function updateEpisode(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $episode = Episode::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'still_path' => 'nullable|url',
                'air_date' => 'nullable|date',
                'runtime' => 'nullable|integer|min:0',
                'rating' => 'nullable|numeric|min:0|max:10',
                'is_active' => 'boolean',
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'still_path.url' => 'L\'URL de l\'image doit être valide.',
                'air_date.date' => 'La date de diffusion doit être une date valide.',
                'runtime.integer' => 'La durée doit être un nombre entier.',
                'runtime.min' => 'La durée doit être positive.',
                'rating.numeric' => 'La note doit être un nombre.',
                'rating.min' => 'La note doit être entre 0 et 10.',
                'rating.max' => 'La note doit être entre 0 et 10.',
            ]);

            // Mettre à jour l'épisode
            $episode->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? $episode->description,
                'still_path' => $validated['still_path'] ?? $episode->still_path,
                'air_date' => $validated['air_date'] ?? $episode->air_date,
                'runtime' => $validated['runtime'] ?? $episode->runtime,
                'rating' => $validated['rating'] ?? $episode->rating,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect()->route('admin.edit-series', $episode->series_id)
                ->with('success', "L'épisode '{$episode->name}' a été mis à jour avec succès.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Supprimer une série
     */
    public function deleteSeries($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $series = Series::findOrFail($id);
            $seriesTitle = $series->title;
            
            // Compter les saisons et épisodes avant suppression
            $seasonsCount = $series->seasons()->count();
            $episodesCount = $series->episodes()->count();
            
            // Supprimer la série (les saisons, épisodes et vidéos seront supprimés en cascade)
            $series->delete();

            return response()->json([
                'success' => true,
                'message' => "La série '{$seriesTitle}' a été supprimée avec succès (incluant {$seasonsCount} saison(s) et {$episodesCount} épisode(s))."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajouter une vidéo
     */
    public function storeVideo(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $validated = $request->validate([
                'movie_id' => 'nullable|exists:movies,id',
                'episode_id' => 'nullable|exists:episodes,id',
                'embed_url' => 'required|url',
                'quality' => 'required|string',
                'language' => 'required|string|max:5',
                'subtitles' => 'nullable|string',
            ]);

            // Traiter les sous-titres
            $subtitles = null;
            if (!empty($validated['subtitles'])) {
                $subtitles = array_map('trim', explode(',', $validated['subtitles']));
            }

            $video = Video::create([
                'movie_id' => $validated['movie_id'] ?? null,
                'episode_id' => $validated['episode_id'] ?? null,
                'embed_url' => $validated['embed_url'],
                'quality' => $validated['quality'],
                'language' => $validated['language'],
                'subtitles' => $subtitles,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vidéo ajoutée avec succès',
                'video' => $video
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'ajout: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une vidéo
     */
    public function updateVideo(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $video = Video::findOrFail($id);

            $validated = $request->validate([
                'embed_url' => 'required|url',
                'quality' => 'required|string',
                'language' => 'required|string|max:5',
                'subtitles' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            // Traiter les sous-titres
            $subtitles = null;
            if (!empty($validated['subtitles'])) {
                $subtitles = array_map('trim', explode(',', $validated['subtitles']));
            }

            $video->update([
                'embed_url' => $validated['embed_url'],
                'quality' => $validated['quality'],
                'language' => $validated['language'],
                'subtitles' => $subtitles,
                'is_active' => $request->has('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vidéo mise à jour avec succès',
                'video' => $video
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une vidéo
     */
    public function deleteVideo($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Vidéo supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Synchroniser toutes les séries avec TMDB
     */
    public function syncSeries(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        try {
            $series = Series::whereNotNull('tmdb_id')->get();
            
            $updated = 0;
            $seasonsUpdated = 0;
            $seasonsCreated = 0;
            $episodesUpdated = 0;
            $episodesCreated = 0;
            $errors = [];

            foreach ($series as $serie) {
                try {
                    // Récupérer les détails à jour depuis TMDB
                    $seriesDetails = $this->tmdbService->getTvShowDetails($serie->tmdb_id);

                    // Construire les URLs complètes des images
                    $posterUrl = null;
                    $backdropUrl = null;
                    
                    if (!empty($seriesDetails['poster_path'])) {
                        $posterUrl = $this->tmdbService->getImageUrl($seriesDetails['poster_path'], 'original');
                    }
                    
                    if (!empty($seriesDetails['backdrop_path'])) {
                        $backdropUrl = $this->tmdbService->getImageUrl($seriesDetails['backdrop_path'], 'original');
                    }

                    // Mettre à jour la série
                    $serie->update([
                        'title' => $seriesDetails['name'] ?? $serie->title,
                        'description' => $seriesDetails['overview'] ?? $serie->description,
                        'poster_path' => $posterUrl ?? $serie->poster_path,
                        'backdrop_path' => $backdropUrl ?? $serie->backdrop_path,
                        'first_air_date' => !empty($seriesDetails['first_air_date']) ? $seriesDetails['first_air_date'] : $serie->first_air_date,
                        'last_air_date' => !empty($seriesDetails['last_air_date']) ? $seriesDetails['last_air_date'] : $serie->last_air_date,
                        'number_of_seasons' => $seriesDetails['number_of_seasons'] ?? $serie->number_of_seasons,
                        'number_of_episodes' => $seriesDetails['number_of_episodes'] ?? $serie->number_of_episodes,
                        'rating' => $seriesDetails['vote_average'] ?? $serie->rating,
                        'vote_count' => $seriesDetails['vote_count'] ?? $serie->vote_count,
                        'status' => $seriesDetails['status'] ?? $serie->status,
                        'original_language' => $seriesDetails['original_language'] ?? $serie->original_language,
                        'original_title' => $seriesDetails['original_name'] ?? $serie->original_title,
                        'genres' => !empty($seriesDetails['genres']) ? $seriesDetails['genres'] : $serie->genres,
                        'production_companies' => !empty($seriesDetails['production_companies']) ? $seriesDetails['production_companies'] : $serie->production_companies,
                        'production_countries' => !empty($seriesDetails['production_countries']) ? $seriesDetails['production_countries'] : $serie->production_countries,
                        'networks' => !empty($seriesDetails['networks']) ? $seriesDetails['networks'] : $serie->networks,
                        'imdb_id' => $seriesDetails['external_ids']['imdb_id'] ?? $serie->imdb_id,
                    ]);

                    $updated++;

                    // Synchroniser les saisons et épisodes
                    if (!empty($seriesDetails['seasons'])) {
                        foreach ($seriesDetails['seasons'] as $seasonData) {
                            // Ignorer la saison 0 (Spéciaux)
                            if ($seasonData['season_number'] == 0) {
                                continue;
                            }

                            try {
                                // Vérifier si la saison existe déjà
                                $existingSeason = Season::where('series_id', $serie->id)
                                    ->where('season_number', $seasonData['season_number'])
                                    ->first();

                                // Récupérer les détails complets de la saison
                                $seasonDetails = $this->tmdbService->makeRequest("/tv/{$serie->tmdb_id}/season/{$seasonData['season_number']}");

                                // Construire l'URL du poster de la saison
                                $seasonPosterUrl = null;
                                if (!empty($seasonDetails['poster_path'])) {
                                    $seasonPosterUrl = $this->tmdbService->getImageUrl($seasonDetails['poster_path'], 'original');
                                }

                                $seasonDataToSave = [
                                    'name' => $seasonDetails['name'] ?? "Saison {$seasonData['season_number']}",
                                    'description' => $seasonDetails['overview'] ?? null,
                                    'poster_path' => $seasonPosterUrl,
                                    'air_date' => !empty($seasonDetails['air_date']) ? $seasonDetails['air_date'] : null,
                                    'episode_count' => $seasonDetails['episodes'] ? count($seasonDetails['episodes']) : 0,
                                    'tmdb_id' => $seasonDetails['id'] ?? null,
                                    'is_active' => true,
                                ];

                                if ($existingSeason) {
                                    // Mettre à jour la saison existante
                                    $existingSeason->update($seasonDataToSave);
                                    $season = $existingSeason;
                                    $seasonsUpdated++;
                                } else {
                                    // Créer une nouvelle saison
                                    $season = Season::create(array_merge($seasonDataToSave, [
                                        'series_id' => $serie->id,
                                        'season_number' => $seasonData['season_number'],
                                    ]));
                                    $seasonsCreated++;
                                }

                                // Synchroniser les épisodes de cette saison
                                if (!empty($seasonDetails['episodes'])) {
                                    foreach ($seasonDetails['episodes'] as $episodeData) {
                                        // Vérifier si l'épisode existe déjà
                                        $existingEpisode = Episode::where('season_id', $season->id)
                                            ->where('episode_number', $episodeData['episode_number'])
                                            ->first();

                                        // Construire l'URL du still de l'épisode
                                        $stillUrl = null;
                                        if (!empty($episodeData['still_path'])) {
                                            $stillUrl = $this->tmdbService->getImageUrl($episodeData['still_path'], 'original');
                                        }

                                        $episodeDataToSave = [
                                            'name' => $episodeData['name'] ?? "Épisode {$episodeData['episode_number']}",
                                            'description' => $episodeData['overview'] ?? null,
                                            'still_path' => $stillUrl,
                                            'air_date' => !empty($episodeData['air_date']) ? $episodeData['air_date'] : null,
                                            'runtime' => $episodeData['runtime'] ?? null,
                                            'rating' => $episodeData['vote_average'] ?? null,
                                            'vote_count' => $episodeData['vote_count'] ?? 0,
                                            'tmdb_id' => $episodeData['id'] ?? null,
                                            'is_active' => true,
                                        ];

                                        if ($existingEpisode) {
                                            // Mettre à jour l'épisode existant
                                            $existingEpisode->update($episodeDataToSave);
                                            $episodesUpdated++;
                                        } else {
                                            // Créer un nouvel épisode
                                            Episode::create(array_merge($episodeDataToSave, [
                                                'series_id' => $serie->id,
                                                'season_id' => $season->id,
                                                'episode_number' => $episodeData['episode_number'],
                                            ]));
                                            $episodesCreated++;
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                Log::error("Erreur lors de la synchro de la saison {$seasonData['season_number']} pour '{$serie->title}': " . $e->getMessage());
                            }
                        }
                    }

                } catch (\Exception $e) {
                    $errors[] = "Erreur pour '{$serie->title}': " . $e->getMessage();
                }
            }

            $message = "Synchronisation terminée : {$updated} série(s), {$seasonsUpdated} saison(s) mises à jour, {$seasonsCreated} saison(s) créées, {$episodesUpdated} épisode(s) mis à jour, {$episodesCreated} épisode(s) créés";

            return response()->json([
                'success' => true,
                'message' => $message,
                'updated' => $updated,
                'total' => $series->count(),
                'seasons_updated' => $seasonsUpdated,
                'seasons_created' => $seasonsCreated,
                'episodes_updated' => $episodesUpdated,
                'episodes_created' => $episodesCreated,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la synchronisation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importer une série depuis TMDB
     */
    public function importSeries(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        $tmdbId = $request->input('tmdb_id');

        if (empty($tmdbId)) {
            return response()->json(['error' => 'ID TMDB manquant'], 400);
        }

        try {
            // Vérifier si la série existe déjà
            $existingSeries = Series::where('tmdb_id', $tmdbId)->first();
            if ($existingSeries) {
                return response()->json([
                    'error' => 'Cette série existe déjà dans votre base de données',
                    'series' => $existingSeries
                ], 409);
            }

            // Récupérer les détails complets de la série depuis TMDB
            $seriesDetails = $this->tmdbService->getTvShowDetails($tmdbId);

            // Construire les URLs complètes des images
            $posterUrl = null;
            $backdropUrl = null;
            
            if (!empty($seriesDetails['poster_path'])) {
                $posterUrl = $this->tmdbService->getImageUrl($seriesDetails['poster_path'], 'original');
            }
            
            if (!empty($seriesDetails['backdrop_path'])) {
                $backdropUrl = $this->tmdbService->getImageUrl($seriesDetails['backdrop_path'], 'original');
            }

            // Créer la série dans la base de données
            $series = Series::create([
                'title' => $seriesDetails['name'] ?? 'Sans titre',
                'description' => $seriesDetails['overview'] ?? null,
                'poster_path' => $posterUrl,
                'backdrop_path' => $backdropUrl,
                'first_air_date' => !empty($seriesDetails['first_air_date']) ? $seriesDetails['first_air_date'] : null,
                'last_air_date' => !empty($seriesDetails['last_air_date']) ? $seriesDetails['last_air_date'] : null,
                'number_of_seasons' => $seriesDetails['number_of_seasons'] ?? 0,
                'number_of_episodes' => $seriesDetails['number_of_episodes'] ?? 0,
                'rating' => $seriesDetails['vote_average'] ?? null,
                'vote_count' => $seriesDetails['vote_count'] ?? 0,
                'status' => $seriesDetails['status'] ?? 'returning',
                'original_language' => $seriesDetails['original_language'] ?? null,
                'original_title' => $seriesDetails['original_name'] ?? null,
                'genres' => !empty($seriesDetails['genres']) ? $seriesDetails['genres'] : null,
                'production_companies' => !empty($seriesDetails['production_companies']) ? $seriesDetails['production_companies'] : null,
                'production_countries' => !empty($seriesDetails['production_countries']) ? $seriesDetails['production_countries'] : null,
                'networks' => !empty($seriesDetails['networks']) ? $seriesDetails['networks'] : null,
                'imdb_id' => $seriesDetails['external_ids']['imdb_id'] ?? null,
                'tmdb_id' => $tmdbId,
                'is_featured' => false,
                'is_active' => true,
            ]);

            // Importer les saisons et épisodes
            $seasonsImported = 0;
            $episodesImported = 0;

            if (!empty($seriesDetails['seasons'])) {
                foreach ($seriesDetails['seasons'] as $seasonData) {
                    // Ignorer la saison 0 (Spéciaux) pour l'instant
                    if ($seasonData['season_number'] == 0) {
                        continue;
                    }

                    try {
                        // Récupérer les détails complets de la saison
                        $seasonDetails = $this->tmdbService->makeRequest("/tv/{$tmdbId}/season/{$seasonData['season_number']}");

                        // Construire l'URL du poster de la saison
                        $seasonPosterUrl = null;
                        if (!empty($seasonDetails['poster_path'])) {
                            $seasonPosterUrl = $this->tmdbService->getImageUrl($seasonDetails['poster_path'], 'original');
                        }

                        // Créer la saison
                        $season = Season::create([
                            'series_id' => $series->id,
                            'name' => $seasonDetails['name'] ?? "Saison {$seasonData['season_number']}",
                            'description' => $seasonDetails['overview'] ?? null,
                            'poster_path' => $seasonPosterUrl,
                            'season_number' => $seasonData['season_number'],
                            'air_date' => !empty($seasonDetails['air_date']) ? $seasonDetails['air_date'] : null,
                            'episode_count' => $seasonDetails['episodes'] ? count($seasonDetails['episodes']) : 0,
                            'tmdb_id' => $seasonDetails['id'] ?? null,
                            'is_active' => true,
                        ]);

                        $seasonsImported++;

                        // Importer les épisodes de cette saison
                        if (!empty($seasonDetails['episodes'])) {
                            foreach ($seasonDetails['episodes'] as $episodeData) {
                                // Construire l'URL du still de l'épisode
                                $stillUrl = null;
                                if (!empty($episodeData['still_path'])) {
                                    $stillUrl = $this->tmdbService->getImageUrl($episodeData['still_path'], 'original');
                                }

                                Episode::create([
                                    'series_id' => $series->id,
                                    'season_id' => $season->id,
                                    'name' => $episodeData['name'] ?? "Épisode {$episodeData['episode_number']}",
                                    'description' => $episodeData['overview'] ?? null,
                                    'still_path' => $stillUrl,
                                    'episode_number' => $episodeData['episode_number'],
                                    'air_date' => !empty($episodeData['air_date']) ? $episodeData['air_date'] : null,
                                    'runtime' => $episodeData['runtime'] ?? null,
                                    'rating' => $episodeData['vote_average'] ?? null,
                                    'vote_count' => $episodeData['vote_count'] ?? 0,
                                    'tmdb_id' => $episodeData['id'] ?? null,
                                    'is_active' => true,
                                ]);

                                $episodesImported++;
                            }
                        }
                    } catch (\Exception $e) {
                        // Log l'erreur mais continue avec les autres saisons
                        \Log::error("Erreur lors de l'import de la saison {$seasonData['season_number']}: " . $e->getMessage());
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Série importée avec succès : {$seasonsImported} saison(s) et {$episodesImported} épisode(s) importés",
                'series' => $series,
                'seasons_imported' => $seasonsImported,
                'episodes_imported' => $episodesImported
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'import: ' . $e->getMessage()
            ], 500);
        }
    }
}