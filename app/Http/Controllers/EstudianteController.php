<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('estudiante.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $estudiantes = Estudiante::with(['persona', 'programaAcademico'])->select(['id', 'per_id', 'id_programa_academico', 'numero_matricula', 'fecha_inscripcion', 'estado'])->orderBy('id', 'desc');
            return DataTables::of($estudiantes)
                ->addColumn('action', function ($row) {
                    $editUrl = route('estudiantes.edit', $row->id);
                    $deleteUrl = route('estudiantes.destroy', $row->id);

                    $canEdit = auth()->user()->can('estudiante.update');
                    $canDelete = auth()->user()->can('estudiante.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_estudiante"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_estudiante"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })

                ->addColumn('estudiante', function ($row) {
                    return 'C.I. '.$row->persona->carnet . '<br> ' . $row->persona->apellidopat . ' ' . $row->persona->apellidomat . ' ' . $row->persona->nombres;
                })
                ->addColumn('programa_academico', function ($row) {
                    return $row->programaAcademico->nombre_programa;
                })
                ->editColumn('estado', function ($row) {
                    return $row->estado ? 'Sí' : 'No';
                })
                ->removeColumn(['id'])
                ->rawColumns(['action','estudiante'])
                ->make(true);
        }

        return view('estudiantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('estudiante.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('estudiantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('estudiante.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['per_id', 'id_programa_academico', 'numero_matricula', 'fecha_inscripcion']);
            $status = $request->has('estado') ? 1 : 0;
            $input['estado'] = $status;
            Estudiante::create($input);

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
        if (! auth()->user()->can('estudiante.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('estudiante.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $estudiante = Estudiante::find($id);
            return view('estudiantes/edit', compact('estudiante'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('estudiante.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['per_id', 'id_programa_academico', 'numero_matricula', 'fecha_inscripcion']);

                $estudiante = Estudiante::findOrFail($id);
                $estudiante->per_id = $input['per_id'];
                $estudiante->id_programa_academico = $input['id_programa_academico'];
                $estudiante->numero_matricula = $input['numero_matricula'];
                $estudiante->fecha_inscripcion = $input['fecha_inscripcion'];
                $estudiante->estado = $request->has('estado') ? 1 : 0;
                $estudiante->save();

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
        if (! auth()->user()->can('estudiante.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $estudiante = Estudiante::findOrFail($id);
                $estudiante->delete();

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

    public function getEstudiantesData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $estudiantes = Estudiante::whereHas('persona', function ($query) use ($term) {
            $query->where('carnet', $term)
                ->orWhere('estado', 1)
                ->orWhere('nombres', 'like', '%' . $term . '%')
                ->orWhere('apellidopat', 'like', '%' . $term . '%')
                ->orWhere('apellidomat', 'like', '%' . $term . '%');
        });

        return $estudiantes->with('persona')->paginate(5, ['*'], 'page', $page);
    }
}
