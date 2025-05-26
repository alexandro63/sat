<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StudentEnrollment;
use Illuminate\Support\Facades\Log;

class StudentEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $student_enrollments = StudentEnrollment::select(['alu_id', 'alu_per_id', 'alu_car_id', 'alu_turno', 'alu_curso', 'alu_estado', 'alu_con_car'])->orderBy('alu_id', 'desc');

            return DataTables::of($student_enrollments)
                ->addColumn('action', function ($row) {
                    $editUrl = route('student_enrollments.edit', $row->alu_id);
                    $showUrl = route('student_enrollments.show', $row->alu_id);
                    $deleteUrl = route('student_enrollments.destroy', $row->alu_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_student_enrollment" title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $showUrl . '" class="btn btn-icon btn-sm btn-round btn-secondary btn-modal" title="Asignación de materia"
                    data-container=".modal_student_enrollment">
                        <i class="far fa-folder"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_student_enrollment" title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->addColumn('cedula', function ($row) {
                    return $row->student->per_ci;
                })
                ->addColumn('alumno', function ($row) {
                    return $row->student->per_apellidopat . ' ' . $row->student->per_apellidomat . ' ' . $row->student->per_nombres;
                })
                ->addColumn('carrera', function ($row) {
                    return $row->degree->car_nombre;
                })
                ->editColumn('alu_curso', function ($row) {
                    return ucfirst($row->alu_curso);
                })
                ->editColumn('alu_turno', function ($row) {
                    return ucfirst($row->alu_turno);
                })
                ->editColumn('alu_con_car', function ($row) {
                    return $row->alu_con_car ? 'Sí' : 'No';
                })
                ->editColumn('alu_estado', function ($row) {
                    return $row->alu_estado ? 'Sí' : 'No';
                })
                ->removeColumn(['alu_id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('alumno_inscripcion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shifts = StudentEnrollment::shifts();
        $courses = StudentEnrollment::courses();
        return view('alumno_inscripcion.create', compact('shifts', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $con_car = $request->has('alu_con_car') ? 1 : 0;
            $estado = $request->has('alu_estado') ? 1 : 0;
            $input = $request->only(['alu_per_id', 'alu_car_id', 'alu_reg_matr', 'alu_mensualidad', 'alu_fec_ing', 'alu_fec_pago', 'alu_turno', 'alu_curso', 'alu_obs']);
            $input['alu_con_car'] = $con_car;
            $input['alu_estado'] = $estado;
            $student_enrollment  = StudentEnrollment::create($input);

            $output = [
                'success' => true,
                'data'    => $student_enrollment,
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
        return view('alumno_inscripcion.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (request()->ajax()) {
            $student_enrollment = StudentEnrollment::find($id);
            $shifts = StudentEnrollment::shifts();
            $courses = StudentEnrollment::courses();
            return view('alumno_inscripcion.edit', compact('student_enrollment', 'shifts', 'courses'));
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
                $input = $request->only(['alu_per_id', 'alu_car_id', 'alu_reg_matr', 'alu_mensualidad', 'alu_fec_ing', 'alu_fec_pago', 'alu_turno', 'alu_curso', 'alu_obs']);

                $student_enrollment = StudentEnrollment::findOrFail($id);
                $student_enrollment->alu_per_id = $input['alu_per_id'];
                $student_enrollment->alu_car_id = $input['alu_car_id'];
                $student_enrollment->alu_reg_matr = $input['alu_reg_matr'];
                $student_enrollment->alu_mensualidad = $input['alu_mensualidad'];
                $student_enrollment->alu_fec_ing = $input['alu_fec_ing'];
                $student_enrollment->alu_fec_pago = $input['alu_fec_pago'];
                $student_enrollment->alu_turno = $input['alu_turno'];
                $student_enrollment->alu_curso = $input['alu_curso'];
                $student_enrollment->alu_obs = $input['alu_obs'];
                $student_enrollment->alu_con_car = $request->has('alu_con_car') ? 1 : 0;
                $student_enrollment->alu_estado = $request->has('alu_estado') ? 1 : 0;

                $student_enrollment->save();

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
                $student_enrollment = StudentEnrollment::findOrFail($id);
                $student_enrollment->delete();

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

    public function getStudentsData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);
        $students = StudentEnrollment::whereHas('people', function ($query) use ($term) {
            $query->where('per_ci', $term)
                ->orWhere('per_nombres', 'like', '%' . $term . '%')
                ->orWhere('per_apellidopat', 'like', '%' . $term . '%')
                ->orWhere('per_apellidomat', 'like', '%' . $term . '%');
        })->where('alu_estado', 1);
        return $students->with('people')->paginate(5, ['*'], 'page', $page);
    }
}
