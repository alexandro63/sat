@extends('layouts.app')
@section('title', 'Modulos')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Modulos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Modulos</h4>
                            @can('modulo.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('modulos.create') }}" data-container=".modal_modulo">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="modulo_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Docente</th>
                                        <th>Metodología</th>
                                        <th>Duración</th>
                                        <th>Descripción</th>
                                        <th>Fecha Incio</th>
                                        <th>Fecha Final</th>
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
    <div class="modal fade modal_modulo" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/modulo.js') }}"></script>
@endpush
