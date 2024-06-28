@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header text-white bg-secondary">
                        Vista detallada del área administrativa
                        <i class="fa-solid fa-eye"></i>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-12 mb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="name">
                                        Nombre
                                    </label>
                                    <input type="text" id="name" class="form-control form-control-lg"
                                        value="{{ $area->name }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('areas.index') }}" class="btn btn-lg btn-secondary w-100">
                            Ir al panel de áreas
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('areas.edit', $area) }}" class="btn btn-lg btn-primary w-100">
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

    <form action="{{ route('areas.destroy', $area) }}" method="POST" id="delete-form">
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
