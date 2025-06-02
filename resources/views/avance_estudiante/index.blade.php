@extends('layouts.app')
@section('title', 'Avance Estudiante')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Avance Estudiante" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Avance de Estudiantes</h4>
                            @can('avance_estudiante.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('avance-estudiante.create') }}"
                                    data-container=".modal_avance_estudiante">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="avance_estudiante_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>En Desarrollo</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_avance_estudiante" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/avanceEstudiante.js') }}"></script>
@endpush
