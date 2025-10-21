<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Series;
use App\Models\History;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil pour les utilisateurs connectés
     */
    public function index()
    {
        $user = Auth::user();
        
        // Contenu en vedette pour le hero slider (films + séries)
        $featuredMovies = Movie::where('is_active', true)
            ->where('is_featured', true)
            ->with('videos')
            ->orderBy('rating', 'desc')
            ->get();
        
        $featuredSeriesForHero = Series::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('rating', 'desc')
            ->get();
        
        // Combiner films et séries en vedette
        $featuredContent = $featuredMovies->concat($featuredSeriesForHero)
            ->sortByDesc('rating')
            ->take(5);
        
        // Si pas assez de contenu en vedette, prendre les mieux notés
        if ($featuredContent->count() < 5) {
            $topMovies = Movie::where('is_active', true)
                ->with('videos')
                ->orderBy('rating', 'desc')
                ->limit(3)
                ->get();
            
            $topSeries = Series::where('is_active', true)
                ->orderBy('rating', 'desc')
                ->limit(2)
                ->get();
            
            $featuredContent = $topMovies->concat($topSeries)
                ->sortByDesc('rating')
                ->take(5);
        }
        
        // Films récents
        $recentMovies = Movie::where('is_active', true)
            ->with('videos')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
        
        // Films populaires
        $popularMovies = Movie::where('is_active', true)
            ->with('videos')
            ->orderBy('rating', 'desc')
            ->limit(12)
            ->get();
        
        // Séries en vedette
        $featuredSeries = Series::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('rating', 'desc')
            ->limit(12)
            ->get();
        
        // Séries récentes
        $recentSeries = Series::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
        
        // Derniers épisodes avec vidéos (triés par la vidéo la plus récente - created ou updated)
        $recentEpisodes = \App\Models\Episode::whereHas('videos')
            ->with(['season.series', 'videos' => function($query) {
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('episodes.*', \DB::raw('MAX(GREATEST(videos.created_at, videos.updated_at)) as latest_video_date'))
            ->join('videos', 'episodes.id', '=', 'videos.episode_id')
            ->groupBy('episodes.id', 'episodes.season_id', 'episodes.episode_number', 'episodes.name', 'episodes.description', 'episodes.air_date', 'episodes.still_path', 'episodes.runtime', 'episodes.created_at', 'episodes.updated_at')
            ->orderBy('latest_video_date', 'desc')
            ->limit(12)
            ->get()
            ->filter(function($episode) {
                return $episode->season && $episode->season->series && $episode->season->series->is_active;
            });
        
        return view('home', compact(
            'user',
            'featuredContent',
            'recentMovies',
            'popularMovies',
            'featuredSeries',
            'recentSeries',
            'recentEpisodes'
        ));
    }
    
    /**
     * Afficher la page de tous les films
     */
    public function movies(Request $request)
    {
        $user = Auth::user();
        
        $query = Movie::where('is_active', true)->with('videos');
        
        // Filtrer par genre
        if ($request->has('genre') && $request->genre) {
            $query->whereJsonContains('genres', ['name' => $request->genre]);
        }
        
        // Filtrer par année
        if ($request->has('year') && $request->year) {
            $query->whereYear('release_date', $request->year);
        }
        
        // Recherche
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('original_title', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Tri
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'year':
                $query->orderBy('release_date', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }
        
        $movies = $query->paginate(24);
        
        // Récupérer tous les genres disponibles
        $allGenres = Movie::where('is_active', true)
            ->get()
            ->pluck('genres')
            ->flatten(1)
            ->unique('name')
            ->sortBy('name')
            ->pluck('name');
        
        // Récupérer les années disponibles
        $years = Movie::where('is_active', true)
            ->whereNotNull('release_date')
            ->selectRaw('YEAR(release_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('movies', compact('user', 'movies', 'allGenres', 'years'));
    }
    
    /**
     * Afficher la page de toutes les séries
     */
    public function series(Request $request)
    {
        $user = Auth::user();
        
        $query = Series::where('is_active', true)->with('seasons');
        
        // Filtrer par genre
        if ($request->has('genre') && $request->genre) {
            $query->whereJsonContains('genres', ['name' => $request->genre]);
        }
        
        // Filtrer par année
        if ($request->has('year') && $request->year) {
            $query->whereYear('first_air_date', $request->year);
        }
        
        // Recherche
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('original_title', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Tri
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'year':
                $query->orderBy('first_air_date', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }
        
        $series = $query->paginate(24);
        
        // Récupérer tous les genres disponibles
        $allGenres = Series::where('is_active', true)
            ->get()
            ->pluck('genres')
            ->flatten(1)
            ->unique('name')
            ->sortBy('name')
            ->pluck('name');
        
        // Récupérer les années disponibles
        $years = Series::where('is_active', true)
            ->whereNotNull('first_air_date')
            ->selectRaw('YEAR(first_air_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('series', compact('user', 'series', 'allGenres', 'years'));
    }
    
    /**
     * Rechercher des films et séries en temps réel
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'movies' => [],
                'series' => []
            ]);
        }
        
        // Recherche dans les films
        $movies = Movie::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('original_title', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->with('videos')
            ->limit(5)
            ->get()
            ->map(function($movie) {
                return [
                    'id' => $movie->id,
                    'title' => $movie->title,
                    'poster_url' => $movie->poster_url,
                    'rating' => $movie->rating,
                    'release_year' => $movie->release_date ? $movie->release_date->format('Y') : null,
                    'type' => 'movie',
                    'has_video' => $movie->videos->count() > 0
                ];
            });
        
        // Recherche dans les séries
        $series = Series::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('original_title', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->limit(5)
            ->get()
            ->map(function($serie) {
                return [
                    'id' => $serie->id,
                    'title' => $serie->title,
                    'poster_url' => $serie->poster_url,
                    'rating' => $serie->rating,
                    'release_year' => $serie->first_air_date ? $serie->first_air_date->format('Y') : null,
                    'type' => 'series',
                    'number_of_seasons' => $serie->number_of_seasons
                ];
            });
        
        return response()->json([
            'movies' => $movies,
            'series' => $series
        ]);
    }
    
    /**
     * Afficher les détails d'un film
     */
    public function showMovie($id)
    {
        $movie = Movie::where('is_active', true)
            ->with('videos')
            ->findOrFail($id);
        
        $user = Auth::user();
        
        // Films similaires (même genre ou rating similaire)
        $similarMovies = Movie::where('is_active', true)
            ->where('id', '!=', $movie->id)
            ->with('videos')
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();
        
        return view('movie-details', compact('movie', 'user', 'similarMovies'));
    }
    
    /**
     * Afficher les détails d'une série
     */
    public function showSeries($id)
    {
        $series = Series::where('is_active', true)
            ->with(['seasons.episodes.videos'])
            ->findOrFail($id);
        
        $user = Auth::user();
        
        // Séries similaires
        $similarSeries = Series::where('is_active', true)
            ->where('id', '!=', $series->id)
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();
        
        return view('series-details', compact('series', 'user', 'similarSeries'));
    }
    
    /**
     * Afficher la page de compte utilisateur
     */
    public function account()
    {
        $user = Auth::user();
        
        // Récupérer toutes les sessions de l'utilisateur depuis la base de données
        $sessions = \DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'ip' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
                    'is_current' => $session->id === session()->getId(),
                ];
            });
        
        return view('account', compact('user', 'sessions'));
    }

    /**
     * Mettre à jour le timezone de l'utilisateur
     */
    public function updateTimezone(Request $request)
    {
        $request->validate([
            'timezone' => 'required|string|in:Europe/Paris,Europe/Brussels,Indian/Mayotte,Indian/Mauritius,Indian/Reunion'
        ]);

        $user = Auth::user();
        $user->timezone = $request->timezone;
        $user->save();

        return redirect()->route('account')->with('success', 'Fuseau horaire mis à jour avec succès !');
    }

    /**
     * Afficher l'historique de l'utilisateur
     */
    public function history()
    {
        $user = Auth::user();
        
        // Récupérer l'historique avec les relations
        $historyItems = History::where('user_id', $user->id)
            ->with(['video.episode.season', 'watchable'])
            ->orderBy('watched_at', 'desc')
            ->get();
        
        // Compter les statistiques
        $totalItems = $historyItems->count();
        $movieCount = $historyItems->where('watchable_type', 'App\Models\Movie')->count();
        $seriesCount = $historyItems->where('watchable_type', 'App\Models\Series')->count();
        $completedCount = $historyItems->where('completed', true)->count();
        
        return view('history', compact('user', 'historyItems', 'totalItems', 'movieCount', 'seriesCount', 'completedCount'));
    }

    /**
     * Ajouter un élément à l'historique
     */
    public function addToHistory(Request $request)
    {
        $request->validate([
            'watchable_id' => 'required|integer',
            'watchable_type' => 'required|string|in:App\Models\Movie,App\Models\Series',
            'video_id' => 'required|integer|exists:videos,id',
            'completed' => 'boolean',
        ]);

        $user = Auth::user();
        
        // Vérifier que la vidéo existe et appartient au contenu
        $video = \App\Models\Video::findOrFail($request->video_id);
        
        // Vérifier la relation entre la vidéo et le contenu
        if ($request->watchable_type === 'App\Models\Movie') {
            if ($video->movie_id != $request->watchable_id) {
                return response()->json(['success' => false, 'message' => 'Vidéo non associée à ce film'], 400);
            }
        } elseif ($request->watchable_type === 'App\Models\Series') {
            // Pour les séries, vérifier que la vidéo appartient à un épisode de cette série
            $episode = $video->episode;
            if (!$episode || $episode->season->series_id != $request->watchable_id) {
                return response()->json(['success' => false, 'message' => 'Vidéo non associée à cette série'], 400);
            }
        }
        
        // Vérifier si une entrée existe déjà
        $existingHistory = History::where('user_id', $user->id)
            ->where('watchable_id', $request->watchable_id)
            ->where('watchable_type', $request->watchable_type)
            ->where('video_id', $request->video_id)
            ->first();
        
        if ($existingHistory) {
            // Si l'entrée existe déjà, ne pas la modifier
            $history = $existingHistory;
        } else {
            // Créer une nouvelle entrée seulement si elle n'existe pas
            $history = History::create([
                'user_id' => $user->id,
                'watchable_id' => $request->watchable_id,
                'watchable_type' => $request->watchable_type,
                'video_id' => $request->video_id,
                'completed' => $request->completed ?? false,
                'watched_at' => now(),
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Historique mis à jour',
            'history' => $history
        ]);
    }

    /**
     * Mettre à jour l'historique
     */
    public function updateHistory(Request $request)
    {
        $request->validate([
            'watchable_id' => 'required|integer',
            'watchable_type' => 'required|string|in:App\Models\Movie,App\Models\Series',
            'video_id' => 'required|integer|exists:videos,id',
            'completed' => 'boolean',
        ]);

        $user = Auth::user();
        
        // Trouver l'entrée d'historique existante
        $history = History::where('user_id', $user->id)
            ->where('watchable_id', $request->watchable_id)
            ->where('watchable_type', $request->watchable_type)
            ->where('video_id', $request->video_id)
            ->first();
        
        if ($history) {
            $history->update([
                'completed' => $request->completed ?? $history->completed,
                'watched_at' => now(),
            ]);
        } else {
            // Créer une nouvelle entrée si elle n'existe pas
            $history = History::create([
                'user_id' => $user->id,
                'watchable_id' => $request->watchable_id,
                'watchable_type' => $request->watchable_type,
                'video_id' => $request->video_id,
                'completed' => $request->completed ?? false,
                'watched_at' => now(),
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Historique mis à jour',
            'history' => $history
        ]);
    }

    /**
     * Vérifier l'état d'un élément dans l'historique
     */
    public function checkHistory(Request $request)
    {
        $request->validate([
            'watchable_id' => 'required|integer',
            'watchable_type' => 'required|string|in:App\Models\Movie,App\Models\Series',
            'video_id' => 'required|integer|exists:videos,id',
        ]);

        $user = Auth::user();
        
        $history = History::where('user_id', $user->id)
            ->where('watchable_id', $request->watchable_id)
            ->where('watchable_type', $request->watchable_type)
            ->where('video_id', $request->video_id)
            ->first();
        
        if ($history) {
            return response()->json([
                'success' => true,
                'history' => $history
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aucun historique trouvé'
            ]);
        }
    }

    /**
     * Supprimer un élément de l'historique
     */
    public function removeFromHistory(Request $request)
    {
        $request->validate([
            'history_id' => 'required|integer|exists:history,id',
        ]);

        $user = Auth::user();
        
        $history = History::where('id', $request->history_id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        $history->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Élément retiré de l\'historique'
        ]);
    }

    /**
     * Vider l'historique
     */
    public function clearHistory()
    {
        $user = Auth::user();
        
        History::where('user_id', $user->id)->delete();
        
        return redirect()->route('history')->with('success', 'Historique vidé avec succès !');
    }
    
    /**
     * Supprimer une session utilisateur
     */
    public function destroySession($sessionId)
    {
        $user = Auth::user();
        
        // Vérifier que la session appartient bien à l'utilisateur
        $session = \DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$session) {
            return redirect()->route('account')->with('error', 'Session non trouvée.');
        }
        
        // Ne pas permettre de supprimer la session actuelle
        if ($sessionId === session()->getId()) {
            return redirect()->route('account')->with('error', 'Vous ne pouvez pas déconnecter votre session actuelle.');
        }
        
        // Supprimer la session
        \DB::table('sessions')
            ->where('id', $sessionId)
            ->delete();
        
        return redirect()->route('account')->with('success', 'Session déconnectée avec succès.');
    }
    
    /**
     * Afficher la page de visionnage d'un épisode
     */
    public function watchEpisode($seriesId, $seasonNumber, $episodeNumber, $videoId = null)
    {
        $user = Auth::user();
        
        // Récupérer la série
        $series = Series::where('is_active', true)
            ->with(['seasons' => function($query) use ($seasonNumber) {
                $query->where('season_number', $seasonNumber);
            }])
            ->findOrFail($seriesId);
        
        // Récupérer la saison
        $season = $series->seasons->first();
        if (!$season) {
            abort(404, 'Saison non trouvée');
        }
        
        // Récupérer l'épisode avec ses vidéos
        $episode = \App\Models\Episode::where('season_id', $season->id)
            ->where('episode_number', $episodeNumber)
            ->with('videos')
            ->firstOrFail();
        
        // Si pas de videoId spécifié et qu'il y a des vidéos, rediriger avec le premier videoId
        if (!$videoId && $episode->videos->count() > 0) {
            $firstVideo = $episode->videos->first();
            return redirect()->route('watch.episode', [
                'seriesId' => $seriesId,
                'seasonNumber' => $seasonNumber,
                'episodeNumber' => $episodeNumber,
                'videoId' => $firstVideo->id
            ]);
        }
        
        // Sélectionner la vidéo spécifique
        $selectedVideo = null;
        if ($videoId) {
            $selectedVideo = $episode->videos->where('id', $videoId)->first();
        }
        
        // Si la vidéo demandée n'existe pas, rediriger vers la première
        if (!$selectedVideo && $episode->videos->count() > 0) {
            $firstVideo = $episode->videos->first();
            return redirect()->route('watch.episode', [
                'seriesId' => $seriesId,
                'seasonNumber' => $seasonNumber,
                'episodeNumber' => $episodeNumber,
                'videoId' => $firstVideo->id
            ]);
        }
        
        // Récupérer tous les épisodes de la saison pour la navigation
        $seasonEpisodes = \App\Models\Episode::where('season_id', $season->id)
            ->with('videos')
            ->orderBy('episode_number')
            ->get();
        
        // Récupérer toutes les saisons pour le sélecteur
        $allSeasons = \App\Models\Season::where('series_id', $seriesId)
            ->orderBy('season_number')
            ->with(['episodes' => function($query) {
                $query->orderBy('episode_number');
            }])
            ->get();
        
        // Épisode suivant et précédent
        $nextEpisode = \App\Models\Episode::where('season_id', $season->id)
            ->where('episode_number', '>', $episodeNumber)
            ->with('season')
            ->orderBy('episode_number')
            ->first();
        
        $previousEpisode = \App\Models\Episode::where('season_id', $season->id)
            ->where('episode_number', '<', $episodeNumber)
            ->with('season')
            ->orderBy('episode_number', 'desc')
            ->first();
        
        // Si pas d'épisode suivant dans la saison, chercher dans la saison suivante
        if (!$nextEpisode) {
            $nextSeason = \App\Models\Season::where('series_id', $seriesId)
                ->where('season_number', '>', $seasonNumber)
                ->orderBy('season_number')
                ->first();
            
            if ($nextSeason) {
                $nextEpisode = \App\Models\Episode::where('season_id', $nextSeason->id)
                    ->with('season')
                    ->orderBy('episode_number')
                    ->first();
            }
        }
        
        return view('watch-episode', compact(
            'user',
            'series',
            'season',
            'episode',
            'selectedVideo',
            'seasonEpisodes',
            'allSeasons',
            'nextEpisode',
            'previousEpisode'
        ));
    }
    
    /**
     * Afficher la page de visionnage d'un film
     */
    public function watchMovie($movieId, $videoId = null)
    {
        $user = auth()->user();
        
        // Récupérer le film avec ses vidéos
        $movie = \App\Models\Movie::with('videos')->findOrFail($movieId);
        
        // Sélectionner la vidéo
        $selectedVideo = null;
        
        if ($videoId) {
            // Trouver la vidéo spécifiée
            $selectedVideo = $movie->videos->firstWhere('id', $videoId);
        }
        
        // Si pas de vidéo spécifiée ou vidéo introuvable, prendre la première disponible
        if (!$selectedVideo && $movie->videos->count() > 0) {
            $selectedVideo = $movie->videos->first();
            
            // Rediriger vers l'URL avec le videoId
            return redirect()->route('watch.movie', [
                'movieId' => $movieId,
                'videoId' => $selectedVideo->id
            ]);
        }
        
        // Récupérer les films similaires
        $similarMovies = \App\Models\Movie::where('is_active', true)
            ->where('id', '!=', $movie->id)
            ->where(function($query) use ($movie) {
                if ($movie->genres) {
                    foreach ($movie->genres as $genre) {
                        $genreName = is_array($genre) ? $genre['name'] : $genre;
                        $query->orWhereJsonContains('genres', ['name' => $genreName]);
                    }
                }
            })
            ->orderBy('rating', 'desc')
            ->limit(12)
            ->get();
        
        return view('watch-movie', compact(
            'user',
            'movie',
            'selectedVideo',
            'similarMovies'
        ));
    }
    
    /**
     * Afficher la page watchlist
     */
    public function watchlist()
    {
        $user = auth()->user();
        
        // Récupérer tous les éléments de la watchlist de l'utilisateur
        $watchlistItems = $user->watchlist()
            ->with('watchable')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Statistiques
        $movieCount = $watchlistItems->filter(function($item) {
            return $item->watchable_type === 'App\Models\Movie';
        })->count();
        
        $seriesCount = $watchlistItems->filter(function($item) {
            return $item->watchable_type === 'App\Models\Series';
        })->count();
        
        // Compter les contenus disponibles (avec vidéos)
        $availableCount = $watchlistItems->filter(function($item) {
            $content = $item->watchable;
            if ($item->watchable_type === 'App\Models\Movie') {
                return $content && $content->videos && $content->videos->count() > 0;
            } else {
                return $content && $content->seasons && 
                       $content->seasons->flatMap->episodes->flatMap->videos->count() > 0;
            }
        })->count();
        
        return view('watchlist', compact('user', 'watchlistItems', 'movieCount', 'seriesCount', 'availableCount'));
    }
    
    /**
     * Ajouter un élément à la watchlist
     */
    public function addToWatchlist(Request $request)
    {
        $user = auth()->user();
        $type = $request->input('type');
        $id = $request->input('id');
        
        // Convertir le type court en nom de classe complet
        $typeMap = [
            'movie' => 'App\Models\Movie',
            'series' => 'App\Models\Series',
        ];
        
        // Vérifier que le type est valide
        if (!isset($typeMap[$type])) {
            return response()->json([
                'success' => false,
                'message' => 'Type invalide'
            ], 400);
        }
        
        $fullClassName = $typeMap[$type];
        
        // Vérifier si l'élément existe déjà dans la watchlist
        $exists = $user->watchlist()
            ->where('watchable_type', $fullClassName)
            ->where('watchable_id', $id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => true,
                'in_watchlist' => true,
                'message' => 'Déjà dans votre liste'
            ]);
        }
        
        // Ajouter à la watchlist
        $user->watchlist()->create([
            'watchable_type' => $fullClassName,
            'watchable_id' => $id,
        ]);
        
        return response()->json([
            'success' => true,
            'in_watchlist' => true,
            'message' => 'Ajouté à votre liste'
        ]);
    }
    
    /**
     * Retirer un élément de la watchlist
     */
    public function removeFromWatchlist(Request $request)
    {
        $user = auth()->user();
        $type = $request->input('type');
        $id = $request->input('id');
        
        // Convertir le type court en nom de classe complet
        $typeMap = [
            'movie' => 'App\Models\Movie',
            'series' => 'App\Models\Series',
        ];
        
        // Vérifier que le type est valide
        if (!isset($typeMap[$type])) {
            return response()->json([
                'success' => false,
                'message' => 'Type invalide'
            ], 400);
        }
        
        $fullClassName = $typeMap[$type];
        
        // Supprimer de la watchlist
        $deleted = $user->watchlist()
            ->where('watchable_type', $fullClassName)
            ->where('watchable_id', $id)
            ->delete();
        
        return response()->json([
            'success' => true,
            'in_watchlist' => false,
            'message' => 'Retiré de votre liste'
        ]);
    }
}