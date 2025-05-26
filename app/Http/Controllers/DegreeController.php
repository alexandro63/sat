<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $degrees = Degree::select(['car_id', 'car_nombre', 'car_descripcion', 'car_duracion'])->orderBy('car_id', 'desc');

            return DataTables::of($degrees)
                ->addColumn('action', function ($row) {
                    $editUrl = route('degrees.edit', $row->car_id);
                    $deleteUrl = route('degrees.destroy', $row->car_id);

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-round btn-primary edit_degree">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-round btn-danger delete_degree">
                        <i class="icon-trash"></i>
                    </button>';


                    return $buttons;
                })
                ->removeColumn("car_id")
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('carreras.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only(['car_nombre', 'car_descripcion', 'car_duracion']);
            $degree  = Degree::create($input);

            $output = [
                'success' => true,
                'data'    => $degree,
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
    public function edit($id)
    {
        if (request()->ajax()) {
            $degree = Degree::find($id);
            return view('carreras/edit', compact('degree'));
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
                $input = $request->only(['car_nombre', 'car_descripcion', 'car_duracion']);

                $degree = Degree::findOrFail($id);
                $degree->car_nombre = $input['car_nombre'];
                $degree->car_descripcion = $input['car_descripcion'];
                $degree->car_duracion = $input['car_duracion'];

                $degree->save();

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
                $degree = Degree::findOrFail($id);
                $degree->delete();

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

    public function getDegreesData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $degrees = Degree::where('car_nombre', 'like', '%' . $term . '%');
        return $degrees->paginate(5, ['*'], 'page', $page);
    }
}
