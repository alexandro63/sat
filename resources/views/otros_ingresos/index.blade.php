@extends('layouts.app')
@section('title', 'Otros Ingresos')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Otros Ingresos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Otros Ingresos</h4>
                            @can('otros_ingresos.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('other_income.create') }}" data-container=".modal_other_income">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="other_income_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>C.I</th>
                                        <th>Persona</th>
                                        <th>Fecha de Pago</th>
                                        <th>Pago</th>
                                        <th>N° Rec/Fac</th>
                                        <th>Usuario</th>
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
    <div class="modal fade modal_other_income" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/otherIncome.js') }}"></script>
@endpush
