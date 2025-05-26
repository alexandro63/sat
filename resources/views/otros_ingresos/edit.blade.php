<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Ingreso
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

            <form action="{{ route('other_income.update', $other_income->pag_id) }}" method="POST"
                id="edit_other_income">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="pag_alu_id">C.I.</label>
                            <select class="form-control" name="pag_alu_id" id="pag_alu_id">
                                @if (!empty($other_income->pag_alu_id))
                                    <option value="{{ $other_income->pag_alu_id }}">
                                        (C.I. {{ $other_income->student->people->per_ci }})
                                        {{ $other_income->student->people->per_nombres }}
                                        {{ $other_income->student->people->per_apellidopat }}
                                        {{ $other_income->student->people->per_apellidomat }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="pag_rof">N° Recibo o Factura</label>
                            <input type="text" class="form-control" id="pag_rof" name="pag_rof"
                                placeholder="Ingrese n° recibo o factura" value="{{ $other_income->pag_rof }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="pag_monto">Total Pago</label>
                            <div class="input-icon">
                                <input type="text" class="form-control input-number" id="pag_monto" name="pag_monto"
                                    placeholder="Total pagado" value="{{ $other_income->pag_monto }}">
                                <span class="input-icon-addon">
                                    Bs.
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="pag_tipo">Tipo de Pago</label>
                            <select class="form-control" name="pag_tipo" id="pag_tipo">
                                <option selected disabled>Seleccionar</option>
                                @foreach ($type_payments as $key => $type_payment)
                                    <option value="{{ $key }}"
                                        {{ $other_income->pag_tipo === $key ? 'selected' : '' }}>{{ $type_payment }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="pag_cuota">Cantidad</label>
                            <input type="text" class="form-control input-number" id="pag_cuota" name="pag_cuota"
                                placeholder="Ingrese cantidad" value="{{ $other_income->pag_cuota }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="pag_fec_hor">Fecha y Hora</label>
                            <input name="pag_fec_hor" type="datetime-local" class="form-control" id="pag_fec_hor"
                                value="{{ $other_income->pag_fec_hor }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label for="pag_obs">Observaciones</label>
                            <textarea name="pag_obs" id="pag_obs" placeholder="Ingrese observaciones" rows="3" cols="45">{{ $other_income->pag_obs }}</textarea>
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
