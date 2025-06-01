<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsuarioController extends Controller
{

    protected $util;

    public function __construct(Util $util)
    {
        return $this->util = $util;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('usuario.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $users = User::with('persona')->select(['id', 'user_name', 'per_id', 'status'])->orderBy('id', 'desc');

            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    $user_auth = Auth::user()->id;
                    $editUrl = route('usuarios.edit', $user->id);
                    $deleteUrl = route('usuarios.destroy', $user->id);

                    $canEdit = auth()->user()->can('usuario.update');
                    $canDelete = auth()->user()->can('usuario.delete') && $user->id !== $user_auth;
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_user"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_user"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->editColumn('per_id', function ($row) {
                    if ($row->persona) {
                        return $row->persona->nombres . ' ' . $row->persona->apellidopat . ' ' . $row->persona->apellidomat;
                    }
                    return '';
                })

                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? 'Sí' : 'No';
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('usuario.create')) {
            abort(403, 'Unauthorized action.');
        }
        $roles = $this->util->getRoleData();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('usuario.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $status = $request->has('status') ? 1 : 0;
            $input = $request->only(['per_id', 'user_name', 'password']);
            $role = Role::findOrFail($request->input('role'));
            $input['status'] = $status;
            $user  = User::create($input);
            $user->assignRole($role->name);

            $output = [
                'success' => true,
                'data'    => $user,
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
        if (! auth()->user()->can('usuario.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('usuario.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $user = User::find($id);
            $roles = $this->util->getRoleData();
            return view('usuarios/edit', compact('user', 'roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('usuario.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['user_name', 'per_id', 'password']);

                $user = User::findOrFail($id);
                $user->user_name = $input['user_name'];
                $user->per_id = $input['per_id'];
                if (!empty($input['password'])) {
                    $user->password = Hash::make($input['password']);
                }
                $user->status = $request->has('status') ? 1 : 0;
                DB::beginTransaction();
                $user->update();
                $role_id = $request->input('role');
                $user_role = $user->roles->first();
                $previous_role = !empty($user_role->id) ? $user_role->id : 0;
                if ($previous_role != $role_id) {
                    $is_admin = $this->util->is_admin($user);
                    $all_admins = $this->util->getAdmins();
                    if ($is_admin && count($all_admins) <= 1) {
                        return   $output = [
                            'success' => false,
                            'msg' => __('messages.cannot_change'),
                        ];
                    }
                    if (!empty($previous_role)) {
                        $user->removeRole($user_role->name);
                    }

                    $role = Role::findOrFail($role_id);
                    $user->assignRole($role->name);
                }
                $output = [
                    'success' => true,
                    'msg' => __('messages.updated_success'),
                ];
                DB::commit();
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
        if (! auth()->user()->can('usuario.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $user = User::findOrFail($id);
                $user->delete();

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

    public function getUserData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $users = User::where('status', 1)->leftJoin('persona', 'users.per_id', '=', 'persona.per_id')
            ->where(function ($query) use ($term) {
                $query->where('users.user_name', 'like', '%' . $term . '%')
                    ->orWhere('persona.nombres', 'like', '%' . $term . '%')
                    ->orWhere('persona.apellidopat', 'like', '%' . $term . '%')
                    ->orWhere('persona.apellidomat', 'like', '%' . $term . '%');
            })
            ->select(
                'users.*',
                'persona.nombres as persona_nombre',
                'persona.apellidopat as persona_apellidopat',
                'persona.apellidomat as persona_apellidomat'
            );

        return $users->paginate(5, ['*'], 'page', $page);
    }
}
