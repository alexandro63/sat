@extends('layouts.app')
@section('title', 'Permisos')
@section('content')

    <div class="page-inner">
        <x-breadcrumb title="Permisos" />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Permisos</h4>
                            <a class="btn btn-primary btn-round ml-auto" href="{{ route('roles.create') }}">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="roles_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Permisos</th>
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
@endsection

@push('scripts')
    <script src="{{ asset('js/app/roles.js') }}"></script>
@endpush
