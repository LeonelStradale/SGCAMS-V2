@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header text-white bg-primary">
                        <div class="row">
                            <div class="col-md-4 mt-1 text-white">
                                Editar área administrativa
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="col-md-8 d-flex flex-row-reverse">
                                <a href="{{ route('areas.index') }}" class="btn btn-secondary btn-sm mx-1">
                                    Volver
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('areas.update', $area) }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="name">
                                            Nombre
                                        </label>
                                        <input type="text" id="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="ej. Dirección de Tecnologías de la Información" name="name"
                                            value="{{ old('name', $area->name) }}" required autofocus />
                                        @error('name')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
