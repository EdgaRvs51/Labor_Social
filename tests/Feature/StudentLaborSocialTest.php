<?php

namespace Tests\Feature;

use App\Models\ProyectoLaborSocial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentLaborSocialTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_create_or_update_project(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post(route('proyecto.store'), [
            'nombre_proyecto' => 'Apoyo academico comunitario',
            'descripcion' => 'Acompanamiento educativo a estudiantes de primaria.',
            'area_servicio' => 'Educacion',
            'institucion_beneficiada' => 'Casa comunal del sector',
            'responsable_proyecto' => 'Prof. Maria Perez',
            'fecha_inicio' => '2026-04-01',
            'fecha_fin_estimada' => '2026-06-30',
            'horas_requeridas' => 120,
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('proyectos_labor_social', [
            'user_id' => $user->id,
            'nombre_proyecto' => 'Apoyo academico comunitario',
            'area_servicio' => 'Educacion',
            'horas_requeridas' => 120,
            'estado' => ProyectoLaborSocial::ESTADO_PROPUESTO,
        ]);
    }

    public function test_student_can_register_hours_and_view_progress(): void
    {
        $user = $this->createUser();

        $proyecto = ProyectoLaborSocial::create([
            'user_id' => $user->id,
            'nombre_proyecto' => 'Jornadas ambientales',
            'descripcion' => 'Limpieza y recuperacion de areas verdes.',
            'institucion_beneficiada' => 'Plaza Bolivar',
            'horas_requeridas' => 120,
        ]);

        $response = $this->actingAs($user)->post(route('horas.store'), [
            'fecha' => '2026-04-05',
            'horas' => 8.5,
            'actividad_realizada' => 'Limpieza de areas comunes',
            'observaciones' => 'Participacion con 10 estudiantes.',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('registros_horas_labor_social', [
            'proyecto_labor_social_id' => $proyecto->id,
            'actividad_realizada' => 'Limpieza de areas comunes',
        ]);

        $dashboard = $this->actingAs($user)->get(route('dashboard'));

        $dashboard->assertOk();
        $dashboard->assertSee('Horas cumplidas');
        $dashboard->assertSee('8.50');
        $dashboard->assertSee('111.50');
        $dashboard->assertSee('Limpieza de areas comunes');
    }

    public function test_admin_cannot_store_student_project(): void
    {
        $admin = $this->createUser(User::ROL_ADMINISTRADOR);

        $response = $this->actingAs($admin)->post(route('proyecto.store'), [
            'nombre_proyecto' => 'Proyecto no permitido',
            'descripcion' => 'No deberia guardarse.',
            'institucion_beneficiada' => 'Institucion',
            'horas_requeridas' => 100,
        ]);

        $response->assertForbidden();
    }

    protected function createUser(string $rol = User::ROL_ESTUDIANTE): User
    {
        return User::create([
            'nombre' => 'Juan',
            'apellido' => 'Diaz',
            'cedula' => fake()->unique()->numerify('########'),
            'correo' => fake()->unique()->safeEmail(),
            'password' => Hash::make('secret123'),
            'rol' => $rol,
        ]);
    }
}
