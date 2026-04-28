@extends('layouts.app')

@section('title', 'Crear cuenta | ElectroStore')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h5 mb-3">Crear cuenta</h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">CI</label>
                                <input type="text" name="ci" value="{{ old('ci') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefono</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Direccion</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contrasena</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmar contrasena</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4">Crear cuenta</button>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesion</a></p>
        </div>
    </div>
</div>
@endsection
