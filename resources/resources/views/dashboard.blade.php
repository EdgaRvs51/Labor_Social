@extends('layout')

@section('title', 'Dashboard | Labor Social')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-nav py-3">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Sistema Labor Social</a>

            <div class="d-flex align-items-center gap-3">
                <span class="badge rounded-pill text-bg-light text-uppercase">{{ auth()->user()->rol }}</span>

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
                        <h1 class="h3 mt-2">Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</h1>
                        <p class="text-muted-soft mb-0">
                            El modulo base de autenticacion ya permite registrar estudiantes, iniciar sesion de forma segura y proteger el acceso al dashboard.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <div class="metric-icon mb-3">LS</div>
                        <h2 class="h5">Resumen de cuenta</h2>
                        <p class="mb-2"><strong>Correo:</strong> {{ auth()->user()->correo }}</p>
                        <p class="mb-0"><strong>Rol:</strong> {{ ucfirst(auth()->user()->rol) }}</p>
                    </div>
                </div>
            </div>

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
        </div>
    </main>
@endsection
