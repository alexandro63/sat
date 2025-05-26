@props([
    'id' => 'customModal',
    'title' => 'Formulario',
    'route' => '#',
    'method' => 'POST',
    'create' => true,
    'position' => 'centered',
    'size' => 'lg',
    'effect' => 'fade',
    'id_form' => null,
])

<div class="modal {{ $effect }}" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-{{ $position }} modal-{{ $size }}" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd bg-primary">
                <h3 class="modal-title">
                    <span class="fw-mediumbold">
                        {{ $create ? 'Nuevo' : 'Editar' }}
                    </span>
                    <span class="fw-light">
                        {{ $title }}
                    </span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">
                    {{ $create ? 'Llena todos los campos para crear un nuevo registro.' : 'Modifica los campos necesarios y guarda los cambios.' }}
                </p>

                <form action="{{ $route }}" method="POST" id={{ 'id_form' }}>
                    @csrf
                    @if (!$create)
                        @method('PUT')
                    @endif

                    {{ $slot }}

                    <div class="modal-footer no-bd mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ $create ? 'Guardar' : 'Actualizar' }}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
