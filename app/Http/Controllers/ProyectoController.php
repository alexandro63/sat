<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('proyecto.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $proyectos = Proyecto::with(['docenteGuia', 'docenteRevisor', 'estudiante'])->select(['id', 'id_docente_revisor', 'id_docente_guia', 'id_estudiante', 'titulo', 'linea_investigacion'])->orderBy('id', 'desc');
            return DataTables::of($proyectos)
                ->addColumn('action', function ($row) {
                    $editUrl = route('proyectos.edit', $row->id);
                    $revisionUrl = route('proyectos.revison', $row->id);
                    $viewUrl = route('proyectos.view', $row->id);
                    $deleteUrl = route('proyectos.destroy', $row->id);

                    $canEdit = auth()->user()->can('proyecto.update');
                    $canDelete = auth()->user()->can('proyecto.delete');
                    $canRevision = auth()->user()->can('proyecto.revision');
                    $canView = auth()->user()->can('proyecto.view');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';
                    $revisionDisabled = $canRevision ? '' : 'disabled';
                    $viewDisabled = $canView ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_proyecto"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons = '
                    <button data-href="' . $revisionUrl . '" class="btn btn-icon btn-sm btn-round btn-primary revision_proyecto"
                    ' . $revisionDisabled . ' title="Revisión">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons = '
                    <button data-href="' . $viewUrl . '" class="btn btn-icon btn-sm btn-round btn-primary view_proyecto"
                    ' . $viewDisabled . ' title="Ver">
                        <i class="icon-eye"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_proyecto"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })

                ->addColumn('docente_guia', function ($row) {
                    return $row->docente->persona->apellidopat . ' ' . $row->docente->persona->apellidomat . ' ' . $row->docente->persona->nombres;
                })
                ->addColumn('docente_revisor', function ($row) {
                    return $row->docente->persona->apellidopat . ' ' . $row->docente->persona->apellidomat . ' ' . $row->docente->persona->nombres;
                })
                ->addColumn('estudiante', function ($row) {
                    return $row->estudiante->persona->apellidopat . ' ' . $row->estudiante->persona->apellidomat . ' ' . $row->estudiante->persona->nombres;
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('proyectos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('proyecto.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('proyectos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('proyecto.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['id_docente_guia', 'id_docente_revisor', 'id_estudiante', 'titulo', 'linea_investigacion', 'area_conocimiento']);
            $input['titulo'] = ucfirst(strtolower($input['titulo']));
            $input['linea_investigacion'] = ucfirst(strtolower($input['linea_investigacion']));
            $input['area_conocimiento'] = ucfirst(strtolower($input['area_conocimiento']));
            Proyecto::create($input);

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
        if (! auth()->user()->can('proyecto.view')) {
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
