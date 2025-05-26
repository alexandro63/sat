<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Usuario
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

            <form action="{{ route('users.store') }}" method="POST" id="add_user">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="per_id">Persona</label>
                            <select class="form-control" name="per_id" id="per_id" style="width: 100%">
                                <option value="" disabled>Seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="role">Permiso</label>
                            <select class="form-control" name="role" id="role" style="width: 100%">
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($roles as $key => $role)
                                    <option value="{{$key}}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Nombre de Usuario</label>
                            <input name="user_name" type="text" class="form-control" placeholder="Ingrese usuario">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Contraseña</label>
                            <input type="text" class="form-control" placeholder="********" name="password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="status">
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
