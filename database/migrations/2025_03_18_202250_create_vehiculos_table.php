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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements("vehiculo_id");
            $table->unsignedBigInteger("funcionario_id");
            $table->string("placa");
            $table->string("tipo");
            $table->string("estado");

            $table->foreign('funcionario_id')
                ->references('funcionario_id')
                ->on('funcionarios')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
