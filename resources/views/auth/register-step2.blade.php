<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Étape 2 - ZTVPlus</title>
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
                    <div class="w-8 h-8 bg-halloween-green rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-text-primary text-sm"></i>
                    </div>
                    <span class="ml-2 text-halloween-green font-semibold">Informations</span>
                </div>
                <div class="w-16 h-1 bg-halloween-orange rounded-full"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-halloween-orange rounded-full flex items-center justify-center">
                        <span class="text-text-primary font-bold">2</span>
                    </div>
                    <span class="ml-2 text-halloween-orange font-semibold">Sécurité</span>
                </div>
            </div>
        </div>

        <!-- Register Step 2 Card -->
        <div class="bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 transition-all duration-300">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-text-primary mb-2">Étape 2/2</h1>
                <p class="text-text-secondary">Sécurisez votre compte</p>
            </div>

            <!-- User Info Display -->
            <div class="mb-6 p-4 bg-bg-secondary rounded-lg border border-halloween-green">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        @if(isset($step1Data['avatar_url']) && $step1Data['avatar_url'])
                            <img src="{{ $step1Data['avatar_url'] }}" alt="Avatar" class="w-12 h-12 rounded-full border-2 border-halloween-orange object-cover">
                        @else
                            <div class="w-12 h-12 bg-halloween-orange rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-text-primary"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-text-primary font-semibold">{{ $step1Data['name'] }}</p>
                            <p class="text-text-secondary text-sm">{{ $step1Data['email'] }}</p>
                        </div>
                    </div>
                    <i class="fas fa-user-check text-halloween-green text-2xl"></i>
                </div>
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

            <!-- Register Step 2 Form -->
            <form method="POST" action="{{ route('register.step2.process') }}" class="space-y-6">
                @csrf
                
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
                            placeholder="Minimum 8 caractères"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password')" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300"
                        >
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-text-muted text-sm mt-1">Le mot de passe doit contenir au moins 8 caractères</p>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-text-primary font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-halloween-orange"></i>
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full px-4 py-3 bg-bg-secondary border border-halloween-orange rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-halloween-orange focus:border-transparent transition-all duration-300 pr-12"
                            placeholder="Confirmez votre mot de passe"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation')" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300"
                        >
                            <i id="password_confirmation-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        class="mr-3 mt-1 text-halloween-orange focus:ring-halloween-orange rounded"
                        required
                    >
                    <label for="terms" class="text-text-secondary text-sm">
                        J'accepte les 
                        <a href="#" class="text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300">
                            conditions d'utilisation
                        </a> 
                        et la 
                        <a href="#" class="text-halloween-orange hover:text-halloween-orange-light transition-colors duration-300">
                            politique de confidentialité
                        </a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary py-3 px-6 rounded-lg font-semibold text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300 border-2 border-halloween-orange"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer mon compte
                </button>
            </form>

            <!-- Back to Step 1 -->
            <div class="mt-6 text-center">
                <a href="{{ route('register.step1') }}" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à l'étape 1
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-text-muted">
            <p>&copy; 2024 ZTVPlus. Plateforme de streaming gratuite et légale.</p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordIcon = document.getElementById(fieldId + '-icon');
            
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
                if (message.textContent.includes('Compte créé') || message.textContent.includes('Veuillez d\'abord')) {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(() => message.remove(), 300);
                }
            });
        }, 5000);

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            updatePasswordStrength(strength);
        });

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }

        function updatePasswordStrength(strength) {
            // You can add a visual strength indicator here if needed
            console.log('Password strength:', strength);
        }
    </script>
</body>
</html>
