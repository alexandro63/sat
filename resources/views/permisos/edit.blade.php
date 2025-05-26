@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')
    <div class="page-inner">
        <x-breadcrumb title="Editar Rol" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0">Editar Rol</h4>
                        <a href="{{ route('roles.index') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i> Volver a Roles
                        </a>
                    </div>

                    <div class="card-body">
                        <p class="text-muted small mb-4">
                            Completa todos los campos marcados con (*) para editar un rol.
                        </p>

                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label for="name">Nombre del Rol</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Ingrese nombre del rol" required value="{{ $role->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label for="start_path">Ruta de Inicio</label>
                                        <select id="start_path" name="start_path" class="form-control select2" required>
                                            @if (!empty($role->start_path))
                                                <option value="{{ $role->start_path }}">{{ $role->start_path }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Permisos Disponibles</h4>
                                            <div class="form-check">
                                                <label class="form-check-label mb-0">
                                                    <input type="checkbox" class="form-check-input" id="select_all">
                                                    <span class="form-check-sign">Marcar Todos</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            @php
                                                $acciones = [
                                                    'view' => 'Ver',
                                                    'index' => 'Lista',
                                                    'create' => 'Crear',
                                                    'update' => 'Editar',
                                                    'delete' => 'Eliminar',
                                                ];

                                                $groupedPermissions = [];

                                                foreach ($permissions as $permission) {
                                                    $parts = explode('.', $permission);
                                                    $grupo = $parts[0];
                                                    $accion = end($parts);
                                                    $label = $acciones[$accion] ?? ucfirst($accion);

                                                    $groupedPermissions[$grupo][] = [
                                                        'full' => $permission,
                                                        'label' => $label,
                                                        'accion' => $accion,
                                                    ];
                                                }

                                                foreach ($groupedPermissions as &$group) {
                                                    usort($group, function ($a, $b) use ($acciones) {
                                                        $order = array_keys($acciones);
                                                        return array_search($a['accion'], $order) <=>
                                                            array_search($b['accion'], $order);
                                                    });
                                                }
                                            @endphp

                                            {{-- Tabs de grupos de permisos --}}
                                            <ul class="nav nav-pills nav-secondary mb-3" id="permission-tabs"
                                                role="tablist">
                                                @foreach ($groupedPermissions as $groupName => $perms)
                                                    <li class="nav-item">
                                                        <a class="nav-link @if ($loop->first) active @endif"
                                                            id="tab-{{ $groupName }}-tab" data-toggle="pill"
                                                            href="#tab-{{ $groupName }}" role="tab"
                                                            aria-controls="tab-{{ $groupName }}"
                                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                            {{ ucfirst(str_replace(['_', '-'], ' ', $groupName)) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            {{-- Contenido de permisos por grupo --}}
                                            <div class="tab-content" id="permission-tabs-content">
                                                @foreach ($groupedPermissions as $groupName => $groupPermissions)
                                                    <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                        id="tab-{{ $groupName }}" role="tabpanel"
                                                        aria-labelledby="tab-{{ $groupName }}-tab">
                                                        <div class="row">
                                                            @foreach ($groupPermissions as $perm)
                                                                <div class="col-md-3">
                                                                    <div class="form-check mb-2">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                name="permissions[]"
                                                                                value="{{ $perm['full'] }}"
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
                            <div class="card-footer text-right mt-3">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app/roles.js') }}"></script>
@endpush
