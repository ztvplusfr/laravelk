<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black min-h-screen font-sans">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-xl border-b border-halloween-orange/30">
        <nav class="container mx-auto px-3 md:px-6 py-3 md:py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-10 md:h-12 w-auto">
            </a>
            
            <div class="flex items-center space-x-2 md:space-x-4">
                <a href="{{ route('home') }}" class="text-text-primary hover:text-halloween-orange transition-colors duration-300 text-sm md:text-base">
                    <i class="fas fa-arrow-left mr-1 md:mr-2"></i>
                    <span class="hidden md:inline">Retour</span>
                </a>
                
                @if($user->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-halloween-purple hover:text-halloween-purple-light transition-colors duration-300" title="Administration">
                    <i class="fas fa-crown text-lg md:text-xl"></i>
                </a>
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-24 md:pt-32 pb-8 md:pb-16">
        <div class="container mx-auto px-3 md:px-6">
            <!-- Page Title -->
            <div class="mb-6 md:mb-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-halloween-orange drop-shadow-lg mb-2">
                    <i class="fas fa-user-circle mr-2 md:mr-3"></i>
                    Mon Compte
                </h1>
                <p class="text-text-secondary text-base md:text-lg">Gérez vos informations personnelles et vos sessions</p>
            </div>
            
            <!-- Messages de succès/erreur -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-halloween-green/20 border border-halloween-green rounded-lg flex items-center">
                <i class="fas fa-check-circle text-halloween-green text-xl mr-3"></i>
                <p class="text-halloween-green font-semibold">{{ session('success') }}</p>
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-6 p-4 bg-halloween-red/20 border border-halloween-red rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle text-halloween-red text-xl mr-3"></i>
                <p class="text-halloween-red font-semibold">{{ session('error') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-8">
                <!-- Informations du compte -->
                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <!-- Profil -->
                    <div class="bg-black/60 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-halloween-orange/30">
                        <h2 class="text-xl md:text-2xl font-bold text-halloween-orange mb-4 md:mb-6 flex items-center">
                            <i class="fas fa-id-card mr-2 md:mr-3"></i>
                            Informations du profil
                        </h2>
                        
                        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-4 md:mb-6">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-halloween-orange shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-gradient-to-br from-halloween-orange to-halloween-yellow rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user text-white text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1 text-center sm:text-left w-full sm:w-auto">
                                <h3 class="text-xl md:text-2xl font-bold text-text-primary mb-1">{{ $user->name }}</h3>
                                <p class="text-text-secondary mb-3 text-sm md:text-base break-all">{{ $user->email }}</p>
                                <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                    @if($user->isAdmin())
                                    <span class="px-2 md:px-3 py-1 bg-halloween-purple/20 border border-halloween-purple text-halloween-purple text-xs font-bold rounded-full">
                                        <i class="fas fa-crown mr-1"></i>ADMIN
                                    </span>
                                    @else
                                    <span class="px-2 md:px-3 py-1 bg-halloween-green/20 border border-halloween-green text-halloween-green text-xs font-bold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>USER
                                    </span>
                                    @endif
                                    <span class="px-2 md:px-3 py-1 bg-halloween-orange/20 border border-halloween-orange text-halloween-orange text-xs font-bold rounded-full whitespace-nowrap">
                                        <i class="fas fa-calendar-alt mr-1"></i><span class="hidden sm:inline">Membre </span>{{ $user->created_at->setTimezone($user->timezone ?? 'Europe/Paris')->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-orange/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-secondary text-sm">Nom d'utilisateur</span>
                                    <i class="fas fa-user text-halloween-orange"></i>
                                </div>
                                <p class="text-text-primary font-semibold">{{ $user->name }}</p>
                            </div>
                            
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-orange/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-secondary text-sm">Email</span>
                                    <i class="fas fa-envelope text-halloween-orange"></i>
                                </div>
                                <p class="text-text-primary font-semibold">{{ $user->email }}</p>
                            </div>
                            
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-orange/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-secondary text-sm">Rôle</span>
                                    <i class="fas fa-shield-alt text-halloween-orange"></i>
                                </div>
                                <p class="text-text-primary font-semibold">{{ $user->isAdmin() ? 'Administrateur' : 'Utilisateur' }}</p>
                            </div>
                            
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-orange/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-secondary text-sm">Date d'inscription</span>
                                    <i class="fas fa-calendar text-halloween-orange"></i>
                                </div>
                                <p class="text-text-primary font-semibold">{{ $user->created_at->setTimezone($user->timezone ?? 'Europe/Paris')->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-orange/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-secondary text-sm">Fuseau horaire</span>
                                    <i class="fas fa-clock text-halloween-orange"></i>
                                </div>
                                <p class="text-text-primary font-semibold">{{ $user->timezone ?? 'Europe/Paris' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modification du timezone -->
                    <div class="bg-black/60 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-halloween-yellow/30">
                        <h2 class="text-xl md:text-2xl font-bold text-halloween-yellow mb-4 md:mb-6 flex items-center">
                            <i class="fas fa-globe mr-2 md:mr-3"></i>
                            Fuseau horaire
                        </h2>
                        
                        <form method="POST" action="{{ route('account.update-timezone') }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div class="bg-black/40 rounded-xl p-4 border border-halloween-yellow/20">
                                <label for="timezone" class="block text-text-secondary text-sm mb-2">
                                    <i class="fas fa-clock mr-2 text-halloween-yellow"></i>
                                    Sélectionnez votre fuseau horaire
                                </label>
                                <select name="timezone" id="timezone" class="w-full bg-black/60 border border-halloween-yellow/30 rounded-lg px-3 py-2 text-text-primary focus:border-halloween-yellow focus:ring-1 focus:ring-halloween-yellow transition-colors duration-300">
                                    <option value="Europe/Paris" {{ ($user->timezone ?? 'Europe/Paris') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (GMT+1/+2)</option>
                                    <option value="Europe/Brussels" {{ ($user->timezone ?? 'Europe/Paris') == 'Europe/Brussels' ? 'selected' : '' }}>Europe/Brussels (GMT+1/+2)</option>
                                    <option value="Indian/Mayotte" {{ ($user->timezone ?? 'Europe/Paris') == 'Indian/Mayotte' ? 'selected' : '' }}>Indian/Mayotte (GMT+3)</option>
                                    <option value="Indian/Mauritius" {{ ($user->timezone ?? 'Europe/Paris') == 'Indian/Mauritius' ? 'selected' : '' }}>Indian/Mauritius (GMT+4)</option>
                                    <option value="Indian/Reunion" {{ ($user->timezone ?? 'Europe/Paris') == 'Indian/Reunion' ? 'selected' : '' }}>Indian/Reunion (GMT+4)</option>
                                </select>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="submit" class="flex-1 bg-halloween-yellow text-black px-4 py-2 rounded-lg font-semibold hover:bg-halloween-yellow-light transition-colors duration-300 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Mettre à jour
                                </button>
                                <button type="button" onclick="resetTimezone()" class="flex-1 bg-halloween-orange/20 text-halloween-orange border border-halloween-orange px-4 py-2 rounded-lg font-semibold hover:bg-halloween-orange/30 transition-colors duration-300 flex items-center justify-center">
                                    <i class="fas fa-undo mr-2"></i>
                                    Réinitialiser
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Sessions actives -->
                    <div class="bg-black/60 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-halloween-purple/30">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h2 class="text-xl md:text-2xl font-bold text-halloween-purple flex items-center">
                                <i class="fas fa-desktop mr-2 md:mr-3"></i>
                                <span class="hidden sm:inline">Sessions actives</span>
                                <span class="sm:hidden">Sessions</span>
                            </h2>
                            <span class="px-2 md:px-3 py-1 bg-halloween-purple/20 text-halloween-purple text-xs md:text-sm font-bold rounded-full">
                                {{ $sessions->count() }}
                            </span>
                        </div>
                        
                        <div class="space-y-3 md:space-y-4">
                            @foreach($sessions as $session)
                            <div class="bg-black/40 rounded-lg md:rounded-xl p-3 md:p-5 border-2 {{ $session['is_current'] ? 'border-halloween-green/50' : 'border-halloween-purple/30' }}">
                                <div class="flex items-start justify-between mb-2 md:mb-3">
                                    <div class="flex items-center space-x-2 md:space-x-3">
                                        @php
                                            $ua = $session['user_agent'];
                                            $osIcon = 'fa-desktop';
                                            $osColor = $session['is_current'] ? 'text-halloween-green' : 'text-halloween-purple';
                                            $osName = 'Inconnu';
                                            $deviceType = 'Ordinateur';
                                            
                                            // Détection du système d'exploitation (ordre important!)
                                            if (str_contains($ua, 'iPhone')) {
                                                $osIcon = 'fa-apple';
                                                $osColor = 'text-gray-300';
                                                $osName = 'iPhone';
                                                $deviceType = 'iOS';
                                            } elseif (str_contains($ua, 'iPad')) {
                                                $osIcon = 'fa-apple';
                                                $osColor = 'text-gray-300';
                                                $osName = 'iPad';
                                                $deviceType = 'iPadOS';
                                            } elseif (str_contains($ua, 'Macintosh') || (str_contains($ua, 'Mac OS') && !str_contains($ua, 'iPhone') && !str_contains($ua, 'iPad'))) {
                                                $osIcon = 'fa-apple';
                                                $osColor = 'text-gray-300';
                                                $osName = 'Mac';
                                                $deviceType = 'macOS';
                                            } elseif (str_contains($ua, 'Windows')) {
                                                $osIcon = 'fa-windows';
                                                $osColor = 'text-blue-400';
                                                $osName = 'Windows';
                                                $deviceType = 'PC';
                                            } elseif (str_contains($ua, 'Linux')) {
                                                $osIcon = 'fa-linux';
                                                $osColor = 'text-yellow-400';
                                                $osName = 'Linux';
                                                $deviceType = 'PC';
                                            } elseif (str_contains($ua, 'Android')) {
                                                $osIcon = 'fa-android';
                                                $osColor = 'text-green-400';
                                                $osName = 'Android';
                                                $deviceType = str_contains($ua, 'Mobile') ? 'Mobile' : 'Tablette';
                                            }
                                        @endphp
                                        <div class="w-10 h-10 md:w-12 md:h-12 {{ $session['is_current'] ? 'bg-halloween-green/20' : 'bg-halloween-purple/20' }} rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fab {{ $osIcon }} {{ $osColor }} text-lg md:text-xl"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-text-primary font-bold flex flex-wrap items-center text-sm md:text-base gap-1">
                                                <span class="truncate">{{ $osName }}</span>
                                                <span class="hidden sm:inline">•</span>
                                                <span class="truncate">{{ $deviceType }}</span>
                                                @if($session['is_current'])
                                                <span class="px-2 py-1 bg-halloween-green/20 text-halloween-green text-xs rounded-full whitespace-nowrap">En cours</span>
                                                @endif
                                            </h3>
                                            <p class="text-text-secondary text-sm">
                                                @php
                                                    $userTimezone = $user->timezone ?? 'Europe/Paris';
                                                    $sessionTime = $session['last_activity']->setTimezone($userTimezone);
                                                    $now = now()->setTimezone($userTimezone);
                                                    $diff = (int) $sessionTime->diffInMinutes($now);
                                                    
                                                    if ($diff < 1) {
                                                        echo "À l'instant";
                                                    } elseif ($diff < 60) {
                                                        echo "Il y a " . $diff . " minute" . ($diff > 1 ? 's' : '');
                                                    } elseif ($diff < 1440) {
                                                        $hours = (int) floor($diff / 60);
                                                        echo "Il y a " . $hours . " heure" . ($hours > 1 ? 's' : '');
                                                    } else {
                                                        $days = (int) floor($diff / 1440);
                                                        echo "Il y a " . $days . " jour" . ($days > 1 ? 's' : '');
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if(!$session['is_current'])
                                    <form method="POST" action="{{ route('session.destroy', $session['id']) }}" class="inline flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-halloween-red hover:text-halloween-red-light transition-colors duration-300" title="Déconnecter cette session">
                                            <i class="fas fa-times-circle text-lg md:text-xl"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs md:text-sm">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt {{ $session['is_current'] ? 'text-halloween-green' : 'text-halloween-purple' }} flex-shrink-0"></i>
                                        <span class="text-text-secondary flex-shrink-0">IP:</span>
                                        <span class="text-text-primary font-semibold truncate">{{ $session['ip'] }}</span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-clock {{ $session['is_current'] ? 'text-halloween-green' : 'text-halloween-purple' }} flex-shrink-0"></i>
                                        <span class="text-text-secondary hidden md:inline flex-shrink-0">Activité:</span>
                                        <span class="text-text-primary font-semibold truncate">{{ $session['last_activity']->setTimezone($user->timezone ?? 'Europe/Paris')->format('d/m H:i') }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-2 md:mt-3 pt-2 md:pt-3 border-t {{ $session['is_current'] ? 'border-halloween-green/20' : 'border-halloween-purple/20' }}">
                                    <p class="text-text-secondary text-xs line-clamp-1">{{ $session['user_agent'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($sessions->count() > 1)
                        <div class="mt-6 p-4 bg-halloween-yellow/10 border border-halloween-yellow/30 rounded-lg">
                            <p class="text-text-secondary text-sm text-center">
                                <i class="fas fa-info-circle mr-2 text-halloween-yellow"></i>
                                Vous avez {{ $sessions->count() }} sessions actives. Vous pouvez déconnecter les sessions que vous ne reconnaissez pas.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="space-y-4 md:space-y-6">
                    <!-- Carte statistiques -->
                    <div class="bg-gradient-to-br from-halloween-orange/20 to-halloween-purple/20 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-halloween-orange/30">
                        <h3 class="text-lg md:text-xl font-bold text-text-primary mb-3 md:mb-4 flex items-center">
                            <i class="fas fa-chart-line mr-2 text-halloween-orange"></i>
                            Statistiques
                        </h3>
                        
                        <div class="space-y-2 md:space-y-3">
                            <div class="flex items-center justify-between p-2 md:p-3 bg-black/40 rounded-lg">
                                <span class="text-text-secondary text-xs md:text-sm">Créé depuis</span>
                                <span class="text-text-primary font-bold text-xs md:text-base">
                                    @php
                                        $userTimezone = $user->timezone ?? 'Europe/Paris';
                                        $createdAt = $user->created_at->setTimezone($userTimezone);
                                        $now = now()->setTimezone($userTimezone);
                                        $diff = (int) $createdAt->diffInMinutes($now);
                                        
                                        if ($diff < 1) {
                                            echo "À l'instant";
                                        } elseif ($diff < 60) {
                                            echo "Il y a " . $diff . " minute" . ($diff > 1 ? 's' : '');
                                        } elseif ($diff < 1440) {
                                            $hours = (int) floor($diff / 60);
                                            echo "Il y a " . $hours . " heure" . ($hours > 1 ? 's' : '');
                                        } elseif ($diff < 43200) {
                                            $days = (int) floor($diff / 1440);
                                            echo "Il y a " . $days . " jour" . ($days > 1 ? 's' : '');
                                        } elseif ($diff < 525600) {
                                            $months = (int) floor($diff / 43200);
                                            echo "Il y a " . $months . " mois";
                                        } else {
                                            $years = (int) floor($diff / 525600);
                                            echo "Il y a " . $years . " an" . ($years > 1 ? 's' : '');
                                        }
                                    @endphp
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-2 md:p-3 bg-black/40 rounded-lg">
                                <span class="text-text-secondary text-xs md:text-sm">Connexion</span>
                                <span class="text-text-primary font-bold text-xs md:text-base">Maintenant</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-black/60 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-halloween-orange/30">
                        <h3 class="text-lg md:text-xl font-bold text-text-primary mb-3 md:mb-4 flex items-center">
                            <i class="fas fa-cog mr-2 text-halloween-orange"></i>
                            Actions
                        </h3>
                        
                        <div class="space-y-2 md:space-y-3">
                            <a href="{{ route('home') }}" class="block w-full bg-halloween-orange text-text-primary px-3 md:px-4 py-2 md:py-3 rounded-lg font-semibold hover:bg-halloween-orange-light transition-colors duration-300 text-center text-sm md:text-base">
                                <i class="fas fa-home mr-2"></i>
                                Accueil
                            </a>
                            
                            @if($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block w-full bg-halloween-purple text-text-primary px-3 md:px-4 py-2 md:py-3 rounded-lg font-semibold hover:bg-halloween-purple-light transition-colors duration-300 text-center text-sm md:text-base">
                                <i class="fas fa-crown mr-2"></i>
                                <span class="hidden sm:inline">Administration</span>
                                <span class="sm:hidden">Admin</span>
                            </a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-halloween-red text-text-primary px-3 md:px-4 py-2 md:py-3 rounded-lg font-semibold hover:bg-halloween-red-light transition-colors duration-300 text-sm md:text-base">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t-2 border-halloween-orange py-6 md:py-8">
        <div class="container mx-auto px-3 md:px-6 text-center">
            <div class="text-xl md:text-2xl font-bold text-halloween-orange drop-shadow-lg mb-2">ZTVPlus</div>
            <p class="text-text-secondary text-sm md:text-base">Votre plateforme de streaming gratuite</p>
        </div>
    </footer>
    
    <!-- Bottom Navigation -->
    @include('components.bottom-nav', ['user' => $user])
    
    <script>
        function resetTimezone() {
            document.getElementById('timezone').value = 'Europe/Paris';
        }
    </script>
</body>
</html>

