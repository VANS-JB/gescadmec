<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix_total'];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
