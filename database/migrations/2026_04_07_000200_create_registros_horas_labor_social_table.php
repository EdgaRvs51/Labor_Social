<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('registros_horas_labor_social')) {
            return;
        }

        Schema::create('registros_horas_labor_social', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('proyecto_labor_social_id');
            $table->date('fecha');
            $table->decimal('horas', 5, 2);
            $table->string('actividad_realizada', 180);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_labor_social_id')
                ->references('id')
                ->on('proyectos_labor_social')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_horas_labor_social');
    }
};
