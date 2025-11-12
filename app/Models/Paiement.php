<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'montant',
        'date_paiement',
        'methode_paiement'
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    // Accessor pour formater la date de paiement
    public function getDatePaiementFormateeAttribute()
    {
        return Carbon::parse($this->date_paiement)->format('d/m/Y');
    }

    // Accessor pour la date en format input
    public function getDatePaiementInputAttribute()
    {
        return Carbon::parse($this->date_paiement)->format('Y-m-d');
    }
}
