@extends('layouts.app')
@section('title', 'Planificación Acádemica')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Planificación Acádemica" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Planificación Acádemica</h4>
                            @can('plan_academico.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('academic_planning.create') }}"
                                    data-container=".modal_academic_planning">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="academic_planning_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de Materia</th>
                                        <th>Aula</th>
                                        <th>Docente</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha Final</th>
                                        <th>Hora de Inicio</th>
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
    <div class="modal fade modal_academic_planning" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/academicPlanning.js') }}"></script>
@endpush
