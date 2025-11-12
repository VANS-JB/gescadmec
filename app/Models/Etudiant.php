<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
   use HasFactory;

    protected $fillable = [
        'nom', 
        'prenom', 
        'email', 
        'telephone', 
        'adresse'
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function besoins()
    {
        return $this->hasMany(Besoin::class);
    }
}
