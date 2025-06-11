<?php
// database/migrations/2024_01_01_000001_create_kieruneks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kieruneks', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->text('opis');
            $table->integer('liczba_miejsc');
            $table->decimal('prog_punktowy', 4, 2)->nullable();
            $table->boolean('aktywny')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kieruneks');
    }
};