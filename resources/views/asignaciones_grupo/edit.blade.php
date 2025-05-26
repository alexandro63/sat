<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Asignación de grupo
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

            <form action="{{ route('group_assign.update', $group_assign->gus_id) }}" method="POST"
                id="add_group_assign">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="gus_usu_id">Usuario</label>
                            <select name="gus_usu_id" id="gus_usu_id" class="form-control">
                                <option value="{{ $group_assign->gus_usu_id }}">({{ $group_assign->user->user_name }})
                                    {{ $group_assign->user->people->per_nombres }}
                                    {{ $group_assign->user->people->per_apellidopat }}
                                    {{ $group_assign->user->people->per_apellidomat }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="gus_gru_id">Grupo</label>
                            <select name="gus_gru_id" id="gus_gru_id" class="form-control">
                                <option value="{{ $group_assign->gus_gru_id }}">{{ $group_assign->group->gru_nombre }}
                                </option>
                            </select>
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
