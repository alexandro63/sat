<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Helpers\OrdinalHelper;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('ambiente.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $classrooms = Classroom::select(['amb_id', 'amb_nombre', 'amb_capacidad', 'amb_piso', 'amb_descripcion'])->orderBy('amb_id', 'desc');

            return DataTables::of($classrooms)
                ->addColumn('action', function ($row) {
                    $editUrl = route('classrooms.edit', $row->amb_id);
                    $deleteUrl = route('classrooms.destroy', $row->amb_id);

                    $canEdit = auth()->user()->can('ambiente.update');
                    $canDelete = auth()->user()->can('ambiente.delete');
                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_classroom"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_classroom"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->editColumn('amb_capacidad', function ($row) {
                    return $row->amb_capacidad ? '<span class="badge badge-info">' . $row->amb_capacidad . ' personas</span>' : 'S/D';
                })
                ->editColumn('amb_piso', function ($row) {
                    return $row->amb_piso ? '<span class="badge badge-info">' . OrdinalHelper::str_ordinal($row->amb_piso) . '</span>' : 'S/D';
                })
                ->removeColumn('amb_id')
                ->rawColumns(['action', 'amb_capacidad', 'amb_piso'])
                ->make(true);
        }

        return view('ambientes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('ambiente.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('ambientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('ambiente.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['amb_nombre', 'amb_capacidad', 'amb_piso', 'amb_descripcion']);
            $classroom  = Classroom::create($input);

            $output = [
                'success' => true,
                'data'    => $classroom,
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
        if (! auth()->user()->can('ambiente.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $classroom = Classroom::find($id);
            return view('ambientes.edit', compact('classroom'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('ambiente.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['amb_nombre', 'amb_capacidad', 'amb_piso', 'amb_descripcion']);

                $classroom = Classroom::findOrFail($id);
                $classroom->amb_nombre = $input['amb_nombre'];
                $classroom->amb_capacidad = $input['amb_capacidad'];
                $classroom->amb_piso = $input['amb_piso'];
                $classroom->amb_descripcion = $input['amb_descripcion'];

                $classroom->save();

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
        if (! auth()->user()->can('ambiente.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $classroom = Classroom::findOrFail($id);
                $classroom->delete();

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

    public function getClassroomsData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $classrooms = Classroom::where('amb_nombre', 'like', '%' . $term . '%')
            ->paginate(5, ['*'], 'page', $page);

        return response()->json($classrooms);
    }
}
