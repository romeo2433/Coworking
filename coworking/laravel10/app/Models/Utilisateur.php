<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateur'; // Nom de la table
    protected $primaryKey = 'id_utilisateur'; // Nom de la clé primaire
    public $timestamps = false; // Si tu ne veux pas de timestamps

    protected $fillable = ['email','mdp','numero', 'id_profil'];

    protected $hidden = ['mdp'];


    public function getAuthPassword()
    {
        return $this->mdp;
    }
}
