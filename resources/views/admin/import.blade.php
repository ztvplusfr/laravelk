@extends('admin.layout')

@section('title', 'Importer depuis TMDB')

@section('content')
<div class="container mx-auto px-6 max-w-6xl">
    <!-- Hero Section -->
    <section class="relative py-12 text-center overflow-hidden mb-12">
        <div class="absolute inset-0 bg-gradient-radial from-halloween-orange/5 via-transparent to-transparent"></div>
        <div class="absolute top-10 left-10 w-20 h-20 bg-halloween-orange/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-halloween-orange/10 rounded-full blur-xl animate-pulse delay-1000"></div>
        
        <div class="relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-halloween-orange drop-shadow-2xl">
                <i class="fas fa-download mr-4"></i>
                Importer depuis TMDB
            </h1>
            <p class="text-xl text-text-secondary">Recherchez et importez des films ou séries depuis The Movie Database</p>
        </div>
    </section>

    <!-- Recherche -->
    <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl mb-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-halloween-orange mb-4">
                <i class="fas fa-search mr-2"></i>
                Rechercher du contenu
            </h2>
            
            <!-- Type Selection -->
            <div class="mb-6">
                <label class="text-text-primary font-semibold mb-3 block">
                    <i class="fas fa-layer-group mr-2 text-halloween-orange"></i>
                    Type de contenu
                </label>
                <div class="flex p-1 bg-transparent border-2 border-halloween-orange/30 rounded-lg">
                    <button onclick="setImportType('movie')" id="btnMovieType" class="flex-1 px-8 py-3 bg-halloween-purple border-2 border-halloween-purple text-text-primary rounded-md font-semibold transition-all duration-300">
                        <i class="fas fa-film mr-2"></i>
                        Films
                    </button>
                    <button onclick="setImportType('tv')" id="btnTvType" class="flex-1 px-8 py-3 bg-transparent border-2 border-transparent text-text-secondary rounded-md font-semibold transition-all duration-300">
                        <i class="fas fa-tv mr-2"></i>
                        Séries TV
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-4">
                <label class="text-text-primary font-semibold mb-3 block">
                    <i class="fas fa-search mr-2 text-halloween-orange"></i>
                    Rechercher <span id="searchTypeLabel" class="text-halloween-purple">des films</span>
                </label>
                <div class="relative">
                    <input type="text" id="tmdbSearch" placeholder="Ex: Avengers, Spider-Man, Iron Man..." class="w-full px-4 py-4 pr-48 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors text-lg" onkeypress="if(event.key==='Enter') searchTMDB()">
                    <button onclick="searchTMDB()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-halloween-orange/50 transition-all duration-300 font-semibold">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                </div>
            </div>

            <!-- Suggestions -->
            <div id="suggestionsContainer" class="p-5 bg-bg-primary rounded-xl border border-halloween-purple/30">
                <div class="flex items-center mb-3">
                    <i class="fas fa-lightbulb text-halloween-yellow text-xl mr-2"></i>
                    <span class="text-text-primary font-semibold">Suggestions populaires :</span>
                </div>
                <div id="movieSuggestions" class="flex flex-wrap gap-2">
                    <button onclick="quickSearch('Avengers')" class="px-4 py-2 bg-halloween-purple/20 text-halloween-purple rounded-full hover:bg-halloween-purple hover:text-text-primary transition-all duration-300 border border-halloween-purple/50 hover:shadow-lg hover:shadow-halloween-purple/50 hover:-translate-y-1">
                        <i class="fas fa-film mr-1"></i>
                        Avengers
                    </button>
                    <button onclick="quickSearch('Spider-Man')" class="px-4 py-2 bg-halloween-purple/20 text-halloween-purple rounded-full hover:bg-halloween-purple hover:text-text-primary transition-all duration-300 border border-halloween-purple/50 hover:shadow-lg hover:shadow-halloween-purple/50 hover:-translate-y-1">
                        <i class="fas fa-film mr-1"></i>
                        Spider-Man
                    </button>
                    <button onclick="quickSearch('Iron Man')" class="px-4 py-2 bg-halloween-purple/20 text-halloween-purple rounded-full hover:bg-halloween-purple hover:text-text-primary transition-all duration-300 border border-halloween-purple/50 hover:shadow-lg hover:shadow-halloween-purple/50 hover:-translate-y-1">
                        <i class="fas fa-film mr-1"></i>
                        Iron Man
                    </button>
                    <button onclick="quickSearch('Inception')" class="px-4 py-2 bg-halloween-purple/20 text-halloween-purple rounded-full hover:bg-halloween-purple hover:text-text-primary transition-all duration-300 border border-halloween-purple/50 hover:shadow-lg hover:shadow-halloween-purple/50 hover:-translate-y-1">
                        <i class="fas fa-film mr-1"></i>
                        Inception
                    </button>
                </div>
                <div id="tvSuggestions" class="hidden flex-wrap gap-2">
                    <button onclick="quickSearch('Breaking Bad')" class="px-4 py-2 bg-halloween-yellow/20 text-halloween-yellow rounded-full hover:bg-halloween-yellow hover:text-text-primary transition-all duration-300 border border-halloween-yellow/50 hover:shadow-lg hover:shadow-halloween-yellow/50 hover:-translate-y-1">
                        <i class="fas fa-tv mr-1"></i>
                        Breaking Bad
                    </button>
                    <button onclick="quickSearch('Game of Thrones')" class="px-4 py-2 bg-halloween-yellow/20 text-halloween-yellow rounded-full hover:bg-halloween-yellow hover:text-text-primary transition-all duration-300 border border-halloween-yellow/50 hover:shadow-lg hover:shadow-halloween-yellow/50 hover:-translate-y-1">
                        <i class="fas fa-tv mr-1"></i>
                        Game of Thrones
                    </button>
                    <button onclick="quickSearch('The Walking Dead')" class="px-4 py-2 bg-halloween-yellow/20 text-halloween-yellow rounded-full hover:bg-halloween-yellow hover:text-text-primary transition-all duration-300 border border-halloween-yellow/50 hover:shadow-lg hover:shadow-halloween-yellow/50 hover:-translate-y-1">
                        <i class="fas fa-tv mr-1"></i>
                        The Walking Dead
                    </button>
                    <button onclick="quickSearch('Stranger Things')" class="px-4 py-2 bg-halloween-yellow/20 text-halloween-yellow rounded-full hover:bg-halloween-yellow hover:text-text-primary transition-all duration-300 border border-halloween-yellow/50 hover:shadow-lg hover:shadow-halloween-yellow/50 hover:-translate-y-1">
                        <i class="fas fa-tv mr-1"></i>
                        Stranger Things
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <div id="loadingResults" class="hidden text-center py-16 bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl mb-8">
        <div class="inline-block animate-spin rounded-full h-16 w-16 border-4 border-halloween-orange border-t-transparent mb-4"></div>
        <p class="text-text-secondary text-lg">Recherche en cours...</p>
    </div>

    <!-- Results -->
    <div id="searchResults" class="space-y-4">
        <div class="text-center py-16 bg-bg-secondary p-8 rounded-2xl border border-halloween-orange/30 shadow-xl">
            <i class="fas fa-search text-6xl text-text-secondary opacity-30 mb-4"></i>
            <p class="text-text-secondary text-lg">Effectuez une recherche pour voir les résultats</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentImportType = 'movie';

    function setImportType(type) {
        currentImportType = type;
        
        const movieBtn = document.getElementById('btnMovieType');
        const tvBtn = document.getElementById('btnTvType');
        const searchTypeLabel = document.getElementById('searchTypeLabel');
        const searchInput = document.getElementById('tmdbSearch');
        const movieSuggestions = document.getElementById('movieSuggestions');
        const tvSuggestions = document.getElementById('tvSuggestions');
        const suggestionsContainer = document.getElementById('suggestionsContainer');
        
        if (type === 'movie') {
            movieBtn.className = 'flex-1 px-8 py-3 bg-halloween-purple border-2 border-halloween-purple text-text-primary rounded-md font-semibold transition-all duration-300';
            tvBtn.className = 'flex-1 px-8 py-3 bg-transparent border-2 border-transparent text-text-secondary rounded-md font-semibold transition-all duration-300';
            searchTypeLabel.textContent = 'des films';
            searchTypeLabel.className = 'text-halloween-purple';
            searchInput.placeholder = 'Ex: Avengers, Spider-Man, Iron Man...';
            movieSuggestions.classList.remove('hidden');
            movieSuggestions.classList.add('flex');
            tvSuggestions.classList.remove('flex');
            tvSuggestions.classList.add('hidden');
            suggestionsContainer.classList.remove('border-halloween-yellow/30');
            suggestionsContainer.classList.add('border-halloween-purple/30');
        } else {
            tvBtn.className = 'flex-1 px-8 py-3 bg-halloween-yellow border-2 border-halloween-yellow text-text-primary rounded-md font-semibold transition-all duration-300';
            movieBtn.className = 'flex-1 px-8 py-3 bg-transparent border-2 border-transparent text-text-secondary rounded-md font-semibold transition-all duration-300';
            searchTypeLabel.textContent = 'des séries TV';
            searchTypeLabel.className = 'text-halloween-yellow';
            searchInput.placeholder = 'Ex: Breaking Bad, Game of Thrones, Stranger Things...';
            tvSuggestions.classList.remove('hidden');
            tvSuggestions.classList.add('flex');
            movieSuggestions.classList.remove('flex');
            movieSuggestions.classList.add('hidden');
            suggestionsContainer.classList.remove('border-halloween-purple/30');
            suggestionsContainer.classList.add('border-halloween-yellow/30');
        }
        
        document.getElementById('searchResults').innerHTML = `
            <div class="text-center py-16 bg-bg-secondary p-8 rounded-2xl border border-halloween-orange/30 shadow-xl">
                <i class="fas fa-search text-6xl text-text-secondary opacity-30 mb-4"></i>
                <p class="text-text-secondary text-lg">Effectuez une recherche pour voir les résultats</p>
            </div>
        `;
    }

    async function searchTMDB() {
        const query = document.getElementById('tmdbSearch').value.trim();
        if (!query) {
            alert('Veuillez entrer un terme de recherche');
            return;
        }

        const resultsDiv = document.getElementById('searchResults');
        const loadingDiv = document.getElementById('loadingResults');
        
        resultsDiv.classList.add('hidden');
        loadingDiv.classList.remove('hidden');

        try {
            const response = await fetch(`{{ route('admin.search-tmdb') }}?q=${encodeURIComponent(query)}&type=${currentImportType}`);
            const data = await response.json();

            loadingDiv.classList.add('hidden');
            resultsDiv.classList.remove('hidden');

            if (data.results && data.results.length > 0) {
                displayResults(data.results);
            } else {
                resultsDiv.innerHTML = `
                    <div class="text-center py-16 bg-bg-secondary p-8 rounded-2xl border border-halloween-orange/30 shadow-xl">
                        <i class="fas fa-search text-6xl text-text-secondary opacity-30 mb-4"></i>
                        <p class="text-text-secondary text-lg">Aucun résultat trouvé pour "${query}"</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Erreur:', error);
            loadingDiv.classList.add('hidden');
            resultsDiv.classList.remove('hidden');
            resultsDiv.innerHTML = `
                <div class="text-center py-16 bg-bg-secondary p-8 rounded-2xl border border-halloween-red shadow-2xl">
                    <i class="fas fa-exclamation-triangle text-6xl text-halloween-red mb-4"></i>
                    <p class="text-halloween-red text-lg font-semibold">Erreur lors de la recherche</p>
                    <p class="text-text-secondary mt-2">Vérifiez votre clé API TMDB dans le fichier .env</p>
                </div>
            `;
        }
    }

    function displayResults(results) {
        const resultsDiv = document.getElementById('searchResults');
        const html = results.map(item => {
            const title = item.title || item.name;
            const date = item.release_date || item.first_air_date || 'N/A';
            const year = date !== 'N/A' ? new Date(date).getFullYear() : 'N/A';
            const posterPath = item.poster_path ? `https://image.tmdb.org/t/p/w200${item.poster_path}` : '/images/no-poster.jpg';
            const rating = item.vote_average ? item.vote_average.toFixed(1) : 'N/A';
            const color = currentImportType === 'movie' ? 'purple' : 'yellow';

            return `
                <div class="flex items-start space-x-6 p-6 bg-bg-secondary rounded-2xl border border-halloween-${color}/30 hover:border-halloween-${color} hover:shadow-2xl hover:shadow-halloween-${color}/20 transition-all duration-300 hover:-translate-y-1">
                    <img src="${posterPath}" alt="${title}" class="w-24 h-36 object-cover rounded-xl border-2 border-halloween-${color} flex-shrink-0 shadow-lg">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-text-primary font-bold text-2xl mb-2">${title}</h3>
                        <p class="text-text-secondary text-sm mb-4 line-clamp-3">${item.overview || 'Aucune description disponible'}</p>
                        <div class="flex items-center space-x-6 text-sm">
                            <span class="text-halloween-orange flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                ${year}
                            </span>
                            <span class="text-halloween-yellow flex items-center">
                                <i class="fas fa-star mr-2"></i>
                                ${rating}/10
                            </span>
                            <span class="text-text-secondary flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                ${item.vote_count || 0} votes
                            </span>
                        </div>
                    </div>
                    <button onclick="importContent(${item.id})" class="group relative overflow-hidden bg-gradient-to-r from-halloween-green to-halloween-green-dark text-text-primary px-8 py-4 rounded-xl font-bold text-lg flex-shrink-0 border-2 border-halloween-green transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-halloween-green/70 hover:border-halloween-green-light hover:-translate-y-1 active:scale-95 cursor-pointer">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-download mr-2 group-hover:animate-bounce"></i>
                            Importer
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-halloween-green-light to-halloween-green opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            `;
        }).join('');

        resultsDiv.innerHTML = html;
    }

    function quickSearch(query) {
        document.getElementById('tmdbSearch').value = query;
        searchTMDB();
    }

    async function importContent(tmdbId) {
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        
        // Désactiver le bouton et afficher un loader
        button.disabled = true;
        button.innerHTML = `
            <span class="relative z-10 flex items-center">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Import en cours...
            </span>
        `;
        
        try {
            const url = currentImportType === 'movie' 
                ? '{{ route("admin.import-movie") }}' 
                : '{{ route("admin.import-series") }}';
                
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tmdb_id: tmdbId
                })
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Succès
                button.innerHTML = `
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Importé !
                    </span>
                `;
                button.classList.remove('from-halloween-green', 'to-halloween-green-dark', 'border-halloween-green');
                button.classList.add('from-halloween-green', 'to-halloween-green', 'border-halloween-green-light', 'opacity-70');
                
                // Afficher un message de succès
                showNotification('success', data.message || 'Import réussi !');
                
                // Rediriger vers la page de gestion après 2 secondes
                setTimeout(() => {
                    window.location.href = currentImportType === 'movie' 
                        ? '{{ route("admin.movies") }}' 
                        : '{{ route("admin.series") }}';
                }, 2000);
            } else {
                // Erreur
                throw new Error(data.error || 'Erreur lors de l\'import');
            }
            
        } catch (error) {
            console.error('Erreur:', error);
            
            // Restaurer le bouton
            button.disabled = false;
            button.innerHTML = originalContent;
            
            // Afficher le message d'erreur
            showNotification('error', error.message || 'Erreur lors de l\'import');
        }
    }
    
    function showNotification(type, message) {
        const colors = {
            success: 'halloween-green',
            error: 'halloween-red',
            info: 'halloween-orange'
        };
        
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            info: 'info-circle'
        };
        
        const color = colors[type] || colors.info;
        const icon = icons[type] || icons.info;
        
        const notification = document.createElement('div');
        notification.className = `fixed top-24 right-6 z-[100] bg-bg-secondary border-2 border-${color} rounded-xl shadow-2xl shadow-${color}/50 p-6 max-w-md animate-slide-in-right`;
        notification.innerHTML = `
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-${color}/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-${icon} text-${color} text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-text-primary font-bold mb-1">${type === 'success' ? 'Succès' : 'Erreur'}</h4>
                    <p class="text-text-secondary text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-text-secondary hover:text-text-primary transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove après 5 secondes
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
</script>
@endsection
