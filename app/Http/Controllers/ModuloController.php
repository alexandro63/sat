<?php

namespace App\Http\Controllers;

use App\Models\Metodologia;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('modulo.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $modulos = Modulo::with(['docente', 'metodologia'])->select(['id', 'codigo', 'nombre', 'id_docente', 'id_metodologia', 'duracion', 'descripcion', 'fecha_inicio', 'fecha_finalizacion'])->orderBy('id', 'desc');
            return DataTables::of($modulos)
                ->addColumn('action', function ($row) {
                    $editUrl = route('modulos.edit', $row->id);
                    $deleteUrl = route('modulos.destroy', $row->id);

                    $canEdit = auth()->user()->can('proyecto.update');
                    $canDelete = auth()->user()->can('proyecto.delete');

                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_modulo"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_modulo"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })

                ->addColumn('docente', function ($row) {
                    return $row->docente->persona->apellidopat . ' ' . $row->docente->persona->apellidomat . ' ' . $row->docente->persona->nombres;
                })
                ->addColumn('metodologia', function ($row) {
                    return $row->metodologia->nombre;
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('modulos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('modulo.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('modulos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('modulo.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['codigo', 'nombre', 'id_docente', 'id_metodologia', 'duracion', 'descripcion', 'fecha_inicio', 'fecha_finalizacion']);
            $input['codigo'] = $input['codigo'];
            $input['nombre'] = ucfirst(strtolower($input['nombre']));
            $input['id_docente'] = $input['id_docente'];
            $input['id_metodologia'] = $input['id_metodologia'];
            $input['duracion'] = $input['duracion'];
            $input['descripcion'] = $input['descripcion'];
            $input['fecha_inicio'] = $input['fecha_inicio'];
            $input['fecha_finalizacion'] = $input['fecha_finalizacion'];

            Modulo::create($input);

            $output = [
                'success' => true,
                'msg'     => __('messages.add_success'),
            ];
        } catch (\Exception $e) {
            Log::emergency(__('messages.error_log'), [
                'Archivo' => $e->getFile(),
                'Línea'   => $e->getLine(),
                'Mensaje' => $e->getMessage(),
            ]);
            $output = [
                'success' => false,
                'msg'     => __('messages.something_went_wrong'),
            ];
        }
        return response()->json($output);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (! auth()->user()->can('modulo.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('modulo.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $modulo = Modulo::find($id);
            return view('modulos/edit', compact('modulo'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('modulo.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['codigo', 'nombre', 'id_docente', 'id_metodologia', 'duracion', 'descripcion', 'fecha_inicio', 'fecha_finalizacion']);

                $modulo = Modulo::findOrFail($id);
                $modulo->codigo = $input['codigo'];
                $modulo->nombre = ucfirst(strtolower($input['nombre']));
                $modulo->id_docente = $input['id_docente'];
                $modulo->id_metodologia = $input['id_metodologia'];
                $modulo->duracion = $input['duracion'];
                $modulo->descripcion = $input['descripcion'];
                $modulo->fecha_inicio = $input['fecha_inicio'];
                $modulo->fecha_finalizacion = $input['fecha_finalizacion'];
                $modulo->save();

                $output = [
                    'success' => true,
                    'msg' => __('messages.updated_success'),
                ];
            } catch (\Exception $e) {
                Log::emergency(__('messages.error_log'), [
                    'Archivo' => $e->getFile(),
                    'Línea'   => $e->getLine(),
                    'Mensaje' => $e->getMessage(),
                ]);

                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! auth()->user()->can('modulo.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $modulo = Modulo::findOrFail($id);
                $modulo->delete();

                $output = [
                    'success' => true,
                    'msg' => __('messages.deleted_success'),
                ];
            } catch (\Exception $e) {
                Log::emergency(__('messages.error_log'), [
                    'Archivo' => $e->getFile(),
                    'Línea'   => $e->getLine(),
                    'Mensaje' => $e->getMessage(),
                ]);

                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    public function getModulosData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $modulos = Modulo::where('nombre', 'like', '%' . $term . '%');

        return $modulos->with('persona')->paginate(5, ['*'], 'page', $page);
    }
}
