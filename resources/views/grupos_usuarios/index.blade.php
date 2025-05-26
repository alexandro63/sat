@extends('layouts.app')
@section('title', 'Grupo Usuarios')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Grupo Usuarios" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Grupo de Usuarios</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('group_users.create') }}" data-container=".modal_group_user">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="group_user_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción del Grupo</th>
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
    <div class="modal fade modal_group_user" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/groupUsers.js') }}"></script>
@endpush
