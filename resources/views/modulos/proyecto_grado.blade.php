@extends('layouts.app')
@section('title', 'Proyecto Grado')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Proyecto Grado" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Proyecto de Grado</h4>
                            <button class="btn btn-primary btn-round ml-auto btn-modal"
                                data-href="{{ route('people.create') }}" data-container=".modal_person">
                                <i class="fa fa-plus"></i>
                                Registrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="people_table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_person" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/people.js') }}"></script>
@endpush
