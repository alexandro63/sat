<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Marcador') }}</title>
    @include('layouts.partials.css')

</head>

<body>
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Marcador</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <div class="card-title">{{ config('app.name', 'SAF') }}</div>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <div class="form-group" id="teacher_attendence">
                                            <input type="text" class="form-control input-number"
                                                placeholder="Carnet de Identidad" name='teacher_attendence'>
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-none" id="teacher_replaced">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-number"
                                                placeholder="Docente a Reemplazar" name='teacher_replaced'>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">Reemplazo</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row text-center">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary btn-border">
                                                <span class="btn-label">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                Entrada
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary btn-border">
                                                <span class="btn-label">
                                                    <i class="fa fa-minus"></i>
                                                </span>
                                                Salida
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('layouts.partials.javascript')
<script src="{{ asset('js/app/attendence.js') }}"></script>

</html>
