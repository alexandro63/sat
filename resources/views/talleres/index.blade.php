@extends('layouts.app')
@section('title', 'Talleres')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Talleres" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Lista de Talleres</h4>
                            @can('taller.create')
                                <button class="btn btn-primary btn-round ml-auto btn-modal"
                                    data-href="{{ route('talleres.create') }}" data-container=".modal_taller">
                                    <i class="fa fa-plus"></i>
                                    Registrar
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="taller_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>En Desarrollo</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_taller" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/taller.js') }}"></script>
@endpush
