@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark">
                        <div class="row">
                            <div class="col-md-8 mt-1 text-white">
                                ➤ Resultados de la búsqueda: {{ $search }}
                            </div>
                            <div class="col-md-4 d-flex flex-row-reverse">
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-sm mx-1">
                                    Volver
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
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
                                        'xls' => [
                                            'icon' => 'fa-file-excel',
                                            'badge' => 'bg-success',
                                            'type' => 'Excel',
                                        ],
                                        'xlsx' => [
                                            'icon' => 'fa-file-excel',
                                            'badge' => 'bg-success',
                                            'type' => 'Excel',
                                        ],
                                        'csv' => [
                                            'icon' => 'fa-file-excel',
                                            'badge' => 'bg-success',
                                            'type' => 'Excel',
                                        ],
                                        'pdf' => ['icon' => 'fa-file-pdf', 'badge' => 'bg-danger', 'type' => 'PDF'],
                                        '' => [
                                            'icon' => 'fa-file-alt',
                                            'badge' => 'bg-secondary',
                                            'type' => 'Documento',
                                        ],
                                    ];

                                    $fileData = $fileTypes[$extension] ?? $fileTypes[''];
                                @endphp

                                <div class="col mb-4">
                                    <div class="card shadow h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <h4 class="mb-0">
                                                    <span class="badge {{ $fileData['badge'] }} text-uppercase me-2">
                                                        <i class="fa-solid {{ $fileData['icon'] }}"></i>
                                                        {{ $fileData['type'] }}
                                                    </span>
                                                </h4>
                                                <div>
                                                    <h5 class="card-title mb-0 ml-3">{{ $document->name }}</h5>
                                                    <p class="text-muted mb-0"><b>Área:</b> {{ $document->area->name }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ url('docs/' . $document->document) }}"
                                                    class="btn {{ $fileData['badge'] }} text-white">
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
