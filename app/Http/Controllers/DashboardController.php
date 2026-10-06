<?php

namespace App\Http\Controllers;

use App\Models\ProyectoLaborSocial;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $proyecto = null;
        $registrosHoras = collect();
        $horasCumplidas = 0.0;
        $horasPendientes = 0.0;
        $horasExcedentes = 0.0;
        $porcentajeAvance = 0.0;

        if (! $user->isAdministrador()) {
            $proyecto = $user->proyectoLaborSocial;

            if ($proyecto instanceof ProyectoLaborSocial) {
                $registrosHoras = $proyecto->registrosHoras()
                    ->orderByDesc('fecha')
                    ->orderByDesc('id')
                    ->get();

                $horasCumplidas = (float) $proyecto->registrosHoras()->sum('horas');
                $horasPendientes = max((float) $proyecto->horas_requeridas - $horasCumplidas, 0);
                $horasExcedentes = max($horasCumplidas - (float) $proyecto->horas_requeridas, 0);
                $porcentajeAvance = $proyecto->horas_requeridas > 0
                    ? min(($horasCumplidas / (float) $proyecto->horas_requeridas) * 100, 100)
                    : 0;
            }
        }

        return view('dashboard', [
            'user' => $user,
            'proyecto' => $proyecto,
            'registrosHoras' => $registrosHoras,
            'horasCumplidas' => $horasCumplidas,
            'horasPendientes' => $horasPendientes,
            'horasExcedentes' => $horasExcedentes,
            'porcentajeAvance' => $porcentajeAvance,
        ]);
    }
}
