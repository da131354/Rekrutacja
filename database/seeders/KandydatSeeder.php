<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandydat;
use App\Models\Kandydatura;
use Faker\Factory as Faker;

class KandydatSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pl_PL');
        
        $kandydaci = [
            [
                'imie' => 'Anna',
                'nazwisko' => 'Kowalska',
                'pesel' => '98010112345',
                'email' => 'anna.kowalska@email.com',
                'telefon' => '+48123456789',
                'adres' => 'ul. Główna 15, 35-001 Rzeszów',
                'data_urodzenia' => '1998-01-01',
                'plec' => 'K',
                'szkola_srednia' => 'I Liceum Ogólnokształcące w Rzeszowie',
                'srednia_ocen' => 4.75
            ],
            [
                'imie' => 'Piotr',
                'nazwisko' => 'Nowak',
                'pesel' => '99050523456',
                'email' => 'piotr.nowak@email.com',
                'telefon' => '+48987654321',
                'adres' => 'ul. Słowackiego 8, 35-002 Rzeszów',
                'data_urodzenia' => '1999-05-05',
                'plec' => 'M',
                'szkola_srednia' => 'II Liceum Ogólnokształcące w Rzeszowie',
                'srednia_ocen' => 4.25
            ],
            [
                'imie' => 'Katarzyna',
                'nazwisko' => 'Wiśniewska',
                'pesel' => '00020634567',
                'email' => 'katarzyna.wisniewska@email.com',
                'telefon' => '+48555666777',
                'adres' => 'ul. Mickiewicza 22, 35-003 Rzeszów',
                'data_urodzenia' => '2000-02-06',
                'plec' => 'K',
                'szkola_srednia' => 'Zespół Szkół Technicznych w Rzeszowie',
                'srednia_ocen' => 5.00
            ]
        ];

        foreach ($kandydaci as $kandydat_data) {
            Kandydat::create($kandydat_data);
        }

        // Dodaj losowych kandydatów
        for ($i = 0; $i < 20; $i++) {
            $plec = $faker->randomElement(['M', 'K']);
            $firstName = $plec === 'M' ? $faker->firstNameMale : $faker->firstNameFemale;
            
            Kandydat::create([
                'imie' => $firstName,
                'nazwisko' => $faker->lastName,
                'pesel' => $faker->unique()->numerify('###########'),
                'email' => $faker->unique()->safeEmail,
                'telefon' => $faker->phoneNumber,
                'adres' => $faker->address,
                'data_urodzenia' => $faker->dateTimeBetween('1995-01-01', '2005-12-31')->format('Y-m-d'),
                'plec' => $plec,
                'szkola_srednia' => $faker->randomElement([
                    'I Liceum Ogólnokształcące w Rzeszowie',
                    'II Liceum Ogólnokształcące w Rzeszowie',
                    'Zespół Szkół Technicznych w Rzeszowie',
                    'Liceum Ogólnokształcące w Jaśle',
                    'Technikum Informatyczne w Tarnowie'
                ]),
                'srednia_ocen' => $faker->randomFloat(2, 3.00, 6.00)
            ]);
        }
    }
}