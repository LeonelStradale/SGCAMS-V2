@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>¡Error!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header text-white bg-secondary">
                        Vista detallada del documento
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="name">
                                        Nombre
                                    </label>
                                    <input type="text" id="name" class="form-control form-control-lg"
                                        value="{{ $document->name }}" disabled />
                                </div>
                            </div>
                            <!-- Área -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="area">
                                        Área administrativa
                                    </label>
                                    <input type="text" id="area" class="form-control form-control-lg"
                                        value="{{ $document->area->name }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Tipo -->
                            <div class="col-md-6 mb-6">
                                <div class="form-outline">
                                    <label class="form-label" for="type">
                                        Tipo de Documento
                                    </label>
                                    <input type="text" id="type" class="form-control form-control-lg"
                                        value="{{ $document->type }}" disabled />
                                </div>
                            </div>
                            <!-- Documento -->
                            <div class="col-md-6 mb-6">
                                @if (in_array(pathinfo($document->document, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <label class="form-label">
                                        Visualizar archivo
                                    </label>
                                    <a href="{{ url('docs/' . $document->document) }}"
                                        class="btn btn-lg btn-primary btn-square form-control form-control-lg">
                                        Haz click aquí para descargar
                                        <i class="fa-solid fa-file-word"></i>
                                    </a>
                                @elseif (in_array(pathinfo($document->document, PATHINFO_EXTENSION), ['xls', 'xlsx', 'csv']))
                                    <label class="form-label">
                                        Visualizar archivo
                                    </label>
                                    <a href="{{ url('docs/' . $document->document) }}"
                                        class="btn btn-lg btn-success btn-square form-control form-control-lg">
                                        Haz click aquí para descargar
                                        <i class="fa-solid fa-file-excel"></i>
                                    </a>
                                @elseif (in_array(pathinfo($document->document, PATHINFO_EXTENSION), ['pdf']))
                                    <label class="form-label">
                                        Visualizar archivo
                                    </label>
                                    <a href="{{ url('docs/' . $document->document) }}"
                                        class="btn btn-lg btn-danger btn-square form-control form-control-lg">
                                        Haz click aquí para descargar
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('documents.index') }}" class="btn btn-lg btn-secondary w-100">
                            Ir al panel de documentos
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-lg btn-primary w-100">
                            Editar
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button onclick="confirmDelete()" class="btn btn-lg btn-danger w-100">
                            Eliminar
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('documents.destroy', $document) }}" method="POST" id="delete-form">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
        <script>
            function confirmDelete() {
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
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
