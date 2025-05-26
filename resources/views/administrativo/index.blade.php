@extends('layouts.app')
@section('title', 'Administrativo')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Administrativo" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Administro</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('administrative.create') }}" data-container=".modal_administrative">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="administrative_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>C.I.</th>
                                        <th>Administrativo</th>
                                        <th>Cargo</th>
                                        <th>Habilitado</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
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
    <div class="modal fade modal_administrative" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/administrative.js') }}"></script>
@endpush
