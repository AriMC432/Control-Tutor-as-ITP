<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('asesores', function (Blueprint $table) {

        $table->string('lugar_tipo')->nullable();

        $table->string('lugar_detalle')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('asesores', function (Blueprint $table) {

        $table->dropColumn([
            'lugar_tipo',
            'lugar_detalle'
        ]);

    });
}
};
