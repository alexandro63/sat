<?php

namespace App\Http\Controllers;

use App\Helpers\UtilHelper;
use App\Models\Pago;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('pago.index')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $pagos = Pago::with('estudiante')->select(['id', 'id_estudiante', 'monto', 'metodo', 'fecha'])->orderBy('id', 'desc');
            return DataTables::of($pagos)
                ->addColumn('action', function ($row) {
                    $editUrl = route('pagos.edit', $row->id);
                    $deleteUrl = route('pagos.destroy', $row->id);

                    $canEdit = auth()->user()->can('pago.update');
                    $canDelete = auth()->user()->can('pago.delete');

                    $editDisabled = $canEdit ? '' : 'disabled';
                    $deleteDisabled = $canDelete ? '' : 'disabled';

                    $buttons = '
                    <button data-href="' . $editUrl . '" class="btn btn-icon btn-sm btn-round btn-primary edit_pago"
                    ' . $editDisabled . ' title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . $deleteUrl . '" class="btn btn-icon btn-sm btn-round btn-danger delete_pago"
                    ' . $deleteDisabled . ' title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })

                ->addColumn('estudiante', function ($row) {
                    return $row->estudiante->persona->apellidopat . ' ' . $row->estudiante->persona->apellidomat . ' ' . $row->estudiante->persona->nombres;
                })
                ->editColumn('monto', function ($row) {
                    return $row->monto . ' Bs.';
                })
                ->removeColumn(['id'])
                ->rawColumns(['action', 'monto'])
                ->make(true);
        }

        return view('pagos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('pago.create')) {
            abort(403, 'Unauthorized action.');
        }
        $metodos = UtilHelper::getTypePayments();
        return view('pagos.create', compact('metodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('pago.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['id_estudiante', 'monto', 'metodo', 'comprobante', 'fecha']);

            if ($request->hasFile('comprobante')) {
                $file = $request->file('comprobante');

                $destinationPath = public_path('documentos/comprobantes');

                // Crear carpeta si no existe
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                // Nombre único para el archivo
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Mover el archivo
                $file->move($destinationPath, $filename);
                // Guardar solo el nombre o ruta relativa
                $input['comprobante'] = 'documentos/comprobantes/' . $filename;
            } else {
                $input['comprobante'] = null;
            }
            Pago::create($input);

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
        if (! auth()->user()->can('pago.view')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('pago.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $pago = Pago::find($id);
            $metodos = UtilHelper::getTypePayments();
            return view('pagos/edit', compact('pago', 'metodos'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('pago.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['id_estudiante', 'monto', 'metodo', 'comprobante', 'fecha']);

                $pago = Pago::findOrFail($id);
                $pago->id_estudiante = $input['id_estudiante'];
                $pago->monto = $input['monto'];
                $pago->metodo = $input['metodo'];
                $pago->fecha = $input['fecha'];

                if ($request->hasFile('comprobante')) {
                    if (!empty($pago->comprobante) && file_exists(public_path($pago->comprobante))) {
                        unlink(public_path($pago->comprobante));
                    }

                    $file = $request->file('comprobante');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'comprobante_' . time() . '.' . $extension;
                    $path = 'documentos/comprobantes';

                    if (!file_exists(public_path($path))) {
                        mkdir(public_path($path), 0777, true);
                    }

                    $file->move(public_path($path), $filename);
                    $pago->comprobante = $path . '/' . $filename;
                }
                $pago->save();

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
        if (! auth()->user()->can('pago.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $pago = Pago::findOrFail($id);
                if (!empty($pago->comprobante)) {
                    $filePath = public_path($pago->comprobante);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $pago->delete();

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

    public function getPagosData(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);

        $pagos = Pago::where('estudiante', 'like', '%' . $term . '%');

        return $pagos->with('persona')->paginate(5, ['*'], 'page', $page);
    }
}
