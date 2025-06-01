<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('persona.index')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $people = People::select(['per_id', 'per_nombres', 'per_apellidopat', 'per_apellidomat', 'per_ci', 'per_estado'])->orderBy('per_id', 'desc');

            return DataTables::of($people)
                ->addColumn('action', function ($people) {
                    $user_auth = Auth::user()->per_id;
                    $editUrl = route('people.edit', $people->per_id);
                    $deleteUrl = route('people.destroy', $people->per_id);
                    $canEdit = auth()->user()->can('permiso.update');
                    $canDelete = auth()->user()->can('permiso.delete') && $people->per_id !== $user_auth;
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';
                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_person"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_person"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->editColumn('per_estado', function ($row) {
                    return $row->per_estado == 1 ? 'Sí' : 'No';
                })
                ->removeColumn(['per_id'])
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('personas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('persona.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('personas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('persona.create')) {
            abort(403, 'Unauthorized action.');
        }
        $status = $request->has('per_estado') ? 1 : 0;
        try {
            $input = $request->only(['per_nombres', 'per_apellidopat', 'per_apellidomat', 'per_ci', 'per_direccion', 'per_telefono', 'per_celular', 'per_estado']);
            $input['per_estado'] = $status;
            $person  = People::create($input);

            $output = [
                'success' => true,
                'data'    => $person,
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
        if (! auth()->user()->can('persona.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! auth()->user()->can('persona.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $person = People::find($id);
            return view('personas/edit', compact('person'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->user()->can('persona.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $input = $request->only(['per_nombres', 'per_apellidopat', 'per_apellidomat', 'per_ci', 'per_direccion', 'per_telefono', 'per_celular']);

                $person = People::findOrFail($id);
                $person->per_nombres = $input['per_nombres'];
                $person->per_apellidopat = $input['per_apellidopat'];
                $person->per_apellidomat = $input['per_apellidomat'];
                $person->per_ci = $input['per_ci'];
                $person->per_direccion = $input['per_direccion'];
                $person->per_telefono = $input['per_telefono'];
                $person->per_celular = $input['per_celular'];
                $person->per_estado = $request->has('per_estado') ? 1 : 0;
                $person->save();

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
        if (! auth()->user()->can('persona.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $person = People::findOrFail($id);
                $person->delete();

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

    /**
     * Search for a people.
     */
    public function getPeopleData(Request $request)
    {
        $people = People::where('per_estado', 1)
            ->where(function ($query) use ($request) {
                $query->where('per_ci', $request->term)
                    ->orWhere('per_nombres', 'like', '%' . $request->term . '%')
                    ->orWhere('per_apellidopat', 'like', '%' . $request->term . '%')
                    ->orWhere('per_apellidomat', 'like', '%' . $request->term . '%');
            });

        return $people->paginate(5, ['*'], 'page', $request->page);
    }
}
