<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
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
                Llena todos los campos con (*) para actualizar el registro.
            </p>

            <form action="{{ route('usuarios.update', $user->id) }}" method="POST" id="edit_user">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Persona</label>
                            <select class="form-control" name="per_id" id="per_id">
                                <option value="{{ $user->persona->id }}">{{ $user->persona->nombres }}
                                    {{ $user->persona->apellidopat }} {{ $user->persona->apellidomat}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="role">Permiso</label>
                            <select class="form-control" name="role" class="form-control">
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $key }}" selected>
                                        {{-- {{ $key ? 'selected' : '' }}> --}}
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Nombre de Usuario</label>
                            <input name="user_name" type="text" class="form-control" placeholder="Ingrese usuario"
                                value="{{ $user->user_name }}">
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
                                <input class="form-check-input" type="checkbox" {{ $user->status ? 'checked' : '' }}
                                    name="status">
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
