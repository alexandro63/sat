@extends('layouts.app')
@section('title', 'Plantel Administrativo')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Plantel Administrativo" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Plantel Administrativo</h4>
                            @can('plantel_administrativo.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('plantel-administrativo.create') }}" data-container=".modal_plantel">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="plantel_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>C.I.</th>
                                        <th>Administrativo</th>
                                        <th>Cargo</th>
                                        <th>Unidad</th>
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
    <div class="modal fade modal_plantel" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/plantelAdministrativo.js') }}"></script>
@endpush
