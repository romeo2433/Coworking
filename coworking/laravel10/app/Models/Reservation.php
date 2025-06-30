<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

     protected $table = 'reservation';
    protected $primaryKey = 'id_reservation'; // Clé primaire

    protected $fillable = [
        'reference',
        'date_reservation',
        'heure_debut',
        'duree',
        'total',
        'id_espace',
        'id_utilisateur',
    ];
    public $timestamps = false;
    public function espace()
    {
        return $this->belongsTo(Espace::class, 'id_espace', 'id_espace');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function status()
{
    return $this->belongsTo(Status::class, 'id_status', 'id_status');
}

    public function options()
{
    return $this->belongsToMany(Option::class, 'option_reservation', 'id_reservation', 'id_option');
}

public function statuses()
{
    return $this->belongsToMany(Status::class, 'status_reservation', 'id_reservation', 'id_status')
                ->withPivot('date_status') // Inclure la date du statut
                ->orderBy('date_status', 'desc'); // Trier par date décroissante
}
// Dans le modèle Reservation
public function statusReservations()
{
    return $this->hasMany(StatusReservation::class, 'id_reservation');
}
public function paiement()
{
    return $this->hasOne(Paiement::class, 'id_reservation');
}



}
