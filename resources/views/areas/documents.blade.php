@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark">
                        <div class="row">
                            <div class="col-md-8 mt-1 text-white">
                                ➤ Documentos del área: {{ $area->name }}
                            </div>
                            <div class="col-md-4 d-flex flex-row-reverse">
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-sm mx-1">
                                    Volver
                                    <i class="fa-solid fa-rotate-left"></i>
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
                        <div class="row">
                            @foreach ($documents as $document)
                                @php
                                    $extension = pathinfo($document->document, PATHINFO_EXTENSION);
                                    
                                    $fileTypes = [
                                        'doc' => ['icon' => 'fa-file-word', 'badge' => 'bg-primary', 'type' => 'Word'],
                                        'docx' => ['icon' => 'fa-file-word', 'badge' => 'bg-primary', 'type' => 'Word'],
                                        'xls' => ['icon' => 'fa-file-excel', 'badge' => 'bg-success', 'type' => 'Excel'],
                                        'xlsx' => ['icon' => 'fa-file-excel', 'badge' => 'bg-success', 'type' => 'Excel'],
                                        'csv' => ['icon' => 'fa-file-excel', 'badge' => 'bg-success', 'type' => 'Excel'],
                                        'pdf' => ['icon' => 'fa-file-pdf', 'badge' => 'bg-danger', 'type' => 'PDF'],
                                        '' => ['icon' => 'fa-file-alt', 'badge' => 'bg-secondary', 'type' => 'Documento']
                                    ];
                        
                                    $fileData = $fileTypes[$extension] ?? $fileTypes[''];
                                @endphp
                        
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <h4 class="mb-0">
                                                    <span class="badge {{ $fileData['badge'] }} text-uppercase me-2">
                                                        <i class="fa-solid {{ $fileData['icon'] }}"></i> {{ $fileData['type'] }}
                                                    </span>
                                                </h4>
                                                <h5 class="card-title mb-0 ml-3">{{ $document->name }}</h5>
                                            </div>
                                            <div>
                                                <a href="{{ url('docs/' . $document->document) }}" class="btn {{ $fileData['badge'] }} text-white">
                                                    Descargar
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
