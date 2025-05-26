<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Administrativo
                </span>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="small">
                Llena todos los campos con (*) para crear un nuevo registro.
            </p>

            <form action="{{ route('administrative.store') }}" method="POST" id="add_administrative">
                @csrf
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
                <p id="step-indicator" class="text-center">Paso 1 de 3</p>

                <div class="step" data-step="1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <label for="adm_per_id">C.I.</label>
                                <select class="form-control" name="adm_per_id" id="adm_per_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <label for="adm_grado_academico">Grado Acádemico</label>
                                <select class="form-control select2" name="adm_grado_academico" id="adm_grado_academico"
                                    style="width: 100%">
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach ($grade_academic as $key => $grade)
                                        <option value="{{ $key }}">{{ $grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <label for="adm_cargo">Cargo Administrativo</label>
                                <input type="text" class="form-control" placeholder="Ingrese Cargo" name="adm_cargo"
                                    id="adm_cargo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="adm_fec_ing">Fecha de Ingreso</label>
                                <input name="adm_fec_ing" type="date" class="form-control" id="adm_fec_ing">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="adm_pago">Salario</label>
                                <input type="text" class="form-control input-number" placeholder="Ingrese Salario"
                                    name="adm_pago" id="adm_pago">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step" data-step="2" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="adm_fec_ini">Fecha de Inicio</label>
                                <input name="adm_fec_ini" type="date" class="form-control" id="adm_fec_ini">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="adm_fec_fin">Fecha Final</label>
                                <input name="adm_fec_fin" type="date" class="form-control" id="adm_fec_fin">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="adm_obs">Observaciones</label>
                                <textarea class="form-control" placeholder="Ingrese observaciones" name="adm_obs" id="adm_obs"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" name="adm_estado">
                                    <span class="form-check-sign">Habilitado?</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step" data-step="3" style="display: none;">
                    <div class="row">
                        <!-- Días -->
                        <label class="font-weight-bold text-danger m-2">Días (*)</label>
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Todos</th>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miércoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $days = [
                                            'todos',
                                            'lunes',
                                            'martes',
                                            'miercoles',
                                            'jueves',
                                            'viernes',
                                            'sabado',
                                            'domingo',
                                        ];
                                    @endphp
                                    <tr>
                                        @foreach ($days as $day)
                                            <td>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input day-checkbox" type="checkbox"
                                                            value="{{ $day }}" name="">
                                                        <span class="form-check-sign p-0"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Horarios -->
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-danger">Hora Inicio (*)</label>
                                    <select class="form-control" id="scheduleStart">
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-danger">Hora Final (*)</label>
                                    <select class="form-control" id="scheduleEnd">
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <label class="invisible">Agregar</label>
                                    <a class="btn btn-primary btn-sm text-white" id="btnAdd"
                                        title="Asignar Horario"> <i class="fa fa-plus"></i></a>
                                    <a class="btn btn-danger btn-sm text-white" id="btnClear" title="Limpiar Todo">
                                        <i class="fa fa-eraser"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive m-2">
                            <table class="table table-bordered text-center" id="tableSchedule">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Final</th>
                                        <th>Opc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="adm_plan_horario" id="schedules_json">
                    </div>
                </div>

                <div class="modal-footer no-bd mt-3">
                    <button type="button" class="btn btn-info" id="prevBtn" style="display: none;">←
                        Anterior</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Siguiente →</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn"
                        style="display: none;">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
