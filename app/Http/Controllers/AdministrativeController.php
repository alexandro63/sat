<?php

namespace App\Http\Controllers;

use App\Helpers\UtilHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Administrative;

class AdministrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('administrativo.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $administrative = Administrative::with('people')
                ->select(['adm_id', 'adm_per_id', 'adm_cargo', 'adm_estado', 'adm_fec_ini', 'adm_fec_fin'])
                ->orderBy('adm_id', 'desc');

            return DataTables::of($administrative)
                ->addColumn('action', function ($row) {
                    $editUrl = route('administrative.edit', $row->adm_id);
                    $deleteUrl = route('administrative.destroy', $row->adm_id);

                    $canEdit = auth()->user()->can('administrativo.update');
                    $canDelete = auth()->user()->can('administrativo.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_administrative"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_administrative"
                    ' . $deleteDisabled . ' title="Editar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->addColumn('documento', function ($row) {
                    return $row->people->per_ci;
                })
                ->addColumn('administrativo', function ($row) {
                    return $row->people->per_apellidomat . ' ' . $row->people->per_apellidopat . ' ' . $row->people->per_nombres;
                })
                ->addColumn('estado', function ($row) {
                    return $row->adm_estado ? 'Sí' : 'No';
                })
                ->removeColumn('adm_id')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('administrativo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('administrativo.create')) {
            abort(403, 'Unauthorized action.');
        }
        $grade_academic = UtilHelper::getGradeAcademic();
        return view('administrativo.create', compact('grade_academic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('administrativo.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['adm_per_id', 'adm_grado_academico', 'adm_fec_ing', 'adm_cargo', 'adm_pago', 'adm_obs', 'adm_fec_ini', 'adm_fec_fin', 'adm_plan_horario']);
            $input['adm_estado'] = $request->has('adm_estado') ? 1 : 0;
            $administrative  = Administrative::create($input);

            $output = [
                'success' => true,
                'data'    => $administrative,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! auth()->user()->can('administrativo.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $administrative = Administrative::find($id);
            $schedules = json_decode($administrative->adm_plan_horario, true);
            $grade_academic = UtilHelper::getGradeAcademic();
            return view('administrativo.edit', compact('administrative', 'grade_academic', 'schedules'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->user()->can('administrativo.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $input = $request->only(['adm_per_id', 'adm_grado_academico', 'adm_fec_ing', 'adm_cargo', 'adm_pago', 'adm_obs', 'adm_fec_ini', 'adm_fec_fin', 'adm_plan_horario']);

                $administrative = Administrative::findOrFail($id);
                $administrative->adm_per_id = $input['adm_per_id'];
                $administrative->adm_grado_academico = $input['adm_grado_academico'];
                $administrative->adm_fec_ing = $input['adm_fec_ing'];
                $administrative->adm_cargo = $input['adm_cargo'];
                $administrative->adm_pago = $input['adm_pago'];
                $administrative->adm_obs = $input['adm_obs'];
                $administrative->adm_fec_ini = $input['adm_fec_ini'];
                $administrative->adm_fec_fin = $input['adm_fec_fin'];
                $administrative->adm_plan_horario = $input['adm_plan_horario'];
                $administrative->adm_estado = $request->has('adm_estado') ? 1 : 0;

                $administrative->update();

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
        if (! auth()->user()->can('administrativo.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $administrative = Administrative::findOrFail($id);
                $administrative->delete();

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
