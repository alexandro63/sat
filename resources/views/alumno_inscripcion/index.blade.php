@extends('layouts.app')
@section('title', 'Alumnos')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Alumnos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Alumnos Inscritos</h4>
                            @can('alumno_inscripcion.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('student_enrollments.create') }}"
                                    data-container=".modal_student_enrollment">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="student_enrollment_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>C.I.</th>
                                        <th>Alumno</th>
                                        <th>Carrera</th>
                                        <th>Curso</th>
                                        <th>Turno</th>
                                        <th>Concluyó Carrera?</th>
                                        <th>Habilitado?</th>
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
    <div class="modal fade modal_student_enrollment" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/studentEnrollments.js') }}"></script>
@endpush
