<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Modulo
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

            <form action="{{ route('modulos.store') }}" method="POST" id="add_modulo">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="codigo">Código</label>
                            <input name="codigo" type="text" class="form-control" id="codigo"
                                placeholder="Ingrese codigo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" type="text" class="form-control" id="nombre"
                                placeholder="Ingrese nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_docente">Docente</label>
                            <select class="form-control" name="id_docente" id="id_docente">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_metodologia">Metodología</label>
                            <select class="form-control" name="id_metodologia" id="id_metodologia">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="duracion">Duración</label>
                            <input name="duracion" type="text" class="form-control" id="duracion"
                                placeholder="Ingrese duración">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input name="fecha_inicio" type="date" class="form-control" id="fecha_inicio">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="fecha_finalizacion">Fecha de Finalización</label>
                            <input name="fecha_finalizacion" type="date" class="form-control"
                                id="fecha_finalizacion">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="5"
                                placeholder="Ingrese una descripción..."></textarea>
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
