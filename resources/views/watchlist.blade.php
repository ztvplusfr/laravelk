<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Liste - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .toast {
            min-width: 300px;
            max-width: 400px;
            padding: 16px 20px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
            border-left: 4px solid;
        }
        
        .toast.success {
            border-color: #10b981;
        }
        
        .toast.error {
            border-color: #ef4444;
        }
        
        .toast.info {
            border-color: #f97316;
        }
        
        .toast-icon {
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .toast.success .toast-icon {
            color: #10b981;
        }
        
        .toast.error .toast-icon {
            color: #ef4444;
        }
        
        .toast.info .toast-icon {
            color: #f97316;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-title {
            font-weight: bold;
            color: white;
            font-size: 14px;
            margin-bottom: 2px;
        }
        
        .toast-message {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            font-size: 20px;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        
        .toast-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        .toast.removing {
            animation: slideOut 0.3s ease-out forwards;
        }
        
        @media (max-width: 640px) {
            .toast-container {
                right: 10px;
                left: 10px;
            }
            
            .toast {
                min-width: auto;
            }
        }
        
        /* Content Card */
        .content-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            aspect-ratio: 2/3;
            background: #1a1a1a;
        }
        
        .content-card:hover {
            transform: translateY(-4px);
            z-index: 10;
        }
        
        .content-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .content-info {
            margin-top: 0.75rem;
            text-align: left;
        }
        
        .content-details {
            margin-top: 0.5rem;
        }
        
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 36px;
            height: 36px;
            background: rgba(239, 68, 68, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .content-card:hover .remove-btn {
            opacity: 1;
        }
        
        .remove-btn:hover {
            background: rgba(239, 68, 68, 1);
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-black min-h-screen font-sans">
    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>
    
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-black/50 backdrop-blur-xl border-b border-halloween-orange/30">
        <nav class="container mx-auto px-4 md:px-6 py-3 md:py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/home" class="flex items-center hover:opacity-80 transition-all duration-300">
                    <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-10 md:h-12 w-auto">
                </a>
                
                <!-- User Info -->
                <a href="{{ route('account') }}" class="flex items-center space-x-2 md:space-x-3 hover:opacity-80 transition-opacity duration-300">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-halloween-orange">
                    @else
                        <div class="w-10 h-10 bg-halloween-orange rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-text-primary"></i>
                        </div>
                    @endif
                    <span class="text-text-primary font-semibold hidden md:block">{{ $user->name }}</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-24 md:pt-28 pb-16 px-4 md:px-6">
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="mb-8 md:mb-12">
                <h1 class="text-3xl md:text-5xl font-bold text-halloween-purple mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-bookmark mr-3 md:mr-4"></i>
                    Ma Liste
                </h1>
                <p class="text-text-secondary text-sm md:text-base">
                    Retrouvez tous les films et séries que vous avez sauvegardés
                </p>
            </div>

            @if($watchlistItems->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16 md:py-24">
                    <i class="fas fa-bookmark text-6xl md:text-8xl text-halloween-purple/30 mb-6"></i>
                    <h2 class="text-2xl md:text-3xl font-bold text-text-primary mb-4">Votre liste est vide</h2>
                    <p class="text-text-secondary mb-8 max-w-md mx-auto">
                        Ajoutez des films et séries à votre liste pour les retrouver facilement plus tard
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center bg-gradient-to-r from-halloween-purple to-halloween-purple-light text-text-primary px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-base md:text-lg shadow-2xl hover:shadow-halloween-purple/50 transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>
            @else
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 md:mb-12">
                    <div class="bg-bg-secondary border-2 border-halloween-purple/30 rounded-xl p-4 md:p-6">
                        <div class="text-halloween-purple text-2xl md:text-3xl font-bold mb-1">{{ $watchlistItems->count() }}</div>
                        <div class="text-text-secondary text-xs md:text-sm">Total</div>
                    </div>
                    <div class="bg-bg-secondary border-2 border-halloween-orange/30 rounded-xl p-4 md:p-6">
                        <div class="text-halloween-orange text-2xl md:text-3xl font-bold mb-1">{{ $movieCount }}</div>
                        <div class="text-text-secondary text-xs md:text-sm">Films</div>
                    </div>
                    <div class="bg-bg-secondary border-2 border-halloween-purple/30 rounded-xl p-4 md:p-6">
                        <div class="text-halloween-purple text-2xl md:text-3xl font-bold mb-1">{{ $seriesCount }}</div>
                        <div class="text-text-secondary text-xs md:text-sm">Séries</div>
                    </div>
                    <div class="bg-bg-secondary border-2 border-halloween-green/30 rounded-xl p-4 md:p-6">
                        <div class="text-halloween-green text-2xl md:text-3xl font-bold mb-1">{{ $availableCount }}</div>
                        <div class="text-text-secondary text-xs md:text-sm">Disponibles en Streaming</div>
                    </div>
                </div>

                <!-- Content by Date -->
                @php
                    $userTimezone = $user->timezone ?? 'Europe/Paris';
                    $groupedItems = $watchlistItems->groupBy(function($item) use ($userTimezone) {
                        return $item->created_at->setTimezone($userTimezone)->format('Y-m-d');
                    });
                @endphp
                
                @foreach($groupedItems as $date => $items)
                    <div class="mb-8 md:mb-12">
                        <!-- Date Header -->
                        <div class="flex items-center mb-4 md:mb-6">
                            <div class="bg-gradient-to-r from-halloween-purple to-halloween-purple-light rounded-xl px-4 md:px-6 py-3 md:py-4">
                                <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 md:mr-3"></i>
                                    @php
                                        $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $date)->setTimezone($userTimezone);
                                        $today = now()->setTimezone($userTimezone);
                                        $yesterday = $today->copy()->subDay();
                                        
                                        if ($dateObj->isSameDay($today)) {
                                            echo "Aujourd'hui";
                                        } elseif ($dateObj->isSameDay($yesterday)) {
                                            echo "Hier";
                                        } else {
                                            echo $dateObj->format('l j F Y');
                                        }
                                    @endphp
                                </h2>
                            </div>
                            <div class="ml-4 bg-bg-secondary border-2 border-halloween-purple/30 rounded-xl px-3 py-2">
                                <span class="text-halloween-purple font-bold text-sm">{{ $items->count() }} élément{{ $items->count() > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                        
                        <!-- Content Grid for this date -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
                            @foreach($items as $item)
                                @php
                                    $content = $item->watchable;
                                    $isMovie = get_class($content) === 'App\Models\Movie';
                                    $routeName = $isMovie ? 'movie.show' : 'series.show';
                                    $contentType = $isMovie ? 'movie' : 'series';
                                @endphp
                                
                                <div class="group" data-id="{{ $content->id }}" data-type="{{ $contentType }}">
                                    <!-- Poster Card -->
                                    <div class="content-card">
                                        <a href="{{ route($routeName, $content->id) }}">
                                            <img src="{{ $content->poster_url }}" alt="{{ $content->title }}" class="content-poster">
                                        </a>
                                        
                                        <!-- Remove Button -->
                                        <button onclick="removeFromWatchlist(event, {{ $content->id }}, '{{ $contentType }}')" class="remove-btn" title="Retirer de ma liste">
                                            <i class="fas fa-times text-white"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Info Card -->
                                    <div class="content-info">
                                        <!-- Type Badge and Time -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                @if($isMovie)
                                                <span class="inline-block px-2 py-1 bg-halloween-orange/80 text-white rounded-full text-xs font-bold">
                                                    <i class="fas fa-film mr-1"></i>FILM
                                                </span>
                                                @else
                                                <span class="inline-block px-2 py-1 bg-halloween-purple/80 text-white rounded-full text-xs font-bold">
                                                    <i class="fas fa-tv mr-1"></i>SÉRIE
                                                </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <div class="text-text-secondary text-xs">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $item->created_at->setTimezone($user->timezone ?? 'Europe/Paris')->format('H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <h3 class="text-text-primary font-bold text-sm md:text-base mb-2 line-clamp-2">{{ $content->title }}</h3>
                                        
                                        <div class="content-details">
                                            @if($content->rating)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <i class="fas fa-star text-halloween-yellow text-xs"></i>
                                                <span class="text-text-primary text-xs">{{ $content->rating }}/10</span>
                                            </div>
                                            @endif
                                            
                                            @if(($isMovie && $content->videos->count() > 0) || (!$isMovie && $content->seasons->flatMap->episodes->flatMap->videos->count() > 0))
                                            <div class="bg-halloween-green/20 text-halloween-green px-3 py-2 rounded-lg font-semibold text-xs flex items-center justify-center">
                                                <i class="fas fa-play mr-2"></i>
                                                Disponible
                                            </div>
                                            @else
                                            <div class="bg-gray-500/20 text-gray-400 px-3 py-2 rounded-lg font-semibold text-xs flex items-center justify-center">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                Bientôt
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t-2 border-halloween-purple py-8 md:py-12">
        <div class="container mx-auto px-6 text-center">
            <p class="text-text-muted text-sm md:text-base">&copy; 2025 ZTVPlus. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Toast Notifications System
        function showToast(type, title, message, duration = 4000) {
            const container = document.getElementById('toastContainer');
            
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            let icon = '';
            if (type === 'success') {
                icon = '<i class="fas fa-check-circle"></i>';
            } else if (type === 'error') {
                icon = '<i class="fas fa-exclamation-circle"></i>';
            } else if (type === 'info') {
                icon = '<i class="fas fa-info-circle"></i>';
            }
            
            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, duration);
        }
        
        function closeToast(button) {
            const toast = button.closest('.toast');
            toast.classList.add('removing');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
        
        // Remove from Watchlist
        function removeFromWatchlist(event, id, type) {
            event.preventDefault();
            event.stopPropagation();
            
            const card = document.querySelector(`[data-id="${id}"][data-type="${type}"]`);
            
            fetch('/watchlist/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type, id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animer la disparition
                    card.style.transform = 'scale(0)';
                    card.style.opacity = '0';
                    
                    setTimeout(() => {
                        card.remove();
                        
                        // Vérifier s'il reste des items
                        const remainingItems = document.querySelectorAll('.content-card').length;
                        if (remainingItems === 0) {
                            location.reload(); // Recharger pour afficher l'empty state
                        }
                    }, 300);
                    
                    showToast('info', 'Retiré de Ma Liste', data.message || 'Le contenu a été retiré de votre liste');
                } else {
                    showToast('error', 'Erreur', data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('error', 'Erreur de connexion', 'Impossible de communiquer avec le serveur');
            });
        }
    </script>
    
    <!-- Bottom Navigation -->
    @include('components.bottom-nav', ['user' => $user])
</body>
</html>

