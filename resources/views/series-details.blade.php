<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $series->title }} - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .backdrop-container {
            position: relative;
            height: 85vh;
            min-height: 600px;
        }
        
        @media (max-width: 768px) {
            .backdrop-container {
                height: auto;
                min-height: auto;
                padding-bottom: 2rem;
            }
        }
        
        .backdrop-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
        }
        
        .backdrop-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.7) 40%, rgba(0, 0, 0, 0.3) 70%, transparent 100%),
                        linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.6) 80%, #000000 100%);
        }
        
        @media (max-width: 768px) {
            .backdrop-gradient {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.9) 70%, #000000 100%);
            }
        }
        
        .genre-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(168, 85, 247, 0.2);
            border: 1px solid rgba(168, 85, 247, 0.5);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #a855f7;
        }
        
        .season-tab {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .season-tab.active {
            background: rgba(168, 85, 247, 0.3);
            border-color: #a855f7;
            color: #a855f7;
        }
        
        /* Movie Card Styles pour les similaires */
        .movie-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            aspect-ratio: 2/3;
        }
        
        .movie-card:hover {
            transform: translateY(-8px) scale(1.05);
            z-index: 10;
        }
        
        .movie-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .movie-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }
        
        .movie-card:hover .movie-overlay {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-black min-h-screen font-sans">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-xl border-b border-halloween-orange/30">
        <nav class="container mx-auto px-3 md:px-6 py-3 md:py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-8 md:h-12 w-auto">
            </a>
            
            <div class="flex items-center space-x-2 md:space-x-4">
                <a href="{{ route('home') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-1 md:mr-2"></i>
                    <span class="hidden md:inline">Retour</span>
                </a>
                
                @if($user->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-halloween-purple hover:text-halloween-purple-light transition-colors duration-300" title="Administration">
                    <i class="fas fa-crown text-lg md:text-xl"></i>
                </a>
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero avec backdrop -->
    <section class="backdrop-container">
        <div class="backdrop-image" style="background-image: url('{{ $series->backdrop_url }}');"></div>
        <div class="backdrop-gradient"></div>
        
        <div class="container mx-auto px-3 md:px-6 h-full flex items-end relative z-10 pb-6 md:pb-12 pt-20 md:pt-24">
            <div class="flex flex-col md:flex-row gap-4 md:gap-8 w-full">
                <!-- Poster -->
                <div class="flex-shrink-0 mx-auto md:mx-0">
                    <img src="{{ $series->poster_url }}" alt="{{ $series->title }}" class="w-40 md:w-64 rounded-xl md:rounded-2xl shadow-2xl">
                </div>
                
                <!-- Informations -->
                <div class="flex-1">
                    <div class="mb-2 md:mb-3 text-center md:text-left">
                        <span class="inline-block px-3 md:px-4 py-1.5 md:py-2 bg-halloween-purple/80 text-white rounded-full text-xs md:text-sm font-bold backdrop-blur-sm">
                            <i class="fas fa-tv mr-1 md:mr-2"></i>SÉRIE
                        </span>
                    </div>
                    
                    <h1 class="text-2xl md:text-4xl lg:text-6xl font-bold mb-2 md:mb-4 text-white drop-shadow-2xl text-center md:text-left">
                        {{ $series->title }}
                    </h1>
                    
                    @if($series->original_title && $series->original_title !== $series->title)
                    <p class="text-text-secondary text-sm md:text-lg mb-2 md:mb-4 text-center md:text-left">{{ $series->original_title }}</p>
                    @endif
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 md:gap-4 mb-4 md:mb-6 text-xs md:text-base">
                        @if($series->rating)
                        <div class="flex items-center space-x-1 md:space-x-2">
                            <i class="fas fa-star text-halloween-yellow text-sm md:text-xl"></i>
                            <span class="text-text-primary font-bold text-sm md:text-xl">{{ $series->rating }}/10</span>
                            @if($series->vote_count)
                            <span class="text-text-secondary text-xs md:text-sm hidden sm:inline">({{ number_format($series->vote_count) }} votes)</span>
                            @endif
                        </div>
                        @endif
                        
                        @if($series->first_air_date)
                        <span class="text-text-primary font-semibold">{{ $series->first_air_date->format('Y') }}</span>
                        @endif
                        
                        @if($series->number_of_seasons)
                        <span class="text-text-primary">
                            <i class="fas fa-list mr-1 md:mr-2"></i>{{ $series->number_of_seasons }} <span class="hidden sm:inline">saison(s)</span><span class="sm:hidden">S</span>
                        </span>
                        @endif
                        
                        @if($series->number_of_episodes)
                        <span class="text-text-primary">
                            <i class="fas fa-film mr-1 md:mr-2"></i>{{ $series->number_of_episodes }} <span class="hidden sm:inline">épisode(s)</span><span class="sm:hidden">Ep</span>
                        </span>
                        @endif
                        
                        @if($series->original_language)
                        <span class="text-text-primary uppercase font-semibold">{{ $series->original_language }}</span>
                        @endif
                    </div>
                    
                    <p class="text-text-primary text-sm md:text-lg mb-4 md:mb-6 leading-relaxed max-w-4xl text-center md:text-left line-clamp-3 md:line-clamp-none">
                        {{ $series->description }}
                    </p>
                    
                    @if($series->genres)
                    <div class="flex flex-wrap gap-2 mb-4 md:mb-6 justify-center md:justify-start">
                        @foreach($series->genres as $genre)
                        <span class="genre-badge text-xs md:text-sm px-2.5 md:px-4 py-1 md:py-2">{{ is_array($genre) ? $genre['name'] : $genre }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 md:gap-4 justify-center md:justify-start">
                        @if($series->seasons->count() > 0)
                        <a href="#seasons" class="group bg-gradient-to-r from-halloween-purple to-halloween-purple-light text-text-primary px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-2xl hover:shadow-halloween-purple/50 transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-play mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                            Voir les épisodes
                        </a>
                        @endif
                        
                        <button class="group bg-black/60 backdrop-blur-sm text-text-primary px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-sm md:text-lg border-2 border-halloween-purple hover:bg-halloween-purple hover:shadow-lg hover:shadow-halloween-purple/50 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            Ma liste
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <main class="bg-black">
        <!-- Saisons et épisodes -->
        @if($series->seasons->count() > 0)
        <section id="seasons" class="py-8 md:py-16">
            <div class="container mx-auto px-3 md:px-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6 md:mb-8 text-halloween-purple drop-shadow-lg">
                    <i class="fas fa-list mr-2 md:mr-3"></i>
                    Saisons et Épisodes
                </h2>
                
                <!-- Tabs des saisons -->
                <div class="flex flex-wrap gap-2 mb-6 md:mb-8">
                    @foreach($series->seasons as $season)
                    <button 
                        class="season-tab px-4 md:px-6 py-2 md:py-3 rounded-full border-2 border-halloween-purple/30 text-text-primary font-semibold text-sm md:text-base {{ $loop->first ? 'active' : '' }}"
                        onclick="showSeason({{ $season->id }})"
                        data-season="{{ $season->id }}"
                    >
                        <span class="hidden sm:inline">Saison {{ $season->season_number }}</span>
                        <span class="sm:hidden">S{{ $season->season_number }}</span>
                    </button>
                    @endforeach
                </div>
                
                <!-- Contenu des saisons -->
                @foreach($series->seasons as $season)
                <div class="season-content {{ !$loop->first ? 'hidden' : '' }}" data-season-content="{{ $season->id }}">
                    <div class="bg-black/60 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 mb-4 md:mb-6 border border-halloween-purple/30">
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6 mb-4 md:mb-6">
                            @if($season->poster_path)
                            <img src="{{ $season->poster_url }}" alt="Saison {{ $season->season_number }}" class="w-24 md:w-32 rounded-lg mx-auto md:mx-0">
                            @endif
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="text-xl md:text-2xl font-bold text-halloween-purple mb-2">Saison {{ $season->season_number }}</h3>
                                @if($season->air_date)
                                <p class="text-text-secondary text-sm md:text-base mb-2">Diffusée en {{ $season->air_date->format('Y') }}</p>
                                @endif
                                @if($season->description)
                                <p class="text-text-primary text-sm md:text-base leading-relaxed">{{ $season->description }}</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($season->episodes->count() > 0)
                        <div class="space-y-3 md:space-y-4">
                            <h4 class="text-lg md:text-xl font-bold text-text-primary mb-3 md:mb-4">
                                <i class="fas fa-film mr-2 text-halloween-purple"></i>
                                Épisodes ({{ $season->episodes->count() }})
                            </h4>
                            @foreach($season->episodes as $episode)
                            <div class="bg-black/40 rounded-lg md:rounded-xl p-3 md:p-4 hover:bg-black/60 transition-colors duration-300 border border-halloween-purple/20 hover:border-halloween-purple/50">
                                <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                                    @if($episode->still_path)
                                    <img src="{{ $episode->still_url }}" alt="Episode {{ $episode->episode_number }}" class="w-full md:w-64 rounded-lg aspect-video object-cover shadow-lg">
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-2">
                                            <h5 class="text-base md:text-lg font-semibold text-text-primary">
                                                {{ $episode->episode_number }}. {{ $episode->name }}
                                            </h5>
                                            @if($episode->videos->count() > 0)
                                            <span class="px-3 py-1 bg-halloween-green/20 text-halloween-green text-xs rounded-full whitespace-nowrap">
                                                <i class="fas fa-check-circle mr-1"></i>Disponible
                                            </span>
                                            @endif
                                        </div>
                                        @if($episode->air_date)
                                        <p class="text-text-secondary text-sm mb-2">{{ $episode->air_date->format('d/m/Y') }}</p>
                                        @endif
                                        @if($episode->description)
                                        <p class="text-text-secondary text-sm leading-relaxed mb-3">{{ $episode->description }}</p>
                                        @endif
                                        @if($episode->videos->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($episode->videos as $video)
                                            <div class="bg-black/60 rounded-lg p-3 border border-halloween-purple/40 hover:border-halloween-purple/70 transition-colors duration-300">
                                                <!-- Badges d'informations -->
                                                <div class="flex flex-wrap gap-2 mb-2">
                                                    @if($video->quality)
                                                    <span class="px-2 py-1 bg-halloween-orange/20 border border-halloween-orange/50 text-halloween-orange text-xs font-bold rounded-full uppercase">
                                                        <i class="fas fa-hd-video mr-1"></i>{{ $video->quality }}
                                                    </span>
                                                    @endif
                                                    
                                                    @if($video->language)
                                                    <span class="px-2 py-1 bg-halloween-purple/20 border border-halloween-purple/50 text-halloween-purple text-xs font-bold rounded-full uppercase">
                                                        <i class="fas fa-language mr-1"></i>{{ $video->language === 'fr' ? 'FR' : ($video->language === 'en' ? 'EN' : strtoupper($video->language)) }}
                                                    </span>
                                                    @endif
                                                    
                                                    @if($video->subtitles && count($video->subtitles) > 0)
                                                    <span class="px-2 py-1 bg-halloween-yellow/20 border border-halloween-yellow/50 text-halloween-yellow text-xs font-bold rounded-full">
                                                        <i class="fas fa-closed-captioning mr-1"></i>ST
                                                    </span>
                                                    @endif
                                                    
                                                    @if($video->is_ready)
                                                    <span class="px-2 py-1 bg-halloween-green/20 border border-halloween-green/50 text-halloween-green text-xs font-bold rounded-full">
                                                        <i class="fas fa-check-circle mr-1"></i>Prêt
                                                    </span>
                                                    @elseif($video->is_processing)
                                                    <span class="px-2 py-1 bg-halloween-yellow/20 border border-halloween-yellow/50 text-halloween-yellow text-xs font-bold rounded-full">
                                                        <i class="fas fa-spinner fa-spin mr-1"></i>En cours
                                                    </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Bouton de lecture -->
                                                <a href="{{ route('watch.episode', [
                                                    'seriesId' => $series->id,
                                                    'seasonNumber' => $season->season_number,
                                                    'episodeNumber' => $episode->episode_number,
                                                    'videoId' => $video->id
                                                ]) }}" class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 bg-gradient-to-r from-halloween-purple to-halloween-purple-light text-text-primary rounded-full text-xs md:text-sm font-semibold hover:shadow-lg hover:shadow-halloween-purple/50 transition-all duration-300">
                                                    <i class="fas fa-play mr-2"></i>
                                                    Regarder maintenant
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-text-secondary text-center py-8">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucun épisode disponible pour cette saison
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Séries similaires -->
        <section class="py-8 md:py-16 border-t border-halloween-orange/20">
            <div class="container mx-auto px-3 md:px-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6 md:mb-8 text-halloween-yellow drop-shadow-lg">
                    <i class="fas fa-tv mr-2 md:mr-3"></i>
                    Séries similaires
                </h2>
                
                @if($similarSeries->count() > 0)
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4">
                    @foreach($similarSeries as $similar)
                    <div>
                        <a href="{{ route('series.show', $similar->id) }}" class="movie-card group block">
                            <img src="{{ $similar->poster_url }}" alt="{{ $similar->title }}" class="movie-poster">
                            
                            <div class="movie-overlay">
                                <h3 class="text-white font-bold text-sm md:text-lg mb-1 md:mb-2 line-clamp-2">{{ $similar->title }}</h3>
                                @if($similar->rating)
                                <div class="flex items-center space-x-1 md:space-x-2 mb-2 md:mb-3">
                                    <i class="fas fa-star text-halloween-yellow text-xs md:text-sm"></i>
                                    <span class="text-white text-xs md:text-sm">{{ $similar->rating }}/10</span>
                                </div>
                                @endif
                                <div class="bg-halloween-yellow text-bg-primary px-2 md:px-4 py-1.5 md:py-2 rounded-lg font-semibold text-xs md:text-sm hover:bg-halloween-yellow-light transition-colors duration-300 flex items-center justify-center">
                                    <i class="fas fa-tv mr-1 md:mr-2"></i>
                                    <span class="hidden md:inline">Voir les épisodes</span>
                                    <span class="md:hidden">Voir</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-black/40 rounded-lg md:rounded-xl p-6 md:p-12 text-center border border-halloween-yellow/20">
                    <i class="fas fa-tv text-halloween-yellow text-3xl md:text-5xl mb-3 md:mb-4 opacity-50"></i>
                    <p class="text-text-secondary text-base md:text-lg">
                        Aucune série similaire disponible pour le moment
                    </p>
                    <p class="text-text-secondary text-xs md:text-sm mt-2">
                        Revenez plus tard pour découvrir d'autres séries
                    </p>
                </div>
                @endif
            </div>
        </section>

        <!-- Informations supplémentaires -->
        <section class="py-8 md:py-16 border-t border-halloween-orange/20">
            <div class="container mx-auto px-3 md:px-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6 md:mb-8 text-halloween-purple drop-shadow-lg">
                    <i class="fas fa-info-circle mr-2 md:mr-3"></i>
                    Informations supplémentaires
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                    @if($series->status)
                    <div>
                        <h3 class="text-halloween-purple font-bold text-base md:text-lg mb-2">Statut</h3>
                        <p class="text-text-primary text-sm md:text-base">
                            @php
                                $statusTranslations = [
                                    'Returning Series' => 'Série en cours',
                                    'Ended' => 'Terminée',
                                    'Canceled' => 'Annulée',
                                    'In Production' => 'En production',
                                    'Planned' => 'Planifiée',
                                    'Pilot' => 'Pilote'
                                ];
                                echo $statusTranslations[$series->status] ?? $series->status;
                            @endphp
                        </p>
                    </div>
                    @endif
                    
                    @if($series->networks)
                    <div>
                        <h3 class="text-halloween-purple font-bold text-base md:text-lg mb-2">Diffuseurs</h3>
                        <div class="text-text-primary text-sm md:text-base space-y-1">
                            @foreach(array_slice($series->networks, 0, 3) as $network)
                            <p>{{ is_array($network) ? $network['name'] : $network }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($series->production_companies)
                    <div>
                        <h3 class="text-halloween-purple font-bold text-base md:text-lg mb-2">Production</h3>
                        <div class="text-text-primary text-sm md:text-base space-y-1">
                            @foreach(array_slice($series->production_companies, 0, 3) as $company)
                            <p>{{ is_array($company) ? $company['name'] : $company }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($series->imdb_id)
                    <div>
                        <h3 class="text-halloween-purple font-bold text-base md:text-lg mb-2">Liens externes</h3>
                        <a href="https://www.imdb.com/title/{{ $series->imdb_id }}" target="_blank" class="text-text-primary text-sm md:text-base hover:text-halloween-purple transition-colors">
                            <i class="fab fa-imdb mr-2"></i>Voir sur IMDb
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t-2 border-halloween-orange py-8">
        <div class="container mx-auto px-6 text-center">
            <div class="text-2xl font-bold text-halloween-orange drop-shadow-lg mb-2">ZTVPlus</div>
            <p class="text-text-secondary">Votre plateforme de streaming gratuite</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Gestion des tabs de saisons
        function showSeason(seasonId) {
            // Masquer tous les contenus de saison
            document.querySelectorAll('.season-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Retirer la classe active de tous les tabs
            document.querySelectorAll('.season-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Afficher le contenu de la saison sélectionnée
            const selectedContent = document.querySelector(`[data-season-content="${seasonId}"]`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
            
            // Ajouter la classe active au tab sélectionné
            const selectedTab = document.querySelector(`[data-season="${seasonId}"]`);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        }
        
        // Smooth scrolling pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>

