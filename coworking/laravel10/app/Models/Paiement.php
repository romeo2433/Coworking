<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiement';
    protected $primaryKey = 'id_paiement';
    public $timestamps = false;

    protected $fillable = [
        'reference',
        'date_paiement',
        'id_reservation',
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    // Relation avec la réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation', 'id_reservation');
    }

    public static function rules()
    {
        return [
            'reference' => 'required|string|max:100|unique:paiements',
            'date_paiement' => 'required|date',
            'id_reservation' => 'required|exists:reservations,id_reservation',
        ];
    }
}