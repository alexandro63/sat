<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Revison de
                </span>
                <span class="fw-light">
                    Proyecto (Estudiante: {{$proyecto->estudiante->persona->nombres}} {{$proyecto->estudiante->persona->apellidopat}} {{$proyecto->estudiante->persona->apellidopat}})
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

            <form action="{{ route('proyecto.revision.update', $proyecto->id) }}" method="POST" id="revision_proyecto">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="calificacion">Calificación</label>
                            <input name="calificacion" type="text" class="form-control" id="calificacion"
                                placeholder="Ingrese calificacion" value="{{$proyecto->calificacion}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="fecha_entrega">Fecha de Entrega</label>
                            <input name="fecha_entrega" type="date" class="form-control" id="fecha_entrega" value="{{$proyecto->fecha_entrega}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label form="fecha_defensa">Fecha de Defensa</label>
                            <input name="fecha_defensa" type="date" class="form-control" id="fecha_defensa" value="{{$proyecto->fecha_defensa}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label form="resumen">Resumen</label>
                            <textarea name="resumen" id="resumen" class="form-control" cols="30" rows="5"
                                placeholder="Ingrese resumen...">{{$proyecto->resumen}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label form="observacion">Observación</label>
                            <textarea name="observacion" id="observacion" class="form-control" cols="30" rows="5"
                                placeholder="Ingrese observacion...">{{$proyecto->resumen}}</textarea>
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
