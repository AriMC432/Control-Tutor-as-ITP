
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informes_tutores', function (Blueprint $table) {
            $table->id('id_informe');
            $table->unsignedBigInteger('id_docente');
            $table->string('periodo', 7);
            $table->string('archivo');
            $table->string('nombre_original');
            $table->string('estatus', 20)->default('En revisión');
            $table->timestamps();

            $table->foreign('id_docente')
                ->references('id_docente')
                ->on('docente')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informes_tutores');
    }
};
