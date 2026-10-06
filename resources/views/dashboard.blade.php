@extends('layout')

@section('title', 'Dashboard | Labor Social')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-nav py-3">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Sistema Labor Social</a>

            <div class="d-flex align-items-center gap-3">
                <span class="badge rounded-pill text-bg-light text-uppercase">{{ $user->rol }}</span>

                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row g-4">
            <div class="col-12">
                @include('alerts')
            </div>

            <div class="col-lg-8">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4 p-lg-5">
                        <span class="text-uppercase small fw-semibold text-muted-soft">Area administrativa</span>
                        <h1 class="h3 mt-2">Bienvenido, {{ $user->nombre }} {{ $user->apellido }}</h1>

                        @if ($user->isAdministrador())
                            <p class="text-muted-soft mb-0">
                                Has ingresado con un perfil administrador. Este panel puede ampliarse para aprobar proyectos, revisar avances y emitir reportes institucionales.
                            </p>
                        @elseif ($proyecto)
                            <p class="text-muted-soft mb-0">
                                Tu proyecto actual es <strong>{{ $proyecto->nombre_proyecto }}</strong>. Ya llevas
                                <strong>{{ number_format($horasCumplidas, 2) }} horas</strong> registradas y te faltan
                                <strong>{{ number_format($horasPendientes, 2) }} horas</strong> para completar la meta.
                            </p>
                        @else
                            <p class="text-muted-soft mb-0">
                                Aun no has registrado tu proyecto de labor social. Completa el formulario para empezar a documentar tus horas y tu avance.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <div class="metric-icon mb-3">LS</div>
                        <h2 class="h5">Resumen de cuenta</h2>
                        <p class="mb-2"><strong>Correo:</strong> {{ $user->correo }}</p>
                        <p class="mb-2"><strong>Rol:</strong> {{ ucfirst($user->rol) }}</p>
                        @if (! $user->isAdministrador())
                            <p class="mb-0">
                                <strong>Estado del proyecto:</strong>
                                {{ $proyecto ? ucfirst(str_replace('_', ' ', $proyecto->estado)) : 'Sin registrar' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            @if ($user->isAdministrador())
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h2 class="h6 text-uppercase text-muted-soft">Usuarios</h2>
                            <p class="mb-0">Base lista para extender con CRUD de estudiantes y administradores.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h2 class="h6 text-uppercase text-muted-soft">Actividades</h2>
                            <p class="mb-0">Este panel puede crecer hacia la gestion de horas, evidencias y reportes.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h2 class="h6 text-uppercase text-muted-soft">Seguridad</h2>
                            <p class="mb-0">Validacion de formularios, hash de contrasenas y proteccion frente a SQL injection con Eloquent.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="card metric-card h-100">
                        <div class="card-body p-4">
                            <div class="section-label mb-2">Horas requeridas</div>
                            <div class="metric-value">{{ $proyecto ? number_format($proyecto->horas_requeridas, 0) : '0' }}</div>
                            <p class="text-muted-soft mb-0 mt-2">Meta total definida para la labor social.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card metric-card h-100">
                        <div class="card-body p-4">
                            <div class="section-label mb-2">Horas cumplidas</div>
                            <div class="metric-value">{{ number_format($horasCumplidas, 2) }}</div>
                            <p class="text-muted-soft mb-0 mt-2">Horas ya registradas por el estudiante.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card metric-card h-100">
                        <div class="card-body p-4">
                            <div class="section-label mb-2">Horas faltantes</div>
                            <div class="metric-value">{{ number_format($horasPendientes, 2) }}</div>
                            <p class="text-muted-soft mb-0 mt-2">Horas pendientes para cumplir la meta.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4 p-lg-5">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div>
                                    <div class="section-label mb-2">Proyecto de labor social</div>
                                    <h2 class="h4 mb-1">{{ $proyecto ? $proyecto->nombre_proyecto : 'Registrar proyecto' }}</h2>
                                    <p class="text-muted-soft mb-0">
                                        {{ $proyecto ? 'Actualiza la informacion de tu proyecto si hubo cambios en la institucion, fechas o meta de horas.' : 'Completa esta informacion antes de registrar horas.' }}
                                    </p>
                                </div>

                                @if ($proyecto)
                                    <span class="status-pill">{{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}</span>
                                @endif
                            </div>

                            <form action="{{ route('proyecto.store') }}" method="POST" class="row g-3">
                                @csrf

                                <div class="col-md-6">
                                    <label for="nombre_proyecto" class="form-label">Nombre del proyecto</label>
                                    <input type="text" class="form-control @error('nombre_proyecto') is-invalid @enderror" id="nombre_proyecto" name="nombre_proyecto" value="{{ old('nombre_proyecto', $proyecto?->nombre_proyecto) }}" maxlength="150" required>
                                    @error('nombre_proyecto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="institucion_beneficiada" class="form-label">Institucion o comunidad beneficiada</label>
                                    <input type="text" class="form-control @error('institucion_beneficiada') is-invalid @enderror" id="institucion_beneficiada" name="institucion_beneficiada" value="{{ old('institucion_beneficiada', $proyecto?->institucion_beneficiada) }}" maxlength="150" required>
                                    @error('institucion_beneficiada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="descripcion" class="form-label">Descripcion de la labor social</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" maxlength="1000" required>{{ old('descripcion', $proyecto?->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="area_servicio" class="form-label">Area o tipo de labor</label>
                                    <input type="text" class="form-control @error('area_servicio') is-invalid @enderror" id="area_servicio" name="area_servicio" value="{{ old('area_servicio', $proyecto?->area_servicio) }}" maxlength="120">
                                    @error('area_servicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="responsable_proyecto" class="form-label">Responsable o tutor</label>
                                    <input type="text" class="form-control @error('responsable_proyecto') is-invalid @enderror" id="responsable_proyecto" name="responsable_proyecto" value="{{ old('responsable_proyecto', $proyecto?->responsable_proyecto) }}" maxlength="120">
                                    @error('responsable_proyecto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="horas_requeridas" class="form-label">Horas requeridas</label>
                                    <input type="number" class="form-control @error('horas_requeridas') is-invalid @enderror" id="horas_requeridas" name="horas_requeridas" value="{{ old('horas_requeridas', $proyecto?->horas_requeridas ?? 120) }}" min="1" max="500" required>
                                    @error('horas_requeridas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $proyecto?->fecha_inicio?->format('Y-m-d')) }}">
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="fecha_fin_estimada" class="form-label">Fecha fin estimada</label>
                                    <input type="date" class="form-control @error('fecha_fin_estimada') is-invalid @enderror" id="fecha_fin_estimada" name="fecha_fin_estimada" value="{{ old('fecha_fin_estimada', $proyecto?->fecha_fin_estimada?->format('Y-m-d')) }}">
                                    @error('fecha_fin_estimada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-brand">{{ $proyecto ? 'Actualizar proyecto' : 'Guardar proyecto' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4 p-lg-5">
                            <div class="section-label mb-2">Avance de horas</div>
                            <h2 class="h4 mb-2">Seguimiento del estudiante</h2>
                            <p class="text-muted-soft mb-4">
                                {{ $proyecto ? 'Monitorea el progreso real del proyecto y registra cada jornada realizada.' : 'Una vez guardes el proyecto, podras registrar horas aqui mismo.' }}
                            </p>

                            <div class="progress progress-soft mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ number_format($porcentajeAvance, 2, '.', '') }}%;" aria-valuenow="{{ number_format($porcentajeAvance, 2, '.', '') }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                                <div>
                                    <div class="section-label">Avance</div>
                                    <div class="h4 mb-0">{{ number_format($porcentajeAvance, 0) }}%</div>
                                </div>
                                <div>
                                    <div class="section-label">Faltantes</div>
                                    <div class="h4 mb-0">{{ number_format($horasPendientes, 2) }} h</div>
                                </div>
                                <div>
                                    <div class="section-label">Extra</div>
                                    <div class="h4 mb-0">{{ number_format($horasExcedentes, 2) }} h</div>
                                </div>
                            </div>

                            @if ($proyecto)
                                <form action="{{ route('horas.store') }}" method="POST" class="row g-3">
                                    @csrf

                                    <div class="col-md-6">
                                        <label for="fecha" class="form-label">Fecha de la actividad</label>
                                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                                        @error('fecha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="horas" class="form-label">Horas cumplidas</label>
                                        <input type="number" class="form-control @error('horas') is-invalid @enderror" id="horas" name="horas" value="{{ old('horas') }}" min="0.5" max="12" step="0.5" required>
                                        @error('horas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="actividad_realizada" class="form-label">Actividad realizada</label>
                                        <input type="text" class="form-control @error('actividad_realizada') is-invalid @enderror" id="actividad_realizada" name="actividad_realizada" value="{{ old('actividad_realizada') }}" maxlength="180" required>
                                        @error('actividad_realizada')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" maxlength="500">{{ old('observaciones') }}</textarea>
                                        @error('observaciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-brand w-100">Registrar horas</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info mb-0">
                                    Guarda primero tu proyecto para habilitar el registro de horas.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card dashboard-card">
                        <div class="card-body p-4 p-lg-5">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div>
                                    <div class="section-label mb-2">Bitacora de horas</div>
                                    <h2 class="h4 mb-1">Horas registradas</h2>
                                    <p class="text-muted-soft mb-0">Cada jornada queda almacenada con su fecha, actividad y cantidad de horas.</p>
                                </div>
                                <span class="status-pill">{{ $registrosHoras->count() }} registros</span>
                            </div>

                            @if ($registrosHoras->isEmpty())
                                <div class="alert alert-light border mb-0">
                                    Aun no has registrado jornadas de labor social.
                                </div>
                            @else
                                <div class="row g-4">
                                    @foreach ($registrosHoras as $registro)
                                        <div class="col-lg-6">
                                            <div class="border rounded-4 p-4 h-100">
                                                <div class="d-flex align-items-start justify-content-between gap-3">
                                                    <div>
                                                        <div class="section-label mb-2">{{ $registro->fecha->format('d/m/Y') }}</div>
                                                        <h3 class="h5 mb-2">{{ $registro->actividad_realizada }}</h3>
                                                    </div>
                                                    <span class="status-pill">{{ number_format((float) $registro->horas, 2) }} h</span>
                                                </div>

                                                @if ($registro->observaciones)
                                                    <p class="text-muted-soft mb-0">{{ $registro->observaciones }}</p>
                                                @else
                                                    <p class="text-muted-soft mb-0">Sin observaciones adicionales.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
