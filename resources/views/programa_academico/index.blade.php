@extends('layouts.app')
@section('title', 'Programa Académico')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Programa Académico" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Programa Académico</h4>
                            @can('programa_academico.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('programa-academico.create') }}"
                                    data-container=".modal_programa_academico">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="programa_academico_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre Programa</th>
                                        <th>Modalidad</th>
                                        <th>Facultad</th>
                                        <th>Nivel</th>
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
    <div class="modal fade modal_programa_academico" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/programaAcademico.js') }}"></script>
@endpush
