<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember') ? true : true; // Toujours se souvenir pour 2 mois

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Configurer la session pour 2 mois
            $request->session()->put('auth.password_confirmed_at', time());
            
            return redirect()->intended('/home')
                ->with('success', 'Connexion réussie ! Bienvenue sur ZTVPlus.');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->withInput($request->except('password'));
    }

    /**
     * Afficher l'étape 1 d'inscription (informations personnelles)
     */
    public function showRegisterStep1()
    {
        return view('auth.register-step1');
    }

    /**
     * Traiter l'étape 1 d'inscription
     */
    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Le nom est requis.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'avatar.max' => 'L\'image ne doit pas dépasser 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            try {
                $supabaseService = new \App\Services\SupabaseStorageService();
                $avatarUrl = $supabaseService->upload(
                    $request->file('avatar'),
                    'avatar-' . time()
                );
                
                if (!$avatarUrl) {
                    throw new \Exception('Échec du téléchargement de l\'avatar.');
                }
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'upload de l\'avatar: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Une erreur est survenue lors du téléchargement de l\'avatar. Veuillez réessayer.')
                    ->withInput();
            }
        }

        // Stocker les données de l'étape 1 en session
        $step1Data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        if ($avatarUrl) {
            $step1Data['avatar_url'] = $avatarUrl;
        }
        
        $request->session()->put('register_step1', $step1Data);

        return redirect()->route('register.step2');
    }

    /**
     * Afficher l'étape 2 d'inscription (mot de passe et conditions)
     */
    public function showRegisterStep2(Request $request)
    {
        // Vérifier que l'étape 1 a été complétée
        if (!$request->session()->has('register_step1')) {
            return redirect()->route('register.step1')
                ->with('error', 'Veuillez d\'abord compléter l\'étape 1.');
        }

        $step1Data = $request->session()->get('register_step1');
        return view('auth.register-step2', compact('step1Data'));
    }

    /**
     * Traiter l'étape 2 d'inscription et créer le compte
     */
    public function processStep2(Request $request)
    {
        // Vérifier que l'étape 1 a été complétée
        if (!$request->session()->has('register_step1')) {
            return redirect()->route('register.step1')
                ->with('error', 'Veuillez d\'abord compléter l\'étape 1.');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'terms.required' => 'Vous devez accepter les conditions d\'utilisation.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Récupérer les données de l'étape 1
        $step1Data = $request->session()->get('register_step1');

        // Créer l'utilisateur
        $userData = [
            'name' => $step1Data['name'],
            'email' => $step1Data['email'],
            'password' => Hash::make($request->password),
        ];
        
        if (isset($step1Data['avatar_url'])) {
            $userData['avatar'] = $step1Data['avatar_url'];
        }
        
        $user = User::create($userData);

        // Nettoyer la session
        $request->session()->forget('register_step1');

        // Ne pas connecter automatiquement, rediriger vers login
        return redirect()->route('login')
            ->with('success', 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
