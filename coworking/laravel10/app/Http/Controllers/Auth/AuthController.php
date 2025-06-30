<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

   
public function login(Request $request)
{
    $request->validate([
        'numero' => 'required|string|max:100'
    ]);

    // Vérifier si l'utilisateur existe
    $utilisateur = \App\Models\Utilisateur::where('numero', $request->numero)->first();

    if (!$utilisateur) {
        // Créer un nouvel utilisateur avec id_profil = 2 (Client)
        $utilisateur = \App\Models\Utilisateur::create([
            'numero' => $request->numero,
            'id_profil' => 2
        ]);
    }

    // Connecter l'utilisateur
    Auth::login($utilisateur);

    if (Auth::check()) {
        return redirect()->route('dashboard')->with('success', 'Connexion réussie !');
    } else {
        return back()->with('error', 'Échec de l\'authentification.');
    }
}
    
    

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie !');
    }
}
