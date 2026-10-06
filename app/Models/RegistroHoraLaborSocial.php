<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroHoraLaborSocial extends Model
{
    use HasFactory;

    protected $table = 'registros_horas_labor_social';

    protected $fillable = [
        'proyecto_labor_social_id',
        'fecha',
        'horas',
        'actividad_realizada',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'horas' => 'decimal:2',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(ProyectoLaborSocial::class, 'proyecto_labor_social_id');
    }
}
