<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $series->title }} - S{{ $season->season_number }}E{{ $episode->episode_number }} - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            background: #000;
        }
        
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <script>
        // Enregistrer dans l'historique quand la page se charge
        document.addEventListener('DOMContentLoaded', function() {
            @if($selectedVideo)
            // Enregistrer automatiquement dans l'historique
            fetch('/history/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    watchable_id: {{ $series->id }},
                    watchable_type: 'App\\Models\\Series',
                    video_id: {{ $selectedVideo->id }},
                    completed: false
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Ajouté à l\'historique:', data.message);
                } else {
                    console.error('Erreur historique:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
            @endif
        });

        // Fonction pour marquer comme terminé
        function markAsCompleted() {
            @if($selectedVideo)
            fetch('/history/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    watchable_id: {{ $series->id }},
                    watchable_type: 'App\\Models\\Series',
                    video_id: {{ $selectedVideo->id }},
                    completed: true
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Épisode marqué comme terminé !');
                } else {
                    console.error('Erreur:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
            @endif
        }

        // Marquer comme terminé quand l'utilisateur quitte la page
        window.addEventListener('beforeunload', function() {
            @if($selectedVideo)
            // Envoyer une requête pour marquer comme terminé
            navigator.sendBeacon('/history/update', JSON.stringify({
                watchable_id: {{ $series->id }},
                watchable_type: 'App\\Models\\Series',
                video_id: {{ $selectedVideo->id }},
                completed: true
            }));
            @endif
        });
    </script>
</head>
<body class="bg-black min-h-screen font-sans">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-black/95 backdrop-blur-xl border-b border-halloween-orange/30">
        <nav class="container mx-auto px-3 md:px-6 py-3 md:py-4">
            <div class="flex justify-between items-center gap-4">
                <div class="flex items-center gap-3 md:gap-4 min-w-0">
                    <a href="{{ route('series.show', $series->id) }}" class="flex items-center hover:opacity-80 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-arrow-left mr-2 text-halloween-orange"></i>
                        <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-8 md:h-10 w-auto">
                    </a>
                    
                    <!-- Episode Title -->
                    <div class="hidden md:flex items-center gap-2 min-w-0 flex-1">
                        <span class="text-halloween-orange">|</span>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('series.show', $series->id) }}" class="hover:text-halloween-orange transition-colors duration-300">
                                <h2 class="text-text-primary font-bold text-xs md:text-sm lg:text-base truncate">
                                    {{ $series->title }}
                                </h2>
                            </a>
                            <p class="text-text-secondary text-xs truncate">
                                <span class="hidden sm:inline">Saison {{ $season->season_number }} Episode {{ $episode->episode_number }}</span>
                                <span class="sm:hidden">S{{ $season->season_number }}E{{ $episode->episode_number }}</span>
                                • {{ $episode->name }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 md:space-x-4 flex-shrink-0">
                    <!-- User Avatar -->
                    <a href="{{ route('account') }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity duration-300" title="Mon compte">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-halloween-orange">
                        @else
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-halloween-orange rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-text-primary text-sm"></i>
                            </div>
                        @endif
                        <span class="text-text-primary font-semibold hidden lg:block">{{ $user->name }}</span>
                    </a>
                    
                    @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-halloween-purple hover:text-halloween-purple-light transition-colors duration-300">
                        <i class="fas fa-crown text-lg md:text-xl"></i>
                    </a>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-20 md:pt-24">
        <!-- Video Player -->
        <section class="bg-black">
            <div class="container mx-auto px-0">
                @if($selectedVideo)
                    <div class="video-container">
                        <iframe src="{{ $selectedVideo->embed_url }}" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                    </div>
                @else
                    <div class="aspect-video bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                        <div class="text-center p-8">
                            <i class="fas fa-video-slash text-halloween-red text-5xl mb-4"></i>
                            <p class="text-text-primary text-xl font-semibold">Vidéo non disponible</p>
                            <p class="text-text-secondary mt-2">Cet épisode n'a pas encore de vidéo</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Episode Info & Controls -->
        <section class="bg-gradient-to-b from-black to-bg-primary py-6 md:py-8 border-b border-halloween-orange/20">
            <div class="container mx-auto px-3 md:px-6">
                <!-- Episode Title & Info -->
                <div class="mb-6">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <a href="{{ route('series.show', $series->id) }}" class="hover:text-halloween-orange transition-colors duration-300">
                                <h1 class="text-2xl md:text-3xl font-bold text-text-primary mb-2">
                                    {{ $series->title }}
                                </h1>
                            </a>
                            <div class="flex flex-wrap items-center gap-2 md:gap-3 text-sm md:text-base">
                                <span class="px-3 py-1 bg-halloween-purple/20 border border-halloween-purple text-halloween-purple font-bold rounded-full">
                                    Saison {{ $season->season_number }}
                                </span>
                                <span class="px-3 py-1 bg-halloween-orange/20 border border-halloween-orange text-halloween-orange font-bold rounded-full">
                                    Épisode {{ $episode->episode_number }}
                                </span>
                                @if($episode->runtime)
                                <span class="text-text-secondary">
                                    <i class="fas fa-clock mr-1"></i>
                                    @php
                                        $hours = floor($episode->runtime / 60);
                                        $minutes = $episode->runtime % 60;
                                        if ($hours > 0) {
                                            echo $hours . ' h';
                                            if ($minutes > 0) {
                                                echo ' ' . $minutes . ' min';
                                            }
                                        } else {
                                            echo $episode->runtime . ' min';
                                        }
                                    @endphp
                                </span>
                                @endif
                                
                                @if($episode->videos->count() > 0)
                                    @foreach($episode->videos as $video)
                                    <span class="px-2.5 py-1 bg-black/60 border border-halloween-orange/40 rounded-lg text-xs md:text-sm flex items-center gap-1.5">
                                        @if($video->quality)
                                        <span class="text-halloween-orange font-bold uppercase">
                                            {{ $video->quality }}
                                        </span>
                                        @endif
                                        
                                        @if($video->language)
                                        <span class="text-text-secondary">
                                            <i class="fas fa-language mr-0.5"></i>{{ $video->language === 'fr' ? 'FR' : ($video->language === 'en' ? 'EN' : strtoupper($video->language)) }}
                                        </span>
                                        @endif
                                        
                                        @if($video->subtitles && count($video->subtitles) > 0)
                                        <span class="text-text-secondary">
                                            <i class="fas fa-closed-captioning"></i>
                                        </span>
                                        @endif
                                    </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="text-xl md:text-2xl font-semibold text-halloween-orange mb-3">
                        {{ $episode->name }}
                    </h2>
                    
                    @if($episode->description)
                    <p class="text-text-secondary leading-relaxed">
                        {{ $episode->description }}
                    </p>
                    @endif
                </div>
                
                <!-- Video Quality Selector (si plusieurs vidéos) -->
                @if($episode->videos->count() > 1)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-text-secondary mb-3 flex items-center">
                        <i class="fas fa-video mr-2"></i>
                        Choisir une version :
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($episode->videos as $video)
                        <a href="{{ route('watch.episode', [
                            'seriesId' => $series->id,
                            'seasonNumber' => $season->season_number,
                            'episodeNumber' => $episode->episode_number,
                            'videoId' => $video->id
                        ]) }}" class="flex items-center gap-2 px-3 md:px-4 py-2 rounded-lg border-2 transition-all duration-300 {{ $selectedVideo && $selectedVideo->id === $video->id ? 'bg-halloween-orange border-halloween-orange text-text-primary' : 'bg-black/40 border-halloween-orange/30 text-text-secondary hover:border-halloween-orange/60' }}">
                            @if($video->quality)
                            <span class="font-bold text-xs md:text-sm uppercase">
                                <i class="fas fa-hd-video mr-1"></i>{{ $video->quality }}
                            </span>
                            @endif
                            
                            @if($video->language)
                            <span class="text-xs md:text-sm">
                                <i class="fas fa-language mr-1"></i>{{ $video->language === 'fr' ? 'FR' : ($video->language === 'en' ? 'EN' : strtoupper($video->language)) }}
                            </span>
                            @endif
                            
                            @if($video->subtitles && count($video->subtitles) > 0)
                            <span class="text-xs">
                                <i class="fas fa-closed-captioning"></i>
                            </span>
                            @endif
                            
                            @if($selectedVideo && $selectedVideo->id === $video->id)
                            <i class="fas fa-check-circle text-xs md:text-sm"></i>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Navigation Controls -->
                <div class="flex flex-wrap gap-3">
                    @if($previousEpisode)
                    <a href="{{ route('watch.episode', [
                        'seriesId' => $series->id,
                        'seasonNumber' => $previousEpisode->season->season_number,
                        'episodeNumber' => $previousEpisode->episode_number
                    ]) }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 bg-bg-secondary hover:bg-bg-tertiary border border-halloween-orange/30 hover:border-halloween-orange rounded-lg transition-all duration-300">
                        <i class="fas fa-chevron-left mr-2 text-halloween-orange"></i>
                        <span class="text-text-primary font-semibold text-sm md:text-base">Épisode précédent</span>
                    </a>
                    @endif
                    
                    @if($nextEpisode)
                    <a href="{{ route('watch.episode', [
                        'seriesId' => $series->id,
                        'seasonNumber' => $nextEpisode->season->season_number,
                        'episodeNumber' => $nextEpisode->episode_number
                    ]) }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary hover:shadow-lg hover:shadow-halloween-orange/50 rounded-lg transition-all duration-300 font-semibold text-sm md:text-base">
                        <span>Épisode suivant</span>
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                    @endif
                    
                    @if($selectedVideo)
                    <button onclick="markAsCompleted()" class="flex items-center px-4 md:px-6 py-2 md:py-3 bg-halloween-green hover:bg-halloween-green-light text-text-primary rounded-lg transition-all duration-300 font-semibold text-sm md:text-base">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Marquer comme terminé</span>
                    </button>
                    @endif
                </div>
            </div>
        </section>

        <!-- Episodes List -->
        <section class="py-8 md:py-12">
            <div class="container mx-auto px-3 md:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                    <!-- Episodes de la saison actuelle -->
                    <div class="lg:col-span-2">
                        <h3 class="text-2xl md:text-3xl font-bold text-halloween-purple mb-6 flex items-center">
                            <i class="fas fa-list mr-3"></i>
                            Saison {{ $season->season_number }} - Épisodes
                        </h3>
                        
                        <div class="space-y-3 md:space-y-4">
                            @foreach($seasonEpisodes as $ep)
                            <a href="{{ route('watch.episode', [
                                'seriesId' => $series->id,
                                'seasonNumber' => $season->season_number,
                                'episodeNumber' => $ep->episode_number
                            ]) }}" class="block bg-black/40 hover:bg-black/60 rounded-lg md:rounded-xl p-3 md:p-4 border-2 {{ $ep->id === $episode->id ? 'border-halloween-orange' : 'border-transparent' }} hover:border-halloween-orange/50 transition-all duration-300 group">
                                <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                                    @if($ep->still_path)
                                    <img src="{{ $ep->still_url }}" alt="Episode {{ $ep->episode_number }}" class="w-full md:w-40 rounded-lg aspect-video object-cover md:flex-shrink-0">
                                    @else
                                    <div class="w-full md:w-40 bg-gradient-to-br from-halloween-purple/20 to-halloween-orange/20 rounded-lg aspect-video flex items-center justify-center md:flex-shrink-0">
                                        <i class="fas fa-tv text-halloween-orange text-3xl opacity-50"></i>
                                    </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-2">
                                            <h4 class="text-base md:text-lg font-bold text-text-primary group-hover:text-halloween-orange transition-colors line-clamp-1">
                                                {{ $ep->episode_number }}. {{ $ep->name }}
                                            </h4>
                                            @if($ep->id === $episode->id)
                                            <span class="px-2 py-1 bg-halloween-orange/20 text-halloween-orange text-xs font-bold rounded-full ml-2 flex-shrink-0">
                                                En cours
                                            </span>
                                            @endif
                                        </div>
                                        
                                        @if($ep->description)
                                        <p class="text-text-secondary text-sm line-clamp-2 mb-2">
                                            {{ $ep->description }}
                                        </p>
                                        @endif
                                        
                                        <div class="flex flex-wrap items-center gap-2 text-xs">
                                            @if($ep->runtime)
                                            <span class="text-text-secondary">
                                                <i class="fas fa-clock mr-1"></i>
                                                @php
                                                    $hours = floor($ep->runtime / 60);
                                                    $minutes = $ep->runtime % 60;
                                                    if ($hours > 0) {
                                                        echo $hours . ' h';
                                                        if ($minutes > 0) {
                                                            echo ' ' . $minutes . ' min';
                                                        }
                                                    } else {
                                                        echo $ep->runtime . ' min';
                                                    }
                                                @endphp
                                            </span>
                                            @endif
                                            
                                            @if($ep->videos->count() > 0)
                                            <span class="text-halloween-green">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                {{ $ep->videos->count() }} vidéo{{ $ep->videos->count() > 1 ? 's' : '' }}
                                            </span>
                                            @endif
                                        </div>
                                        
                                        @if($ep->videos->count() > 0)
                                        <div class="flex flex-wrap items-center gap-2 mt-2">
                                            @foreach($ep->videos as $video)
                                            <div class="flex items-center gap-1.5 px-2 py-1 bg-black/60 border border-halloween-orange/30 rounded-md">
                                                @if($video->quality)
                                                <span class="text-halloween-orange font-bold text-xs uppercase">
                                                    {{ $video->quality }}
                                                </span>
                                                @endif
                                                
                                                @if($video->language)
                                                <span class="text-text-secondary text-xs">
                                                    <i class="fas fa-language mr-0.5"></i>{{ $video->language === 'fr' ? 'FR' : ($video->language === 'en' ? 'EN' : strtoupper($video->language)) }}
                                                </span>
                                                @endif
                                                
                                                @if($video->subtitles && count($video->subtitles) > 0)
                                                <span class="text-text-secondary text-xs">
                                                    <i class="fas fa-closed-captioning"></i>
                                                </span>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Season Selector -->
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-halloween-orange mb-6 flex items-center">
                            <i class="fas fa-layer-group mr-3"></i>
                            Toutes les saisons
                        </h3>
                        
                        <div class="space-y-3">
                            @foreach($allSeasons as $s)
                            <div class="bg-black/60 rounded-lg md:rounded-xl p-4 border-2 {{ $s->id === $season->id ? 'border-halloween-orange' : 'border-halloween-orange/20' }}">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-bold text-text-primary">
                                        Saison {{ $s->season_number }}
                                    </h4>
                                    <span class="text-text-secondary text-sm">
                                        {{ $s->episodes->count() }} épisodes
                                    </span>
                                </div>
                                
                                @if($s->id === $season->id)
                                <p class="text-halloween-orange text-sm font-semibold">
                                    <i class="fas fa-play mr-1"></i>
                                    En cours de visionnage
                                </p>
                                @else
                                <a href="{{ route('watch.episode', [
                                    'seriesId' => $series->id,
                                    'seasonNumber' => $s->season_number,
                                    'episodeNumber' => 1
                                ]) }}" class="text-sm text-halloween-purple hover:text-halloween-purple-light transition-colors font-semibold">
                                    <i class="fas fa-play mr-1"></i>
                                    Commencer la saison
                                </a>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Back to Series -->
                        <a href="{{ route('series.show', $series->id) }}" class="mt-6 block w-full bg-halloween-purple text-text-primary px-4 py-3 rounded-lg font-semibold hover:bg-halloween-purple-light transition-colors duration-300 text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Détails de la série
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t-2 border-halloween-orange py-6 md:py-8">
        <div class="container mx-auto px-3 md:px-6 text-center">
            <div class="text-xl md:text-2xl font-bold text-halloween-orange drop-shadow-lg mb-2">ZTVPlus</div>
            <p class="text-text-secondary text-sm md:text-base">Votre plateforme de streaming gratuite</p>
        </div>
    </footer>
</body>
</html>

