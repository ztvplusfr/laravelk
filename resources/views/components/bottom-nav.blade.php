<!-- Phosphor Icons -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css">

<!-- Bottom Navigation Bar (Mobile) -->
<nav class="bottom-nav" id="bottomNav">
    <div class="bottom-nav-container" id="bottomNavContainer">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="ph ph-house-simple"></i>
        </a>
        
        <a href="{{ route('movies') }}" class="bottom-nav-item {{ request()->routeIs('movies') ? 'active' : '' }}">
            <i class="fas fa-film"></i>
        </a>
        
        <a href="{{ route('series') }}" class="bottom-nav-item {{ request()->routeIs('series') ? 'active' : '' }}">
            <i class="fas fa-tv"></i>
        </a>
        
        <a href="{{ route('watchlist') }}" class="bottom-nav-item {{ request()->routeIs('watchlist') ? 'active' : '' }}">
            <i class="fas fa-bookmark"></i>
        </a>
        
        <a href="{{ route('account') }}" class="bottom-nav-item {{ request()->routeIs('account') ? 'active' : '' }}">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="bottom-nav-avatar">
            @else
                <div class="bottom-nav-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </a>
    </div>
</nav>

<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        display: none;
        padding: 0;
        width: 100%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @media (max-width: 768px) {
        .bottom-nav {
            display: flex;
            justify-content: center;
        }
    }
    
    .bottom-nav-container {
        background: rgba(0, 0, 0, 0.98);
        backdrop-filter: blur(20px);
        border-top: 2px solid rgba(249, 115, 22, 0.3);
        border-radius: 0;
        padding: 12px 20px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom));
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.5),
                    0 0 0 1px rgba(249, 115, 22, 0.1);
        transition: box-shadow 0.3s ease;
        width: 100%;
        max-width: 100%;
    }
    
    .bottom-nav-container:hover {
        box-shadow: 0 -12px 45px rgba(0, 0, 0, 0.6),
                    0 0 0 1px rgba(249, 115, 22, 0.2);
    }
    
    .bottom-nav-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 18px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        color: rgba(229, 231, 235, 0.6);
        text-decoration: none;
        flex: 0 1 auto;
        min-width: 48px;
        max-width: 80px;
    }
    
    .bottom-nav-item i {
        font-size: 24px;
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    /* Padding spécifique pour l'item avatar */
    .bottom-nav-item:has(.bottom-nav-avatar),
    .bottom-nav-item:has(.bottom-nav-avatar-placeholder) {
        padding: 6px 10px;
        flex: 0 0 auto;
    }
    
    .bottom-nav-item:hover,
    .bottom-nav-item.active {
        color: #f97316;
        background: rgba(249, 115, 22, 0.1);
    }
    
    .bottom-nav-item:hover i {
        transform: scale(1.15) rotate(5deg);
    }
    
    .bottom-nav-item.active i {
        transform: scale(1.1);
        animation: pulse 1.5s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1.1);
        }
        50% {
            transform: scale(1.15);
        }
    }
    
    .bottom-nav-avatar {
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
        max-width: 36px;
        max-height: 36px;
        border-radius: 50%;
        border: 2px solid rgba(249, 115, 22, 0.5);
        object-fit: cover;
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        flex-shrink: 0;
        display: block;
        aspect-ratio: 1 / 1;
    }
    
    .bottom-nav-avatar-placeholder {
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
        max-width: 36px;
        max-height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(249, 115, 22, 0.5);
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        flex-shrink: 0;
        aspect-ratio: 1 / 1;
    }
    
    .bottom-nav-avatar-placeholder i {
        font-size: 18px;
        color: #fff;
        transition: all 0.2s ease;
    }
    
    .bottom-nav-item:hover .bottom-nav-avatar,
    .bottom-nav-item.active .bottom-nav-avatar {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3);
        transform: scale(1.1) rotate(5deg);
    }
    
    .bottom-nav-item:hover .bottom-nav-avatar-placeholder,
    .bottom-nav-item.active .bottom-nav-avatar-placeholder {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3);
        transform: scale(1.1) rotate(5deg);
    }
    
    .bottom-nav-item:hover .bottom-nav-avatar-placeholder i {
        transform: scale(1.2);
    }
    
    /* Animations d'apparition */
    @keyframes slideUp {
        0% {
            opacity: 0;
            transform: translateY(100%);
        }
        60% {
            transform: translateY(-5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .bottom-nav {
        animation: slideUp 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    /* Animation lors du hover sur les items */
    .bottom-nav-item:hover {
        transform: translateY(-2px);
    }
    
    .bottom-nav-item:active {
        transform: translateY(0) scale(0.95);
    }
    
    .bottom-nav-item.active {
        animation: scaleIn 0.3s ease-out;
    }
    
    /* Empêcher le contenu de passer sous la bottom nav */
    @media (max-width: 768px) {
        body {
            padding-bottom: 80px;
        }
    }
</style>
