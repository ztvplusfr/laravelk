<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTVPlus - Plateforme de Streaming Gratuite</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen font-sans">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-bg-primary/80 backdrop-blur-xl border-b-2 border-halloween-orange">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('storage/brand/logo.png') }}" alt="ZTVPlus" class="h-12 w-auto">
            </a>
            <ul class="hidden md:flex space-x-8">
                <li><a href="#accueil" class="text-text-primary hover:text-halloween-orange hover:bg-halloween-orange/10 px-4 py-2 rounded-full transition-all duration-300">Accueil</a></li>
                <li><a href="#fonctionnalites" class="text-text-primary hover:text-halloween-orange hover:bg-halloween-orange/10 px-4 py-2 rounded-full transition-all duration-300">Fonctionnalités</a></li>
                <li><a href="#contact" class="text-text-primary hover:text-halloween-orange hover:bg-halloween-orange/10 px-4 py-2 rounded-full transition-all duration-300">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="accueil" class="relative pt-32 pb-20 text-center overflow-hidden bg-bg-primary">
        <!-- Background Effects -->
        <div class="absolute inset-0 bg-gradient-radial from-halloween-orange/5 via-transparent to-transparent"></div>
        <div class="absolute top-20 left-10 w-20 h-20 bg-halloween-orange/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-halloween-purple/10 rounded-full blur-xl animate-pulse delay-1000"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-6xl md:text-7xl font-bold mb-6 text-halloween-orange drop-shadow-2xl animate-fade-in">
                ZTVPlus
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-text-secondary max-w-3xl mx-auto leading-relaxed">
                La plateforme de streaming gratuite disponible partout
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#" class="group bg-gradient-to-r from-halloween-orange to-halloween-yellow text-text-primary px-8 py-4 rounded-full font-semibold text-lg shadow-2xl hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300 border-2 border-halloween-orange">
                    <i class="fas fa-play mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    Commencer maintenant
                </a>
                <a href="{{ route('login') }}" class="group text-text-primary border-2 border-halloween-purple px-8 py-4 rounded-full font-semibold text-lg hover:bg-halloween-purple hover:shadow-lg hover:shadow-halloween-purple/50 transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                    Se connecter
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-20 bg-bg-primary">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-16 text-halloween-orange drop-shadow-lg">
                Pourquoi choisir ZTVPlus ?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">100% Gratuit</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Profitez de tous nos contenus sans aucun abonnement. Aucune carte bancaire requise, aucun engagement.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">Disponible partout</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Accédez à ZTVPlus depuis n'importe quel appareil : smartphone, tablette, ordinateur, smart TV.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">Contenu varié</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Films, séries, documentaires, émissions en direct. Une bibliothèque riche et constamment mise à jour.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">Interface intuitive</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Une expérience utilisateur fluide et moderne. Navigation simple et recherche intelligente.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">Streaming optimisé</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Qualité adaptative selon votre connexion. Streaming fluide même avec une connexion limitée.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group bg-bg-primary p-8 rounded-2xl border border-halloween-orange shadow-2xl hover:shadow-halloween-orange/20 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl text-halloween-orange mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-text-primary">Sécurisé et légal</h3>
                    <p class="text-text-secondary leading-relaxed">
                        Contenu 100% légal et sécurisé. Vos données personnelles sont protégées.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-bg-primary border-t-2 border-b-2 border-halloween-orange">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="group">
                    <h3 class="text-4xl md:text-5xl font-bold text-halloween-orange drop-shadow-lg mb-2 group-hover:scale-110 transition-transform duration-300">
                        1M+
                    </h3>
                    <p class="text-text-secondary text-lg">Utilisateurs actifs</p>
                </div>
                <div class="group">
                    <h3 class="text-4xl md:text-5xl font-bold text-halloween-orange drop-shadow-lg mb-2 group-hover:scale-110 transition-transform duration-300">
                        10K+
                    </h3>
                    <p class="text-text-secondary text-lg">Heures de contenu</p>
                </div>
                <div class="group">
                    <h3 class="text-4xl md:text-5xl font-bold text-halloween-orange drop-shadow-lg mb-2 group-hover:scale-110 transition-transform duration-300">
                        50+
                    </h3>
                    <p class="text-text-secondary text-lg">Pays desservis</p>
                </div>
                <div class="group">
                    <h3 class="text-4xl md:text-5xl font-bold text-halloween-orange drop-shadow-lg mb-2 group-hover:scale-110 transition-transform duration-300">
                        24/7
                    </h3>
                    <p class="text-text-secondary text-lg">Disponibilité</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-bg-primary border-t-2 border-halloween-orange py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo Section -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-halloween-orange drop-shadow-lg mb-4">ZTVPlus</h3>
                    <p class="text-text-secondary leading-relaxed">
                        La plateforme de streaming gratuite qui révolutionne l'accès au divertissement. Disponible partout, pour tous.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold text-halloween-orange drop-shadow-lg mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#accueil" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Accueil</a></li>
                        <li><a href="#fonctionnalites" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Fonctionnalités</a></li>
                        <li><a href="#" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Aide</a></li>
                        <li><a href="#" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Support</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-xl font-bold text-halloween-orange drop-shadow-lg mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-text-muted hover:text-halloween-orange transition-colors duration-300">Mentions légales</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-bold text-halloween-orange drop-shadow-lg mb-4">Contact</h3>
                    <ul class="space-y-2 text-text-muted">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-halloween-orange"></i>
                            contact@ztvplus.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-halloween-orange"></i>
                            +33 1 23 45 67 89
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-halloween-orange"></i>
                            Paris, France
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Social Links -->
            <div class="flex justify-center space-x-4 mb-8">
                <a href="#" class="w-12 h-12 bg-bg-primary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-bg-primary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-bg-primary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-bg-primary border border-halloween-orange text-text-primary rounded-full flex items-center justify-center hover:bg-halloween-orange hover:shadow-lg hover:shadow-halloween-orange/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-bg-tertiary pt-8 text-center">
                <p class="text-text-muted">
                    &copy; 2024 ZTVPlus. Tous droits réservés. Plateforme de streaming gratuite et légale.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation des statistiques au scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('h3');
                    statNumbers.forEach(stat => {
                        const finalNumber = stat.textContent;
                        const isPercentage = finalNumber.includes('%');
                        const isPlus = finalNumber.includes('+');
                        const isSlash = finalNumber.includes('/');
                        
                        let number = finalNumber.replace(/[^\d]/g, '');
                        if (number) {
                            let current = 0;
                            const increment = number / 50;
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= number) {
                                    stat.textContent = finalNumber;
                                    clearInterval(timer);
                                } else {
                                    let displayNumber = Math.floor(current);
                                    if (isPercentage) displayNumber += '%';
                                    if (isPlus) displayNumber += '+';
                                    if (isSlash) displayNumber = finalNumber;
                                    stat.textContent = displayNumber;
                                }
                            }, 30);
                        }
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('section:nth-of-type(3)');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>