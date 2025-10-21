@extends('admin.layout')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container mx-auto px-6">
    <!-- Hero Section -->
    <section class="relative py-12 text-center overflow-hidden mb-12">
        <div class="absolute inset-0 bg-gradient-radial from-halloween-green/5 via-transparent to-transparent"></div>
        <div class="absolute top-10 left-10 w-20 h-20 bg-halloween-green/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-halloween-green/10 rounded-full blur-xl animate-pulse delay-1000"></div>
        
        <div class="relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-halloween-green drop-shadow-2xl">
                <i class="fas fa-users mr-4"></i>
                Gestion des Utilisateurs
            </h1>
            <p class="text-xl text-text-secondary">Gérez tous les utilisateurs de la plateforme</p>
        </div>
    </section>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-green shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Total Utilisateurs</p>
                    <p class="text-4xl font-bold text-halloween-green">{{ $stats['total'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-green/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-halloween-green text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-purple shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Administrateurs</p>
                    <p class="text-4xl font-bold text-halloween-purple">{{ $stats['admins'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-purple/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-crown text-halloween-purple text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-bg-secondary p-6 rounded-2xl border border-halloween-orange shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-text-secondary text-sm mb-2">Utilisateurs</p>
                    <p class="text-4xl font-bold text-halloween-orange">{{ $stats['users'] }}</p>
                </div>
                <div class="w-16 h-16 bg-halloween-orange/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user text-halloween-orange text-2xl"></i>
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

    <!-- Liste des utilisateurs -->
    <div class="bg-bg-secondary p-8 rounded-2xl border border-halloween-green shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-halloween-green">
                <i class="fas fa-list mr-2"></i>
                Liste des Utilisateurs
            </h2>
        </div>

        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-halloween-green/30">
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Avatar</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Nom</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Email</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Rôle</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Inscription</th>
                        <th class="text-left py-4 px-4 text-text-secondary font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-halloween-green/10 hover:bg-bg-primary transition-colors">
                        <td class="py-4 px-4">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full border-2 border-halloween-green object-cover">
                            @else
                            <div class="w-12 h-12 bg-gradient-to-br from-halloween-green to-halloween-green-light rounded-full flex items-center justify-center">
                                <span class="text-text-primary font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-text-primary font-semibold">{{ $user->name }}</div>
                        </td>
                        <td class="py-4 px-4 text-text-secondary">
                            {{ $user->email }}
                        </td>
                        <td class="py-4 px-4">
                            @if($user->role === 'admin')
                            <span class="px-3 py-1 bg-halloween-purple/20 text-halloween-purple text-sm font-semibold rounded-full border border-halloween-purple">
                                <i class="fas fa-crown mr-1"></i>
                                Admin
                            </span>
                            @else
                            <span class="px-3 py-1 bg-halloween-green/20 text-halloween-green text-sm font-semibold rounded-full border border-halloween-green">
                                <i class="fas fa-user mr-1"></i>
                                User
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-text-secondary">
                            {{ $user->created_at->format('d/m/Y') }}
                            <div class="text-xs text-text-muted">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex space-x-2">
                                <button class="text-halloween-orange hover:text-halloween-orange-light transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->id !== Auth::user()->id)
                                <button class="text-halloween-red hover:text-halloween-red-light transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-users text-6xl text-text-secondary opacity-30 mb-4"></i>
            <p class="text-text-secondary text-lg">Aucun utilisateur trouvé</p>
        </div>
        @endif
    </div>
</div>
@endsection

