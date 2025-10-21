<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
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
        
        /* User Dropdown Menu */
        .user-dropdown {
            position: relative;
        }
        
        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .admin-crown {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
            border: 2px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
            box-shadow: 0 2px 8px rgba(168, 85, 247, 0.5);
        }
        
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 200px;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(249, 115, 22, 0.3);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid rgba(249, 115, 22, 0.3);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #e5e7eb;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(249, 115, 22, 0.1);
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-item:hover {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 12px;
        }
        
        /* Hero Slider Styles */
        .hero-section {
            position: relative;
        }
        
        .hero-swiper {
            width: 100%;
            height: 100vh;
            min-height: 600px;
        }
        
        @media (max-width: 768px) {
            .hero-swiper {
                min-height: 500px;
            }
        }
        
        .hero-slide {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .hero-backdrop {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        
        .hero-slide:hover .hero-backdrop {
            transform: scale(1.15);
        }
        
        .hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.7) 40%, rgba(0, 0, 0, 0.3) 70%, transparent 100%),
                        linear-gradient(to bottom, transparent 0%, transparent 40%, rgba(0, 0, 0, 0.6) 80%, rgba(0, 0, 0, 0.95) 100%);
        }
        
        /* Fade to black at the bottom of hero */
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(to bottom, transparent 0%, #000000 100%);
            pointer-events: none;
            z-index: 6;
        }
        
        /* Enhanced text shadow for better readability */
        .hero-slide h1 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8),
                         4px 4px 8px rgba(0, 0, 0, 0.6),
                         6px 6px 12px rgba(0, 0, 0, 0.4);
        }
        
        /* Carousel Styles */
        .carousel-swiper {
            padding: 20px 0;
        }
        
        .movie-card {
            transition: all 0.3s ease;
        }
        
        .movie-card:hover {
            transform: translateY(-4px);
        }
        
        .movie-poster-wrapper {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            aspect-ratio: 2/3;
            background: #1a1a1a;
        }
        
        .movie-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .movie-card:hover .movie-poster {
            transform: scale(1.05);
        }
        
        .movie-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .movie-card:hover .movie-overlay {
            opacity: 1;
        }
        
        /* Swiper Navigation */
        .hero-swiper .swiper-button-next,
        .hero-swiper .swiper-button-prev {
            color: #fff;
            background: rgba(249, 115, 22, 0.9);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(249, 115, 22, 0.5);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
        }
        
        .hero-swiper .swiper-button-next:hover,
        .hero-swiper .swiper-button-prev:hover {
            background: rgba(249, 115, 22, 1);
            border-color: rgba(249, 115, 22, 1);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6);
        }
        
        .hero-swiper .swiper-button-next:after,
        .hero-swiper .swiper-button-prev:after {
            font-size: 24px;
            font-weight: bold;
        }
        
        /* Hero Pagination */
        .hero-swiper .swiper-pagination {
            bottom: 80px;
            right: 40px;
            left: auto;
            width: auto;
            display: flex;
            gap: 12px;
            background: rgba(0, 0, 0, 0.7);
            padding: 12px 20px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(249, 115, 22, 0.3);
            z-index: 20;
        }
        
        .hero-swiper .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .hero-swiper .swiper-pagination-bullet-active {
            background: #f97316;
            border-color: rgba(249, 115, 22, 0.5);
            transform: scale(1.3);
        }
        
        .hero-swiper .swiper-pagination-bullet:hover {
            background: rgba(249, 115, 22, 0.7);
            transform: scale(1.2);
        }
        
        /* Carousel Navigation */
        .carousel-swiper .swiper-button-next,
        .carousel-swiper .swiper-button-prev {
            color: #f97316;
            background: rgba(17, 24, 39, 0.8);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }
        
        .carousel-swiper .swiper-button-next:after,
        .carousel-swiper .swiper-button-prev:after {
            font-size: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-swiper .swiper-button-next,
            .hero-swiper .swiper-button-prev {
                display: none;
            }
            
            .hero-swiper .swiper-pagination {
                bottom: 40px;
                right: 50%;
                transform: translateX(50%);
                padding: 8px 15px;
                gap: 8px;
                z-index: 30;
            }
            
            .hero-swiper .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
            }
        }
        
        /* Custom Scrollbar pour les résultats de recherche */
        #searchResults {
            scrollbar-width: thin;
            scrollbar-color: #f97316 #1f2937;
        }
        
        #searchResults::-webkit-scrollbar {
            width: 8px;
        }
        
        #searchResults::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 10px;
        }
        
        #searchResults::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 10px;
        }
        
        #searchResults::-webkit-scrollbar-thumb:hover {
            background: #fb923c;
        }
    </style>
</head>
<body class="bg-black min-h-screen font-sans">
    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>
    
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 transition-all duration-500 ease-in-out">
        <nav class="container mx-auto px-4 md:px-6 py-3 md:py-4">
            <div class="flex justify-between items-center">
                <!-- Logo et Navigation à gauche -->
                <div class="flex items-center space-x-4 md:space-x-8">
                    <a href="/home" class="flex items-center hover:opacity-80 transition-all duration-300">
                        <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-10 md:h-12 w-auto">
                    </a>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden md:flex items-center space-x-4 md:space-x-6">
                        <a href="{{ route('home') }}" class="text-halloween-orange font-bold transition-colors duration-300">
                            Accueil
                        </a>
                        <a href="{{ route('movies') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300 font-semibold">
                            Films
                        </a>
                        <a href="{{ route('series') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300 font-semibold">
                            Séries
                        </a>
                    </div>
                </div>
                
                <!-- Actions à droite -->
                <div class="flex items-center space-x-4 md:space-x-4">
                    <!-- Bouton Recherche -->
                    <button id="searchToggle" class="text-text-primary hover:text-halloween-orange transition-colors duration-300" title="Rechercher">
                        <i class="fas fa-search text-2xl md:text-xl"></i>
                    </button>
                    
                    <!-- Bouton Ma Liste -->
                    <a href="{{ route('watchlist') }}" class="hidden md:inline-block text-text-primary hover:text-halloween-purple transition-colors duration-300 mr-4" title="Ma Liste">
                        <i class="fas fa-bookmark text-lg md:text-xl"></i>
                    </a>
                    
                    <!-- Bouton Historique -->
                    <a href="{{ route('history') }}" class="text-text-primary hover:text-halloween-green transition-colors duration-300" title="Historique">
                        <i class="fas fa-history text-2xl md:text-xl"></i>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown hidden md:block">
                        <button id="userDropdownToggle" class="flex items-center space-x-2 md:space-x-3 hover:opacity-80 transition-opacity duration-300 focus:outline-none" title="Mon compte">
                            <div class="avatar-wrapper">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-halloween-orange">
                                @else
                                    <div class="w-10 h-10 bg-halloween-orange rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-text-primary"></i>
                                    </div>
                                @endif
                                @if($user->isAdmin())
                                    <div class="admin-crown">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-text-primary hidden lg:flex items-center space-x-2">
                                <p class="font-semibold">{{ $user->name }}</p>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-300" id="dropdownChevron"></i>
                            </div>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdownMenu" class="dropdown-menu">
                            <a href="{{ route('account') }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Mon Compte</span>
                            </a>
                            
                            @if($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-crown"></i>
                                <span>Administration</span>
                            </a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Barre de recherche cachée -->
        <div id="searchBar" class="hidden border-t border-halloween-orange/30 bg-black/95 backdrop-blur-xl">
            <div class="container mx-auto px-6 py-4">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Rechercher des films, séries..." 
                        class="w-full bg-bg-secondary text-text-primary px-6 py-3 pr-12 rounded-full border-2 border-halloween-orange/50 focus:border-halloween-orange focus:outline-none transition-colors duration-300"
                        autocomplete="off"
                    >
                    <button id="searchClose" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-text-secondary hover:text-halloween-orange transition-colors duration-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <!-- Résultats de recherche -->
                    <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-bg-secondary border-2 border-halloween-orange/50 rounded-2xl shadow-2xl shadow-halloween-orange/20 max-h-96 overflow-y-auto">
                        <!-- Loader -->
                        <div id="searchLoader" class="hidden p-8 text-center">
                            <i class="fas fa-spinner fa-spin text-halloween-orange text-3xl"></i>
                            <p class="text-text-secondary mt-2">Recherche en cours...</p>
                        </div>
                        
                        <!-- Contenu des résultats -->
                        <div id="searchContent"></div>
                        
                        <!-- Aucun résultat -->
                        <div id="noResults" class="hidden p-8 text-center">
                            <i class="fas fa-search text-text-secondary text-4xl mb-3"></i>
                            <p class="text-text-secondary">Aucun résultat trouvé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Slider -->
        <section id="home" class="hero-section">
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    @forelse($featuredContent as $content)
                    <div class="swiper-slide hero-slide">
                        <!-- Backdrop Image -->
                        <div class="hero-backdrop" style="background-image: url('{{ $content->backdrop_url }}');"></div>
                        <div class="hero-gradient"></div>
                        
                        <!-- Content -->
                        <div class="container mx-auto px-6 h-full flex items-end md:items-center relative z-10">
                            <div class="max-w-4xl w-full pb-20 md:pb-0">
                                <!-- Type Badge -->
                                <div class="mb-3 md:mb-4">
                                    @if(get_class($content) === 'App\Models\Movie')
                                    <span class="inline-block px-4 py-2 bg-halloween-orange/80 text-white rounded-full text-sm font-bold backdrop-blur-sm">
                                        <i class="fas fa-film mr-2"></i>FILM
                                    </span>
                                    @else
                                    <span class="inline-block px-4 py-2 bg-halloween-purple/80 text-white rounded-full text-sm font-bold backdrop-blur-sm">
                                        <i class="fas fa-tv mr-2"></i>SÉRIE
                                    </span>
                                    @endif
                                </div>
                                
                                <h1 class="text-2xl md:text-5xl lg:text-6xl font-bold mb-3 md:mb-4 text-white drop-shadow-2xl line-clamp-2 leading-tight">
                                    {{ $content->title }}
                                </h1>
                                
                                <!-- Infos (rating, année, durée) -->
                                <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-2 md:mb-3 text-sm md:text-base">
                                    @if($content->rating)
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-star text-halloween-yellow text-sm md:text-base"></i>
                                        <span class="text-text-primary font-bold">{{ $content->rating }}/10</span>
                                    </div>
                                    @endif
                                    
                                    @if(isset($content->release_date) && $content->release_date)
                                    <span class="text-text-secondary">{{ $content->release_date->format('Y') }}</span>
                                    @elseif(isset($content->first_air_date) && $content->first_air_date)
                                    <span class="text-text-secondary">{{ $content->first_air_date->format('Y') }}</span>
                                    @endif
                                    
                                    @if(isset($content->runtime) && $content->runtime)
                                    <span class="text-text-secondary">
                                        @php
                                            $hours = floor($content->runtime / 60);
                                            $minutes = $content->runtime % 60;
                                            if ($hours > 0) {
                                                echo $hours . ' h';
                                                if ($minutes > 0) {
                                                    echo ' ' . $minutes . ' min';
                                                }
                                            } else {
                                                echo $content->runtime . ' min';
                                            }
                                        @endphp
                                    </span>
                                    @elseif(isset($content->number_of_seasons) && $content->number_of_seasons)
                                    <span class="text-text-secondary">{{ $content->number_of_seasons }} saison(s)</span>
                                    @endif
                                </div>
                                
                                <!-- Genres sur une ligne séparée -->
                                @if($content->genres && count($content->genres) > 0)
                                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                                    @foreach(array_slice($content->genres, 0, 2) as $genre)
                                    <span class="px-2 md:px-3 py-1 bg-halloween-orange/20 backdrop-blur-sm border border-halloween-orange/50 text-halloween-orange text-xs font-bold rounded-full">
                                        {{ is_array($genre) ? $genre['name'] : $genre }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                                
                                <p class="text-text-primary text-sm md:text-lg mb-4 md:mb-6 line-clamp-2 md:line-clamp-3 leading-relaxed max-w-3xl">
                                    {{ $content->description }}
                                </p>
                                
                                <div class="flex flex-wrap gap-2 md:gap-4">
                                    @if(get_class($content) === 'App\Models\Movie')
                                    <a href="{{ route('movie.show', $content->id) }}" class="group bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-4 md:px-8 py-2 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:scale-105 transition-all duration-300 flex items-center">
                                        <i class="fas fa-play mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                        {{ $content->videos->count() > 0 ? 'Regarder' : 'Voir les détails' }}
                                    </a>
                                    @elseif(get_class($content) === 'App\Models\Series')
                                    <a href="{{ route('series.show', $content->id) }}" class="group bg-gradient-to-r from-halloween-purple to-halloween-purple-light text-text-primary px-4 md:px-8 py-2 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-2xl hover:shadow-halloween-purple/50 transform hover:scale-105 transition-all duration-300 flex items-center">
                                        <i class="fas fa-play mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                        Voir les épisodes
                                    </a>
                                    @endif
                                    
                                    <!-- Bouton Ma Liste -->
                                    @php
                                        $fullClassName = get_class($content);
                                        // Déterminer le type court basé sur la classe
                                        if ($fullClassName === 'App\Models\Movie') {
                                            $contentType = 'movie';
                                        } elseif ($fullClassName === 'App\Models\Series') {
                                            $contentType = 'series';
                                        } else {
                                            $contentType = 'unknown';
                                        }
                                        $isInWatchlist = auth()->user()->watchlist()->where('watchable_type', $fullClassName)->where('watchable_id', $content->id)->exists();
                                    @endphp
                                    <button onclick="toggleWatchlist(this)" 
                                            class="watchlist-btn group bg-black/60 backdrop-blur-sm border-2 border-halloween-purple text-text-primary px-4 md:px-8 py-2 md:py-4 rounded-full font-bold text-sm md:text-lg hover:bg-halloween-purple hover:shadow-lg hover:shadow-halloween-purple/50 transition-all duration-300 flex items-center"
                                            data-type="{{ $contentType }}"
                                            data-id="{{ $content->id }}"
                                            data-in-watchlist="{{ $isInWatchlist ? 'true' : 'false' }}">
                                        <i class="fas fa-{{ $isInWatchlist ? 'check' : 'plus' }} mr-2"></i>
                                        <span class="hidden md:inline">{{ $isInWatchlist ? 'Dans ma liste' : 'Ma liste' }}</span>
                                        <span class="md:hidden">Liste</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide hero-slide">
                        <div class="hero-backdrop" style="background: linear-gradient(135deg, #f97316 0%, #a855f7 100%);"></div>
                        <div class="hero-gradient"></div>
                        <div class="container mx-auto px-6 h-full flex items-end md:items-center justify-center relative z-10">
                            <div class="text-center max-w-4xl pb-20 md:pb-0">
                                <h1 class="text-3xl md:text-6xl font-bold mb-4 md:mb-6 text-white drop-shadow-2xl line-clamp-2">
                                    Bienvenue sur ZTVPlus
                                </h1>
                                <p class="text-lg md:text-2xl text-text-primary mb-8">
                                    Votre plateforme de streaming gratuite
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!-- Derniers Épisodes -->
        @if($recentEpisodes->count() > 0)
        <section class="py-16 bg-black">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-halloween-green drop-shadow-lg">
                        <i class="fas fa-clock mr-3"></i>
                        Derniers Épisodes
                    </h2>
                    <a href="{{ route('series') }}" class="text-halloween-green hover:text-halloween-green-light font-semibold flex items-center">
                        Voir tout
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="swiper carousel-swiper" id="recent-episodes-swiper">
                    <div class="swiper-wrapper">
                        @foreach($recentEpisodes as $episode)
                        <div class="swiper-slide">
                            <a href="{{ route('watch.episode', [
                                'seriesId' => $episode->season->series->id,
                                'seasonNumber' => $episode->season->season_number,
                                'episodeNumber' => $episode->episode_number
                            ]) }}" class="group block bg-black/40 rounded-xl overflow-hidden hover:bg-black/60 transition-all duration-300 border-2 border-transparent hover:border-halloween-green/50">
                                <!-- Episode Still (Rectangle) -->
                                <div class="relative aspect-video overflow-hidden">
                                    @if($episode->still_path)
                                        <img src="{{ $episode->still_url }}" alt="{{ $episode->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-halloween-green/20 to-halloween-purple/20 flex items-center justify-center">
                                            <i class="fas fa-tv text-halloween-green text-4xl opacity-50"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                                    
                                    <!-- Play button -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="w-12 h-12 bg-halloween-green/90 rounded-full flex items-center justify-center">
                                            <i class="fas fa-play text-white text-lg ml-1"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Episode badge -->
                                    <div class="absolute top-2 left-2">
                                        <span class="px-2 py-1 bg-halloween-green/90 text-text-primary text-xs font-bold rounded-full">
                                            S{{ $episode->season->season_number }}E{{ $episode->episode_number }}
                                        </span>
                                    </div>
                                    
                                    @if($episode->runtime)
                                    <div class="absolute bottom-2 right-2">
                                        <span class="px-2 py-1 bg-black/80 text-text-primary text-xs font-semibold rounded">
                                            <i class="fas fa-clock mr-1"></i>
                                            @php
                                                $hours = floor($episode->runtime / 60);
                                                $minutes = $episode->runtime % 60;
                                                if ($hours > 0) {
                                                    echo $hours . 'h';
                                                    if ($minutes > 0) {
                                                        echo ' ' . $minutes . 'min';
                                                    }
                                                } else {
                                                    echo $episode->runtime . 'min';
                                                }
                                            @endphp
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Episode Info -->
                                <div class="p-4">
                                    <h3 class="text-halloween-green font-bold text-sm mb-1 group-hover:text-halloween-green-light transition-colors truncate">
                                        {{ $episode->season->series->title }}
                                    </h3>
                                    <h4 class="text-text-primary font-semibold text-sm mb-2 line-clamp-1">
                                        {{ $episode->name }}
                                    </h4>
                                    
                                    @if($episode->description)
                                    <p class="text-text-secondary text-xs line-clamp-2 leading-relaxed">
                                        {{ $episode->description }}
                                    </p>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- Films Récents -->
        @if($recentMovies->count() > 0)
        <section id="movies" class="py-16 bg-black">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-halloween-orange drop-shadow-lg">
                        <i class="fas fa-film mr-3"></i>
                        Films Récents
                </h2>
                    <a href="{{ route('movies') }}" class="text-halloween-orange hover:text-halloween-orange-light font-semibold flex items-center">
                        Voir tout
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    </div>

                <div class="swiper carousel-swiper">
                    <div class="swiper-wrapper">
                        @foreach($recentMovies as $movie)
                        <div class="swiper-slide">
                            <div class="movie-card group">
                                <a href="{{ route('movie.show', $movie->id) }}">
                                    <!-- Poster -->
                                    <div class="movie-poster-wrapper">
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="movie-poster">
                                        
                                        <!-- Overlay avec bouton play au centre -->
                                        <div class="movie-overlay">
                                            <div class="w-14 h-14 bg-halloween-orange/90 rounded-full flex items-center justify-center">
                                                <i class="fas fa-play text-white text-xl ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Infos sous le poster -->
                                    <div class="mt-3">
                                        <h3 class="text-text-primary font-bold text-sm md:text-base mb-1 line-clamp-2 group-hover:text-halloween-orange transition-colors text-left">
                                            {{ $movie->title }}
                                        </h3>
                                        
                                        <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                                            @if($movie->rating)
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                <span>{{ $movie->rating }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($movie->release_date)
                                            <span>{{ $movie->release_date->format('Y') }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($movie->videos->count() > 0)
                                        <span class="inline-block px-2 py-1 bg-halloween-orange/20 text-halloween-orange text-xs rounded-full">
                                            Disponible
                                        </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- Films Populaires -->
        @if($popularMovies->count() > 0)
        <section class="py-16 bg-black">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-halloween-purple drop-shadow-lg">
                        <i class="fas fa-fire mr-3"></i>
                        Films Populaires
                    </h2>
                    <a href="{{ route('movies') }}?sort=rating" class="text-halloween-purple hover:text-halloween-purple-light font-semibold flex items-center">
                        Voir tout
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="swiper carousel-swiper" id="popular-swiper">
                    <div class="swiper-wrapper">
                        @foreach($popularMovies as $movie)
                        <div class="swiper-slide">
                            <div class="movie-card group">
                                <a href="{{ route('movie.show', $movie->id) }}">
                                    <!-- Poster -->
                                    <div class="movie-poster-wrapper">
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="movie-poster">
                                        
                                        <!-- Overlay avec bouton play au centre -->
                                        <div class="movie-overlay">
                                            <div class="w-14 h-14 bg-halloween-purple/90 rounded-full flex items-center justify-center">
                                                <i class="fas fa-play text-white text-xl ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Infos sous le poster -->
                                    <div class="mt-3">
                                        <h3 class="text-text-primary font-bold text-sm md:text-base mb-1 line-clamp-2 group-hover:text-halloween-purple transition-colors text-left">
                                            {{ $movie->title }}
                                        </h3>
                                        
                                        <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                                            @if($movie->rating)
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                <span>{{ $movie->rating }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($movie->release_date)
                                            <span>{{ $movie->release_date->format('Y') }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($movie->videos->count() > 0)
                                        <span class="inline-block px-2 py-1 bg-halloween-purple/20 text-halloween-purple text-xs rounded-full">
                                            Disponible
                                        </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- Séries en Vedette -->
        @if($featuredSeries->count() > 0)
        <section id="series" class="py-16 bg-black">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-halloween-yellow drop-shadow-lg">
                        <i class="fas fa-tv mr-3"></i>
                        Séries en Vedette
                </h2>
                    <a href="{{ route('series') }}?sort=rating" class="text-halloween-yellow hover:text-halloween-yellow-light font-semibold flex items-center">
                        Voir tout
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="swiper carousel-swiper" id="series-swiper">
                    <div class="swiper-wrapper">
                        @foreach($featuredSeries as $series)
                        <div class="swiper-slide">
                            <div class="movie-card group">
                                <a href="{{ route('series.show', $series->id) }}">
                                    <!-- Poster -->
                                    <div class="movie-poster-wrapper">
                                        <img src="{{ $series->poster_url }}" alt="{{ $series->title }}" class="movie-poster">
                                        
                                        <!-- Overlay avec bouton TV au centre -->
                                        <div class="movie-overlay">
                                            <div class="w-14 h-14 bg-halloween-yellow/90 rounded-full flex items-center justify-center">
                                                <i class="fas fa-tv text-white text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Infos sous le poster -->
                                    <div class="mt-3">
                                        <h3 class="text-text-primary font-bold text-sm md:text-base mb-1 line-clamp-2 group-hover:text-halloween-yellow transition-colors text-left">
                                            {{ $series->title }}
                                        </h3>
                                        
                                        <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                                            @if($series->rating)
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                <span>{{ $series->rating }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($series->first_air_date)
                                            <span>{{ $series->first_air_date->format('Y') }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($series->number_of_seasons)
                                        <span class="inline-block px-2 py-1 bg-halloween-yellow/20 text-halloween-yellow text-xs rounded-full">
                                            {{ $series->number_of_seasons }} saison{{ $series->number_of_seasons > 1 ? 's' : '' }}
                                        </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- Séries Récentes -->
        @if($recentSeries->count() > 0)
        <section class="py-16 bg-black">
            <div class="container mx-auto px-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-halloween-green drop-shadow-lg">
                        <i class="fas fa-clock mr-3"></i>
                        Séries Récentes
                    </h2>
                    <a href="{{ route('series') }}" class="text-halloween-green hover:text-halloween-green-light font-semibold flex items-center">
                        Voir tout
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="swiper carousel-swiper" id="recent-series-swiper">
                    <div class="swiper-wrapper">
                        @foreach($recentSeries as $series)
                        <div class="swiper-slide">
                            <div class="movie-card group">
                                <a href="{{ route('series.show', $series->id) }}">
                                    <!-- Poster -->
                                    <div class="movie-poster-wrapper">
                                        <img src="{{ $series->poster_url }}" alt="{{ $series->title }}" class="movie-poster">
                                        
                                        <!-- Overlay avec bouton TV au centre -->
                                        <div class="movie-overlay">
                                            <div class="w-14 h-14 bg-halloween-green/90 rounded-full flex items-center justify-center">
                                                <i class="fas fa-tv text-white text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Infos sous le poster -->
                                    <div class="mt-3">
                                        <h3 class="text-text-primary font-bold text-sm md:text-base mb-1 line-clamp-2 group-hover:text-halloween-green transition-colors text-left">
                                            {{ $series->title }}
                                        </h3>
                                        
                                        <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                                            @if($series->rating)
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                <span>{{ $series->rating }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($series->first_air_date)
                                            <span>{{ $series->first_air_date->format('Y') }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($series->number_of_seasons)
                                        <span class="inline-block px-2 py-1 bg-halloween-green/20 text-halloween-green text-xs rounded-full">
                                            {{ $series->number_of_seasons }} saison{{ $series->number_of_seasons > 1 ? 's' : '' }}
                                        </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t-2 border-halloween-orange py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-halloween-orange mb-4">
                        <i class="fas fa-play-circle mr-2"></i>
                        ZTVPlus
                    </h3>
                    <p class="text-text-secondary">
                        Votre plateforme de streaming gratuite et légale
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-text-primary mb-4">Navigation</h4>
                    <ul class="space-y-2 text-text-secondary">
                        <li><a href="{{ route('home') }}" class="hover:text-halloween-orange transition-colors">Accueil</a></li>
                        <li><a href="{{ route('movies') }}" class="hover:text-halloween-orange transition-colors">Films</a></li>
                        <li><a href="{{ route('series') }}" class="hover:text-halloween-orange transition-colors">Séries</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-text-primary mb-4">Légal</h4>
                    <ul class="space-y-2 text-text-secondary">
                        <li><a href="#" class="hover:text-halloween-orange transition-colors">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-halloween-orange transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-halloween-orange transition-colors">Mentions légales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-text-primary mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                <a href="#" class="w-12 h-12 bg-bg-tertiary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-bg-tertiary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-bg-tertiary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-halloween-orange/30 pt-8 text-center text-text-muted">
                <p>&copy; 2025 ZTVPlus. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation -->
    @include('components.bottom-nav', ['user' => $user])

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Toast Notifications System
        function showToast(type, title, message, duration = 4000) {
            const container = document.getElementById('toastContainer');
            
            // Créer le toast
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            // Icône selon le type
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
            
            // Auto-remove après duration
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
        
        // Hero Slider
        const heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            },
        });

        // Carousel Swipers
        const carouselConfig = {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 6,
                    spaceBetween: 30,
                },
            },
        };

        // Initialize all carousel swipers
        document.querySelectorAll('.carousel-swiper').forEach((el) => {
            new Swiper(el, carouselConfig);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Header background on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('bg-black/50', 'backdrop-blur-xl', 'border-b', 'border-halloween-orange/30');
            } else {
                header.classList.remove('bg-black/50', 'backdrop-blur-xl', 'border-b', 'border-halloween-orange/30');
            }
        });

        // User Dropdown Toggle
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        const dropdownChevron = document.getElementById('dropdownChevron');
        
        if (userDropdownToggle && userDropdownMenu) {
            userDropdownToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
                if (dropdownChevron) {
                    dropdownChevron.style.transform = userDropdownMenu.classList.contains('show') 
                        ? 'rotate(180deg)' 
                        : 'rotate(0deg)';
                }
            });
            
            // Fermer le dropdown en cliquant ailleurs
            document.addEventListener('click', (e) => {
                if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.remove('show');
                    if (dropdownChevron) {
                        dropdownChevron.style.transform = 'rotate(0deg)';
                    }
                }
            });
            
            // Fermer le dropdown avec Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && userDropdownMenu.classList.contains('show')) {
                    userDropdownMenu.classList.remove('show');
                    if (dropdownChevron) {
                        dropdownChevron.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }

        // Toggle Search Bar
        const searchToggle = document.getElementById('searchToggle');
        const searchBar = document.getElementById('searchBar');
        const searchClose = document.getElementById('searchClose');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchLoader = document.getElementById('searchLoader');
        const searchContent = document.getElementById('searchContent');
        const noResults = document.getElementById('noResults');
        
        let searchTimeout;

        searchToggle.addEventListener('click', () => {
            searchBar.classList.remove('hidden');
            searchInput.focus();
        });

        searchClose.addEventListener('click', () => {
            searchBar.classList.add('hidden');
            searchResults.classList.add('hidden');
            searchInput.value = '';
            searchContent.innerHTML = '';
        });

        // Fermer la barre de recherche avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !searchBar.classList.contains('hidden')) {
                searchBar.classList.add('hidden');
                searchResults.classList.add('hidden');
                searchInput.value = '';
                searchContent.innerHTML = '';
            }
        });

        // Recherche en temps réel
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.trim();
            
            // Annuler la recherche précédente
            clearTimeout(searchTimeout);
            
            // Si moins de 2 caractères, cacher les résultats
            if (searchTerm.length < 2) {
                searchResults.classList.add('hidden');
                searchContent.innerHTML = '';
                return;
            }
            
            // Afficher le loader
            searchResults.classList.remove('hidden');
            searchLoader.classList.remove('hidden');
            searchContent.innerHTML = '';
            noResults.classList.add('hidden');
            
            // Attendre 500ms avant de faire la recherche (debounce)
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('search') }}?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchLoader.classList.add('hidden');
                        
                        const totalResults = data.movies.length + data.series.length;
                        
                        if (totalResults === 0) {
                            noResults.classList.remove('hidden');
                            return;
                        }
                        
                        let html = '';
                        
                        // Afficher les films
                        if (data.movies.length > 0) {
                            html += '<div class="p-4">';
                            html += '<h3 class="text-halloween-orange font-bold text-lg mb-3"><i class="fas fa-film mr-2"></i>Films</h3>';
                            html += '<div class="space-y-2">';
                            data.movies.forEach(movie => {
                                html += `
                                    <a href="/movie/${movie.id}" class="flex items-center p-3 hover:bg-bg-tertiary rounded-lg transition-colors duration-300 group">
                                        <img src="${movie.poster_url}" alt="${movie.title}" class="w-16 h-24 object-cover rounded-lg mr-4">
                                        <div class="flex-1">
                                            <h4 class="text-text-primary font-semibold group-hover:text-halloween-orange transition-colors">${movie.title}</h4>
                                            <div class="flex items-center space-x-3 mt-1">
                                                ${movie.rating ? `
                                                    <div class="flex items-center text-sm">
                                                        <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                        <span class="text-text-secondary">${movie.rating}/10</span>
                                                    </div>
                                                ` : ''}
                                                ${movie.release_year ? `<span class="text-text-secondary text-sm">${movie.release_year}</span>` : ''}
                                            </div>
                                            ${movie.has_video ? '<span class="inline-block mt-1 px-2 py-1 bg-halloween-orange/20 text-halloween-orange text-xs rounded-full">Disponible</span>' : ''}
                                        </div>
                                        <i class="fas fa-chevron-right text-text-secondary group-hover:text-halloween-orange transition-colors"></i>
                                    </a>
                                `;
                            });
                            html += '</div></div>';
                        }
                        
                        // Afficher les séries
                        if (data.series.length > 0) {
                            html += '<div class="p-4 border-t border-halloween-orange/20">';
                            html += '<h3 class="text-halloween-purple font-bold text-lg mb-3"><i class="fas fa-tv mr-2"></i>Séries</h3>';
                            html += '<div class="space-y-2">';
                            data.series.forEach(serie => {
                                html += `
                                    <a href="/series/${serie.id}" class="flex items-center p-3 hover:bg-bg-tertiary rounded-lg transition-colors duration-300 group">
                                        <img src="${serie.poster_url}" alt="${serie.title}" class="w-16 h-24 object-cover rounded-lg mr-4">
                                        <div class="flex-1">
                                            <h4 class="text-text-primary font-semibold group-hover:text-halloween-purple transition-colors">${serie.title}</h4>
                                            <div class="flex items-center space-x-3 mt-1">
                                                ${serie.rating ? `
                                                    <div class="flex items-center text-sm">
                                                        <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                                        <span class="text-text-secondary">${serie.rating}/10</span>
                                                    </div>
                                                ` : ''}
                                                ${serie.release_year ? `<span class="text-text-secondary text-sm">${serie.release_year}</span>` : ''}
                                            </div>
                                            ${serie.number_of_seasons ? `<span class="inline-block mt-1 px-2 py-1 bg-halloween-purple/20 text-halloween-purple text-xs rounded-full">${serie.number_of_seasons} saison(s)</span>` : ''}
                                        </div>
                                        <i class="fas fa-chevron-right text-text-secondary group-hover:text-halloween-purple transition-colors"></i>
                                    </a>
                                `;
                            });
                            html += '</div></div>';
                        }
                        
                        searchContent.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Erreur de recherche:', error);
                        searchLoader.classList.add('hidden');
                        searchContent.innerHTML = '<div class="p-8 text-center text-halloween-red"><i class="fas fa-exclamation-triangle mr-2"></i>Erreur lors de la recherche</div>';
                    });
            }, 500);
        });
        
        // Fonction pour ajouter/retirer de la watchlist
        function toggleWatchlist(buttonElement) {
            const isInWatchlist = buttonElement.dataset.inWatchlist === 'true';
            const type = buttonElement.dataset.type;
            const id = buttonElement.dataset.id;
            
            // Trouver tous les boutons pour le même contenu (à cause des clones de Swiper)
            const allButtons = document.querySelectorAll(`[data-type="${type}"][data-id="${id}"]`);
            
            // Désactiver tous les boutons pendant la requête
            allButtons.forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.6';
            });
            
            const url = isInWatchlist ? '/watchlist/remove' : '/watchlist/add';
            const method = 'POST';
            
            const payload = {
                type: type,
                id: id
            };
            
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour TOUS les boutons (y compris les clones)
                    allButtons.forEach(btn => {
                        btn.dataset.inWatchlist = data.in_watchlist ? 'true' : 'false';
                        
                        // Mettre à jour l'icône
                        const icon = btn.querySelector('i');
                        if (icon) {
                            icon.className = `fas fa-${data.in_watchlist ? 'check' : 'plus'} mr-2`;
                        }
                        
                        // Mettre à jour le texte
                        const textDesktop = btn.querySelector('.hidden.md\\:inline');
                        if (textDesktop) {
                            textDesktop.textContent = data.in_watchlist ? 'Dans ma liste' : 'Ma liste';
                        }
                        
                        // Animation de succès
                        btn.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            btn.style.transform = '';
                        }, 200);
                    });
                    
                    // Afficher notification toast (une seule fois)
                    if (data.in_watchlist) {
                        showToast('success', 'Ajouté à Ma Liste', data.message || 'Le contenu a été ajouté à votre liste');
                    } else {
                        showToast('info', 'Retiré de Ma Liste', data.message || 'Le contenu a été retiré de votre liste');
                    }
                } else {
                    showToast('error', 'Erreur', data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('error', 'Erreur de connexion', 'Impossible de communiquer avec le serveur');
            })
            .finally(() => {
                // Réactiver tous les boutons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                });
            });
        }
    </script>
</body>
</html>
