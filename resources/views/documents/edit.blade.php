@php
    use App\Enums\DocumentType;
@endphp

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
                    <div class="card-header text-white bg-primary">
                        <div class="row">
                            <div class="col-md-4 mt-1 text-white">
                                Añadir documento
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="col-md-8 d-flex flex-row-reverse">
                                <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm mx-1">
                                    Volver
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documents.update', $document) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <!-- Nombre -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="name">
                                            Nombre
                                        </label>
                                        <input type="text" id="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="ej. F-DIR-36" name="name"
                                            value="{{ old('name', $document->name) }}" required autofocus />
                                        @error('name')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Área -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="area_id">Área Administrativa</label>
                                        <select class="form-control form-control-lg @error('area_id') is-invalid @enderror"
                                            id="area_id" name="area_id" required>
                                            <option selected disabled>Escoge una área</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}"
                                                    {{ $document->area_id == $area->id ? 'selected' : '' }}>
                                                    {{ $area->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('area_id')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Tipo -->
                                <div class="col-md-2 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="type">
                                            Tipo de Documento
                                        </label>
                                        <select class="form-control form-control-lg @error('type') is-invalid @enderror"
                                            id="type" name="type" required>
                                            <option selected disabled>Escoge un tipo</option>
                                            @foreach (DocumentType::cases() as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ $document->type == $type->value ? 'selected' : '' }}>
                                                    {{ $type->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Subir Documento -->
                                <div class="col-md-6 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="document">
                                            Subir nuevo archivo
                                        </label>
                                        <input type="file" name="document"
                                            class="form-control form-control-lg @error('document') is-invalid @enderror">
                                        @error('document')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Documento -->
                                <div class="col-md-4 mb-6">
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
                                            class="btn btn-lg btn-primary btn-square form-control form-control-lg">
                                            Haz click aquí para descargar
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                    @endif
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
