<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            KierunekSeeder::class,
            KandydatSeeder::class,
            KandydaturaSeeder::class,
        ]);
    }
}