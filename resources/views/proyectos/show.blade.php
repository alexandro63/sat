<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Datos de
                </span>
                <span class="fw-light">
                    Revison de Proyecto (Estudiante: {{$proyecto->estudiante->persona->nombres}} {{$proyecto->estudiante->persona->apellidopat}} {{$proyecto->estudiante->persona->apellidopat}})
                </span>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Calificación</th>
                                <th>Fecha de Entrega</th>
                                <th>Fecha de Defensa</th>
                                <th>Resumén</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $proyecto->calificacion }}</td>
                                <td>{{ $proyecto->fecha_entrega }}</td>
                                <td>{{ $proyecto->fecha_defensa }}</td>
                                <td>{{ $proyecto->resumen }}</td>
                                <td>{{ $proyecto->observacion }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
