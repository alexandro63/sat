@extends('layouts.app')
@section('title', 'Pagos')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Pagos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Pagos</h4>
                            @can('pago.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('pagos.create') }}" data-container=".modal_pago">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pago_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Monto</th>
                                        <th>Método</th>
                                        <th>Fecha</th>
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
    <div class="modal fade modal_pago" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/pago.js') }}"></script>
@endpush
