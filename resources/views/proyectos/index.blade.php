@extends('layouts.app')
@section('title', 'Proyectos')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Proyectos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Proyectos</h4>
                            @can('proyecto.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('proyectos.create') }}" data-container=".modal_proyecto">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="proyecto_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Doc. Guía</th>
                                        <th>Doc. Revisor</th>
                                        <th>Estudiante</th>
                                        <th>Titulo</th>
                                        <th>Investigación</th>
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
    <div class="modal fade modal_proyecto" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/proyecto.js') }}"></script>
@endpush
