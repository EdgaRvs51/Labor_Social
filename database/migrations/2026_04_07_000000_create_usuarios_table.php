<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('usuarios')) {
            return;
        }

        Schema::create('usuarios', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nombre', 80);
            $table->string('apellido', 80);
            $table->string('cedula', 20)->unique();
            $table->string('correo', 120)->unique();
            $table->string('password');
            $table->enum('rol', ['estudiante', 'administrador'])->default('estudiante');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
}
