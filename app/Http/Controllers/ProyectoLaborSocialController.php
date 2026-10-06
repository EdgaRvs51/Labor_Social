<?php

namespace App\Http\Controllers;

use App\Models\ProyectoLaborSocial;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProyectoLaborSocialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        abort_if($user->isAdministrador(), 403);

        $request->merge([
            'nombre_proyecto' => trim((string) $request->input('nombre_proyecto')),
            'descripcion' => trim((string) $request->input('descripcion')),
            'area_servicio' => trim((string) $request->input('area_servicio')),
            'institucion_beneficiada' => trim((string) $request->input('institucion_beneficiada')),
            'responsable_proyecto' => trim((string) $request->input('responsable_proyecto')),
        ]);

        $validated = $request->validate([
            'nombre_proyecto' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'area_servicio' => ['nullable', 'string', 'max:120'],
            'institucion_beneficiada' => ['required', 'string', 'max:150'],
            'responsable_proyecto' => ['nullable', 'string', 'max:120'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin_estimada' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'horas_requeridas' => ['required', 'integer', 'min:1', 'max:500'],
        ], [
            'nombre_proyecto.required' => 'Debes indicar el nombre del proyecto.',
            'descripcion.required' => 'Debes describir la labor social.',
            'institucion_beneficiada.required' => 'Debes indicar la institucion o comunidad beneficiada.',
            'horas_requeridas.required' => 'Debes indicar las horas requeridas.',
            'fecha_fin_estimada.after_or_equal' => 'La fecha estimada no puede ser menor a la fecha de inicio.',
        ]);

        $proyecto = ProyectoLaborSocial::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre_proyecto' => $validated['nombre_proyecto'],
                'descripcion' => $validated['descripcion'],
                'area_servicio' => $validated['area_servicio'] ?: null,
                'institucion_beneficiada' => $validated['institucion_beneficiada'],
                'responsable_proyecto' => $validated['responsable_proyecto'] ?: null,
                'fecha_inicio' => $validated['fecha_inicio'] ?? null,
                'fecha_fin_estimada' => $validated['fecha_fin_estimada'] ?? null,
                'horas_requeridas' => $validated['horas_requeridas'],
            ]
        );

        $this->sincronizarEstado($proyecto);

        return redirect()->route('dashboard')
            ->with('status', 'Proyecto de labor social guardado correctamente.');
    }

    protected function sincronizarEstado(ProyectoLaborSocial $proyecto): void
    {
        $horasCumplidas = (float) $proyecto->registrosHoras()->sum('horas');

        $proyecto->estado = match (true) {
            $horasCumplidas >= (float) $proyecto->horas_requeridas && $proyecto->horas_requeridas > 0 => ProyectoLaborSocial::ESTADO_CULMINADO,
            $horasCumplidas > 0 => ProyectoLaborSocial::ESTADO_EN_PROGRESO,
            default => ProyectoLaborSocial::ESTADO_PROPUESTO,
        };

        $proyecto->save();
    }
}
