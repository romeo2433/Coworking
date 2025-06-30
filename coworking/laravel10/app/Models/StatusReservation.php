<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusReservation extends Model
{
    protected $table = 'status_reservation';

    protected $primaryKey =null;

    public $incrementing = false; // Active l'auto-incrémentation si la table a un ID unique

    public $timestamps = false;

    protected $fillable = ['id_reservation', 'id_status', 'date_status'];

    // Relation avec la réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation');
    }
    
    // Relation avec le statut
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status', 'id_status');
    }
}
