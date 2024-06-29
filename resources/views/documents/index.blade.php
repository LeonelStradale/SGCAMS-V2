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

                @if ($documents->isEmpty())
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                        <strong>
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> ¡Atención! No hay documentos registrados.
                        </strong>
                        <a href="{{ route('documents.create') }}" class="btn btn-success">
                            Añadir nuevo documento
                            <i class="fa-solid fa-file-circle-plus"></i>
                        </a>
                    </div>
                @else
                    <div class="card shadow-lg">
                        <div class="card-header bg-dark">
                            <div class="row">
                                <div class="col-md-4 mt-1 text-white">
                                    ➤ Todos los documentos
                                </div>
                                <div class="col-md-8 d-flex flex-row-reverse">
                                    <a href="{{ route('documents.create') }}" class="btn btn-success btn-sm mx-1">
                                        Añadir nuevo documento
                                        <i class="fa-solid fa-file-circle-plus"></i>
                                    </a>
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
                            <table class="table table-responsive table-hover text-center align-items-center">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nombre</th>
                                        <th>Area</th>
                                        <th>Tipo</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                    @foreach ($documents as $document)
                                        <tr>
                                            <th scope="row">{{ $document->name }}</th>
                                            <td>{{ $document->area->name }}</td>
                                            <td>
                                                @if ($document->type == 'Documento')
                                                    <span class="badge text-bg-primary">
                                                        {{ $document->type }}
                                                    </span>
                                                @elseif ($document->type == 'Formato')
                                                    <span class="badge text-bg-danger">
                                                        {{ $document->type }}
                                                    </span>
                                                @elseif ($document->type == 'Excel')
                                                    <span class="badge text-bg-success">
                                                        {{ $document->type }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('documents.show', $document->id) }}"
                                                    class="btn btn-secondary me-2">
                                                    Mostrar
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('documents.edit', $document->id) }}"
                                                    class="btn btn-primary me-2">
                                                    Editar
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('documents.destroy', $document->id) }}"
                                                    method="post" id="delete-form-{{ $document->id }}">>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $document->id }})" class="btn btn-danger">
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
                            {{ $documents->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function confirmDelete(documentId) {
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
                        document.getElementById('delete-form-' + documentId).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
