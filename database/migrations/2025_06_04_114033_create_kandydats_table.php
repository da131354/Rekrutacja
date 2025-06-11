<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kandydats', function (Blueprint $table) {
            $table->id();
            $table->string('imie');
            $table->string('nazwisko');
            $table->string('pesel')->unique();
            $table->string('email')->unique();
            $table->string('telefon');
            $table->text('adres');
            $table->date('data_urodzenia');
            $table->enum('plec', ['M', 'K']);
            $table->string('szkola_srednia');
            $table->decimal('srednia_ocen', 3, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kandydats');
    }
};
