<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $table = 'option';
    protected $primaryKey = 'id_option';
    public $timestamps = false;

    protected $fillable = ['nom', 'prix','code','option'];


    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'option_reservation', 'id_option', 'id_reservation');
    }
    
}
