# Projet Laravel avec TailwindCSS v4

Ce projet Laravel est configuré avec Vite et TailwindCSS v4.

## 🚀 Technologies utilisées

- **Laravel 12** - Framework PHP moderne
- **Vite 5.4** - Build tool rapide et moderne (compatible Node.js 18+)
- **TailwindCSS v4** - Framework CSS utilitaire de nouvelle génération
- **Node.js 18+** - Runtime JavaScript

## 📦 Installation

1. **Installer les dépendances PHP :**
   ```bash
   composer install
   ```

2. **Installer les dépendances Node.js :**
   ```bash
   npm install
   ```

3. **Configurer l'environnement :**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Construire les assets :**
   ```bash
   npm run build
   ```

## ⚠️ Compatibilité Node.js

Ce projet utilise **Vite 5.4** qui est compatible avec **Node.js 18+**. Si vous rencontrez des problèmes avec Vite 7, les versions ont été ajustées pour une meilleure compatibilité.

## 🔧 Résolution des problèmes

### Problème de base de données SQLite
Si vous rencontrez l'erreur `could not find driver (Connection: sqlite)`, le projet est configuré pour utiliser le système de fichiers pour les sessions au lieu de la base de données :

- **Sessions** : `SESSION_DRIVER=file`
- **Cache** : `CACHE_STORE=file`  
- **Queue** : `QUEUE_CONNECTION=sync`

Cette configuration évite les problèmes de driver SQLite tout en gardant l'application fonctionnelle.

## 🛠️ Commandes de développement

- **Démarrer le serveur de développement :**
  ```bash
  npm run dev
  ```

- **Construire pour la production :**
  ```bash
  npm run build
  ```

- **Démarrer le serveur Laravel :**
  ```bash
  php artisan serve
  ```

## 🎨 TailwindCSS v4

Ce projet utilise TailwindCSS v4 avec les nouvelles fonctionnalités :

- **Configuration simplifiée** avec `@import 'tailwindcss'`
- **Nouvelles directives** `@source` pour le scan automatique
- **Thème personnalisé** avec `@theme`
- **Support natif** des modes sombre/clair
- **Optimisations** de performance intégrées

## 📁 Structure du projet

```
├── resources/
│   ├── css/
│   │   └── app.css          # Fichier CSS principal avec TailwindCSS v4
│   ├── js/
│   │   └── app.js           # Fichier JavaScript principal
│   └── views/
│       └── welcome.blade.php # Page d'accueil avec exemples TailwindCSS
├── vite.config.js           # Configuration Vite
└── package.json            # Dépendances Node.js
```

## 🔧 Configuration

### Vite (vite.config.js)
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### TailwindCSS v4 (resources/css/app.css)
```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
}
```

## 🌟 Fonctionnalités

- ✅ Laravel 12 avec toutes les dernières fonctionnalités
- ✅ Vite 7 pour un build ultra-rapide
- ✅ TailwindCSS v4 avec les nouvelles fonctionnalités
- ✅ Support du mode sombre natif
- ✅ Configuration optimisée pour le développement
- ✅ Hot reload avec Vite
- ✅ Optimisations automatiques

## 📝 Notes

- Le projet utilise Node.js 18+ (recommandé 20+ pour Vite 7)
- TailwindCSS v4 est encore en version alpha/beta
- La configuration est optimisée pour le développement et la production

## 🚀 Démarrage rapide

1. Clonez le projet
2. `composer install && npm install`
3. `cp .env.example .env && php artisan key:generate`
4. `npm run dev` (dans un terminal)
5. `php artisan serve` (dans un autre terminal)
6. Ouvrez http://localhost:8000

Profitez de votre nouveau projet Laravel avec TailwindCSS v4 ! 🎉