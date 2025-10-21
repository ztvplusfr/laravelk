<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Étape 1 - ZTVPlus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styles pour les champs autofill */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important;
            -webkit-text-fill-color: #ffffff !important;
            background-color: #1a1a1a !important;
            border: 2px solid #ff6b35 !important;
        }
        
        /* Styles pour Firefox */
        input:-moz-autofill {
            background-color: #1a1a1a !important;
            color: #ffffff !important;
            border: 2px solid #ff6b35 !important;
        }
        
        /* Styles pour les champs en focus avec autofill */
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px #1a1a1a inset, 0 0 0 2px #ff6b35 !important;
            -webkit-text-fill-color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-bg-primary min-h-screen font-sans flex items-center justify-center">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-radial from-halloween-orange/5 via-transparent to-transparent"></div>
    <div class="absolute top-20 left-10 w-20 h-20 bg-halloween-orange/10 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-halloween-purple/10 rounded-full blur-xl animate-pulse delay-1000"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-halloween-green/10 rounded-full blur-xl animate-pulse delay-500"></div>
    <div class="absolute bottom-1/3 right-1/4 w-24 h-24 bg-halloween-yellow/10 rounded-full blur-xl animate-pulse delay-700"></div>

    <div class="relative z-10 w-full max-w-md mx-auto px-6">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="text-4xl font-bold text-halloween-orange drop-shadow-2xl hover:drop-shadow-3xl transition-all duration-300">
                ZTVPlus
            </a>
            <p class="text-text-secondary mt-2">Plateforme de streaming gratuite</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-halloween-orange rounded-full flex items-center justify-center">
                        <span class="text-text-primary font-bold">1</span>
                    </div>
                    <span class="ml-2 text-halloween-orange font-semibold">Informations</span>
                </div>
                <div class="w-16 h-1 bg-bg-tertiary rounded-full"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-bg-tertiary rounded-full flex items-center justify-center">
                        <span class="text-text-muted font-bold">2</span>
                    </div>
                    <span class="ml-2 text-text-muted font-semibold">Sécurité</span>
                </div>
            </div>
        </div>

        <!-- Register Step 1 Card -->
        <div class="bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 transition-all duration-300">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-text-primary mb-2">Étape 1/2</h1>
                <p class="text-text-secondary">Vos informations personnelles</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-halloween-green/20 border border-halloween-green text-halloween-green rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-halloween-red/20 border border-halloween-red text-halloween-red rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-halloween-red/20 border border-halloween-red text-halloween-red rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Register Step 1 Form -->
            <form method="POST" action="{{ route('register.step1.process') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Avatar Field -->
                <div class="flex flex-col items-center mb-6">
                    <div class="relative group mb-2">
                        <div id="avatar-preview" class="w-24 h-24 rounded-full bg-bg-secondary border-2 border-dashed border-halloween-orange/50 flex items-center justify-center overflow-hidden">
                            <i class="fas fa-user text-3xl text-text-muted"></i>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <label for="avatar" class="cursor-pointer p-2 bg-halloween-orange/80 hover:bg-halloween-orange rounded-full transition-colors duration-300">
                                <i class="fas fa-camera text-white"></i>
                            </label>
                        </div>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                    </div>
                    <p class="text-xs text-text-muted mt-1">Cliquez sur l'icône pour ajouter une photo</p>
                    @error('avatar')
                        <p class="text-halloween-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-text-primary font-semibold mb-2">
                        <i class="fas fa-user mr-2 text-halloween-orange"></i>
                        Nom complet
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-bg-secondary border border-halloween-orange rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-halloween-orange focus:border-transparent transition-all duration-300"
                        placeholder="Votre nom complet"
                        required
                    >
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-text-primary font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-halloween-orange"></i>
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-bg-secondary border border-halloween-orange rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-halloween-orange focus:border-transparent transition-all duration-300"
                        placeholder="votre@email.com"
                        required
                    >
                    <p class="text-text-muted text-sm mt-1">Nous utiliserons cette adresse pour vous connecter</p>
                </div>

                <!-- Avatar Field -->
                <div>
                    <label for="avatar" class="block text-text-primary font-semibold mb-2">
                        <i class="fas fa-user-circle mr-2 text-halloween-orange"></i>
                        Photo de profil (optionnel)
                    </label>
                    <div class="relative">
                        <input 
                            type="file" 
                            id="avatar" 
                            name="avatar" 
                            accept="image/*"
                            class="w-full px-4 py-3 bg-bg-secondary border border-halloween-orange rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-halloween-orange focus:border-transparent transition-all duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-halloween-orange file:text-text-primary hover:file:bg-halloween-orange-light"
                        >
                        <div class="mt-2 text-center">
                            <div id="avatar-preview" class="hidden">
                                <img id="preview-img" class="w-20 h-20 rounded-full mx-auto border-2 border-halloween-orange" alt="Aperçu">
                                <p class="text-text-secondary text-sm mt-1">Aperçu de votre avatar</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-text-muted text-sm mt-1">Formats acceptés : JPG, PNG, GIF (max 2MB)</p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary py-3 px-6 rounded-lg font-semibold text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300 border-2 border-halloween-orange"
                >
                    <i class="fas fa-arrow-right mr-2"></i>
                    Continuer vers l'étape 2
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-text-secondary">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}" class="text-halloween-orange hover:text-halloween-orange-light font-semibold transition-colors duration-300">
                        Se connecter
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="/" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-text-muted">
            <p>&copy; 2024 ZTVPlus. Plateforme de streaming gratuite et légale.</p>
        </div>
    </div>

    <script>
        // Avatar preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            
            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Vérifier la taille du fichier (max 2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('La taille du fichier ne doit pas dépasser 2MB');
                            this.value = '';
                            return;
                        }
                        
                        // Vérifier le type de fichier
                        if (!file.type.match('image.*')) {
                            alert('Veuillez sélectionner une image valide (JPEG, PNG, GIF)');
                            this.value = '';
                            return;
                        }
                        
                        // Afficher l'aperçu de l'image
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            }
        });

        // Auto-hide success/error messages after 5 seconds
        setTimeout(() => {
            const messages = document.querySelectorAll('.mb-6');
            messages.forEach(message => {
                if (message.textContent.includes('Cette adresse email') || message.textContent.includes('Veuillez d\'abord')) {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(() => message.remove(), 300);
                }
            });
        }, 5000);
    </script>
</body>
</html>
