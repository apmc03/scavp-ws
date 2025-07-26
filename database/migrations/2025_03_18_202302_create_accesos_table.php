<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->bigIncrements("acceso_id");
            $table->unsignedBigInteger("vehiculo_id");
            $table->string("visitante");
            $table->string("placa");
            $table->string("foto_ingreso");
            $table->string("foto_salida")->nullable();
            $table->timestamp("fecha_ingreso");
            $table->timestamp("fecha_salida")->nullable();

            $table->foreign('vehiculo_id')
                ->references('vehiculo_id')
                ->on('vehiculos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesos');
    }
};
