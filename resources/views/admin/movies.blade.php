@extends('admin.layout')

@section('title', 'Gestion des Films')

@section('content')
<div class="container mx-auto px-6">
    <!-- Hero Section -->
    <section class="relative py-12 text-center overflow-hidden mb-12">
        <div class="absolute inset-0 bg-gradient-radial from-halloween-purple/5 via-transparent to-transparent"></div>
        <div class="absolute top-10 left-10 w-20 h-20 bg-halloween-purple/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-halloween-purple/10 rounded-full blur-xl animate-pulse delay-1000"></div>
        
        <div class="relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-halloween-purple drop-shadow-2xl">
                <i class="fas fa-film mr-4"></i>
                Gestion des Films
            </h1>
            <p class="text-xl text-text-secondary">Gérez tous les films de la plateforme</p>
        </div>
    </section>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-purple shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Total Films</p>
                    <p class="text-4xl font-bold text-halloween-purple">{{ $stats['total'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-purple/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-film text-halloween-purple text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-green shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Films Actifs</p>
                    <p class="text-4xl font-bold text-halloween-green">{{ $stats['active'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-green/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-halloween-green text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-orange shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">En Vedette</p>
                    <p class="text-4xl font-bold text-halloween-orange">{{ $stats['featured'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-orange/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-halloween-orange text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-yellow shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Ce Mois-ci</p>
                    <p class="text-4xl font-bold text-halloween-yellow">{{ $stats['recent'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-yellow/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-halloween-yellow text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des films -->
    <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-purple shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-halloween-purple">
                <i class="fas fa-list mr-2"></i>
                Liste des Films
            </h2>
            <div class="flex space-x-4">
                <button onclick="syncAllMovies()" id="syncButton" class="bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-6 py-3 rounded-lg font-semibold hover:shadow-2xl hover:shadow-halloween-orange/50 transition-all duration-300 hover:scale-105">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Synchroniser tout
                </button>
                <a href="{{ route('admin.import') }}" class="bg-gradient-to-r from-halloween-purple to-halloween-purple-dark text-text-primary px-6 py-3 rounded-lg font-semibold hover:shadow-2xl hover:shadow-halloween-purple/50 transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un Film
                </a>
            </div>
        </div>

        @if($movies->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-halloween-purple/30">
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Poster</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Titre</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Date</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Note</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Statut</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movies as $movie)
                    <tr class="border-b border-halloween-purple/10 hover:bg-bg-primary transition-colors">
                        <td class="py-4 px-4">
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover rounded border border-halloween-purple">
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-text-primary font-semibold">{{ $movie->title }}</div>
                            <div class="text-text-secondary text-sm">{{ Str::limit($movie->description, 50) }}</div>
                        </td>
                        <td class="py-4 px-4 text-text-secondary">
                            {{ $movie->release_date ? $movie->release_date->format('Y') : 'N/A' }}
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-halloween-yellow">
                                <i class="fas fa-star mr-1"></i>
                                {{ $movie->rating ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            @if($movie->is_active)
                            <span class="px-3 py-1 bg-halloween-green/20 text-halloween-green text-sm font-semibold rounded-full border border-halloween-green">
                                <i class="fas fa-check mr-1"></i>
                                Actif
                            </span>
                            @else
                            <span class="px-3 py-1 bg-halloween-red/20 text-halloween-red text-sm font-semibold rounded-full border border-halloween-red">
                                <i class="fas fa-times mr-1"></i>
                                Inactif
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.edit-movie', $movie->id) }}" class="text-halloween-orange hover:text-halloween-orange-light transition-colors" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteMovie({{ $movie->id }}, '{{ addslashes($movie->title) }}')" class="text-halloween-red hover:text-halloween-red-light transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $movies->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-film text-6xl text-text-secondary opacity-30 mb-4"></i>
            <p class="text-text-secondary text-lg">Aucun film trouvé</p>
            <a href="{{ route('admin.import') }}" class="inline-block mt-4 bg-halloween-purple text-text-primary px-6 py-3 rounded-lg hover:bg-halloween-purple-light transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Ajouter votre premier film
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function deleteMovie(movieId, movieTitle) {
        // Confirmation
        if (!confirm(`Êtes-vous sûr de vouloir supprimer le film "${movieTitle}" ?\n\nCette action est irréversible.`)) {
            return;
        }
        
        try {
            const response = await fetch(`/admin/movies/${movieId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Succès
                showNotification('success', data.message);
                
                // Recharger la page après 2 secondes
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                throw new Error(data.error || 'Erreur lors de la suppression');
            }
            
        } catch (error) {
            console.error('Erreur:', error);
            showNotification('error', error.message || 'Erreur lors de la suppression');
        }
    }

    async function syncAllMovies() {
        const button = document.getElementById('syncButton');
        const originalContent = button.innerHTML;
        
        // Confirmation
        if (!confirm('Voulez-vous vraiment synchroniser tous les films ? Cette opération peut prendre plusieurs minutes.')) {
            return;
        }
        
        // Désactiver le bouton et afficher un loader
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Synchronisation en cours...';
        
        try {
            const response = await fetch('{{ route("admin.sync-movies") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Succès
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Synchronisé !';
                
                // Afficher une notification de succès
                showNotification('success', data.message);
                
                // Afficher les erreurs s'il y en a
                if (data.errors && data.errors.length > 0) {
                    setTimeout(() => {
                        showNotification('warning', `${data.errors.length} erreur(s) rencontrée(s). Consultez la console pour plus de détails.`);
                        console.error('Erreurs de synchronisation:', data.errors);
                    }, 2000);
                }
                
                // Recharger la page après 3 secondes
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } else {
                throw new Error(data.error || 'Erreur lors de la synchronisation');
            }
            
        } catch (error) {
            console.error('Erreur:', error);
            
            // Restaurer le bouton
            button.disabled = false;
            button.innerHTML = originalContent;
            
            // Afficher le message d'erreur
            showNotification('error', error.message || 'Erreur lors de la synchronisation');
        }
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
        
        const titles = {
            success: 'Succès',
            error: 'Erreur',
            warning: 'Attention',
            info: 'Information'
        };
        
        const color = colors[type] || colors.info;
        const icon = icons[type] || icons.info;
        const title = titles[type] || titles.info;
        
        const notification = document.createElement('div');
        notification.className = `fixed top-24 right-6 z-[100] bg-bg-secondary border-2 border-${color} rounded-xl shadow-2xl shadow-${color}/50 p-6 max-w-md transition-all duration-300`;
        notification.style.transform = 'translateX(400px)';
        notification.innerHTML = `
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-${color}/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-${icon} text-${color} text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-text-primary font-bold mb-1">${title}</h4>
                    <p class="text-text-secondary text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-text-secondary hover:text-text-primary transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Auto-remove après 5 secondes
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
</script>
@endsection
