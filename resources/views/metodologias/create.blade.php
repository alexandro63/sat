<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nueva
                </span>
                <span class="fw-light">
                    Metodología
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

            <form action="{{ route('metodologias.store') }}" method="POST" id="add_metodologia">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="nombre">Nombre</label>
                            <input name="nombre" type="text" class="form-control" id="nombre"
                                placeholder="Ingrese nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="descripcion">Descripción</label>
                            <input name="descripcion" type="text" class="form-control" id="descripcion"
                                placeholder="Ingrese descripción">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="objetivos">Objetivos</label>
                            <input name="objetivos" type="text" class="form-control" id="objetivos"
                                placeholder="Ingrese objetivos">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="numero_modulos">N° Modulos</label>
                            <input name="numero_modulos" type="text" class="form-control input-number"
                                id="numero_modulos" placeholder="Ingrese n° modulos">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="fecha_inicio">Fecha de Inicio</label>
                            <input name="fecha_inicio" type="date" class="form-control" id="fecha_inicio">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="fecha_finalizacion">Fecha de Finalización</label>
                            <input name="fecha_finalizacion" type="date" class="form-control"
                                id="fecha_finalizacion">
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
