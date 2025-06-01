<?php

namespace App\Http\Controllers;

use App\Models\ProgramaAcademico;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ProgramaAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('programa_academico.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $programaAcademico = ProgramaAcademico::select(['id', 'codigo', 'nombre_programa', 'modalidad', 'facultad', 'nivel', 'estado'])->orderBy('id', 'desc');
            return DataTables::of($programaAcademico)
                ->addColumn('action', function ($row) {
                    $editUrl = route('programa-academico.edit', $row->id);
                    $deleteUrl = route('programa-academico.destroy', $row->id);

                    $canEdit = auth()->user()->can('programa_academico.update');
                    $canDelete = auth()->user()->can('programa_academico.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_programa_academico"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_programa_academico"
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

        return view('programa_academico.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('programa_academico.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('programa_academico.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('programa_academico.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['codigo', 'nombre_programa', 'modalidad', 'facultad', 'nivel']);
            $input['nombre_programa'] = ucfirst(strtolower($input['nombre_programa']));
            $input['modalidad']       = ucfirst(strtolower($input['modalidad']));
            $input['facultad']        = ucfirst(strtolower($input['facultad']));
            $input['nivel']           = ucfirst(strtolower($input['nivel']));
            $status = $request->has('estado') ? 1 : 0;
            $input['estado'] = $status;
            ProgramaAcademico::create($input);

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
        if (! auth()->user()->can('programa_academico.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('programa_academico.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $programaAcademico = ProgramaAcademico::find($id);
            return view('programa_academico/edit', compact('programaAcademico'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('programa_academico.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['codigo', 'nombre_programa', 'modalidad', 'facultad', 'nivel']);
                $programaAcademico = ProgramaAcademico::findOrFail($id);
                $programaAcademico->codigo = $input['codigo'];
                $programaAcademico->nombre_programa = ucfirst(strtolower($input['nombre_programa']));
                $programaAcademico->modalidad = ucfirst(strtolower($input['modalidad']));
                $programaAcademico->facultad = ucfirst(strtolower($input['facultad']));
                $programaAcademico->nivel = ucfirst(strtolower($input['nivel']));
                $programaAcademico->estado = $request->has('estado') ? 1 : 0;
                $programaAcademico->save();

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
        if (! auth()->user()->can('programa_academico.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $programaAcademico = ProgramaAcademico::findOrFail($id);
                $programaAcademico->delete();

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

    public function getProgramaAcademicoData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $programaAcademico = ProgramaAcademico::where('estado', 1)
            ->orWhere('codigo', 'like', '%' . $term . '%')
            ->orWhere('nombre_programa', 'like', '%' . $term . '%')
            ->orWhere('modalidad', 'like', '%' . $term . '%');

        return $programaAcademico->paginate(5, ['*'], 'page', $page);
    }
}
