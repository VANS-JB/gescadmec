<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;


class Besoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'description',
        'date_soumission',
        'statut'
    ];

    protected $casts = [
        'date_soumission' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Accessor pour formater la date de soumission
    public function getDateSoumissionFormateeAttribute()
    {
        return Carbon::parse($this->date_soumission)->format('d/m/Y');
    }

    // Accessor pour la date en format input
    public function getDateSoumissionInputAttribute()
    {
        return Carbon::parse($this->date_soumission)->format('Y-m-d');
    }
}
