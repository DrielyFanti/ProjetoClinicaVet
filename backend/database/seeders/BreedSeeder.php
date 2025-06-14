<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Breed;
use App\Models\Species;

class BreedSeeder extends Seeder
{
    public function run(): void
    {
        $breedsData = [
            'Cachorro' => [
                'Labrador Retriever',
                'Golden Retriever',
                'Bulldog',
                'Poodle',
                'Pastor Alemão',
                'Rottweiler',
                'Yorkshire Terrier',
                'Shih Tzu',
                'Pug',
                'Beagle',
                'Dachshund',
                'Boxer',
                'Chihuahua',
                'Husky Siberiano',
                'Doberman'
            ],
            'Gato' => [
                'Siamês',
                'Persa',
                'Maine Coon',
                'Sphynx',
                'Ragdoll',
                'Bengala',
                'Abissínio',
                'Birmanês',
                'Munchkin',
                'Siberiano'
            ],
            'Ave' => [
                'Canário',
                'Periquito',
                'Calopsita',
                'Agapornis',
                'Papagaio',
                'Cacatua',
                'Mandarim',
                'Diamante Gould',
                'Ring Neck',
                'Forpus'
            ],
            'Coelho' => [
                'Holandês',
                'Angorá',
                'Rex',
                'Mini Lop',
                'Holland Lop',
                'Netherland Dwarf',
                'Lionhead',
                'Fuzzy Lop',
                'Mini Rex',
                'Jersey Wooly'
            ],
            'Hamster' => [
                'Sírio',
                'Anão Russo',
                'Roborovski',
                'Chinês',
                'Campbell',
                'Winter White',
                'Teddy Bear',
                'Panda',
                'Albino',
                'Dourado'
            ],
            'Porquinho da Índia' => [
                'Inglês',
                'Abissínio',
                'Peruano',
                'Coronet',
                'Sheba',
                'Texel',
                'Silkie',
                'Teddy',
                'Alpaca',
                'Merino'
            ],
            'Tartaruga' => [
                'Tigre d\'água',
                'Vermelha',
                'Pintada',
                'Cabeçuda',
                'Oliva',
                'Verde',
                'Couro',
                'Caretta',
                'Kemp\'s Ridley',
                'Hawksbill'
            ],
            'Peixe' => [
                'Betta',
                'Kinguio',
                'Tetra',
                'Molinésia',
                'Platy',
                'Espada',
                'Acará',
                'Discus',
                'Koi',
                'Neon'
            ]
        ];

        foreach ($breedsData as $speciesName => $breeds) {
            $species = Species::where('name', $speciesName)->first();
            
            if ($species) {
                foreach ($breeds as $breedName) {
                    Breed::create([
                        'name' => $breedName,
                        'species_id' => $species->id,
                        'is_active' => true
                    ]);
                }
            }
        }
    }
}
