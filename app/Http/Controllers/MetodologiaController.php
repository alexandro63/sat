<?php

namespace App\Http\Controllers;

use App\Models\Metodologia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class MetodologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('metodologia.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $metodologias = Metodologia::select(['id', 'nombre', 'descripcion', 'objetivos', 'numero_modulos', 'fecha_inicio', 'fecha_finalizacion'])->orderBy('id', 'desc');
            return DataTables::of($metodologias)
                ->addColumn('action', function ($row) {
                    $editUrl = route('metodologias.edit', $row->id);
                    $deleteUrl = route('metodologias.destroy', $row->id);

                    $canEdit = auth()->user()->can('metodologia.update');
                    $canDelete = auth()->user()->can('metodologia.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_metodologia"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_metodologia"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })

                ->editColumn('estado', function ($row) {
                    return $row->estado ? 'Sí' : 'No';
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('metodologias.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('metodologia.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('metodologias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('metodologia.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['nombre', 'descripcion', 'objetivos', 'numero_modulos', 'fecha_inicio', 'fecha_finalizacion']);
            $input['nombre'] = ucfirst(strtolower($input['nombre']));
            $input['descripcion']       = ucfirst(strtolower($input['descripcion']));
            $input['objetivos']        = ucfirst(strtolower($input['objetivos']));
            $input['numero_modulos']  = $input['numero_modulos'];
            $input['fecha_inicio']  = $input['fecha_inicio'];
            $input['fecha_finalizacion']  = $input['fecha_finalizacion'];
            Metodologia::create($input);

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
        if (! auth()->user()->can('metodologia.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('metodologia.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $metodologia = Metodologia::find($id);
            return view('metodologias/edit', compact('metodologia'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('metodologia.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['nombre', 'descripcion', 'objetivos', 'numero_modulos', 'fecha_inicio', 'fecha_finalizacion']);
                $metodologia = Metodologia::findOrFail($id);
                $metodologia->nombre = ucfirst(strtolower($input['nombre']));
                $metodologia->descripcion = ucfirst(strtolower($input['descripcion']));
                $metodologia->objetivos = ucfirst(strtolower($input['objetivos']));
                $metodologia->numero_modulos = $input['numero_modulos'];
                $metodologia->fecha_inicio = $input['fecha_inicio'];
                $metodologia->fecha_finalizacion = $input['fecha_finalizacion'];
                $metodologia->save();

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
        if (! auth()->user()->can('metodologia.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $metodologia = Metodologia::findOrFail($id);
                $metodologia->delete();

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

    public function getMetodologiasData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $metodologias = Metodologia::where('nombre', 'like', '%' . $term . '%');

        return $metodologias->paginate(5, ['*'], 'page', $page);
    }
}
