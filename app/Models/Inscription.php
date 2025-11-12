<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Inscription extends Model
{
   use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'niveau_id', 
        'date_debut',
        'date_fin',
        'montant_total',
        'montant_verse',
        'reste_a_payer',
        'statut_paiement'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'montant_total' => 'decimal:2',
        'montant_verse' => 'decimal:2',
        'reste_a_payer' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Calculer les jours restants
    public function getJoursRestantsAttribute()
    {
        return now()->diffInDays(Carbon::parse($this->date_fin), false);
    }

    // Accessor pour formater la date de début
    public function getDateDebutFormateeAttribute()
    {
        return Carbon::parse($this->date_debut)->format('d/m/Y');
    }

    // Accessor pour formater la date de fin
    public function getDateFinFormateeAttribute()
    {
        return Carbon::parse($this->date_fin)->format('d/m/Y');
    }
}
