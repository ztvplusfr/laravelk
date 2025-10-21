@extends('admin.layout')

@section('title', 'Modifier la Saison')

@section('content')
<!-- Hero Section -->
<section class="relative py-12 overflow-hidden mb-8">
    <div class="absolute inset-0 bg-gradient-to-br from-halloween-purple/20 to-halloween-yellow/20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.edit-series', $season->series_id) }}" class="text-halloween-purple hover:text-halloween-purple-light transition-colors hover:scale-110 transform duration-300">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <h1 class="text-5xl md:text-6xl font-bold text-halloween-purple drop-shadow-2xl">
                <i class="fas fa-layer-group mr-3"></i>
                Modifier la Saison
            </h1>
        </div>
        <p class="text-xl text-text-primary font-semibold ml-16 drop-shadow-lg">{{ $season->series->title }} - {{ $season->name }}</p>
        
        <!-- Info rapide -->
        <div class="flex flex-wrap gap-4 mt-6 ml-16">
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-purple/30">
                <i class="fas fa-hashtag text-halloween-purple"></i>
                <span class="text-text-primary font-semibold">Saison {{ $season->season_number }}</span>
            </div>
            
            @if($season->episodes->count() > 0)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-yellow/30">
                <i class="fas fa-video text-halloween-yellow"></i>
                <span class="text-text-primary font-semibold">{{ $season->episodes->count() }} épisode(s)</span>
            </div>
            @endif
            
            @if($season->air_date)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-orange/30">
                <i class="fas fa-calendar text-halloween-orange"></i>
                <span class="text-text-primary font-semibold">{{ $season->air_date->format('Y') }}</span>
            </div>
            @endif
            
            @if($season->is_active)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-green/30">
                <i class="fas fa-check-circle text-halloween-green"></i>
                <span class="text-text-primary font-semibold">Active</span>
            </div>
            @else
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-red/30">
                <i class="fas fa-times-circle text-halloween-red"></i>
                <span class="text-text-primary font-semibold">Inactive</span>
            </div>
            @endif
        </div>
    </div>
</section>

<div class="container mx-auto px-6 pb-12">
    <!-- Messages -->
    @if(session('success'))
    <div id="successMessage" class="mb-6 bg-halloween-green/20 border-2 border-halloween-green text-halloween-green px-6 py-4 rounded-xl flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-2xl mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-halloween-green hover:text-halloween-green-light">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="errorMessage" class="mb-6 bg-halloween-red/20 border-2 border-halloween-red text-halloween-red px-6 py-4 rounded-xl flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-halloween-red hover:text-halloween-red-light">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-halloween-red/20 border-2 border-halloween-red text-halloween-red px-6 py-4 rounded-xl">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-2xl mr-3 mt-1"></i>
            <div>
                <h3 class="font-bold mb-2">Erreurs de validation :</h3>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.update-season', $season->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne de gauche - Aperçu -->
            <div class="lg:col-span-1">
                <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-purple shadow-2xl sticky top-6">
                    <h2 class="text-2xl font-bold text-halloween-purple mb-4">
                        <i class="fas fa-image mr-2"></i>
                        Aperçu
                    </h2>
                    
                    <!-- Poster -->
                    @if($season->poster_path)
                    <div class="mb-6">
                        <label class="text-text-secondary text-sm mb-2 block">Poster</label>
                        <div class="relative group">
                            <img id="posterPreview" src="{{ $season->poster_path }}" alt="{{ $season->name }}" class="w-full rounded-xl border-2 border-halloween-purple shadow-lg">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-3xl"></i>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mb-6">
                        <div class="w-full h-64 bg-bg-tertiary rounded-xl border-2 border-halloween-purple/30 flex items-center justify-center">
                            <div class="text-center text-text-secondary">
                                <i class="fas fa-image text-5xl mb-2 opacity-30"></i>
                                <p class="text-sm">Aucun poster</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Informations -->
                    <h3 class="text-lg font-bold text-halloween-purple mb-3 mt-6">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">Série:</span>
                            <a href="{{ route('admin.edit-series', $season->series_id) }}" class="text-halloween-purple hover:text-halloween-purple-light font-semibold">{{ $season->series->title }}</a>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">Numéro:</span>
                            <span class="text-text-primary font-semibold">Saison {{ $season->season_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">TMDB ID:</span>
                            <span class="text-text-primary font-semibold">{{ $season->tmdb_id ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">Date d'ajout:</span>
                            <span class="text-text-primary">{{ $season->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-text-secondary">Dernière MàJ:</span>
                            <span class="text-text-primary">{{ $season->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Formulaire -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-purple shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-purple mb-6">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier la saison
                    </h2>

                    <div class="space-y-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="text-text-primary font-semibold mb-2 block">
                                Nom <span class="text-halloween-red">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $season->name) }}" required class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="text-text-primary font-semibold mb-2 block">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors resize-none">{{ old('description', $season->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date de diffusion -->
                            <div>
                                <label for="air_date" class="text-text-primary font-semibold mb-2 block">
                                    Date de diffusion
                                </label>
                                <input type="date" id="air_date" name="air_date" value="{{ old('air_date', $season->air_date ? $season->air_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            </div>

                            <!-- Nombre d'épisodes -->
                            <div>
                                <label for="episode_count" class="text-text-primary font-semibold mb-2 block">
                                    Nombre d'épisodes
                                </label>
                                <input type="number" id="episode_count" name="episode_count" value="{{ old('episode_count', $season->episode_count) }}" min="0" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            </div>
                        </div>

                        <!-- Poster URL -->
                        <div>
                            <label for="poster_path" class="text-text-primary font-semibold mb-2 block">
                                URL du Poster
                            </label>
                            <input type="url" id="poster_path" name="poster_path" value="{{ old('poster_path', $season->poster_path) }}" onchange="updatePosterPreview(this.value)" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            <p class="text-text-secondary text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                URL complète de l'image (ex: https://image.tmdb.org/t/p/original/...)
                            </p>
                        </div>

                        <!-- Saison active -->
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $season->is_active) ? 'checked' : '' }} class="w-6 h-6 text-halloween-green bg-bg-tertiary border-2 border-halloween-green/30 rounded focus:ring-2 focus:ring-halloween-green cursor-pointer">
                            <div>
                                <span class="text-text-primary font-semibold group-hover:text-halloween-green transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Saison active
                                </span>
                                <p class="text-text-secondary text-sm">La saison est visible pour les utilisateurs</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.edit-series', $season->series_id) }}" class="px-6 py-3 bg-bg-tertiary text-text-secondary rounded-xl hover:bg-bg-secondary border-2 border-transparent hover:border-halloween-purple/30 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    
                    <button type="submit" class="bg-gradient-to-r from-halloween-green to-halloween-green-dark text-text-primary px-8 py-3 rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl hover:shadow-halloween-green/50 transition-all duration-300 hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Auto-hide success/error messages
    setTimeout(() => {
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');
        if (successMsg) successMsg.remove();
        if (errorMsg) errorMsg.remove();
    }, 5000);

    // Update poster preview
    function updatePosterPreview(url) {
        const preview = document.getElementById('posterPreview');
        if (preview && url && (url.startsWith('http://') || url.startsWith('https://'))) {
            preview.src = url;
        }
    }
</script>
@endsection

