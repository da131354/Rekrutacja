<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kandydaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandydat_id')->constrained('kandydats')->onDelete('cascade');
            $table->foreignId('kierunek_id')->constrained('kieruneks')->onDelete('cascade');
            $table->enum('status', ['oczekujaca', 'zaakceptowana', 'odrzucona'])->default('oczekujaca');
            $table->decimal('punkty_rekrutacyjne', 5, 2)->nullable();
            $table->text('uwagi')->nullable();
            $table->timestamp('data_zlozenia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kandydaturas');
    }
};
