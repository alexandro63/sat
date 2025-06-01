<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
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

            <form action="{{ route('docentes.update', $docente->id) }}" method="POST" id="edit_teacher">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_per_id">C.I.</label>
                            <select class="form-control" name="per_id" id="per_id">
                                @if (!empty($docente->per_id))
                                    <option value="{{ $docente->per_id }}" selected>
                                        (C.I. {{ $docente->persona->carnet }}) {{ $docente->persona->nombres }} {{ $docente->persona->apellidopat }} {{ $docente->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="numero_item">N° de Item</label>
                            <input name="numero_item" type="text" class="form-control" id="numero_item"
                                placeholder="Ingrese nº item" value="{{ $docente->numero_item }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="especialidad">Especialidad</label>
                            <input name="especialidad" type="text" class="form-control" id="especialidad"
                                placeholder="Ingrese especialidad" value="{{ $docente->especialidad }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="tipo_contrato">Tipo de contrato</label>
                            <input name="tipo_contrato" type="text" class="form-control" id="tipo_contrato"
                                placeholder="Ingrese tipo de contrato" value="{{ $docente->tipo_contrato }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" {{ $docente->estado ? 'checked' : '' }}
                                    name="estado">
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
