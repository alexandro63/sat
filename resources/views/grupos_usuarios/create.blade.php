<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Grupo de Usuario
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

            <form action="{{ route('group_users.store') }}" method="POST" id="add_group_user">
                @csrf
                <div class="row">
                    <div class="col-md-6 pr-0 ">
                        <div class="form-group form-group-default required">
                            <label>Nombre</label>
                            <input name="gru_nombre" type="text" class="form-control" placeholder="Ingrese nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Descripción del Grupo</label>
                            <input type="text" class="form-control" placeholder="Ingrese descripción" name="gru_obs">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="gru_estado">
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
