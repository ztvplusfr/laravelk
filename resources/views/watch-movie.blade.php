<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - ZTVPlus</title>
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
            // D'abord vérifier l'état actuel
            checkCurrentStatus().then(() => {
                // Puis enregistrer automatiquement dans l'historique
                fetch('/history/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        watchable_id: {{ $movie->id }},
                        watchable_type: 'App\\Models\\Movie',
                        video_id: {{ $selectedVideo->id }},
                        completed: isCompleted // Utiliser l'état actuel
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Ajouté à l\'historique:', data.message);
                        // Mettre à jour l'état après l'ajout si nécessaire
                        if (data.history && data.history.completed !== isCompleted) {
                            isCompleted = data.history.completed;
                            updateButtonState();
                        }
                    } else {
                        console.error('Erreur historique:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
            @endif
        });
        
        // Fonction pour vérifier l'état actuel
        function checkCurrentStatus() {
            @if($selectedVideo)
            return fetch('/history/check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    watchable_id: {{ $movie->id }},
                    watchable_type: 'App\\Models\\Movie',
                    video_id: {{ $selectedVideo->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.history) {
                    isCompleted = data.history.completed;
                    updateButtonState();
                }
                return data;
            })
            .catch(error => {
                console.error('Erreur lors de la vérification:', error);
                return { success: false };
            });
            @else
            return Promise.resolve({ success: false });
            @endif
        }

        // État initial du bouton
        let isCompleted = false;
        
        // Fonction pour basculer l'état de completion
        function toggleCompletion() {
            @if($selectedVideo)
            const newCompleted = !isCompleted;
            
            fetch('/history/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    watchable_id: {{ $movie->id }},
                    watchable_type: 'App\\Models\\Movie',
                    video_id: {{ $selectedVideo->id }},
                    completed: newCompleted
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isCompleted = newCompleted;
                    updateButtonState();
                } else {
                    console.error('Erreur:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
            @endif
        }
        
        // Fonction pour mettre à jour l'apparence du bouton
        function updateButtonState() {
            const btn = document.getElementById('completionBtn');
            const icon = document.getElementById('completionIcon');
            const text = document.getElementById('completionText');
            
            if (isCompleted) {
                // État terminé - vert
                btn.className = 'flex items-center px-4 md:px-6 py-2 md:py-3 bg-halloween-green hover:bg-halloween-green-light text-text-primary rounded-lg transition-all duration-300 font-semibold text-sm md:text-base';
                icon.className = 'fas fa-check-circle mr-2';
                text.textContent = 'Terminé';
            } else {
                // État en cours - jaune
                btn.className = 'flex items-center px-4 md:px-6 py-2 md:py-3 bg-halloween-yellow hover:bg-halloween-yellow-light text-black rounded-lg transition-all duration-300 font-semibold text-sm md:text-base';
                icon.className = 'fas fa-play mr-2';
                text.textContent = 'Marquer comme terminé';
            }
        }

        // Marquer comme terminé quand l'utilisateur quitte la page
        window.addEventListener('beforeunload', function() {
            @if($selectedVideo)
            // Envoyer une requête pour marquer comme terminé
            navigator.sendBeacon('/history/update', JSON.stringify({
                watchable_id: {{ $movie->id }},
                watchable_type: 'App\\Models\\Movie',
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
                    <a href="{{ route('movie.show', $movie->id) }}" class="flex items-center hover:opacity-80 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-arrow-left mr-2 text-halloween-orange"></i>
                        <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-8 md:h-10 w-auto">
                    </a>
                    
                    <!-- Movie Title -->
                    <div class="hidden md:flex items-center gap-2 min-w-0 flex-1">
                        <span class="text-halloween-orange">|</span>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('movie.show', $movie->id) }}" class="hover:text-halloween-orange transition-colors duration-300">
                                <h2 class="text-text-primary font-bold text-xs md:text-sm lg:text-base truncate">
                                    {{ $movie->title }}
                                </h2>
                            </a>
                            @if($movie->release_date)
                            <p class="text-text-secondary text-xs truncate">
                                {{ $movie->release_date->format('Y') }}
                            </p>
                            @endif
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
                            <p class="text-text-secondary mt-2">Ce film n'a pas encore de vidéo</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Movie Info & Controls -->
        <section class="bg-gradient-to-b from-black to-bg-primary py-6 md:py-8 border-b border-halloween-orange/20">
            <div class="container mx-auto px-3 md:px-6">
                <!-- Movie Title & Info -->
                <div class="mb-6">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <a href="{{ route('movie.show', $movie->id) }}" class="hover:text-halloween-orange transition-colors duration-300">
                                <h1 class="text-2xl md:text-3xl font-bold text-text-primary mb-2">
                                    {{ $movie->title }}
                                </h1>
                            </a>
                            <div class="flex flex-wrap items-center gap-2 md:gap-3 text-sm md:text-base">
                                @if($movie->release_date)
                                <span class="px-3 py-1 bg-halloween-orange/20 border border-halloween-orange text-halloween-orange font-bold rounded-full">
                                    {{ $movie->release_date->format('Y') }}
                                </span>
                                @endif
                                
                                @if($movie->runtime)
                                <span class="text-text-secondary">
                                    <i class="fas fa-clock mr-1"></i>
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
                                
                                @if($movie->rating)
                                <span class="text-text-secondary">
                                    <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                    {{ $movie->rating }}/10
                                </span>
                                @endif
                                
                                @if($movie->videos->count() > 0)
                                    @foreach($movie->videos as $video)
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
                    
                    @if($movie->description)
                    <p class="text-text-secondary leading-relaxed">
                        {{ $movie->description }}
                    </p>
                    @endif
                </div>
                
                <!-- Video Quality Selector (si plusieurs vidéos) -->
                @if($movie->videos->count() > 1)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-text-secondary mb-3 flex items-center">
                        <i class="fas fa-video mr-2"></i>
                        Choisir une version :
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($movie->videos as $video)
                        <a href="{{ route('watch.movie', [
                            'movieId' => $movie->id,
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

                <!-- Back to Details & Mark as Completed -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('movie.show', $movie->id) }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 bg-bg-secondary hover:bg-bg-tertiary border border-halloween-orange/30 hover:border-halloween-orange rounded-lg transition-all duration-300">
                        <i class="fas fa-info-circle mr-2 text-halloween-orange"></i>
                        <span class="text-text-primary font-semibold text-sm md:text-base">Détails du film</span>
                    </a>
                    
                    @if($selectedVideo)
                    <button id="completionBtn" onclick="toggleCompletion()" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-text-primary rounded-lg transition-all duration-300 font-semibold text-sm md:text-base">
                        <i id="completionIcon" class="fas fa-play mr-2"></i>
                        <span id="completionText">Marquer comme terminé</span>
                    </button>
                    @endif
                </div>
            </div>
        </section>

        <!-- Similar Movies -->
        @if($similarMovies && $similarMovies->count() > 0)
        <section class="py-8 md:py-12 border-t border-halloween-orange/20">
            <div class="container mx-auto px-3 md:px-6">
                <h3 class="text-2xl md:text-3xl font-bold text-halloween-yellow mb-6 flex items-center">
                    <i class="fas fa-film mr-3"></i>
                    Films similaires
                </h3>
                
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4">
                    @foreach($similarMovies->take(12) as $similar)
                    <a href="{{ route('movie.show', $similar->id) }}" class="group block">
                        <div class="relative aspect-[2/3] rounded-lg overflow-hidden mb-2">
                            <img src="{{ $similar->poster_url }}" alt="{{ $similar->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3">
                                <div class="text-white">
                                    @if($similar->rating)
                                    <div class="flex items-center text-xs mb-1">
                                        <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                        {{ $similar->rating }}/10
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h4 class="text-text-primary text-sm font-semibold line-clamp-2 group-hover:text-halloween-orange transition-colors">
                            {{ $similar->title }}
                        </h4>
                        @if($similar->release_date)
                        <p class="text-text-secondary text-xs">{{ $similar->release_date->format('Y') }}</p>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
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

