<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kandydats', function (Blueprint $table) {
            $table->string('zdjecie')->nullable()->after('srednia_ocen');
        });
    }

    public function down()
    {
        Schema::table('kandydats', function (Blueprint $table) {
            $table->dropColumn('zdjecie');
        });
    }
};