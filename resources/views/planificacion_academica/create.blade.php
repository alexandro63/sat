<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nueva
                </span>
                <span class="fw-light">
                    Planificación Acádemica
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

            <form action="{{ route('academic_planning.store') }}" method="POST" id="add_academic_planning">
                @csrf
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
                <p id="step-indicator" class="text-center">Paso 1 de 3</p>

                <div class="step" data-step="1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="plan_mat_id">Materia</label>
                                <select class="form-control" name="plan_mat_id" id="plan_mat_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="plan_doc_id">Docente</label>
                                <select class="form-control" name="plan_doc_id" id="plan_doc_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="plan_amb_id">Aula</label>
                                <select class="form-control" name="plan_amb_id" id="plan_amb_id">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step" data-step="2" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="plan_fec_ini">Fecha Inicio</label>
                                <input name="plan_fec_ini" type="date" class="form-control" id="plan_fec_ini">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="plan_fec_fin">Fecha Final</label>
                                <input name="plan_fec_fin" type="date" class="form-control" id="plan_fec_fin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="plan_hor_ini">Horario</label>
                                <input name="plan_hor_ini" type="time" class="form-control" id="plan_hor_ini">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step" data-step="3" style="display: none;">
                    <div class="row">
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

                        <input type="hidden" name="plan_horario" id="schedules_json">
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
