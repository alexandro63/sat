<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Ambiente
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

            <form action="{{ route('classrooms.update', $classroom->amb_id) }}" method="POST" id="edit_classroom">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                            <label for="amb_nombre">Nombre</label>
                            <input type="text" class="form-control" id="amb_nombre" name="amb_nombre"
                                placeholder="Ingrese nombre" value="{{ $classroom->amb_nombre }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="amb_capacidad">Capacidad</label>
                            <input type="text" class="form-control input-number" id="amb_capacidad"
                                name="amb_capacidad" placeholder="Ingrese capacidad"
                                value="{{ $classroom->amb_capacidad }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="amb_piso">Piso</label>
                            <input type="text" class="form-control input-number" id="amb_piso" name="amb_piso"
                                placeholder="Ingrese piso" value="{{ $classroom->amb_piso }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="amb_descripcion">Descripción</label>
                            <textarea name="amb_descripcion" id="amb_descripcion" placeholder="Ingrese descripción" rows="3" cols="45">{{ $classroom->amb_descripcion }}</textarea>
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
