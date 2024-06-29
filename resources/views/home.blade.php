@extends('layouts.app')

<style>
    .card-equal-height {
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($areas->isEmpty())
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <div>
                            ¡Atención! No hay áreas administrativos registradas.
                        </div>
                    </div>
                @else
                    <div class="card shadow-lg">
                        <div class="card-header bg-dark">
                            <div class="row">
                                <div class="col-md-4 mt-1 text-white">
                                    ➤ Todos los documentos
                                </div>
                                <div class="col-md-8 d-flex flex-row-reverse">
                                    <!-- Modal: Buscar Documento -->
                                    <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalBD">
                                        Buscar documento
                                        <i class="fa-solid fa-search"></i>
                                    </button>
                                    <!-- Modal: Buscar Documento -->
                                    <div class="modal fade" id="exampleModalBD" tabindex="-1"
                                        aria-labelledby="exampleModalBDLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white" id="exampleModalBDLabel">
                                                        Buscar documento
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="p">
                                                        Ingrese el nombre del documento para realizar su búsqueda dentro del
                                                        sistema.
                                                    </p>
                                                    <form action="#" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <!-- Nombre -->
                                                            <div class="col-md-12 mb-2">
                                                                <div class="form-outline">
                                                                    <label class="form-label text-dark" for="doc">
                                                                        Nombre
                                                                    </label>
                                                                    <input type="text" id="doc"
                                                                        class="form-control form-control-lg"
                                                                        placeholder="ej. F-DIR-36" name="doc" required
                                                                        autofocus />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2 pt-2">
                                                            <button class="btn btn-primary" type="submit">
                                                                Buscar documento
                                                                <i class="fa-solid fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                                @foreach ($areas as $area)
                                    <div class="col">
                                        <a href="{{ route('areas.show', $area->id) }}"
                                            class="card text-decoration-none bg-primary text-white card-equal-height">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-center">{{ $area->name }}</h5>
                                                <div class="mt-auto">
                                                    <p class="card-text text-center mt-4">
                                                        <small class="text-body-white">
                                                            Ver documentos
                                                            <i class="fa-solid fa-angle-right"></i>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
