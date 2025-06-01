@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Usuarios" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Usuarios</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('usuarios.create') }}" data-container=".modal_user">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de Usuario</th>
                                        <th>Nombre Completo</th>
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
    <div class="modal fade modal_user" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/users.js') }}"></script>
@endpush
