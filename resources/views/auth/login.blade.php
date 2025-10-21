<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ZTVPlus</title>
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

        <!-- Login Card -->
        <div class="bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 transition-all duration-300">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-text-primary mb-2">Connexion</h1>
                <p class="text-text-secondary">Accédez à votre compte ZTVPlus</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-halloween-green/20 border border-halloween-green text-halloween-green rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
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

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
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
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-text-primary font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-halloween-orange"></i>
                        Mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-3 bg-bg-secondary border border-halloween-orange rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-halloween-orange focus:border-transparent transition-all duration-300 pr-12"
                            placeholder="Votre mot de passe"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300"
                        >
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-text-secondary">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            checked
                            class="mr-2 text-halloween-orange focus:ring-halloween-orange rounded"
                        >
                        Se souvenir de moi (2 mois)
                    </label>
                    <a href="#" class="text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary py-3 px-6 rounded-lg font-semibold text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300 border-2 border-halloween-orange"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-text-secondary">
                    Pas encore de compte ? 
                    <a href="{{ route('register.step1') }}" class="text-halloween-orange hover:text-halloween-orange-light font-semibold transition-colors duration-300">
                        Créer un compte
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
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide success/error messages after 5 seconds
        setTimeout(() => {
            const messages = document.querySelectorAll('.mb-6');
            messages.forEach(message => {
                if (message.textContent.includes('Connexion réussie') || message.textContent.includes('Les identifiants')) {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(() => message.remove(), 300);
                }
            });
        }, 5000);
    </script>
</body>
</html>
