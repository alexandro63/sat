@extends('layouts.app')
@section('title', 'Carreras')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Carreras" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Carreras</h4>
                            @can('carrera.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('degrees.create') }}" data-container=".modal_degree">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="degrees_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de Carrera</th>
                                        <th>Descripción de Carrera</th>
                                        <th>Duración de Carrera (Meses)</th>
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
    <div class="modal fade modal_degree" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/degrees.js') }}"></script>
@endpush
