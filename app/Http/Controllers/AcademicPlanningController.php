<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicPlanning;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class AcademicPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('plan_academico.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $academic_planning = AcademicPlanning::with([
                'subject:mat_id,mat_nombre',
                'classroom:amb_id,amb_nombre',
                'teacher.people:per_id,per_apellidopat,per_apellidomat,per_nombres'
            ])->select(['plan_id', 'plan_mat_id', 'plan_doc_id', 'plan_amb_id', 'plan_fec_ini', 'plan_fec_fin', 'plan_hor_ini'])->orderBy('plan_id', 'desc');

            return DataTables::of($academic_planning)
                ->addColumn('action', function ($row) {
                    $editUrl = route('academic_planning.edit', $row->plan_id);
                    $deleteUrl = route('academic_planning.destroy', $row->plan_id);

                    $canEdit = auth()->user()->can('plan_academico.update');
                    $canDelete = auth()->user()->can('plan_academico.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_academic_planning" ' . $editDisabled . 'title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_academic_planning" ' . $deleteDisabled . 'title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->addColumn('materia', function ($row) {
                    return $row->subject->mat_nombre;
                })
                ->addColumn('ambiente', function ($row) {
                    return $row->classroom->amb_nombre;
                })
                ->addColumn('docente', function ($row) {
                    return $row->teacher->people->per_apellidopat . ' ' . $row->teacher->people->per_apellidomat . ' ' . $row->teacher->people->per_nombres;
                })
                ->removeColumn('plan_id')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('planificacion_academica.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('plan_academico.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('planificacion_academica.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('plan_academico.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['plan_mat_id', 'plan_doc_id', 'plan_amb_id', 'plan_fec_ini', 'plan_fec_fin', 'plan_hor_ini', 'plan_horario']);
            $academic_planning  = AcademicPlanning::create($input);

            $output = [
                'success' => true,
                'data'    => $academic_planning,
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
        if (! auth()->user()->can('plan_academico.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! auth()->user()->can('plan_academico.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $academic_planning = AcademicPlanning::find($id);
            $schedules = json_decode($academic_planning->plan_horario, true);
            return view('planificacion_academica.edit', compact('academic_planning', 'schedules'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->user()->can('plan_academico.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $input = $request->only(['plan_mat_id', 'plan_doc_id', 'plan_amb_id', 'plan_fec_ini', 'plan_fec_fin', 'plan_hor_ini', 'plan_horario']);

                $academic_planning = AcademicPlanning::findOrFail($id);
                $academic_planning->plan_mat_id = $input['plan_mat_id'];
                $academic_planning->plan_doc_id = $input['plan_doc_id'];
                $academic_planning->plan_amb_id = $input['plan_amb_id'];
                $academic_planning->plan_fec_ini = $input['plan_fec_ini'];
                $academic_planning->plan_fec_fin = $input['plan_fec_fin'];
                $academic_planning->plan_hor_ini = $input['plan_hor_ini'];
                $academic_planning->plan_horario = $input['plan_horario'];

                $academic_planning->save();

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
        if (! auth()->user()->can('plan_academico.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $academic_planning = AcademicPlanning::findOrFail($id);
                $academic_planning->delete();

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
}
