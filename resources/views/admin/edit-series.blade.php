@extends('admin.layout')

@section('title', 'Modifier la Série')

@section('content')
<!-- Hero Section avec Backdrop -->
<section class="relative py-20 overflow-hidden mb-8">
    <!-- Backdrop en pleine largeur -->
    <div class="absolute inset-0">
        @if($series->backdrop_url)
        <img src="{{ $series->backdrop_url }}" alt="{{ $series->title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-bg-primary/90 via-transparent to-bg-primary/90"></div>
        @else
        <div class="absolute inset-0 bg-gradient-to-br from-halloween-yellow/20 to-halloween-purple/20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>
        @endif
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.series') }}" class="text-halloween-yellow hover:text-halloween-yellow-light transition-colors hover:scale-110 transform duration-300">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <h1 class="text-5xl md:text-6xl font-bold text-halloween-yellow drop-shadow-2xl">
                <i class="fas fa-edit mr-3"></i>
                Modifier la Série
            </h1>
        </div>
        <p class="text-2xl text-text-primary font-semibold ml-16 drop-shadow-lg">{{ $series->title }}</p>
        
        <!-- Info rapide -->
        <div class="flex flex-wrap gap-4 mt-6 ml-16">
            @if($series->first_air_date)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-yellow/30">
                <i class="fas fa-calendar text-halloween-yellow"></i>
                <span class="text-text-primary font-semibold">{{ $series->first_air_date->format('Y') }}</span>
            </div>
            @endif
            
            @if($series->number_of_seasons)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-purple/30">
                <i class="fas fa-layer-group text-halloween-purple"></i>
                <span class="text-text-primary font-semibold">{{ $series->number_of_seasons }} saison(s)</span>
            </div>
            @endif
            
            @if($series->number_of_episodes)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-orange/30">
                <i class="fas fa-video text-halloween-orange"></i>
                <span class="text-text-primary font-semibold">{{ $series->number_of_episodes }} épisode(s)</span>
            </div>
            @endif
            
            @if($series->rating)
            <div class="flex items-center space-x-2 bg-bg-primary/50 backdrop-blur-sm px-4 py-2 rounded-lg border border-halloween-yellow/30">
                <i class="fas fa-star text-halloween-yellow"></i>
                <span class="text-text-primary font-semibold">{{ $series->rating }}/10</span>
            </div>
            @endif
            
            @if($series->is_active)
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

    <form action="{{ route('admin.update-series', $series->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne de gauche - Aperçu -->
            <div class="lg:col-span-1">
                <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-yellow shadow-2xl sticky top-6">
                    <h2 class="text-2xl font-bold text-halloween-yellow mb-4">
                        <i class="fas fa-image mr-2"></i>
                        Aperçu
                    </h2>
                    
                    <!-- Poster -->
                    <div class="mb-6">
                        <label class="text-text-secondary text-sm mb-2 block">Poster</label>
                        <div class="relative group">
                            <img id="posterPreview" src="{{ $series->poster_url }}" alt="{{ $series->title }}" class="w-full rounded-xl border-2 border-halloween-yellow shadow-lg">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-3xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Informations rapides -->
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-halloween-yellow/30">
                            <span class="text-text-secondary">TMDB ID:</span>
                            <span class="text-text-primary font-semibold">{{ $series->tmdb_id }}</span>
                        </div>
                        @if($series->imdb_id)
                        <div class="flex justify-between items-center py-2 border-b border-halloween-yellow/30">
                            <span class="text-text-secondary">IMDB ID:</span>
                            <span class="text-text-primary font-semibold">{{ $series->imdb_id }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-halloween-yellow/30">
                            <span class="text-text-secondary">Date d'ajout:</span>
                            <span class="text-text-primary">{{ $series->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-text-secondary">Dernière MàJ:</span>
                            <span class="text-text-primary">{{ $series->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Formulaire -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-yellow shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-yellow mb-6">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations générales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Titre -->
                        <div class="md:col-span-2">
                            <label for="title" class="text-text-primary font-semibold mb-2 block">
                                Titre <span class="text-halloween-red">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $series->title) }}" required class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Titre original -->
                        <div>
                            <label for="original_title" class="text-text-primary font-semibold mb-2 block">
                                Titre original
                            </label>
                            <input type="text" id="original_title" name="original_title" value="{{ old('original_title', $series->original_title) }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Langue originale -->
                        <div>
                            <label for="original_language" class="text-text-primary font-semibold mb-2 block">
                                Langue
                            </label>
                            <input type="text" id="original_language" name="original_language" value="{{ old('original_language', $series->original_language) }}" placeholder="fr, en, es..." class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="text-text-primary font-semibold mb-2 block">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors resize-none">{{ old('description', $series->description) }}</textarea>
                        </div>

                        <!-- Première diffusion -->
                        <div>
                            <label for="first_air_date" class="text-text-primary font-semibold mb-2 block">
                                Première diffusion
                            </label>
                            <input type="date" id="first_air_date" name="first_air_date" value="{{ old('first_air_date', $series->first_air_date ? $series->first_air_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Dernière diffusion -->
                        <div>
                            <label for="last_air_date" class="text-text-primary font-semibold mb-2 block">
                                Dernière diffusion
                            </label>
                            <input type="date" id="last_air_date" name="last_air_date" value="{{ old('last_air_date', $series->last_air_date ? $series->last_air_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Nombre de saisons -->
                        <div>
                            <label for="number_of_seasons" class="text-text-primary font-semibold mb-2 block">
                                Nombre de saisons
                            </label>
                            <input type="number" id="number_of_seasons" name="number_of_seasons" value="{{ old('number_of_seasons', $series->number_of_seasons) }}" min="0" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Nombre d'épisodes -->
                        <div>
                            <label for="number_of_episodes" class="text-text-primary font-semibold mb-2 block">
                                Nombre d'épisodes
                            </label>
                            <input type="number" id="number_of_episodes" name="number_of_episodes" value="{{ old('number_of_episodes', $series->number_of_episodes) }}" min="0" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="rating" class="text-text-primary font-semibold mb-2 block">
                                Note (0-10)
                            </label>
                            <input type="number" id="rating" name="rating" value="{{ old('rating', $series->rating) }}" min="0" max="10" step="0.1" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="text-text-primary font-semibold mb-2 block">
                                Statut
                            </label>
                            <select id="status" name="status" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
                                <option value="">-- Sélectionner --</option>
                                <option value="Returning Series" {{ old('status', $series->status) == 'Returning Series' ? 'selected' : '' }}>Returning Series</option>
                                <option value="Ended" {{ old('status', $series->status) == 'Ended' ? 'selected' : '' }}>Ended</option>
                                <option value="Canceled" {{ old('status', $series->status) == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                <option value="In Production" {{ old('status', $series->status) == 'In Production' ? 'selected' : '' }}>In Production</option>
                                <option value="Planned" {{ old('status', $series->status) == 'Planned' ? 'selected' : '' }}>Planned</option>
                            </select>
                        </div>

                        <!-- IMDB ID -->
                        <div class="md:col-span-2">
                            <label for="imdb_id" class="text-text-primary font-semibold mb-2 block">
                                IMDB ID
                            </label>
                            <input type="text" id="imdb_id" name="imdb_id" value="{{ old('imdb_id', $series->imdb_id) }}" placeholder="tt1234567" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-yellow/30 rounded-xl focus:border-halloween-yellow focus:outline-none transition-colors">
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
                            <input type="url" id="poster_path" name="poster_path" value="{{ old('poster_path', $series->poster_path) }}" onchange="updatePosterPreview(this.value)" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
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
                            <input type="url" id="backdrop_path" name="backdrop_path" value="{{ old('backdrop_path', $series->backdrop_path) }}" class="w-full px-4 py-3 bg-bg-tertiary text-text-primary border-2 border-halloween-purple/30 rounded-xl focus:border-halloween-purple focus:outline-none transition-colors">
                            <p class="text-text-secondary text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Image de fond pour la page de la série
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Saisons et Épisodes -->
                @if($series->seasons->count() > 0)
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-purple shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-purple mb-6">
                        <i class="fas fa-layer-group mr-2"></i>
                        Saisons et Épisodes
                        <span class="text-text-secondary text-lg ml-2">({{ $series->seasons->count() }} saison(s), {{ $series->episodes->count() }} épisode(s))</span>
                    </h2>

                    <div class="space-y-4">
                        @foreach($series->seasons->sortBy('season_number') as $season)
                        <div class="bg-bg-tertiary rounded-xl border-2 border-halloween-purple/30 overflow-hidden">
                            <!-- En-tête de la saison (cliquable) -->
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-bg-secondary transition-colors">
                                <button type="button" onclick="toggleSeason({{ $season->id }})" class="flex items-center space-x-4 flex-1">
                                    <div class="w-16 h-16 bg-halloween-purple/20 rounded-lg flex items-center justify-center border-2 border-halloween-purple">
                                        <span class="text-halloween-purple font-bold text-xl">S{{ $season->season_number }}</span>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="text-text-primary font-bold text-lg">{{ $season->name }}</h3>
                                        <p class="text-text-secondary text-sm">
                                            <i class="fas fa-video mr-1"></i>
                                            {{ $season->episodes->count() }} épisode(s)
                                            @if($season->air_date)
                                            • <i class="fas fa-calendar ml-2 mr-1"></i>{{ $season->air_date->format('Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </button>
                                <div class="flex items-center space-x-3">
                                    @if($season->is_active)
                                    <span class="px-3 py-1 bg-halloween-green/20 text-halloween-green text-xs font-semibold rounded-full border border-halloween-green">
                                        <i class="fas fa-check mr-1"></i>Actif
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-halloween-red/20 text-halloween-red text-xs font-semibold rounded-full border border-halloween-red">
                                        <i class="fas fa-times mr-1"></i>Inactif
                                    </span>
                                    @endif
                                    <a href="{{ route('admin.edit-season', $season->id) }}" class="text-halloween-orange hover:text-halloween-orange-light transition-colors p-2" title="Modifier la saison">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" onclick="toggleSeason({{ $season->id }})" class="text-halloween-purple p-2">
                                        <i class="fas fa-chevron-down transition-transform duration-300" id="chevron-{{ $season->id }}"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Liste des épisodes (masquée par défaut) -->
                            <div id="season-{{ $season->id }}" class="hidden border-t-2 border-halloween-purple/30">
                                @if($season->episodes->count() > 0)
                                <div class="p-4 space-y-2 max-h-96 overflow-y-auto">
                                    @foreach($season->episodes->sortBy('episode_number') as $episode)
                                    <div class="bg-bg-secondary px-4 py-3 rounded-lg border border-halloween-purple/20 hover:border-halloween-purple/50 transition-colors group">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-3 flex-1">
                                                <div class="w-12 h-12 bg-halloween-yellow/20 rounded flex items-center justify-center border border-halloween-yellow flex-shrink-0">
                                                    <span class="text-halloween-yellow font-bold text-sm">E{{ $episode->episode_number }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-text-primary font-semibold">{{ $episode->name }}</h4>
                                                    @if($episode->description)
                                                    <p class="text-text-secondary text-sm mt-1 line-clamp-2">{{ $episode->description }}</p>
                                                    @endif
                                                    <div class="flex flex-wrap gap-3 mt-2 text-xs">
                                                        @if($episode->air_date)
                                                        <span class="text-text-secondary">
                                                            <i class="fas fa-calendar mr-1"></i>{{ $episode->air_date->format('d/m/Y') }}
                                                        </span>
                                                        @endif
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
                                                        @if($episode->rating)
                                                        <span class="text-halloween-yellow">
                                                            <i class="fas fa-star mr-1"></i>{{ $episode->rating }}/10
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 ml-3">
                                                @if($episode->is_active)
                                                <span class="px-2 py-1 bg-halloween-green/20 text-halloween-green text-xs font-semibold rounded border border-halloween-green">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                @else
                                                <span class="px-2 py-1 bg-halloween-red/20 text-halloween-red text-xs font-semibold rounded border border-halloween-red">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                @endif
                                                <a href="{{ route('admin.edit-episode', $episode->id) }}" class="text-halloween-orange hover:text-halloween-orange-light transition-colors opacity-0 group-hover:opacity-100" title="Modifier l'épisode">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="p-6 text-center text-text-secondary">
                                    <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                                    <p>Aucun épisode pour cette saison</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Options -->
                <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl">
                    <h2 class="text-2xl font-bold text-halloween-orange mb-6">
                        <i class="fas fa-cog mr-2"></i>
                        Options
                    </h2>

                    <div class="space-y-4">
                        <!-- Série en vedette -->
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $series->is_featured) ? 'checked' : '' }} class="w-6 h-6 text-halloween-orange bg-bg-tertiary border-2 border-halloween-orange/30 rounded focus:ring-2 focus:ring-halloween-orange cursor-pointer">
                            <div>
                                <span class="text-text-primary font-semibold group-hover:text-halloween-orange transition-colors">
                                    <i class="fas fa-star mr-2"></i>
                                    Série en vedette
                                </span>
                                <p class="text-text-secondary text-sm">Afficher cette série dans la section des séries en vedette</p>
                            </div>
                        </label>

                        <!-- Série active -->
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $series->is_active) ? 'checked' : '' }} class="w-6 h-6 text-halloween-green bg-bg-tertiary border-2 border-halloween-green/30 rounded focus:ring-2 focus:ring-halloween-green cursor-pointer">
                            <div>
                                <span class="text-text-primary font-semibold group-hover:text-halloween-green transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Série active
                                </span>
                                <p class="text-text-secondary text-sm">La série est visible pour les utilisateurs</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.series') }}" class="px-6 py-3 bg-bg-tertiary text-text-secondary rounded-xl hover:bg-bg-secondary border-2 border-transparent hover:border-halloween-yellow/30 transition-all duration-300">
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

    // Toggle season episodes
    function toggleSeason(seasonId) {
        const seasonDiv = document.getElementById(`season-${seasonId}`);
        const chevron = document.getElementById(`chevron-${seasonId}`);
        
        if (seasonDiv.classList.contains('hidden')) {
            // Ouvrir la saison
            seasonDiv.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            // Fermer la saison
            seasonDiv.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection

