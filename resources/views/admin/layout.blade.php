<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen font-sans">
    <!-- Header Admin -->
    <header class="fixed top-0 w-full z-50 bg-bg-primary/80 backdrop-blur-xl border-b-2 border-halloween-orange">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-all duration-300">
                        <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-12 w-auto">
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
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-bg-primary border-t-2 border-halloween-orange py-8 mt-16">
        <div class="container mx-auto px-6 text-center">
            <div class="text-2xl font-bold text-halloween-orange drop-shadow-lg mb-2">ZTVPlus Admin</div>
            <p class="text-text-secondary">Panneau d'administration</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

