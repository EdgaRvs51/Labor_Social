<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProyectoLaborSocial extends Model
{
    use HasFactory;

    public const ESTADO_PROPUESTO = 'propuesto';
    public const ESTADO_EN_PROGRESO = 'en_progreso';
    public const ESTADO_CULMINADO = 'culminado';

    protected $table = 'proyectos_labor_social';

    protected $fillable = [
        'user_id',
        'nombre_proyecto',
        'descripcion',
        'area_servicio',
        'institucion_beneficiada',
        'responsable_proyecto',
        'fecha_inicio',
        'fecha_fin_estimada',
        'horas_requeridas',
        'estado',
    ];

    protected $attributes = [
        'horas_requeridas' => 120,
        'estado' => self::ESTADO_PROPUESTO,
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin_estimada' => 'date',
            'horas_requeridas' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registrosHoras(): HasMany
    {
        return $this->hasMany(RegistroHoraLaborSocial::class, 'proyecto_labor_social_id');
    }
}
