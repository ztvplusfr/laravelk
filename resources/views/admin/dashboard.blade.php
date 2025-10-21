<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen font-sans">
    <!-- Header Admin -->
    <header class="fixed top-0 w-full z-50 bg-bg-primary/80 backdrop-blur-xl border-b-2 border-halloween-orange">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-halloween-orange drop-shadow-lg hover:drop-shadow-xl transition-all duration-300">
                        ZTVPlus
                    </a>
                    <span class="px-3 py-1 bg-halloween-purple/20 border border-halloween-purple text-halloween-purple text-sm font-semibold rounded-full">
                        <i class="fas fa-crown mr-1"></i>
                        Admin
                    </span>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-text-primary hover:text-halloween-orange hover:bg-bg-secondary rounded-lg transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-bg-secondary text-halloween-orange' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.movies') }}" class="px-4 py-2 text-text-primary hover:text-halloween-purple hover:bg-bg-secondary rounded-lg transition-all duration-300 {{ request()->routeIs('admin.movies') ? 'bg-bg-secondary text-halloween-purple' : '' }}">
                        <i class="fas fa-film mr-2"></i>
                        Films
                    </a>
                    <a href="{{ route('admin.series') }}" class="px-4 py-2 text-text-primary hover:text-halloween-yellow hover:bg-bg-secondary rounded-lg transition-all duration-300 {{ request()->routeIs('admin.series') ? 'bg-bg-secondary text-halloween-yellow' : '' }}">
                        <i class="fas fa-tv mr-2"></i>
                        Séries
                    </a>
                    <a href="{{ route('admin.users') }}" class="px-4 py-2 text-text-primary hover:text-halloween-green hover:bg-bg-secondary rounded-lg transition-all duration-300 {{ request()->routeIs('admin.users') ? 'bg-bg-secondary text-halloween-green' : '' }}">
                        <i class="fas fa-users mr-2"></i>
                        Utilisateurs
                    </a>
                    <a href="{{ route('admin.import') }}" class="px-4 py-2 text-text-primary hover:text-halloween-orange-light hover:bg-bg-secondary rounded-lg transition-all duration-300 {{ request()->routeIs('admin.import') ? 'bg-bg-secondary text-halloween-orange-light' : '' }}">
                        <i class="fas fa-download mr-2"></i>
                        Importer
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="hidden lg:block text-text-secondary text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-halloween-red text-text-primary px-4 py-2 rounded-lg hover:bg-halloween-red-light transition-colors shadow-lg hover:shadow-halloween-red/50">
                            <i class="fas fa-sign-out-alt md:mr-2"></i>
                            <span class="hidden md:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="pt-24 pb-16">
        <!-- Hero Section -->
        <section class="relative py-12 text-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-radial from-halloween-orange/5 via-transparent to-transparent"></div>
            <div class="absolute top-10 left-10 w-20 h-20 bg-halloween-purple/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-halloween-orange/10 rounded-full blur-xl animate-pulse delay-1000"></div>
            
            <div class="container mx-auto px-6 relative z-10">
                <h1 class="text-5xl md:text-6xl font-bold mb-4 text-halloween-orange drop-shadow-2xl">
                    Tableau de bord
                </h1>
                <p class="text-xl text-text-secondary">Administration de la plateforme ZTVPlus</p>
            </div>
        </section>

        <div class="container mx-auto px-6">
            <!-- Statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Utilisateurs -->
                <div class="group bg-bg-secondary p-6 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-text-secondary text-sm mb-2">Utilisateurs</p>
                            <p class="text-4xl font-bold text-halloween-orange mb-2">{{ $stats['users']['total'] }}</p>
                            <p class="text-text-secondary text-xs">
                                <i class="fas fa-arrow-up text-halloween-green mr-1"></i>
                                +{{ $stats['users']['active'] }} ce mois
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-halloween-orange/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-halloween-orange text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Films -->
                <div class="group bg-bg-secondary p-6 rounded-2xl border border-halloween-purple shadow-2xl hover:shadow-halloween-purple/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-text-secondary text-sm mb-2">Films</p>
                            <p class="text-4xl font-bold text-halloween-purple mb-2">{{ $stats['movies']['total'] }}</p>
                            <p class="text-text-secondary text-xs">
                                <i class="fas fa-check-circle text-halloween-green mr-1"></i>
                                {{ $stats['movies']['active'] }} actifs
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-halloween-purple/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-film text-halloween-purple text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Séries -->
                <div class="group bg-bg-secondary p-6 rounded-2xl border border-halloween-yellow shadow-2xl hover:shadow-halloween-yellow/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-text-secondary text-sm mb-2">Séries</p>
                            <p class="text-4xl font-bold text-halloween-yellow mb-2">{{ $stats['series']['total'] }}</p>
                            <p class="text-text-secondary text-xs">
                                <i class="fas fa-check-circle text-halloween-green mr-1"></i>
                                {{ $stats['series']['active'] }} actives
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-halloween-yellow/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tv text-halloween-yellow text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Vidéos -->
                <div class="group bg-bg-secondary p-6 rounded-2xl border border-halloween-green shadow-2xl hover:shadow-halloween-green/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-text-secondary text-sm mb-2">Vidéos</p>
                            <p class="text-4xl font-bold text-halloween-green mb-2">{{ $stats['videos']['total'] }}</p>
                            <p class="text-text-secondary text-xs">
                                <i class="fas fa-check-circle text-halloween-green mr-1"></i>
                                {{ $stats['videos']['ready'] }} prêtes
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-halloween-green/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-halloween-green text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique des statistiques mensuelles -->
            <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl mb-12">
                <h3 class="text-3xl font-bold text-halloween-orange mb-6">
                    <i class="fas fa-chart-line mr-2"></i>
                    Évolution mensuelle
                </h3>
                <div class="h-64 flex items-end space-x-3">
                    @foreach($monthlyStats as $index => $stat)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-gradient-to-t from-halloween-orange to-halloween-yellow rounded-t-xl flex flex-col items-center justify-end relative group hover:from-halloween-yellow hover:to-halloween-orange transition-all duration-300" 
                             style="height: {{ max(40, ($stat['users'] + $stat['movies'] + $stat['series']) * 3) }}px">
                            <div class="absolute -top-8 text-sm font-bold text-halloween-orange opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                {{ $stat['users'] + $stat['movies'] + $stat['series'] }}
                            </div>
                        </div>
                        <div class="text-xs text-text-secondary mt-3 font-semibold">{{ $stat['month'] }}</div>
                        <div class="text-xs text-text-muted mt-1">
                            <i class="fas fa-users text-halloween-orange"></i> {{ $stat['users'] }}
                            <i class="fas fa-film text-halloween-purple ml-2"></i> {{ $stat['movies'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Contenu récent -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Films récents -->
                <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-purple shadow-2xl">
                    <h3 class="text-2xl font-bold text-halloween-purple mb-6 flex items-center">
                        <i class="fas fa-film mr-2"></i>
                        Films récents
                    </h3>
                    <div class="space-y-4">
                        @forelse($recentMovies as $movie)
                        <div class="flex items-center space-x-3 p-3 bg-bg-primary rounded-lg border border-halloween-purple/30 hover:border-halloween-purple hover:shadow-lg hover:shadow-halloween-purple/20 transition-all duration-300">
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover rounded border border-halloween-purple">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-text-primary font-semibold truncate">{{ $movie->title }}</h4>
                                <p class="text-text-secondary text-sm">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $movie->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-text-secondary">
                            <i class="fas fa-film text-4xl mb-3 opacity-30"></i>
                            <p>Aucun film récent</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Séries récentes -->
                <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-yellow shadow-2xl">
                    <h3 class="text-2xl font-bold text-halloween-yellow mb-6 flex items-center">
                        <i class="fas fa-tv mr-2"></i>
                        Séries récentes
                    </h3>
                    <div class="space-y-4">
                        @forelse($recentSeries as $series)
                        <div class="flex items-center space-x-3 p-3 bg-bg-primary rounded-lg border border-halloween-yellow/30 hover:border-halloween-yellow hover:shadow-lg hover:shadow-halloween-yellow/20 transition-all duration-300">
                            <img src="{{ $series->poster_url }}" alt="{{ $series->title }}" class="w-12 h-16 object-cover rounded border border-halloween-yellow">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-text-primary font-semibold truncate">{{ $series->title }}</h4>
                                <p class="text-text-secondary text-sm">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $series->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-text-secondary">
                            <i class="fas fa-tv text-4xl mb-3 opacity-30"></i>
                            <p>Aucune série récente</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Utilisateurs récents -->
                <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-orange shadow-2xl">
                    <h3 class="text-2xl font-bold text-halloween-orange mb-6 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Utilisateurs récents
                    </h3>
                    <div class="space-y-4">
                        @forelse($recentUsers as $user)
                        <div class="flex items-center space-x-3 p-3 bg-bg-primary rounded-lg border border-halloween-orange/30 hover:border-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/20 transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-halloween-orange to-halloween-yellow rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-text-primary font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-text-primary font-semibold truncate">{{ $user->name }}</h4>
                                <p class="text-text-secondary text-sm">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full font-semibold flex-shrink-0 {{ $user->role === 'admin' ? 'bg-halloween-purple/20 text-halloween-purple border border-halloween-purple' : 'bg-halloween-green/20 text-halloween-green border border-halloween-green' }}">
                                @if($user->role === 'admin')
                                <i class="fas fa-crown mr-1"></i>
                                @endif
                                {{ $user->role }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8 text-text-secondary">
                            <i class="fas fa-users text-4xl mb-3 opacity-30"></i>
                            <p>Aucun utilisateur récent</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-orange shadow-2xl">
                <h3 class="text-3xl font-bold text-halloween-orange mb-6 flex items-center">
                    <i class="fas fa-bolt mr-2"></i>
                    Actions rapides
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.movies') }}" class="group bg-gradient-to-br from-halloween-purple to-halloween-purple-dark text-text-primary px-6 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl hover:shadow-halloween-purple/50 transform hover:-translate-y-1 transition-all duration-300 text-center border border-halloween-purple">
                        <i class="fas fa-film mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Gérer les films
                    </a>
                    <a href="{{ route('admin.series') }}" class="group bg-gradient-to-br from-halloween-yellow to-halloween-yellow-dark text-text-primary px-6 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl hover:shadow-halloween-yellow/50 transform hover:-translate-y-1 transition-all duration-300 text-center border border-halloween-yellow">
                        <i class="fas fa-tv mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Gérer les séries
                    </a>
                    <a href="{{ route('admin.users') }}" class="group bg-gradient-to-br from-halloween-orange to-halloween-orange-dark text-text-primary px-6 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300 text-center border border-halloween-orange">
                        <i class="fas fa-users mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Gérer les utilisateurs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-bg-primary border-t-2 border-halloween-orange py-8 mt-16">
        <div class="container mx-auto px-6 text-center">
            <div class="text-2xl font-bold text-halloween-orange drop-shadow-lg mb-2">ZTVPlus Admin</div>
            <p class="text-text-secondary">Panneau d'administration</p>
        </div>
    </footer>

    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
</body>
</html>