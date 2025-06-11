<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kierunek;
use App\Models\Kandydat;
use App\Models\Kandydatura;

class KierunekSeeder extends Seeder
{
    public function run()
    {
        $kierunki = [
            [
                'nazwa' => 'Informatyka',
                'opis' => 'Kierunek kształcący specjalistów w dziedzinie technologii informatycznych, programowania i systemów komputerowych.',
                'liczba_miejsc' => 120,
                'prog_punktowy' => 85.50,
                'aktywny' => true
            ],
            [
                'nazwa' => 'Zarządzanie',
                'opis' => 'Studia przygotowujące do pracy w obszarze zarządzania przedsiębiorstwem i organizacjami.',
                'liczba_miejsc' => 80,
                'prog_punktowy' => 75.00,
                'aktywny' => true
            ],
            [
                'nazwa' => 'Psychologia',
                'opis' => 'Kierunek kształcący psychologów w różnych specjalizacjach.',
                'liczba_miejsc' => 60,
                'prog_punktowy' => 88.00,
                'aktywny' => true
            ],
            [
                'nazwa' => 'Budownictwo',
                'opis' => 'Studia techniczne przygotowujące inżynierów budownictwa.',
                'liczba_miejsc' => 90,
                'prog_punktowy' => 78.50,
                'aktywny' => true
            ],
            [
                'nazwa' => 'Filologia Angielska',
                'opis' => 'Studia językoznawcze i literaturoznawcze z języka angielskiego.',
                'liczba_miejsc' => 50,
                'prog_punktowy' => 82.00,
                'aktywny' => true
            ]
        ];

        $zdjecia = [
    'Informatyka' => 'kierunki/informatyka.jpg',
    'Zarządzanie' => 'kierunki/zarzadzanie.jpg', 
    'Psychologia' => 'kierunki/psychologia.jpg',
    'Budownictwo' => 'kierunki/budownictwo.jpg',
    'Filologia Angielska' => 'kierunki/filologia.jpg'
];

foreach ($kierunki as $kierunek) {
    if (isset($zdjecia[$kierunek['nazwa']])) {
        $kierunek['zdjecie'] = $zdjecia[$kierunek['nazwa']];
    }
    Kierunek::create($kierunek);
}
    }
}