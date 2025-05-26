<!-- permisos//show -->
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd bg-primary">
            <h3 class="modal-title">
                <span class="fw-mediumbold">
                    Editar
                </span>
                <span class="fw-light">
                    Permiso
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

            <form action="{{ route('roles.update', $role->id) }}" method="POST" id="edit_role">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default required">
                            <label for="name">Nombre de Permiso</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Ingrese nombre permiso" value="{{ $role->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="select_all" value="select_all"
                                    name="">
                                <span class="form-check-sign">Marcar Todo</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $acciones = [
                                            'view' => 'Ver',
                                            'create' => 'Crear',
                                            'update' => 'Editar',
                                            'delete' => 'Eliminar',
                                            'index' => 'Listar',
                                        ];

                                        // Agrupar permisos por módulo
                                        $groupedPermissions = [];

                                        foreach ($permissions as $permission) {
                                            $parts = explode('.', $permission);
                                            $grupo = $parts[0]; // ejemplo: 'administrativo'

                                            // Extraer acción final
                                            $accion = end($parts);

                                            // Traducir acción
                                            $label = $acciones[$accion] ?? ucfirst($accion);

                                            // Guardar agrupado
                                            $groupedPermissions[$grupo][] = [
                                                'full' => $permission,
                                                'label' => $label,
                                            ];
                                        }
                                    @endphp

                                    <div class="row">
                                        @foreach ($groupedPermissions as $groupName => $groupPermissions)
                                            <div class="col-md-12">
                                                <h5 class="mt-3 text-uppercase font-weight-bold">
                                                    {{ ucfirst(str_replace(['_', '-'], ' ', $groupName)) }}
                                                </h5>
                                                <div class="row">
                                                    @foreach ($groupPermissions as $perm)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="permissions[]" value="{{ $perm['full'] }}"
                                                                        {{ in_array($perm['full'], $role_permissions) ? 'checked' : '' }}>
                                                                    <span
                                                                        class="form-check-sign">{{ $perm['label'] }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
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
