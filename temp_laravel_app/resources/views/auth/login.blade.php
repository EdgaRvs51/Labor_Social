@extends('layout')

@section('title', 'Iniciar sesion | Labor Social')

@section('content')
    <div class="container auth-shell d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-xl-10">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="brand-panel d-flex flex-column justify-content-between">
                                <div>
                                    <small>U.E.P. Instituto Elena de Bueno</small>
                                    <h1>Panel administrativo de labor social</h1>
                                    <p class="mb-0">
                                        Gestiona el acceso al sistema web de registro y control de actividades de labor social.
                                    </p>
                                </div>

                                <div class="soft-badge mt-4">
                                    <span class="fw-semibold">Laravel + MySQL</span>
                                    <span>Autenticacion segura</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="form-panel">
                                <div class="mb-4">
                                    <h2 class="h3 mb-2">Iniciar sesion</h2>
                                    <p class="text-muted-soft mb-0">Accede con tu correo registrado para entrar al dashboard.</p>
                                </div>

                                @include('alerts')

                                <form action="{{ route('login.attempt') }}" method="POST" novalidate>
                                    @csrf

                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo electronico</label>
                                        <input
                                            type="email"
                                            class="form-control @error('correo') is-invalid @enderror"
                                            id="correo"
                                            name="correo"
                                            value="{{ old('correo') }}"
                                            maxlength="120"
                                            autocomplete="email"
                                            autofocus
                                            required
                                        >
                                        @error('correo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">Contrasena</label>
                                        <input
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password"
                                            name="password"
                                            minlength="8"
                                            autocomplete="current-password"
                                            required
                                        >
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-brand w-100">Entrar al sistema</button>
                                </form>

                                <p class="text-center text-muted-soft mt-4 mb-0">
                                    &iquest;Aun no tienes cuenta?
                                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Registrar usuario</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
