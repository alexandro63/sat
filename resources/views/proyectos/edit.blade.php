<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Proyecto
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

            <form action="{{ route('proyectos.update', $proyecto->id) }}" method="POST" id="edit_proyecto">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_docente_guia">Doc. Guía</label>
                            <select class="form-control" name="id_docente_guia" id="id_docente_guia">
                                @if (!empty($proyecto->id_docente_guia))
                                    <option value="{{ $proyecto->id_docente_guia }}" selected>
                                        (C.I. {{ $proyecto->docenteGuia->persona->carnet }})
                                        {{ $proyecto->docenteGuia->persona->nombres }}
                                        {{ $proyecto->docenteGuia->persona->apellidopat }}
                                        {{ $proyecto->docenteGuia->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_docente_revisor">Doc. Revisor</label>
                            <select class="form-control" name="id_docente_revisor" id="id_docente_revisor">
                                @if (!empty($proyecto->id_docente_revisor))
                                    <option value="{{ $proyecto->id_docente_revisor }}" selected>
                                        (C.I. {{ $proyecto->docenteRevisor->persona->carnet }})
                                        {{ $proyecto->docenteRevisor->persona->nombres }}
                                        {{ $proyecto->docenteRevisor->persona->apellidopat }}
                                        {{ $proyecto->docenteRevisor->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_estudiante">Estudiante</label>
                            <select class="form-control" name="id_estudiante" id="id_estudiante">
                                @if (!empty($proyecto->id_estudiante))
                                    <option value="{{ $proyecto->id_estudiante }}" selected>
                                        (C.I. {{ $proyecto->estudiante->persona->carnet }})
                                        {{ $proyecto->estudiante->persona->nombres }}
                                        {{ $proyecto->estudiante->persona->apellidopat }}
                                        {{ $proyecto->estudiante->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="titulo">Título</label>
                            <input name="titulo" type="text" class="form-control" id="titulo"
                                placeholder="Ingrese titulo" value="{{$proyecto->titulo}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="linea_investigacion">Linea de Investigación</label>
                            <input name="linea_investigacion" type="text" class="form-control"
                                id="linea_investigacion" placeholder="Ingrese linea de investigación" value="{{$proyecto->linea_investigacion}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="area_conocimiento">Area de Conocimiento</label>
                            <input name="area_conocimiento" type="text" class="form-control" id="area_conocimiento"
                                placeholder="Ingrese area de conocimiento" value="{{$proyecto->area_conocimiento}}">
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
