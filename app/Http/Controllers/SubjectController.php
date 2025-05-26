<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $subjects = Subject::with('degree')->select(['mat_id', 'mat_car_id', 'mat_nombre', 'mat_descripcion'])->orderBy('mat_id', 'desc');

            return DataTables::of($subjects)
                ->addColumn('action', function ($row) {
                    $editUrl = route('subjects.edit', $row->mat_id);
                    $deleteUrl = route('subjects.destroy', $row->mat_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-round btn-primary edit_subject">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-round btn-danger delete_subject">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->addColumn('car_nombre', function ($row) {
                    return $row->degree->car_nombre;
                })
                ->removeColumn(['mat_id'])
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('materias.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only(['mat_car_id', 'mat_nombre', 'mat_descripcion']);
            $subject  = Subject::create($input);

            $output = [
                'success' => true,
                'data'    => $subject,
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
            $subject = Subject::find($id);
            return view('materias/edit', compact('subject'));
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
                $input = $request->only(['mat_car_id', 'mat_nombre', 'mat_descripcion']);

                $subject = Subject::findOrFail($id);
                $subject->mat_car_id = $input['mat_car_id'];
                $subject->mat_nombre = $input['mat_nombre'];
                $subject->mat_descripcion = $input['mat_descripcion'];

                $subject->save();

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
                $subject = Subject::findOrFail($id);
                $subject->delete();

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

    public function getSubjectsData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $subjects = Subject::where('mat_nombre', 'like', '%' . $term . '%');
        return $subjects->paginate(5, ['*'], 'page', $page);
    }
}
