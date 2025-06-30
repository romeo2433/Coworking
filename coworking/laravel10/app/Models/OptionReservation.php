<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OptionReservation extends Pivot
{
    protected $table = 'option_reservation'; // Nom exact de la table

    protected $primaryKey = null; // Pas de clé primaire auto-incrémentée

    public $incrementing = false; // Désactiver l'auto-incrémentation de l'ID

    public $timestamps = false; // Désactiver les timestamps (created_at, updated_at)

    protected $fillable = ['id_option', 'id_reservation'];

    // Relation avec l'option
    public function option()
    {
        return $this->belongsTo(Option::class, 'id_option');
    }

    // Relation avec la réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation');
    }
}
