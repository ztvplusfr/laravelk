@extends('admin.layout')

@section('title', 'Modifier le Film')

@section('content')
<!-- Hero Section avec Backdrop -->
<section class="relative py-20 overflow-hidden mb-8">
    <!-- Backdrop en pleine largeur -->
    <div class="absolute inset-0">
        @if($movie->backdrop_url)
        <img src="{{ $movie->backdrop_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-bg-primary/90 via-transparent to-bg-primary/90"></div>
        @else
        <div class="absolute inset-0 bg-gradient-to-br from-halloween-purple/20 to-halloween-orange/20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>
        @endif
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.movies') }}" class="text-halloween-orange hover:text-halloween-orange-light transition-colors hover:scale-110 transform duration-300">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <h1 class="text-5xl md:text-6xl font-bold text-halloween-orange drop-shadow-2xl">
                <i class="fas fa-edit mr-3"></i>
                Modifier le Film
            </h1>
        </div>
        <p class="text-2xl text-text-primary font-semibold ml-16 drop-shadow-lg">{{ $movie->title }}</p>
        
        <!-- Info rapide -->
        <div class="flex flex-wrap gap-4 mt-6 ml-16">
            @if($movie->release_date)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-orange/30">
                <i class="fas fa-calendar text-halloween-orange"></i>
                <span class="text-text-primary font-semibold">{{ $movie->release_date->format('Y') }}</span>
            </div>
            @endif
            
            @if($movie->runtime)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-purple/30">
                <i class="fas fa-clock text-halloween-purple"></i>
                <span class="text-text-primary font-semibold">
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
            </div>
            @endif
            
            @if($movie->rating)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-yellow/30">
                <i class="fas fa-star text-halloween-yellow"></i>
                <span class="text-text-primary font-semibold">{{ $movie->rating }}/10</span>
            </div>
            @endif
            
            @if($movie->is_active)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-green/30">
                <i class="fas fa-check-circle text-halloween-green"></i>
                <span class="text-text-primary font-semibold">Actif</span>
            </div>
            @else
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-red/30">
                <i class="fas fa-times-circle text-halloween-red"></i>
                <span class="text-text-primary font-semibold">Inactif</span>
            </div>
            @endif
        </div>
    </div>
</section>

<div class="container mx-auto px-6 pb-12">
    <!-- Messages de succès/erreur -->
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

    <form action="{{ route('admin.update-movie', $movie->id) }}" method="POST" class="space-y-6">
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
                    <div class="mb-6">
                        <label class="text-text-secondary text-sm mb-2 block">Poster</label>
                        <div class="relative group">
                            <img id="posterPreview" src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full rounded-xl border-2 border-halloween-purple shadow-lg">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-3xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Informations rapides -->
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">TMDB ID:</span>
                            <span class="text-text-primary font-semibold">{{ $movie->tmdb_id }}</span>
                        </div>
                        @if($movie->imdb_id)
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">IMDB ID:</span>
                            <span class="text-text-primary font-semibold">{{ $movie->imdb_id }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-halloween-purple/30">
                            <span class="text-text-secondary">Date d'ajout:</span>
                            <span class="text-text-primary">{{ $movie->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-text-secondary">Dernière MàJ:</span>
                            <span class="text-text-primary">{{ $movie->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Formulaire -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-orange mb-6">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations générales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Titre -->
                        <div class="md:col-span-2">
                            <label for="title" class="text-text-primary font-semibold mb-2 block">
                                Titre <span class="text-halloween-red">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $movie->title) }}" required class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Titre original -->
                        <div>
                            <label for="original_title" class="text-text-primary font-semibold mb-2 block">
                                Titre original
                            </label>
                            <input type="text" id="original_title" name="original_title" value="{{ old('original_title', $movie->original_title) }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Langue originale -->
                        <div>
                            <label for="original_language" class="text-text-primary font-semibold mb-2 block">
                                Langue
                            </label>
                            <input type="text" id="original_language" name="original_language" value="{{ old('original_language', $movie->original_language) }}" placeholder="fr, en, es..." class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="text-text-primary font-semibold mb-2 block">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors resize-none">{{ old('description', $movie->description) }}</textarea>
                        </div>

                        <!-- Date de sortie -->
                        <div>
                            <label for="release_date" class="text-text-primary font-semibold mb-2 block">
                                Date de sortie
                            </label>
                            <input type="date" id="release_date" name="release_date" value="{{ old('release_date', $movie->release_date ? $movie->release_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Durée -->
                        <div>
                            <label for="runtime" class="text-text-primary font-semibold mb-2 block">
                                Durée (minutes)
                            </label>
                            <input type="number" id="runtime" name="runtime" value="{{ old('runtime', $movie->runtime) }}" min="0" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="rating" class="text-text-primary font-semibold mb-2 block">
                                Note (0-10)
                            </label>
                            <input type="number" id="rating" name="rating" value="{{ old('rating', $movie->rating) }}" min="0" max="10" step="0.1" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="text-text-primary font-semibold mb-2 block">
                                Statut
                            </label>
                            <select id="status" name="status" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                                <option value="">-- Sélectionner --</option>
                                <option value="Released" {{ old('status', $movie->status) == 'Released' ? 'selected' : '' }}>Released</option>
                                <option value="Post Production" {{ old('status', $movie->status) == 'Post Production' ? 'selected' : '' }}>Post Production</option>
                                <option value="In Production" {{ old('status', $movie->status) == 'In Production' ? 'selected' : '' }}>In Production</option>
                                <option value="Planned" {{ old('status', $movie->status) == 'Planned' ? 'selected' : '' }}>Planned</option>
                                <option value="Canceled" {{ old('status', $movie->status) == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>

                        <!-- IMDB ID -->
                        <div class="md:col-span-2">
                            <label for="imdb_id" class="text-text-primary font-semibold mb-2 block">
                                IMDB ID
                            </label>
                            <input type="text" id="imdb_id" name="imdb_id" value="{{ old('imdb_id', $movie->imdb_id) }}" placeholder="tt1234567" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-orange/30 rounded-xl focus:border-halloween-orange focus:outline-none transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-purple shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-purple mb-6">
                        <i class="fas fa-images mr-2"></i>
                        Images
                    </h2>

                    <div class="space-y-4">
                        <!-- Poster URL -->
                        <div>
                            <label for="poster_path" class="text-text-primary font-semibold mb-2 block">
                                URL du Poster
                            </label>
                            <input type="url" id="poster_path" name="poster_path" value="{{ old('poster_path', $movie->poster_path) }}" onchange="updatePosterPreview(this.value)" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            <p class="text-text-secondary text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                URL complète de l'image (ex: https://image.tmdb.org/t/p/original/...)
                            </p>
                        </div>

                        <!-- Backdrop URL -->
                        <div>
                            <label for="backdrop_path" class="text-text-primary font-semibold mb-2 block">
                                URL du Backdrop
                            </label>
                            <input type="url" id="backdrop_path" name="backdrop_path" value="{{ old('backdrop_path', $movie->backdrop_path) }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            <p class="text-text-secondary text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Image de fond pour la page du film
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Vidéos -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-purple shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-halloween-purple">
                            <i class="fas fa-play-circle mr-2"></i>
                            Vidéos
                            <span class="text-text-secondary text-lg ml-2">({{ $movie->videos->count() }})</span>
                        </h2>
                        <button type="button" onclick="showAddVideoForm()" class="bg-gradient-to-r from-halloween-green to-halloween-green-dark text-text-primary px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter une vidéo
                        </button>
                    </div>

                    <!-- Formulaire d'ajout de vidéo (masqué par défaut) -->
                    <div id="addVideoForm" class="hidden mb-6 p-6 bg-bg-tertiary rounded-xl border-2 border-halloween-green">
                        <h3 class="text-lg font-bold text-halloween-green mb-4">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Nouvelle vidéo
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-text-primary font-semibold mb-2 block text-sm">URL Embed <span class="text-halloween-red">*</span></label>
                                <input type="url" id="new_embed_url" class="w-full px-3 py-2 bg-bg-secondary text-text-primary border border-halloween-purple/30 rounded-lg focus:border-halloween-purple focus:outline-none text-sm" placeholder="https://vidsrc.xyz/embed/movie/...">
                            </div>
                            <div>
                                <label class="text-text-primary font-semibold mb-2 block text-sm">Qualité</label>
                                <select id="new_quality" class="w-full px-3 py-2 bg-bg-secondary text-text-primary border border-halloween-purple/30 rounded-lg focus:border-halloween-purple focus:outline-none text-sm">
                                    <option value="SD">SD</option>
                                    <option value="HD" selected>HD</option>
                                    <option value="FHD">FHD (1080p)</option>
                                    <option value="4K">4K</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-text-primary font-semibold mb-2 block text-sm">Langue</label>
                                <select id="new_language" class="w-full px-3 py-2 bg-bg-secondary text-text-primary border border-halloween-purple/30 rounded-lg focus:border-halloween-purple focus:outline-none text-sm">
                                    <option value="fr" selected>Français</option>
                                    <option value="en">Anglais</option>
                                    <option value="es">Espagnol</option>
                                    <option value="de">Allemand</option>
                                    <option value="it">Italien</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-text-primary font-semibold mb-2 block text-sm">Sous-titres (séparés par virgule)</label>
                                <input type="text" id="new_subtitles" class="w-full px-3 py-2 bg-bg-secondary text-text-primary border border-halloween-purple/30 rounded-lg focus:border-halloween-purple focus:outline-none text-sm" placeholder="fr, en, es">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <button type="button" onclick="hideAddVideoForm()" class="px-4 py-2 bg-bg-secondary text-text-secondary rounded-lg hover:bg-bg-tertiary transition-colors text-sm">
                                Annuler
                            </button>
                            <button type="button" onclick="addVideo()" class="bg-gradient-to-r from-halloween-green to-halloween-green-dark text-text-primary px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 text-sm">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer
                            </button>
                        </div>
                    </div>

                    <!-- Liste des vidéos -->
                    <div id="videosList" class="space-y-3">
                        @forelse($movie->videos as $video)
                        <div class="video-item p-4 bg-bg-tertiary rounded-lg border border-halloween-purple/30 hover:border-halloween-purple/50 transition-colors" data-video-id="{{ $video->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="px-3 py-1 bg-halloween-purple/20 text-halloween-purple text-xs font-bold rounded-full border border-halloween-purple">
                                            {{ $video->quality }}
                                        </span>
                                        <span class="px-3 py-1 bg-halloween-yellow/20 text-halloween-yellow text-xs font-bold rounded-full border border-halloween-yellow">
                                            {{ strtoupper($video->language) }}
                                        </span>
                                        @if($video->subtitles)
                                        <span class="text-text-secondary text-xs">
                                            <i class="fas fa-closed-captioning mr-1"></i>
                                            {{ implode(', ', $video->subtitles) }}
                                        </span>
                                        @endif
                                        @if($video->is_active)
                                        <span class="px-2 py-1 bg-halloween-green/20 text-halloween-green text-xs font-semibold rounded border border-halloween-green">
                                            <i class="fas fa-check"></i> Actif
                                        </span>
                                        @endif
                                    </div>
                                    <p class="text-text-secondary text-sm truncate">
                                        <i class="fas fa-link mr-1"></i>
                                        {{ $video->embed_url }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2 ml-3">
                                    <button type="button" onclick="editVideo({{ $video->id }})" class="text-halloween-orange hover:text-halloween-orange-light transition-colors p-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" onclick="deleteVideo({{ $video->id }})" class="text-halloween-red hover:text-halloween-red-light transition-colors p-2" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-text-secondary">
                            <i class="fas fa-video-slash text-4xl mb-2 opacity-30"></i>
                            <p>Aucune vidéo ajoutée</p>
                            <p class="text-sm">Cliquez sur "Ajouter une vidéo" pour commencer</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Options -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-yellow shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-yellow mb-6">
                        <i class="fas fa-cog mr-2"></i>
                        Options
                    </h2>

                    <div class="space-y-4">
                        <!-- Film en vedette -->
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $movie->is_featured) ? 'checked' : '' }} class="w-6 h-6 text-halloween-yellow bg-bg-tertiary border-2 border-halloween-yellow/30 rounded focus:ring-2 focus:ring-halloween-yellow cursor-pointer">
                            <div>
                                <span class="text-text-primary font-semibold group-hover:text-halloween-yellow transition-colors">
                                    <i class="fas fa-star mr-2"></i>
                                    Film en vedette
                                </span>
                                <p class="text-text-secondary text-sm">Afficher ce film dans la section des films en vedette</p>
                            </div>
                        </label>

                        <!-- Film actif -->
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $movie->is_active) ? 'checked' : '' }} class="w-6 h-6 text-halloween-green bg-bg-tertiary border-2 border-halloween-green/30 rounded focus:ring-2 focus:ring-halloween-green cursor-pointer">
                            <div>
                                <span class="text-text-primary font-semibold group-hover:text-halloween-green transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Film actif
                                </span>
                                <p class="text-text-secondary text-sm">Le film est visible pour les utilisateurs</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.movies') }}" class="px-6 py-3 bg-bg-tertiary text-text-secondary rounded-xl hover:bg-bg-secondary border-2 border-transparent hover:border-halloween-orange/30 transition-all duration-300">
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
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            preview.src = url;
        }
    }

    // Gestion des vidéos
    function showAddVideoForm() {
        document.getElementById('addVideoForm').classList.remove('hidden');
    }

    function hideAddVideoForm() {
        document.getElementById('addVideoForm').classList.add('hidden');
        // Réinitialiser le formulaire
        document.getElementById('new_embed_url').value = '';
        document.getElementById('new_quality').value = 'HD';
        document.getElementById('new_language').value = 'fr';
        document.getElementById('new_subtitles').value = '';
    }

    async function addVideo() {
        const embedUrl = document.getElementById('new_embed_url').value;
        const quality = document.getElementById('new_quality').value;
        const language = document.getElementById('new_language').value;
        const subtitles = document.getElementById('new_subtitles').value;

        if (!embedUrl) {
            showNotification('error', 'L\'URL embed est obligatoire');
            return;
        }

        try {
            const response = await fetch('{{ route("admin.store-video") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    movie_id: {{ $movie->id }},
                    embed_url: embedUrl,
                    quality: quality,
                    language: language,
                    subtitles: subtitles
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showNotification('success', data.message);
                hideAddVideoForm();
                // Recharger la page après 1 seconde
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.error || 'Erreur lors de l\'ajout');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showNotification('error', error.message);
        }
    }

    async function deleteVideo(videoId) {
        if (!confirm('Voulez-vous vraiment supprimer cette vidéo ?')) {
            return;
        }

        try {
            const response = await fetch(`/admin/videos/${videoId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showNotification('success', data.message);
                // Supprimer l'élément du DOM
                document.querySelector(`[data-video-id="${videoId}"]`).remove();
                
                // Vérifier s'il reste des vidéos
                const videosList = document.getElementById('videosList');
                if (videosList.querySelectorAll('.video-item').length === 0) {
                    videosList.innerHTML = `
                        <div class="text-center py-8 text-text-secondary">
                            <i class="fas fa-video-slash text-4xl mb-2 opacity-30"></i>
                            <p>Aucune vidéo ajoutée</p>
                            <p class="text-sm">Cliquez sur "Ajouter une vidéo" pour commencer</p>
                        </div>
                    `;
                }
            } else {
                throw new Error(data.error || 'Erreur lors de la suppression');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showNotification('error', error.message);
        }
    }

    function editVideo(videoId) {
        showNotification('info', 'Fonctionnalité d\'édition en cours de développement');
    }

    function showNotification(type, message) {
        const colors = {
            success: 'halloween-green',
            error: 'halloween-red',
            warning: 'halloween-yellow',
            info: 'halloween-orange'
        };
        
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        
        const color = colors[type] || colors.info;
        const icon = icons[type] || icons.info;
        
        const notification = document.createElement('div');
        notification.className = `fixed top-24 right-6 z-[100] bg-bg-secondary border-2 border-${color} rounded-xl shadow-2xl shadow-${color}/50 p-6 max-w-md transition-all duration-300`;
        notification.style.transform = 'translateX(400px)';
        notification.innerHTML = `
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-${color}/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-${icon} text-${color} text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-text-primary">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-text-secondary hover:text-text-primary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
</script>
@endsection

