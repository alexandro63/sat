<?php

namespace App\Http\Controllers;

use App\Helpers\UtilHelper;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $teachers = Teacher::with('people')->select(['doc_id', 'doc_per_id', 'doc_estado'])->orderBy('doc_id', 'desc');
            return DataTables::of($teachers)
                ->addColumn('action', function ($row) {
                    $editUrl = route('teachers.edit', $row->doc_id);
                    $deleteUrl = route('teachers.destroy', $row->doc_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_teacher" title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_teacher" title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->addColumn('documento', function ($row) {
                    return $row->people->per_ci;
                })
                ->addColumn('docente', function ($row) {
                    return $row->people->per_apellidopat . ' ' . $row->people->per_apellidomat . ' ' . $row->people->per_nombres;
                })
                ->addColumn('doc_estado', function ($row) {
                    return $row->doc_estado == 1 ? 'Sí' : 'No';
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
        $grade_academic = UtilHelper::getGradeAcademic();
        return view('docentes.create', compact('grade_academic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = $request->has('doc_estado') ? 1 : 0;
        try {
            $input = $request->only(['doc_per_id', 'doc_grado_academico', 'doc_pago', 'doc_observaciones', 'doc_fec_ing']);
            $input['doc_estado'] = $status;
            $teacher  = Teacher::create($input);

            $output = [
                'success' => true,
                'data'    => $teacher,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $teacher = Teacher::find($id);
            $grade_academic = UtilHelper::getGradeAcademic();
            return view('docentes/edit', compact('teacher', 'grade_academic'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // if (! auth()->user()->can('user.update')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $input = $request->only(['doc_per_id', 'doc_grado_academico', 'doc_pago', 'doc_observaciones', 'doc_fec_ing']);

                $teacher = Teacher::findOrFail($id);
                $teacher->doc_per_id = $input['doc_per_id'];
                $teacher->doc_grado_academico = $input['doc_grado_academico'];
                $teacher->doc_pago = $input['doc_pago'];
                $teacher->doc_observaciones = $input['doc_observaciones'];
                $teacher->doc_fec_ing = $input['doc_fec_ing'];
                $teacher->doc_estado = $request->has('doc_estado') ? 1 : 0;
                $teacher->save();

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
        if (request()->ajax()) {
            try {
                $teacher = Teacher::findOrFail($id);
                $teacher->delete();

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

        $teachers = Teacher::whereHas('people', function ($query) use ($term) {
            $query->where('per_ci', $term)
                ->orWhere('per_nombres', 'like', '%' . $term . '%')
                ->orWhere('per_apellidopat', 'like', '%' . $term . '%')
                ->orWhere('per_apellidomat', 'like', '%' . $term . '%');
        });

        return $teachers->with('people')->paginate(5, ['*'], 'page', $page);
    }
}
