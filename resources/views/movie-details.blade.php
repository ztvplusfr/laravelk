<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - ZTVPlus</title>
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
            background: rgba(249, 115, 22, 0.2);
            border: 1px solid rgba(249, 115, 22, 0.5);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #f97316;
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
        <div class="backdrop-image" style="background-image: url('{{ $movie->backdrop_url }}');"></div>
        <div class="backdrop-gradient"></div>
        
        <div class="container mx-auto px-3 md:px-6 h-full flex items-end relative z-10 pb-6 md:pb-12 pt-20 md:pt-24">
            <div class="flex flex-col md:flex-row gap-4 md:gap-8 w-full">
                <!-- Poster -->
                <div class="flex-shrink-0 mx-auto md:mx-0">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-40 md:w-64 rounded-xl md:rounded-2xl shadow-2xl">
                </div>
                
                <!-- Informations -->
                <div class="flex-1">
                    <div class="mb-2 md:mb-3 text-center md:text-left">
                        <span class="inline-block px-3 md:px-4 py-1.5 md:py-2 bg-halloween-orange/80 text-white rounded-full text-xs md:text-sm font-bold backdrop-blur-sm">
                            <i class="fas fa-film mr-1 md:mr-2"></i>FILM
                        </span>
                    </div>
                    
                    <h1 class="text-2xl md:text-4xl lg:text-6xl font-bold mb-2 md:mb-4 text-white drop-shadow-2xl text-center md:text-left">
                        {{ $movie->title }}
                    </h1>
                    
                    @if($movie->original_title && $movie->original_title !== $movie->title)
                    <p class="text-text-secondary text-sm md:text-lg mb-2 md:mb-4 text-center md:text-left">{{ $movie->original_title }}</p>
                    @endif
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 md:gap-4 mb-4 md:mb-6 text-xs md:text-base">
                        @if($movie->rating)
                        <div class="flex items-center space-x-1 md:space-x-2">
                            <i class="fas fa-star text-halloween-yellow text-sm md:text-xl"></i>
                            <span class="text-text-primary font-bold text-sm md:text-xl">{{ $movie->rating }}/10</span>
                            @if($movie->vote_count)
                            <span class="text-text-secondary text-xs md:text-sm hidden sm:inline">({{ number_format($movie->vote_count) }} votes)</span>
                            @endif
                        </div>
                        @endif
                        
                        @if($movie->release_date)
                        <span class="text-text-primary font-semibold">{{ $movie->release_date->format('Y') }}</span>
                        @endif
                        
                        @if($movie->runtime)
                        <span class="text-text-primary">
                            <i class="far fa-clock mr-1 md:mr-2"></i>
                            @php
                                $hours = floor($movie->runtime / 60);
                                $minutes = $movie->runtime % 60;
                                if ($hours > 0) {
                                    echo $hours . ' h';
                                    if ($minutes > 0) {
                                        echo ' ' . $minutes . ' min';
                                    }
                                } else {
                                    echo $movie->runtime . ' min';
                                }
                            @endphp
                        </span>
                        @endif
                        
                        @if($movie->original_language)
                        <span class="text-text-primary uppercase font-semibold">{{ $movie->original_language }}</span>
                        @endif
                    </div>
                    
                    <p class="text-text-primary text-sm md:text-lg mb-4 md:mb-6 leading-relaxed max-w-4xl text-center md:text-left line-clamp-3 md:line-clamp-none">
                        {{ $movie->description }}
                    </p>
                    
                    @if($movie->genres)
                    <div class="flex flex-wrap gap-2 mb-4 md:mb-6 justify-center md:justify-start">
                        @foreach($movie->genres as $genre)
                        <span class="genre-badge text-xs md:text-sm px-2.5 md:px-4 py-1 md:py-2">{{ is_array($genre) ? $genre['name'] : $genre }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 md:gap-4 justify-center md:justify-start">
                        @if($movie->videos->count() > 0)
                        <a href="{{ route('watch.movie', ['movieId' => $movie->id]) }}" class="group bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-play mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                            Regarder maintenant
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
        <!-- Vidéos disponibles -->
        @if($movie->videos->count() > 0)
        <section id="videos" class="py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-halloween-orange drop-shadow-lg">
                    <i class="fas fa-play-circle mr-3"></i>
                    Vidéos disponibles
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($movie->videos as $video)
                    <div class="bg-black/60 rounded-xl overflow-hidden border border-halloween-orange/30 hover:border-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/20 transition-all duration-300 group">
                        <!-- Backdrop avec overlay -->
                        <div class="aspect-video bg-black relative overflow-hidden cursor-pointer">
                            <img src="{{ $movie->backdrop_url }}" alt="{{ $movie->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                            
                            <!-- Play button -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 bg-halloween-orange/90 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-play text-white text-2xl ml-1"></i>
                                </div>
                            </div>
                            
                            <!-- Badges de statut en haut -->
                            <div class="absolute top-3 left-3 flex gap-2">
                                @if($video->is_ready)
                                <span class="px-2 py-1 bg-halloween-green/90 backdrop-blur-sm text-white text-xs font-bold rounded-full flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>Prêt
                                </span>
                                @elseif($video->is_processing)
                                <span class="px-2 py-1 bg-halloween-yellow/90 backdrop-blur-sm text-bg-primary text-xs font-bold rounded-full flex items-center">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>En cours
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Informations de la vidéo -->
                        <div class="p-4">
                            <h3 class="text-text-primary font-semibold mb-3 flex items-center">
                                <i class="fas fa-film text-halloween-orange mr-2"></i>
                                {{ $movie->title }}
                            </h3>
                            
                            <!-- Badges d'informations -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @if($video->quality)
                                <span class="px-3 py-1 bg-halloween-orange/20 border border-halloween-orange/50 text-halloween-orange text-xs font-bold rounded-full uppercase">
                                    <i class="fas fa-hd-video mr-1"></i>{{ $video->quality }}
                                </span>
                                @endif
                                
                                @if($video->language)
                                <span class="px-3 py-1 bg-halloween-purple/20 border border-halloween-purple/50 text-halloween-purple text-xs font-bold rounded-full uppercase">
                                    <i class="fas fa-language mr-1"></i>{{ $video->language === 'fr' ? 'Français' : ($video->language === 'en' ? 'Anglais' : strtoupper($video->language)) }}
                                </span>
                                @endif
                                
                                @if($video->subtitles && count($video->subtitles) > 0)
                                <span class="px-3 py-1 bg-halloween-yellow/20 border border-halloween-yellow/50 text-halloween-yellow text-xs font-bold rounded-full">
                                    <i class="fas fa-closed-captioning mr-1"></i>ST: {{ implode(', ', array_map('strtoupper', array_slice($video->subtitles, 0, 2))) }}
                                    @if(count($video->subtitles) > 2)
                                    <span class="ml-1">+{{ count($video->subtitles) - 2 }}</span>
                                    @endif
                                </span>
                                @endif
                            </div>
                            
                            <!-- Bouton de lecture -->
                            <a href="{{ route('watch.movie', ['movieId' => $movie->id, 'videoId' => $video->id]) }}" class="block w-full bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-4 py-3 rounded-lg font-bold text-center hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-play mr-2"></i>
                                Regarder maintenant
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Films similaires -->
        <section class="py-16 border-t border-halloween-orange/20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-halloween-purple drop-shadow-lg">
                    <i class="fas fa-film mr-3"></i>
                    Films similaires
                </h2>
                
                @if($similarMovies->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($similarMovies as $similar)
                    <div>
                        <a href="{{ route('movie.show', $similar->id) }}" class="movie-card group block">
                            <img src="{{ $similar->poster_url }}" alt="{{ $similar->title }}" class="movie-poster">
                            
                            <div class="movie-overlay">
                                <h3 class="text-white font-bold text-lg mb-2">{{ $similar->title }}</h3>
                                @if($similar->rating)
                                <div class="flex items-center space-x-2 mb-3">
                                    <i class="fas fa-star text-halloween-yellow text-sm"></i>
                                    <span class="text-white text-sm">{{ $similar->rating }}/10</span>
                                </div>
                                @endif
                                <div class="bg-halloween-purple text-text-primary px-4 py-2 rounded-lg font-semibold hover:bg-halloween-purple-light transition-colors duration-300 flex items-center inline-flex">
                                    <i class="fas fa-{{ $similar->videos->count() > 0 ? 'play' : 'info-circle' }} mr-2"></i>
                                    {{ $similar->videos->count() > 0 ? 'Regarder' : 'Détails' }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-black/40 rounded-xl p-12 text-center border border-halloween-purple/20">
                    <i class="fas fa-film text-halloween-purple text-5xl mb-4 opacity-50"></i>
                    <p class="text-text-secondary text-lg">
                        Aucun film similaire disponible pour le moment
                    </p>
                    <p class="text-text-secondary text-sm mt-2">
                        Revenez plus tard pour découvrir d'autres films
                    </p>
                </div>
                @endif
            </div>
        </section>

        <!-- Informations supplémentaires -->
        <section class="py-16 border-t border-halloween-orange/20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-halloween-orange drop-shadow-lg">
                    <i class="fas fa-info-circle mr-3"></i>
                    Informations supplémentaires
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @if($movie->status)
                    <div>
                        <h3 class="text-halloween-orange font-bold text-lg mb-2">Statut</h3>
                        <p class="text-text-primary">
                            @php
                                $statusTranslations = [
                                    'Released' => 'Sorti',
                                    'Post Production' => 'Post-production',
                                    'In Production' => 'En production',
                                    'Planned' => 'Planifié',
                                    'Rumored' => 'Rumeur',
                                    'Canceled' => 'Annulé'
                                ];
                                echo $statusTranslations[$movie->status] ?? $movie->status;
                            @endphp
                        </p>
                    </div>
                    @endif
                    
                    @if($movie->production_companies)
                    <div>
                        <h3 class="text-halloween-orange font-bold text-lg mb-2">Production</h3>
                        <div class="text-text-primary space-y-1">
                            @foreach(array_slice($movie->production_companies, 0, 3) as $company)
                            <p>{{ is_array($company) ? $company['name'] : $company }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($movie->imdb_id)
                    <div>
                        <h3 class="text-halloween-orange font-bold text-lg mb-2">Liens externes</h3>
                        <a href="https://www.imdb.com/title/{{ $movie->imdb_id }}" target="_blank" class="text-text-primary hover:text-halloween-orange transition-colors">
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

