<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
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
                Actualiza todos los campos con (*) para editar este registro.
            </p>

            <form action="{{ route('personas.update', $persona->id) }}" method="POST" id="edit_person">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>C.I</label>
                            <input name="carnet" type="text" class="form-control input-number"
                                placeholder="Ingrese cédula de identidad" value="{{ $persona->carnet }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Nombres</label>
                            <input name="nombres" type="text" class="form-control" placeholder="Ingrese nombres"
                                value="{{ $persona->nombres }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Primer Apellido</label>
                            <input name="apellidopat" type="text" class="form-control"
                                placeholder="Ingrese 1er apellido" value="{{ $persona->apellidopat }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Segundo Apellido</label>
                            <input name="apellidomat" type="text" class="form-control"
                                placeholder="Ingrese 2do apellido" value="{{ $persona->apellidomat }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Fecha de nacimiento</label>
                            <input name="fecha_nacimiento" type="date" class="form-control" value="{{ $persona->fecha_nacimiento }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Telefono</label>
                            <input name="telefono" type="text" class="form-control input-number"
                                placeholder="Ingrese telefono" value="{{ $persona->telefono }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Correo</label>
                            <input name="correo" type="email" class="form-control" placeholder="Ingrese correo" value="{{ $persona->correo }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Dirección</label>
                            <input name="direccion" type="text" class="form-control"
                                placeholder="Ingrese dirección" value="{{ $persona->direccion }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="estado"
                                    {{ $persona->estado == 1 ? 'checked' : '' }}>
                                <span class="form-check-sign">Habilitado</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer no-bd mt-3">
                    <button type="submit" class="btn btn-primary">
                        Actualizar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
