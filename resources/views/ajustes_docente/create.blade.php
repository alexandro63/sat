<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Ajuste Docente
                </span>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="small">
               Llene todos los campos marcados con (*).
            </p>

            <form action="{{ route('teacher_settings.store') }}" method="POST" id="add_teacher_settings">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="per_id">Docente</label>
                            <select class="form-control" name="per_id" id="per_id">
                                <option value="" disabled>Seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Fecha de Descuento</label>
                            <input name="user_name" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="per_id">Motivo Descuento</label>
                            <select class="form-control" name="per_id" id="per_id">
                                <option value="" disabled>Seleccione</option>
                                @foreach ($discount_reason as $key => $discount)
                                    <option value="{{ $key }}">{{ $discount }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label>Total Descuento</label>
                            <div class="input-icon">
                                <input name="user_name" type="text" class="form-control input-number"
                                    placeholder="Total descuento">
                                <span class="input-icon-addon">
                                    Bs.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default requiered">
                            <label for="amb_descripcion">Observaciones</label>
                            <textarea name="amb_descripcion" id="amb_descripcion" placeholder="Ingrese Observación" rows="3" cols="45"></textarea>
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
