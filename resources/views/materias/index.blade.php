@extends('layouts.app')
@section('title', 'Materias')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Materias" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Materias</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('subjects.create') }}" data-container=".modal_subject">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="subjects_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de Carrera</th>
                                        <th>Nombre de Materia</th>
                                        <th>Descripción de Materia</th>
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
    <div class="modal fade modal_subject" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/subjects.js') }}"></script>
@endpush
