<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Animal;
use App\Models\Species;
use App\Models\Breed;
use App\Models\Tutor;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            [
                'name' => 'Rex',
                'tutor_id' => 1,
                'species_id' => 1, // Cachorro
                'breed_id' => 1, // Labrador
                'birth_date' => '2020-01-01',
                'weight' => 25.5,
                'is_active' => true,
                'notes' => 'Cachorro muito brincalhão e dócil'
            ],
            [
                'name' => 'Mingau',
                'tutor_id' => 2,
                'species_id' => 2, // Gato
                'breed_id' => 11, // Siamês
                'birth_date' => '2021-03-15',
                'weight' => 4.2,
                'is_active' => true,
                'notes' => 'Gato muito carinhoso e tranquilo'
            ],
            [
                'name' => 'Pipoca',
                'tutor_id' => 3,
                'species_id' => 3, // Ave
                'breed_id' => 21, // Calopsita
                'birth_date' => '2022-05-20',
                'weight' => 0.3,
                'is_active' => true,
                'notes' => 'Calopsita muito cantora'
            ],
            [
                'name' => 'Bolinha',
                'tutor_id' => 4,
                'species_id' => 4, // Coelho
                'breed_id' => 31, // Holandês
                'birth_date' => '2021-08-10',
                'weight' => 2.5,
                'is_active' => true,
                'notes' => 'Coelho muito ativo'
            ],
            [
                'name' => 'Nemo',
                'tutor_id' => 5,
                'species_id' => 8, // Peixe
                'breed_id' => 81, // Betta
                'birth_date' => '2023-01-15',
                'weight' => 0.05,
                'is_active' => true,
                'notes' => 'Peixe muito colorido'
            ],
            [
                'name' => 'Thor',
                'tutor_id' => 1,
                'species_id' => 1, // Cachorro
                'breed_id' => 5, // Pastor Alemão
                'birth_date' => '2019-11-30',
                'weight' => 35.0,
                'is_active' => true,
                'notes' => 'Cachorro muito protetor'
            ],
            [
                'name' => 'Luna',
                'tutor_id' => 2,
                'species_id' => 2, // Gato
                'breed_id' => 12, // Persa
                'birth_date' => '2020-07-22',
                'weight' => 5.0,
                'is_active' => true,
                'notes' => 'Gato muito peludo e calmo'
            ],
            [
                'name' => 'Pipoca',
                'tutor_id' => 3,
                'species_id' => 5, // Hamster
                'breed_id' => 41, // Sírio
                'birth_date' => '2023-02-28',
                'weight' => 0.1,
                'is_active' => true,
                'notes' => 'Hamster muito ativo à noite'
            ],
            [
                'name' => 'Tartaruga',
                'tutor_id' => 4,
                'species_id' => 7, // Tartaruga
                'breed_id' => 61, // Tigre d\'água
                'birth_date' => '2020-04-15',
                'weight' => 1.2,
                'is_active' => true,
                'notes' => 'Tartaruga muito dócil'
            ],
            [
                'name' => 'Bolinha',
                'tutor_id' => 5,
                'species_id' => 6, // Porquinho da Índia
                'breed_id' => 51, // Inglês
                'birth_date' => '2022-09-10',
                'weight' => 0.8,
                'is_active' => true,
                'notes' => 'Porquinho muito carinhoso'
            ]
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
