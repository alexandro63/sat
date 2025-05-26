@extends('layouts.app')
@section('title', 'Reportes')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Grupos Asignaciones" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Grupos Asignaciones</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="degrees_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Estamos en desarrolloo....</th>
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
    {{-- <script src="{{ asset('js/app/degrees.js') }}"></script> --}}
@endpush
