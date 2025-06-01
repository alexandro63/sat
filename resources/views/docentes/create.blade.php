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

            <form action="{{ route('docentes.store') }}" method="POST" id="add_teacher">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="per_id">C.I.</label>
                            <select class="form-control" name="per_id" id="per_id" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="numero_item">N° de Item</label>
                            <input name="numero_item" type="text" class="form-control" id="numero_item"
                                placeholder="Ingrese nº item">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="especialidad">Especialidad</label>
                            <input name="especialidad" type="text" class="form-control" id="especialidad"
                                placeholder="Ingrese especialidad">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="tipo_contrato">Tipo de contrato</label>
                            <input name="tipo_contrato" type="text" class="form-control" id="tipo_contrato"
                                placeholder="Ingrese tipo de contrato">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="estado">
                                <span class="form-check-sign">Habilitado?</span>
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
