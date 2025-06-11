<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandydatura;
use App\Models\Kandydat;
use App\Models\Kierunek;
use Faker\Factory as Faker;

class KandydaturaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $kandydats = Kandydat::all();
        $kieruneks = Kierunek::all();

        // Utwórz kandydatury dla pierwszych kandydatów (przykładowe)
        if ($kandydats->count() >= 3 && $kieruneks->count() >= 3) {
            Kandydatura::create([
                'kandydat_id' => 1,
                'kierunek_id' => 1, // Informatyka
                'status' => 'zaakceptowana',
                'punkty_rekrutacyjne' => 92.50,
                'uwagi' => 'Bardzo dobry kandydat z wysokimi ocenami.',
                'data_zlozenia' => now()->subDays(30)
            ]);

            Kandydatura::create([
                'kandydat_id' => 2,
                'kierunek_id' => 2, // Zarządzanie
                'status' => 'oczekujaca',
                'punkty_rekrutacyjne' => null,
                'uwagi' => null,
                'data_zlozenia' => now()->subDays(15)
            ]);

            Kandydatura::create([
                'kandydat_id' => 3,
                'kierunek_id' => 3, // Psychologia
                'status' => 'zaakceptowana',
                'punkty_rekrutacyjne' => 95.00,
                'uwagi' => 'Kandydat celujący, zalecany do przyjęcia.',
                'data_zlozenia' => now()->subDays(25)
            ]);
        }

        // Dodaj losowe kandydatury
        $usedCombinations = [];
        for ($i = 0; $i < 30; $i++) {
            do {
                $kandydat_id = $kandydats->random()->id;
                $kierunek_id = $kieruneks->random()->id;
                $combination = $kandydat_id . '-' . $kierunek_id;
            } while (in_array($combination, $usedCombinations));
            
            $usedCombinations[] = $combination;
            
            $status = $faker->randomElement(['oczekujaca', 'zaakceptowana', 'odrzucona']);
            $punkty = $status === 'oczekujaca' ? null : $faker->randomFloat(2, 60, 100);
            
            Kandydatura::create([
                'kandydat_id' => $kandydat_id,
                'kierunek_id' => $kierunek_id,
                'status' => $status,
                'punkty_rekrutacyjne' => $punkty,
                'uwagi' => $faker->optional(0.3)->sentence,
                'data_zlozenia' => $faker->dateTimeBetween('-60 days', 'now')
            ]);
        }
    }
}