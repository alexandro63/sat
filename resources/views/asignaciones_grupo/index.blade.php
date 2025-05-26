@extends('layouts.app')
@section('title', 'Asignaciones de grupo')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Asignaciones de grupos" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Asignaciones de Grupo</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('group_assign.create') }}" data-container=".modal_group_assign">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="group_assign_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
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
    <div class="modal fade modal_group_assign" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/groupAssign.js') }}"></script>
@endpush
