<?php

namespace App\Http\Controllers;

use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class GroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $group_users = GroupUser::select(['gru_id', 'gru_nombre', 'gru_obs', 'gru_estado'])->orderBy('gru_id', 'desc');

            return DataTables::of($group_users)
                ->addColumn('action', function ($group_users) {
                    $editUrl = route('group_users.edit', $group_users->gru_id);
                    $deleteUrl = route('group_users.destroy', $group_users->gru_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-round btn-primary edit_group_user">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';
                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-round btn-danger delete_group_user">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->editColumn('gru_estado', function ($row) {
                    return $row->gru_estado == 1 ? 'Sí' : 'No';
                })
                ->removeColumn(['grud_id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('grupos_usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grupos_usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = $request->has('gru_estado') ? 1 : 0;
        try {
            $input = $request->only(['gru_id', 'gru_nombre', 'gru_obs']);
            $input['gru_estado'] = $status;
            $group_user  = GroupUser::create($input);

            $output = [
                'success' => true,
                'data'    => $group_user,
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
    public function edit(string $id)
    {
        if (request()->ajax()) {
            $group_user = GroupUser::find($id);
            return view('grupos_usuarios/edit', compact('group_user'));
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
                $input = $request->only(['gru_id', 'gru_nombre', 'gru_obs']);

                $group_user = GroupUser::findOrFail($id);
                $group_user->gru_nombre = $input['gru_nombre'];
                $group_user->gru_obs = $input['gru_obs'];
                $group_user->gru_estado = $request->has('gru_estado') ? 1 : 0;
                $group_user->save();

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
                $group_user = GroupUser::findOrFail($id);
                $group_user->delete();

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

    public function getGroupUserData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);
        $groups = GroupUser::where('gru_estado',1)->where('gru_nombre', 'like', '%' . $term . '%');

        return $groups->paginate(5, ['*'], 'page', $page);
    }
}
