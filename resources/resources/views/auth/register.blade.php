@extends('layout')

@section('title', 'Registro de usuarios | Labor Social')

@section('content')
    <div class="container auth-shell d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-xl-11">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="brand-panel d-flex flex-column justify-content-between">
                                <div>
                                    <small>Registro institucional</small>
                                    <h1>Crear cuenta para estudiantes</h1>
                                    <p class="mb-0">
                                        Completa el formulario para habilitar el acceso al modulo administrativo y al control de actividades.
                                    </p>
                                </div>

                                <div class="soft-badge mt-4">
                                    <span class="fw-semibold">Seguridad</span>
                                    <span>El rol administrador se gestiona internamente</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="form-panel">
                                <div class="mb-4">
                                    <h2 class="h3 mb-2">Registrar usuario</h2>
                                    <p class="text-muted-soft mb-0">Todos los campos son obligatorios para crear la cuenta.</p>
                                </div>

                                @include('alerts')

                                <form action="{{ route('register.store') }}" method="POST" novalidate>
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input
                                                type="text"
                                                class="form-control @error('nombre') is-invalid @enderror"
                                                id="nombre"
                                                name="nombre"
                                                value="{{ old('nombre') }}"
                                                maxlength="80"
                                                autocomplete="given-name"
                                                required
                                            >
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input
                                                type="text"
                                                class="form-control @error('apellido') is-invalid @enderror"
                                                id="apellido"
                                                name="apellido"
                                                value="{{ old('apellido') }}"
                                                maxlength="80"
                                                autocomplete="family-name"
                                                required
                                            >
                                            @error('apellido')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="cedula" class="form-label">Cedula</label>
                                            <input
                                                type="text"
                                                class="form-control @error('cedula') is-invalid @enderror"
                                                id="cedula"
                                                name="cedula"
                                                value="{{ old('cedula') }}"
                                                maxlength="20"
                                                autocomplete="off"
                                                required
                                            >
                                            @error('cedula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="correo" class="form-label">Correo electronico</label>
                                            <input
                                                type="email"
                                                class="form-control @error('correo') is-invalid @enderror"
                                                id="correo"
                                                name="correo"
                                                value="{{ old('correo') }}"
                                                maxlength="120"
                                                autocomplete="email"
                                                required
                                            >
                                            @error('correo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Contrasena</label>
                                            <input
                                                type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password"
                                                name="password"
                                                minlength="8"
                                                autocomplete="new-password"
                                                required
                                            >
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                minlength="8"
                                                autocomplete="new-password"
                                                required
                                            >
                                        </div>

                                        <div class="col-12">
                                            <label for="rol_visible" class="form-label">Rol asignado</label>
                                            <input type="text" id="rol_visible" class="form-control" value="Estudiante" disabled>
                                            <div class="form-text">
                                                Por seguridad, las cuentas administrativas solo deben crearse desde la base de datos o un modulo interno protegido.
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-brand w-100 mt-4">Crear cuenta</button>
                                </form>

                                <p class="text-center text-muted-soft mt-4 mb-0">
                                    &iquest;Ya tienes una cuenta?
                                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Iniciar sesion</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
