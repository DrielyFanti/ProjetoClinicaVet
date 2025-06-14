<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'zip_code' => '01234-567',
                'is_active' => true
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
                'zip_code' => '04567-890',
                'is_active' => true
            ],
            [
                'name' => 'Pedro Oliveira',
                'cpf' => '456.789.123-00',
                'email' => 'pedro@email.com',
                'phone' => '(11) 97777-7777',
                'whatsapp' => '(11) 97777-7777',
                'address' => 'Rua C, 789',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '07890-123',
                'is_active' => true
            ],
            [
                'name' => 'Ana Costa',
                'cpf' => '789.123.456-00',
                'email' => 'ana@email.com',
                'phone' => '(11) 96666-6666',
                'whatsapp' => '(11) 96666-6666',
                'address' => 'Rua D, 321',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '03210-987',
                'is_active' => true
            ],
            [
                'name' => 'Carlos Souza',
                'cpf' => '321.654.987-00',
                'email' => 'carlos@email.com',
                'phone' => '(11) 95555-5555',
                'whatsapp' => '(11) 95555-5555',
                'address' => 'Rua E, 654',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '06540-321',
                'is_active' => true
            ]
        ];

        foreach ($tutors as $tutor) {
            Tutor::create($tutor);
        }
    }
}
