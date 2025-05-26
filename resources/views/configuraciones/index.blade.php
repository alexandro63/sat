@extends('layouts.app')
@section('title', 'Configuraciones')
@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Configuraciones" />

        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/users.js') }}"></script>
@endpush
