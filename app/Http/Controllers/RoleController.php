<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Utils\Util;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleController extends Controller
{
    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('permiso.index')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $roles = Role::select(['id', 'name']);

            return Datatables::of($roles)
                ->addColumn('action', function ($row) {
                    $editUrl = route('roles.edit', $row->id);
                    $deleteUrl = route('roles.destroy', $row->id);
                    $canEdit = auth()->user()->can('permiso.update');
                    $canDelete = auth()->user()->can('permiso.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button onclick="window.location.href=\'' . $editUrl . '\'" class="btn btn-icon btn-sm btn-round btn-primary" title="Editar" ' . $editDisabled . '>
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_role" title="Eliminar"
                    ' . $deleteDisabled . '>
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('permisos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('permiso.create')) {
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::pluck('name')->toArray();

        return view('permisos.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('permiso.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $role_name = ucfirst($request->input('name'));
            $role_start_path = $request->input('start_path');
            $permissions = $request->input('permissions', []);

            $count = Role::where('name', $role_name)
                ->count();

            if ($count == 0) {
                $role = Role::create([
                    'name' => $role_name,
                    'start_path' => $role_start_path,
                ]);

                $radio_options = $request->input('radio_option');
                if (! empty($radio_options)) {
                    foreach ($radio_options as $key => $value) {
                        $permissions[] = $value;
                    }
                }

                $this->__createPermissionIfNotExists($permissions);

                if (! empty($permissions)) {
                    $role->syncPermissions($permissions);
                }
                $output = [
                    'success' => true,
                    'msg'     => __('messages.add_success'),
                ];
            } else {
                $output = [
                    'success' => false,
                    'msg' => __('messages.already_exists'),
                ];
            }
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

        return redirect()->route('roles.index')->with('status', $output);
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
        if (! auth()->user()->can('permiso.update')) {
            abort(403, 'Unauthorized action.');
        }

        $role = Role::with(['permissions'])
            ->find($id);

        $permissions = Permission::pluck('name')->toArray();
        $role_permissions = [];
        foreach ($role->permissions as $role_perm) {
            $role_permissions[] = $role_perm->name;
        }
        return view('permisos.edit')
            ->with(compact('role', 'role_permissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->user()->can('permiso.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $role_name = ucfirst($request->input('name'));
            $role_start_path = $request->input('start_path');
            $permissions = $request->input('permissions');

            $count = Role::where('name', $role_name)
                ->where('id', '!=', $id)
                ->count();
            if ($count == 0) {
                $role = Role::findOrFail($id);

                if (! $role->is_default) {
                    $role->name = $role_name;
                    $role->start_path = $role_start_path;
                    $role->save();
                    $this->__createPermissionIfNotExists($permissions);

                    if (! empty($permissions)) {
                        $role->syncPermissions($permissions);
                    }

                    $output = [
                        'success' => true,
                        'msg' => __('messages.updated_success'),
                    ];
                } else {
                    $output = [
                        'success' => false,
                        'msg' => __('messages.is_default'),
                    ];
                }
            } else {
                $output = [
                    'success' => false,
                    'msg' => __('messages.already_exists'),
                ];
            }
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
        return redirect()->route('roles.index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! auth()->user()->can('permiso.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $role = Role::findOrFail($id);
                $role->delete();

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

    private function __createPermissionIfNotExists($permissions)
    {
        $exising_permissions = Permission::whereIn('name', $permissions)
            ->pluck('name')
            ->toArray();

        $non_existing_permissions = array_diff($permissions, $exising_permissions);

        if (! empty($non_existing_permissions)) {
            foreach ($non_existing_permissions as $new_permission) {
                $time_stamp = Carbon::now()->toDateTimeString();
                Permission::create([
                    'name' => $new_permission,
                    'guard_name' => 'web',
                ]);
            }
        }
    }

    public function getRoleData()
    {
        $roles_array = Role::pluck('name', 'id');
        $roles = [];

        $is_admin = $this->util->is_admin(auth()->user());

        foreach ($roles_array as $key => $value) {
            if (!$is_admin && $value == 'Admin') {
                continue;
            }
            $roles[$key] = $value;
        }

        return $roles;
    }

    public function getRoutesData()
    {
        $excludedPrefixes = [
            'livewire',
            'login',
            'logout',
            'register',
            'password',
            '',
            'sanctum',
            'up',
        ];

        $excludedKeywords = [
            'create',
            'edit',
            'store',
            'update',
            'delete',
            'post',
            'put',
        ];

        $routes = collect(Route::getRoutes())->filter(function ($route) use ($excludedPrefixes, $excludedKeywords) {
            $uri = $route->uri();
            $methods = $route->methods();

            if (!in_array('GET', $methods)) {
                return false;
            }

            if (Str::contains($uri, '{')) {
                return false;
            }

            foreach ($excludedPrefixes as $prefix) {
                if (Str::startsWith($uri, $prefix)) {
                    return false;
                }
            }

            foreach ($excludedKeywords as $keyword) {
                if (Str::contains($uri, $keyword)) {
                    return false;
                }
            }

            return true;
        })->map(fn($route) => [
            'uri' => $route->uri()
        ])->unique('uri')->values();

        return $routes;
    }

    public function getRoutes(Request $request)
    {
        $routes = $this->getRoutesData();
        $term = $request->input('term');

        $filtered = $routes;

        if (!empty($term)) {
            $filtered = $routes->filter(function ($item) use ($term) {
                return Str::contains($item['uri'], $term);
            });
        }

        $page = $request->input('page', 1);
        $perPage = 5;

        $paginated = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $paginated;
    }
}
