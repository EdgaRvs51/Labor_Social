<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROL_ESTUDIANTE = 'estudiante';
    public const ROL_ADMINISTRADOR = 'administrador';

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'correo',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'rol' => self::ROL_ESTUDIANTE,
    ];

    public function isAdministrador(): bool
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    public function proyectoLaborSocial(): HasOne
    {
        return $this->hasOne(ProyectoLaborSocial::class, 'user_id');
    }

    public function registrosHorasLaborSocial(): HasManyThrough
    {
        return $this->hasManyThrough(
            RegistroHoraLaborSocial::class,
            ProyectoLaborSocial::class,
            'user_id',
            'proyecto_labor_social_id'
        );
    }
}
