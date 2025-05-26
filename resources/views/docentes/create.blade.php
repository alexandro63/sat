<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Docente
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

            <form action="{{ route('teachers.store') }}" method="POST" id="add_teacher">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_per_id">C.I.</label>
                            <select class="form-control" name="doc_per_id" id="doc_per_id" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_grado_academico">Grado Acádemico</label>
                            <select class="form-control select2" name="doc_grado_academico" id="doc_grado_academico"
                                style="width: 100%">
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($grade_academic as $key => $grade)
                                    <option value="{{ $key }}">{{ $grade }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="doc_fec_ing">Fecha de Ingreso</label>
                            <input name="doc_fec_ing" type="date" class="form-control" id="doc_fec_ing">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_pago">Pago por Hora Acádemica</label>
                            <input type="text" class="form-control input-number" placeholder="Ingrese Pago x Hora"
                                name="doc_pago" id="doc_pago">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="doc_observaciones">Observaciones</label>
                            <textarea class="form-control" placeholder="Ingrese observaciones" name="doc_observaciones" id="doc_observaciones"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="doc_estado">
                                <span class="form-check-sign">A Prueba?</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer no-bd mt-3">
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
