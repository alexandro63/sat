<?php

namespace App\Http\Controllers;

use App\Models\PlantelAdministrativo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PlantelAdministrativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('plantel_administrativo.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $planteAdministrativo = PlantelAdministrativo::with('persona')->select(['id', 'per_id', 'cargo', 'unidad', 'estado'])->orderBy('id', 'desc');
            return DataTables::of($planteAdministrativo)
                ->addColumn('action', function ($row) {
                    $editUrl = route('plantel-administrativo.edit', $row->id);
                    $deleteUrl = route('plantel-administrativo.destroy', $row->id);

                    $canEdit = auth()->user()->can('plantel_administrativo.update');
                    $canDelete = auth()->user()->can('plantel_administrativo.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_plantel"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_plantel"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })

                ->addColumn('documento', function ($row) {
                    return $row->persona->carnet;
                })
                ->addColumn('plantel_administrativo', function ($row) {
                    return $row->persona->apellidopat . ' ' . $row->persona->apellidomat . ' ' . $row->persona->nombres;
                })
                ->editColumn('cargo', function ($row) {
                    return ucfirst($row->cargo);
                })
                ->editColumn('unidad', function ($row) {
                    return ucfirst($row->unidad);
                })
                ->editColumn('estado', function ($row) {
                    return $row->estado ? 'Sí' : 'No';
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('plantel_administrativo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('plantel_administrativo.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('plantel_administrativo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('plantel_administrativo.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['per_id', 'cargo', 'unidad']);
            $status = $request->has('estado') ? 1 : 0;
            $input['estado'] = $status;
            PlantelAdministrativo::create($input);

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
        if (! auth()->user()->can('plantel_administrativo.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('plantel_administrativo.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $plantel = PlantelAdministrativo::find($id);
            return view('plantel_administrativo/edit', compact('plantel'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('plantel_administrativo.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['per_id', 'cargo', 'unidad']);

                $planteAdministrativo = PlantelAdministrativo::findOrFail($id);
                $planteAdministrativo->per_id = $input['per_id'];
                $planteAdministrativo->cargo = $input['cargo'];
                $planteAdministrativo->unidad = $input['unidad'];
                $planteAdministrativo->estado = $request->has('estado') ? 1 : 0;
                $planteAdministrativo->save();

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
        if (! auth()->user()->can('plantel_administrativo.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $planteAdministrativo = PlantelAdministrativo::findOrFail($id);
                $planteAdministrativo->delete();

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

    public function getPlantelAdministrativoData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $planteAdministrativo = PlantelAdministrativo::whereHas('persona', function ($query) use ($term) {
            $query->where('carnet', $term)
                ->orWhere('estado', 1)
                ->orWhere('nombres', 'like', '%' . $term . '%')
                ->orWhere('apellidopat', 'like', '%' . $term . '%')
                ->orWhere('apellidomat', 'like', '%' . $term . '%');
        });

        return $planteAdministrativo->with('persona')->paginate(5, ['*'], 'page', $page);
    }
}
