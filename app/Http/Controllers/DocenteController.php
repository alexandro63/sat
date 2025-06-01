<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('docente.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $docentes = Docente::with('persona')->select(['id', 'per_id', 'numero_item', 'especialidad', 'estado'])->orderBy('id', 'desc');
            return DataTables::of($docentes)
                ->addColumn('action', function ($row) {
                    $editUrl = route('docentes.edit', $row->id);
                    $deleteUrl = route('docentes.destroy', $row->id);

                    $canEdit = auth()->user()->can('docente.update');
                    $canDelete = auth()->user()->can('docente.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_teacher"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_teacher"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->editColumn('numero_item', function ($row) {
                    return $row->numero_item;
                })
                ->addColumn('documento', function ($row) {
                    return $row->persona->carnet;
                })
                ->addColumn('docente', function ($row) {
                    return $row->persona->apellidopat . ' ' . $row->persona->apellidomat . ' ' . $row->persona->nombres;
                })
                ->editColumn('especialidad', function ($row) {
                    return $row->especialidad;
                })
                ->editColumn('estado', function ($row) {
                    return $row->estado ? 'Sí' : 'No';
                })
                ->removeColumn(['doc_id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('docentes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('docente.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('docente.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['per_id', 'numero_item', 'especialidad', 'tipo_contrato']);
            $status = $request->has('estado') ? 1 : 0;
            Docente::create($input);

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

        // Devuelve siempre JSON con cabecera correcta
        return response()->json($output);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (! auth()->user()->can('docente.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('docente.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $docente = Docente::find($id);
            return view('docentes/edit', compact('docente'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('docente.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['per_id', 'numero_item', 'especialidad', 'tipo_contrato']);

                $docente = Docente::findOrFail($id);
                $docente->per_id = $input['per_id'];
                $docente->numero_item = $input['numero_item'];
                $docente->especialidad = $input['especialidad'];
                $docente->tipo_contrato = $input['tipo_contrato'];
                $docente->estado = $request->has('estado') ? 1 : 0;
                $docente->save();

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
        if (! auth()->user()->can('docente.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $docente = Docente::findOrFail($id);
                $docente->delete();

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

    public function getTeachersData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $docentes = Docente::whereHas('persona', function ($query) use ($term) {
            $query->where('carnet', $term)
                ->orWhere('nombres', 'like', '%' . $term . '%')
                ->orWhere('apellidopat', 'like', '%' . $term . '%')
                ->orWhere('apellidomat', 'like', '%' . $term . '%');
        });

        return $docentes->with('people')->paginate(5, ['*'], 'page', $page);
    }
}
