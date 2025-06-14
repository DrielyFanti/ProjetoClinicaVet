<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Species;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $species = [
            [
                'name' => 'Cachorro',
                'description' => 'Canis lupus familiaris',
                'is_active' => true
            ],
            [
                'name' => 'Gato',
                'description' => 'Felis catus',
                'is_active' => true
            ],
            [
                'name' => 'Ave',
                'description' => 'Aves em geral',
                'is_active' => true
            ],
            [
                'name' => 'Coelho',
                'description' => 'Oryctolagus cuniculus',
                'is_active' => true
            ],
            [
                'name' => 'Hamster',
                'description' => 'Cricetinae',
                'is_active' => true
            ],
            [
                'name' => 'Porquinho da Índia',
                'description' => 'Cavia porcellus',
                'is_active' => true
            ],
            [
                'name' => 'Tartaruga',
                'description' => 'Testudines',
                'is_active' => true
            ],
            [
                'name' => 'Peixe',
                'description' => 'Peixes ornamentais',
                'is_active' => true
            ]
        ];

        foreach ($species as $specie) {
            Species::create($specie);
        }
    }
} 