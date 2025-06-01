<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Plantel Administativo
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

            <form action="{{ route('plantel-administrativo.update', $plantel->id) }}" method="POST" id="edit_plantel">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="per_id">C.I.</label>
                            <select class="form-control" name="per_id" id="per_id">
                                @if (!empty($plantel->per_id))
                                    <option value="{{ $plantel->per_id }}" selected>
                                        (C.I. {{ $plantel->persona->carnet }}) {{ $plantel->persona->nombres }}
                                        {{ $plantel->persona->apellidopat }} {{ $plantel->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="cargo">Cargo</label>
                            <input name="cargo" type="text" class="form-control" id="cargo"
                                placeholder="Ingrese cargo" value="{{ $plantel->cargo }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="unidad">Unidad</label>
                            <input name="unidad" type="text" class="form-control" id="unidad"
                                placeholder="Ingrese unidad" value="{{ $plantel->unidad }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="estado"
                                    {{ $plantel->estado ? 'checked' : '' }}>
                                <span class="form-check-sign">Habilitado?</span>
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
