<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Carrera
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

            <form action="{{ route('degrees.update', $degree->car_id) }}" method="POST" id="edit_degree">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                            <label for="car_nombre">Nombre de Carrera</label>
                            <input type="text" class="form-control" id="car_nombre" name="car_nombre"
                                placeholder="Ingrese nombre carrera" value="{{ $degree->car_nombre }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="car_duracion">Duración de Carrera (Meses)</label>
                            <input type="text" class="form-control input-number" id="car_duracion"
                                name="car_duracion" value="{{ $degree->car_duracion }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="car_descripcion">Descripción de Carrera</label>
                            <textarea name="car_descripcion" id="car_descripcion" placeholder="Ingrese descripción" rows="3" cols="45">{{ $degree->car_descripcion }}</textarea>
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
