<?php

namespace App\Http\Controllers;

use App\Models\ProyectoLaborSocial;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistroHoraLaborSocialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        abort_if($user->isAdministrador(), 403);

        $proyecto = $user->proyectoLaborSocial;

        if (! $proyecto instanceof ProyectoLaborSocial) {
            return redirect()->route('dashboard')
                ->withErrors(['horas' => 'Primero debes registrar tu proyecto de labor social.']);
        }

        $request->merge([
            'actividad_realizada' => trim((string) $request->input('actividad_realizada')),
            'observaciones' => trim((string) $request->input('observaciones')),
        ]);

        $validated = $request->validate([
            'fecha' => ['required', 'date', 'before_or_equal:today'],
            'horas' => ['required', 'numeric', 'min:0.5', 'max:12'],
            'actividad_realizada' => ['required', 'string', 'max:180'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ], [
            'fecha.required' => 'Debes indicar la fecha de la jornada.',
            'fecha.before_or_equal' => 'No puedes registrar horas en una fecha futura.',
            'horas.required' => 'Debes indicar cuantas horas cumpliste.',
            'horas.min' => 'La jornada minima permitida es de 0.5 horas.',
            'horas.max' => 'La jornada maxima permitida es de 12 horas.',
            'actividad_realizada.required' => 'Debes describir la actividad realizada.',
        ]);

        $proyecto->registrosHoras()->create([
            'fecha' => $validated['fecha'],
            'horas' => $validated['horas'],
            'actividad_realizada' => $validated['actividad_realizada'],
            'observaciones' => $validated['observaciones'] ?: null,
        ]);

        $this->sincronizarEstado($proyecto);

        return redirect()->route('dashboard')
            ->with('status', 'Horas registradas correctamente.');
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
