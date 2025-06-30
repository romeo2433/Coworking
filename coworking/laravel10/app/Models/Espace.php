<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espace extends Model
{
    // Assurez-vous que le nom de la table est bien 'espaces'
    protected $table = 'espace'; // Table au pluriel, comme tu l'as mentionné

    // Si la clé primaire n'est pas 'id', tu dois la spécifier :
    protected $primaryKey = 'id_espace'; // Si ce n'est pas 'id'

    // Pas de timestamps (si tu n'utilises pas les champs created_at et updated_at)
    public $timestamps = false;

    // Définir les attributs mass-assignables
    protected $fillable = ['nom', 'prix_heure'];
}
