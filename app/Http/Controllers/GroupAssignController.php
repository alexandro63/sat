<?php

namespace App\Http\Controllers;

use App\Models\GroupAssign;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class GroupAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $group_assign = GroupAssign::select(['gus_id', 'gus_gru_id', 'gus_usu_id'])->orderBy('gus_id', 'desc');

            return DataTables::of($group_assign)
                ->addColumn('gru_nombre', function ($row) {
                    return $row->group->gru_nombre;
                })

                ->addColumn('usuario_info', function ($row) {
                    return $row->user->user_name;
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('group_assign.edit', $row->gus_id);
                    $deleteUrl = route('group_assign.destroy', $row->gus_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-round btn-primary edit_group_assign" title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';
                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-round btn-danger delete_group_assign" title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->removeColumn("gus_id")
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('asignaciones_grupo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asignaciones_grupo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only(['gus_id', 'gus_gru_id', 'gus_usu_id']);
            $group_assign  = GroupAssign::create($input);

            $output = [
                'success' => true,
                'data'    => $group_assign,
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
            $group_assign = GroupAssign::find($id);
            return view('asignaciones_grupo/edit', compact('group_assign'));
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
                $input = $request->only(['gus_gru_id', 'gus_usu_id']);

                $group_assign = GroupAssign::findOrFail($id);
                $group_assign->gus_gru_id = $input['gus_gru_id'];
                $group_assign->gus_usu_id = $input['gus_usu_id'];
                $group_assign->save();

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
                $group_assign = GroupAssign::findOrFail($id);
                $group_assign->delete();

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
