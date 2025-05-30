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

            <form action="{{ route('teachers.update', $teacher->doc_id) }}" method="POST" id="edit_teacher">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_per_id">C.I.</label>
                            <select class="form-control" name="doc_per_id" id="doc_per_id">
                                @if (!empty($teacher->doc_per_id))
                                    <option value="{{ $teacher->doc_per_id }}" selected>
                                        (C.I. {{ $teacher->people->per_ci }})
                                        {{ $teacher->people->per_nombres }} {{ $teacher->people->per_apellidopat }}
                                        {{ $teacher->people->per_apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                            <label for="doc_grado_academico">Grado Acádemico</label>
                            <select class="form-control select2" name="doc_grado_academico" id="doc_grado_academico">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($grade_academic as $key => $grade)
                                    <option value="{{ $key }}"
                                        {{ $teacher->doc_grado_academico == $key ? 'selected' : '' }}>
                                        {{ $grade }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="doc_fec_ing">Fecha de Ingreso</label>
                            <input name="doc_fec_ing" type="date" class="form-control" id="doc_fec_ing"
                                value="{{ $teacher->doc_fec_ing }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="doc_observaciones">Observaciones</label>
                            <textarea class="form-control" placeholder="Ingrese observaciones" name="doc_observaciones" id="doc_observaciones">{{ $teacher->doc_observaciones }}</textarea>
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
