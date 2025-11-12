<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Niveau;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            ['nom' => 'Débutant A1', 'prix_total' => 500000],
            ['nom' => 'Élémentaire A2', 'prix_total' => 600000],
            ['nom' => 'Intermédiaire B1', 'prix_total' => 700000],
            ['nom' => 'Intermédiaire Supérieur B2', 'prix_total' => 800000],
            ['nom' => 'Avancé C1', 'prix_total' => 900000],
            ['nom' => 'Maîtrise C2', 'prix_total' => 1000000],
        ];

        foreach ($niveaux as $niveau) {
            Niveau::create($niveau);
        }
    }
}
