@extends('layouts.app')

@section('content')
    <div class="panel-header bg-danger-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Panel Principal</h2>
                    <h3 class="text-white op-7 mb-2">{{ $greeting }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Estadísticas Generales</div>
                        <div class="card-category">Información diaria de actividad en el sistema</div>
                        <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="studentsCount"></div>
                                <h6 class="fw-bold mt-3 mb-0">Alumnos Activos</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="teachersCount"></div>
                                <h6 class="fw-bold mt-3 mb-0">Docentes Activos</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="administrativeCount"></div>
                                <h6 class="fw-bold mt-3 mb-0">Administrativos Activos</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="usersCount"></div>
                                <h6 class="fw-bold mt-3 mb-0">Usuarios Activos</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const activeStudents = {{ $activeStudents }};
        const activeTeachers = {{ $activeTeachers }};
        const activeAdministrative = {{ $activeAdministrative }};
        const activeUsers = {{ $activeUsers }};
    </script>
    <script src="{{ asset('js/app/home.js') }}"></script>
@endpush
