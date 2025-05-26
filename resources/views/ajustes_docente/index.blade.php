@extends('layouts.app')
@section('title', 'Descuento')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Ajuste Docente" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Ajuste</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('teacher_settings.create') }}" data-container=".modal_teacher_setting">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="teacher_settings_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Docente</th>
                                        <th>Fecha Descuento</th>
                                        <th>Motivo Descuento</th>
                                        <th>Monto Descuento</th>
                                        <th>Observaciones</th>
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
    <div class="modal fade modal_teacher_setting" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/teacherSettings.js') }}"></script>
@endpush
