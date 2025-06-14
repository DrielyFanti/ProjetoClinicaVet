<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Consulta Veterinária',
                'price' => 150.00,
                'description' => 'Consulta com veterinário para avaliação geral do animal',
                'is_active' => true
            ],
            [
                'name' => 'Vacinação',
                'price' => 80.00,
                'description' => 'Aplicação de vacinas',
                'is_active' => true
            ],
            [
                'name' => 'Banho e Tosa',
                'price' => 60.00,
                'description' => 'Banho, tosa e higienização do animal',
                'is_active' => true
            ],
            [
                'name' => 'Cirurgia',
                'price' => 500.00,
                'description' => 'Procedimento cirúrgico',
                'is_active' => true
            ],
            [
                'name' => 'Exame de Sangue',
                'price' => 120.00,
                'description' => 'Coleta e análise de sangue',
                'is_active' => true
            ],
            [
                'name' => 'Raio-X',
                'price' => 200.00,
                'description' => 'Exame de imagem',
                'is_active' => true
            ],
            [
                'name' => 'Ultrassonografia',
                'price' => 300.00,
                'description' => 'Exame de imagem detalhado',
                'is_active' => true
            ],
            [
                'name' => 'Dentista',
                'price' => 250.00,
                'description' => 'Limpeza e tratamento dentário',
                'is_active' => true
            ],
            [
                'name' => 'Fisioterapia',
                'price' => 180.00,
                'description' => 'Sessão de fisioterapia',
                'is_active' => true
            ],
            [
                'name' => 'Internação',
                'price' => 150.00,
                'description' => 'Diária de internação',
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
