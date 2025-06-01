<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Programa Académico
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

            <form action="{{ route('programa-academico.update', $programaAcademico->id) }}" method="POST"
                id="edit_programa_academico">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="codigo">Código</label>
                            <input name="codigo" type="text" class="form-control" id="codigo"
                                placeholder="Ingrese código" value="{{ $programaAcademico->codigo }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="nombre_programa">Nombre Programa</label>
                            <input name="nombre_programa" type="text" class="form-control" id="nombre_programa"
                                placeholder="Ingrese nombre de programa"
                                value="{{ $programaAcademico->nombre_programa }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="modalidad">Modalidad</label>
                            <input name="modalidad" type="text" class="form-control" id="modalidad"
                                placeholder="Ingrese modalidad" value="{{ $programaAcademico->modalidad }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="facultad">Facultad</label>
                            <input name="facultad" type="text" class="form-control" id="facultad"
                                placeholder="Ingrese facultad" value="{{ $programaAcademico->facultad }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="nivel">Nivel</label>
                            <input name="nivel" type="text" class="form-control" id="nivel"
                                placeholder="Ingrese nivel" value="{{ $programaAcademico->nivel }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox"
                                    {{ $programaAcademico->estado ? 'checked' : '' }} name="estado">
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
