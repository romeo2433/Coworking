<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    
    protected $primaryKey = 'id_status'; // Spécifier la clé primaire
    public $timestamps = false; // Désactiver `created_at` et `updated_at` si non utilisés


    protected $fillable = ['status'];

   
    public function reservations()
{
    return $this->belongsToMany(Reservation::class, 'status_reservation', 'id_status', 'id_reservation')
                ->withPivot('date_status');
}
public function statusReservations()
{
    return $this->hasMany(\App\Models\StatusReservation::class, 'id_status');
}


}
