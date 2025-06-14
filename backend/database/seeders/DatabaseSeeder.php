<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Species;
use App\Models\Tutor;
use App\Models\Animal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário padrão
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@vetclinic.com',
            'password' => bcrypt('password')
        ]);

        // Criar espécies
        $species = [
            ['name' => 'Cachorro', 'description' => 'Canis lupus familiaris'],
            ['name' => 'Gato', 'description' => 'Felis catus'],
            ['name' => 'Ave', 'description' => 'Aves em geral'],
        ];

        foreach ($species as $specie) {
            Species::create($specie);
        }

        // Criar tutores
        $tutors = [
            [
                'name' => 'João Silva',
                'cpf' => '123.456.789-00',
                'email' => 'joao@email.com',
                'phone' => '(11) 99999-9999',
                'whatsapp' => '(11) 99999-9999',
                'address' => 'Rua A, 123',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01234-567'
            ],
            [
                'name' => 'Maria Santos',
                'cpf' => '987.654.321-00',
                'email' => 'maria@email.com',
                'phone' => '(11) 98888-8888',
                'whatsapp' => '(11) 98888-8888',
                'address' => 'Rua B, 456',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '04567-890'
            ]
        ];

        foreach ($tutors as $tutor) {
            Tutor::create($tutor);
        }

        // Criar animais
        $animals = [
            [
                'name' => 'Rex',
                'species_id' => 1,
                'tutor_id' => 1,
                'birth_date' => '2020-01-01',
                'gender' => 'male',
                'weight' => 25.5,
                'color' => 'Preto',
                'notes' => 'Cachorro muito brincalhão'
            ],
            [
                'name' => 'Mingau',
                'species_id' => 2,
                'tutor_id' => 2,
                'birth_date' => '2021-03-15',
                'gender' => 'female',
                'weight' => 4.2,
                'color' => 'Branco',
                'notes' => 'Gato muito carinhoso'
            ]
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }

        // Executar seeders na ordem correta
        $this->call([
            SpeciesSeeder::class,    // Primeiro as espécies
            BreedSeeder::class,      // Depois as raças
            TutorSeeder::class,      // Depois os tutores
            AnimalSeeder::class,     // Depois os animais
            ServiceSeeder::class,    // Por fim os serviços
        ]);
    }
}
