<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kieruneks', function (Blueprint $table) {
            $table->string('zdjecie')->nullable()->after('aktywny');
        });
    }

    public function down()
    {
        Schema::table('kieruneks', function (Blueprint $table) {
            $table->dropColumn('zdjecie');
        });
    }
};