<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Materia
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

            <form action="{{ route('subjects.update', $subject->mat_id) }}" method="POST" id="edit_subject">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="mat_car_id">Nombre de Carrera</label>
                            <select class="form-control" name="mat_car_id" id="mat_car_id" style="width: 100%">
                                @if (!empty($subject))
                                    <option value="{{ $subject->mat_car_id }}" selected>
                                        {{ $subject->degree->car_nombre }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="mat_nombre">Nombre de Materia</label>
                            <input name="mat_nombre" type="text" class="form-control" placeholder="Ingrese materia"
                                id="mat_nombre" value="{{ $subject->mat_nombre }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="mat_descripcion">Descripción de Materia</label>
                            <textarea name="mat_descripcion" id="mat_descripcion" rows="3" cols="45" placeholder="Ingrese descripción">{{ $subject->mat_descripcion }}</textarea>
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
