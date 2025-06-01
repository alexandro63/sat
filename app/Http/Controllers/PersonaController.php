<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
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
            $persona = Persona::select(['id', 'nombres', 'apellidopat', 'apellidomat', 'carnet', 'estado'])->orderBy('id', 'desc');

            return DataTables::of($persona)
                ->addColumn('action', function ($row) {
                    $user_auth = Auth::user()->id;
                    $editUrl = route('personas.edit', $row->id);
                    $deleteUrl = route('personas.destroy', $row->id);
                    $canEdit = auth()->user()->can('permiso.update');
                    $canDelete = auth()->user()->can('permiso.delete') && $row->id !== $user_auth;
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
                ->editColumn('estado', function ($row) {
                    return $row->estado == 1 ? 'Sí' : 'No';
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
            $input = $request->only(['nombres', 'apellidopat', 'apellidomat', 'carnet', 'direccion', 'telefono', 'correo', 'fecha_nacimiento', 'estado']);
            $input['estado'] = $status;
            Persona::create($input);

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
            $persona = Persona::find($id);
            return view('personas/edit', compact('persona'));
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
                $input = $request->only(['nombres', 'apellidopat', 'apellidomat', 'carnet', 'direccion', 'telefono', 'correo', 'fecha_nacimiento']);

                $persona = Persona::findOrFail($id);
                $persona->nombres = $input['nombres'];
                $persona->apellidopat = $input['apellidopat'];
                $persona->apellidomat = $input['apellidomat'];
                $persona->carnet = $input['carnet'];
                $persona->direccion = $input['direccion'];
                $persona->telefono = $input['telefono'];
                $persona->correo = $input['correo'];
                $persona->fecha_nacimiento = $input['fecha_nacimiento'];
                $persona->estado = $request->has('estado') ? 1 : 0;
                $persona->save();

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
                $persona = Persona::findOrFail($id);
                $persona->delete();

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
        $persona = Persona::where('estado', 1)
            ->where(function ($query) use ($request) {
                $query->where('carnet', $request->term)
                    ->orWhere('nombres', 'like', '%' . $request->term . '%')
                    ->orWhere('apellidopat', 'like', '%' . $request->term . '%')
                    ->orWhere('apellidomat', 'like', '%' . $request->term . '%');
            });

        return $persona->paginate(5, ['*'], 'page', $request->page);
    }
}
