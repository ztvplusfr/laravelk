<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Séries - ZTVPlus</title>
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
        
        .series-card {
            transition: all 0.3s ease;
        }
        
        .series-card:hover {
            transform: translateY(-4px);
        }
        
        .series-poster-wrapper {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            aspect-ratio: 2/3;
            background: #1a1a1a;
        }
        
        .series-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .series-card:hover .series-poster {
            transform: scale(1.05);
        }
        
        .series-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .series-card:hover .series-overlay {
            opacity: 1;
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
                    <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-all duration-300">
                        <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-10 md:h-12 w-auto">
                    </a>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden md:flex items-center space-x-4 md:space-x-6">
                        <a href="{{ route('home') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300 font-semibold">
                            Accueil
                        </a>
                        <a href="{{ route('movies') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300 font-semibold">
                            Films
                        </a>
                        <a href="{{ route('series') }}" class="text-halloween-orange font-bold transition-colors duration-300">
                            Séries
                        </a>
                    </div>
                </div>
                
                <!-- Actions à droite -->
                <div class="flex items-center space-x-4 md:space-x-4">
                    <!-- Bouton Recherche -->
                    <button id="searchToggle" class="text-text-primary hover:text-halloween-orange transition-colors duration-300" title="Rechercher">
                        <i class="fas fa-search text-lg md:text-xl"></i>
                    </button>
                    
                    <!-- Bouton Ma Liste -->
                    <a href="{{ route('watchlist') }}" class="text-text-primary hover:text-halloween-purple transition-colors duration-300" title="Ma Liste">
                        <i class="fas fa-bookmark text-lg md:text-xl"></i>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
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
    <main class="pt-24 md:pt-28 pb-24 px-4 md:px-6">
        <div class="container mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-5xl font-bold text-halloween-purple mb-4">
                    <i class="fas fa-tv mr-3"></i>
                    Séries
                </h1>
                <p class="text-text-secondary">{{ $series->total() }} série(s) disponible(s)</p>
            </div>

            <!-- Filters -->
            <div class="bg-bg-secondary border-2 border-halloween-purple/30 rounded-2xl p-4 md:p-6 mb-8">
                <form method="GET" action="{{ route('series') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-text-secondary text-sm mb-2">Rechercher</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Titre de la série..."
                            class="w-full bg-bg-tertiary text-text-primary px-4 py-2 rounded-lg border border-halloween-purple/30 focus:border-halloween-purple focus:outline-none"
                        >
                    </div>

                    <!-- Genre Filter -->
                    <div>
                        <label class="block text-text-secondary text-sm mb-2">Genre</label>
                        <select name="genre" class="w-full bg-bg-tertiary text-text-primary px-4 py-2 rounded-lg border border-halloween-purple/30 focus:border-halloween-purple focus:outline-none">
                            <option value="">Tous les genres</option>
                            @foreach($allGenres as $genre)
                                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Filter -->
                    <div>
                        <label class="block text-text-secondary text-sm mb-2">Année</label>
                        <select name="year" class="w-full bg-bg-tertiary text-text-primary px-4 py-2 rounded-lg border border-halloween-purple/30 focus:border-halloween-purple focus:outline-none">
                            <option value="">Toutes les années</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-text-secondary text-sm mb-2">Trier par</label>
                        <select name="sort" class="w-full bg-bg-tertiary text-text-primary px-4 py-2 rounded-lg border border-halloween-purple/30 focus:border-halloween-purple focus:outline-none">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Mieux notées</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Titre (A-Z)</option>
                            <option value="year" {{ request('sort') == 'year' ? 'selected' : '' }}>Année</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="md:col-span-4 flex gap-2">
                        <button type="submit" class="bg-halloween-purple text-text-primary px-6 py-2 rounded-lg font-semibold hover:bg-halloween-purple-light transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('series') }}" class="bg-bg-tertiary text-text-primary px-6 py-2 rounded-lg font-semibold hover:bg-halloween-purple/20 transition-colors border border-halloween-purple/30">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Series Grid -->
            @if($series->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 mb-8">
                    @foreach($series as $serie)
                        <div class="series-card group">
                            <a href="{{ route('series.show', $serie->id) }}">
                                <!-- Poster -->
                                <div class="series-poster-wrapper">
                                    <img src="{{ $serie->poster_url }}" alt="{{ $serie->title }}" class="series-poster">
                                    
                                    <!-- Overlay avec bouton play au centre -->
                                    <div class="series-overlay">
                                        <div class="w-14 h-14 bg-halloween-purple/90 rounded-full flex items-center justify-center">
                                            <i class="fas fa-tv text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Infos sous le poster -->
                                <div class="mt-3">
                                    <h3 class="text-text-primary font-bold text-sm md:text-base mb-1 line-clamp-2 group-hover:text-halloween-purple transition-colors text-left">
                                        {{ $serie->title }}
                                    </h3>
                                    
                                    <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                                        @if($serie->rating)
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-halloween-yellow mr-1"></i>
                                            <span>{{ $serie->rating }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($serie->first_air_date)
                                        <span>{{ $serie->first_air_date->format('Y') }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($serie->number_of_seasons)
                                    <span class="inline-block px-2 py-1 bg-halloween-purple/20 text-halloween-purple text-xs rounded-full">
                                        {{ $serie->number_of_seasons }} saison{{ $serie->number_of_seasons > 1 ? 's' : '' }}
                                    </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($series->hasPages())
                    <div class="flex justify-center mt-8">
                        <div class="flex items-center space-x-2">
                            @if ($series->onFirstPage())
                                <span class="px-4 py-2 bg-bg-tertiary text-text-secondary rounded-lg cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $series->appends(request()->except('page'))->previousPageUrl() }}" class="px-4 py-2 bg-halloween-purple text-text-primary rounded-lg hover:bg-halloween-purple-light transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            <span class="px-4 py-2 bg-bg-secondary text-text-primary rounded-lg border border-halloween-purple/30">
                                Page {{ $series->currentPage() }} / {{ $series->lastPage() }}
                            </span>

                            @if ($series->hasMorePages())
                                <a href="{{ $series->appends(request()->except('page'))->nextPageUrl() }}" class="px-4 py-2 bg-halloween-purple text-text-primary rounded-lg hover:bg-halloween-purple-light transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-4 py-2 bg-bg-tertiary text-text-secondary rounded-lg cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <i class="fas fa-tv text-6xl text-halloween-purple/30 mb-6"></i>
                    <h2 class="text-2xl font-bold text-text-primary mb-4">Aucune série trouvée</h2>
                    <p class="text-text-secondary mb-8">Essayez de modifier vos filtres</p>
                    <a href="{{ route('series') }}" class="inline-flex items-center bg-halloween-purple text-text-primary px-6 py-3 rounded-full font-bold hover:bg-halloween-purple-light transition-colors">
                        <i class="fas fa-redo mr-2"></i>
                        Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Bottom Navigation -->
    @include('components.bottom-nav', ['user' => $user])

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
    </script>
</body>
</html>

