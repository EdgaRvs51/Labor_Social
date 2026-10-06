<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyectos_labor_social')) {
            return;
        }

        Schema::create('proyectos_labor_social', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('nombre_proyecto', 150);
            $table->text('descripcion');
            $table->string('area_servicio', 120)->nullable();
            $table->string('institucion_beneficiada', 150);
            $table->string('responsable_proyecto', 120)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin_estimada')->nullable();
            $table->unsignedInteger('horas_requeridas')->default(120);
            $table->enum('estado', ['propuesto', 'en_progreso', 'culminado'])->default('propuesto');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos_labor_social');
    }
};
