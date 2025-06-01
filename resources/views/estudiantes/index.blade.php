@extends('layouts.app')
@section('title', 'Estudiantes')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Estudiantes" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Estudiantes</h4>
                            @can('estudiante.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('estudiantes.create') }}" data-container=".modal_estudiante">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="estudiante_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Programa Académico</th>
                                        <th>N° Matricula</th>
                                        <th>Fecha Inscripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_estudiante" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/estudiante.js') }}"></script>
@endpush
