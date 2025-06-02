<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Nuevo
                </span>
                <span class="fw-light">
                    Pago
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

            <form action="{{ route('pagos.update', $pago->id) }}" method="POST" id="edit_pago"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="id_estudiante">Estudiante</label>
                            <select class="form-control" name="id_estudiante" id="id_estudiante">
                                @if (!empty($pago->id_estudiante))
                                    <option value="{{ $pago->id_estudiante }}" selected>
                                        (C.I. {{ $pago->estudiante->persona->carnet }})
                                        {{ $pago->estudiante->persona->nombres }}
                                        {{ $pago->estudiante->persona->apellidopat }}
                                        {{ $pago->estudiante->persona->apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="fecha">Fecha</label>
                            <input name="fecha" type="date" class="form-control" id="fecha"
                                value="{{ $pago->fecha }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="monto">Monto</label>
                            <input name="monto" type="text" class="form-control input-number" id="monto"
                                placeholder="Ingrese monto Bs." value="{{ $pago->monto }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label form="metodo">Método de Pago</label>
                            <select class="form-control" name="metodo" id="metodo">
                                <option selected disabled>Seleccionar</option>
                                @foreach ($metodos as $key => $metodo)
                                    <option value="{{ $key }}" {{ $key === $pago->metodo ? 'selected' : '' }}>
                                        {{ $metodo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label form="comprobante">Comprobante</label>
                            <input name="comprobante" type="file" class="form-control" id="comprobante"
                                accept=".jpg,.jpeg,.png,.pdf">
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
