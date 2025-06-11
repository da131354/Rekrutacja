<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokuments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandydatura_id')->constrained('kandydaturas')->onDelete('cascade');
            $table->string('nazwa_dokumentu');
            $table->string('sciezka_pliku');
            $table->string('typ_pliku');
            $table->integer('rozmiar_pliku');
            $table->boolean('zweryfikowany')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokuments');
    }
};