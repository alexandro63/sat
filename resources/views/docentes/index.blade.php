@extends('layouts.app')
@section('title', 'Docentes')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Docentes" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Docentes</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('teachers.create') }}" data-container=".modal_teacher">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="teachers_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>C.I.</th>
                                        <th>Docente</th>
                                        <th>Aprueba?</th>
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
    <div class="modal fade modal_teacher" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/teachers.js') }}"></script>
@endpush
