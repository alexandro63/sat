<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Alumno Inscrito
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

            <form action="{{ route('student_enrollments.store') }}" method="POST" id="add_student_enrollment">
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
                                <label for="alu_per_id">Alumno</label>
                                <select class="form-control" name="alu_per_id" id="alu_per_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="alu_car_id">Carrera</label>
                                <select class="form-control" name="alu_car_id" id="alu_car_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="alu_doc_id">Docente</label>
                                <select class="form-control" name="alu_doc_id" id="alu_doc_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="alu_doc_rev_id">Revisor</label>
                                <select class="form-control" name="alu_doc_rev_id" id="alu_doc_rev_id">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step" data-step="2" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="alu_fec_ing">Fecha de Inscripción</label>
                                <input name="alu_fec_ing" type="date" class="form-control" id="alu_fec_ing">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label for="alu_turno">Turno</label>
                                <select class="form-control" name="alu_turno" id="alu_turno">
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach ($shifts as $key => $shift)
                                        <option value="{{ $key }}"> {{ $shift }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="alu_fec_1er">Fecha de 1ra Entrega</label>
                                <input name="alu_fec_1er" type="date" class="form-control" id="alu_fec_1er">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="alu_fec_2do">Fecha de 2do Entrega</label>
                                <input name="alu_fec_2do" type="date" class="form-control" id="alu_fec_2do">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label form="alu_fec_pre">Fecha de Predefensa</label>
                                <input name="alu_fec_pre" type="date" class="form-control" id="alu_fec_pre">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="step" data-step="3" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="alu_estado">
                                    <span class="form-check-sign">Habilitado?</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="alu_con_car">
                                    <span class="form-check-sign">Concluyó Carrera?</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alu_obs">Observación</label>
                                <textarea class="form-control" id="alu_obs" rows="4" name="alu_obs" placeholder="Ingrese observación"></textarea>
                            </div>
                        </div>
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
