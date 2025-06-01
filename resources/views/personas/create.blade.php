<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nueva
                </span>
                <span class="fw-light">
                    Persona
                </span>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="small">
                Llena todos los campos para crear un nuevo registro.
            </p>

            <form action="{{ route('personas.store') }}" method="POST" id="add_person">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>C.I</label>
                            <input name="carnet" type="text" class="form-control input-number"
                                placeholder="Ingrese cédula de identidad">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Nombres</label>
                            <input name="nombres" type="text" class="form-control" placeholder="Ingrese nombres">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Primer Apellido</label>
                            <input name="apellidopat" type="text" class="form-control"
                                placeholder="Ingrese 1er apellido">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Segundo Apellido</label>
                            <input name="apellidomat" type="text" class="form-control"
                                placeholder="Ingrese 2do apellido">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Fecha de nacimiento</label>
                            <input name="fecha_nacimiento" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Telefono</label>
                            <input name="telefono" type="text" class="form-control input-number"
                                placeholder="Ingrese telefono">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Correo</label>
                            <input name="correo" type="email" class="form-control" placeholder="Ingrese correo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Dirección</label>
                            <input name="direccion" type="text" class="form-control"
                                placeholder="Ingrese dirección">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="per_estado">
                                <span class="form-check-sign">Habilitado</span>
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
