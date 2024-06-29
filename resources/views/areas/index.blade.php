@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($message = Session::get('error'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Éxito!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>¡Error!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif

                @if ($areas->isEmpty())
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                        <strong>
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> ¡Atención! No hay áreas administrativas
                            registradas.
                        </strong>
                        <a href="{{ route('areas.create') }}" class="btn btn-success">
                            Añadir nueva área administrativa
                            <i class="fa-solid fa-folder-plus"></i>
                        </a>
                    </div>
                @else
                    <div class="card shadow-lg">
                        <div class="card-header bg-dark">
                            <div class="row">
                                <div class="col-md-4 mt-1 text-white">
                                    ➤ Todas las áreas administrativas
                                </div>
                                <div class="col-md-8 d-flex flex-row-reverse">
                                    <a href="{{ route('areas.create') }}" class="btn btn-success btn-sm mx-1">
                                        Añadir nueva área administrativa
                                        <i class="fa-solid fa-folder-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-hover text-center align-items-center">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nombre</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                    @foreach ($areas as $area)
                                        <tr>
                                            <th scope="row">{{ $area->name }}</th>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('areas.show', $area->id) }}"
                                                    class="btn btn-secondary me-2">
                                                    Mostrar
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-primary me-2">
                                                    Editar
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('areas.destroy', $area) }}" method="POST"
                                                    id="delete-form-{{ $area->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $area->id }})"
                                                        class="btn btn-danger">
                                                        Eliminar
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mx-3">
                            {{ $areas->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function confirmDelete(areaId) {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, bórralo!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + areaId).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
