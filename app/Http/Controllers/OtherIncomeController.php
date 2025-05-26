<?php

namespace App\Http\Controllers;

use App\Helpers\UtilHelper;
use App\Models\OtherIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class OtherIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $other_incomes  = OtherIncome::with([
                'student.people:per_id,per_ci,per_nombres,per_apellidopat,per_apellidomat',
                'user:id,user_name'
            ])->select(['pag_id', 'pag_alu_id', 'pag_fec_hor', 'pag_monto', 'pag_rof', 'pag_usu_id'])->orderBy('pag_id', 'desc');

            return DataTables::of($other_incomes)
                ->addColumn('action', function ($row) {
                    $editUrl = route('other_income.edit', $row->pag_id);
                    $deleteUrl = route('other_income.destroy', $row->pag_id);

                    $buttons = '
                    <button data-href="' . e($editUrl) . '" class="btn btn-icon btn-sm btn-round btn-primary edit_other_income" title="Editar">
                        <i class="icon-pencil"></i>
                    </button>
                    &nbsp;';

                    $buttons .= '
                    <button data-href="' . e($deleteUrl) . '" class="btn btn-icon btn-sm btn-round btn-danger delete_other_income" title="Eliminar">
                        <i class="icon-trash"></i>
                    </button>';

                    return $buttons;
                })
                ->addColumn('documento', function ($row) {
                    return $row->student->people->per_ci;
                })
                ->addColumn('persona', function ($row) {
                    return $row->student->people->per_apellidopat . ' ' . $row->student->people->per_apellidomat . ' ' . $row->student->people->per_nombres;
                })
                ->editColumn('pag_monto', function ($row) {
                    return $row->pag_monto . ' <span>Bs</span>';
                })
                ->addColumn('usuario', function ($row) {
                    return $row->user->user_name;
                })
                ->removeColumn("pag_id")
                ->rawColumns(['action', 'pag_monto'])
                ->make(true);
        }

        return view('otros_ingresos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_payments = UtilHelper::getTypePayments();
        return view('otros_ingresos.create', compact('type_payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only(['pag_alu_id', 'pag_fec_hor', 'pag_monto', 'pag_cuota', 'pag_rof', 'pag_obs', 'pag_tipo']);
            $input['pag_usu_id'] = Session::get('user.user_id', Auth::id());
            $other_income  = OtherIncome::create($input);

            $output = [
                'success' => true,
                'data'    => $other_income,
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
            $other_income = OtherIncome::find($id);
            $type_payments = UtilHelper::getTypePayments();
            return view('otros_ingresos.edit', compact('other_income', 'type_payments'));
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
                $input = $request->only(['pag_alu_id', 'pag_fec_hor', 'pag_monto', 'pag_cuota', 'pag_rof', 'pag_obs', 'pag_tipo']);
                $other_income = OtherIncome::findOrFail($id);
                $other_income->pag_alu_id = $input['pag_alu_id'];
                $other_income->pag_fec_hor = $input['pag_fec_hor'];
                $other_income->pag_monto = $input['pag_monto'];
                $other_income->pag_cuota = $input['pag_cuota'];
                $other_income->pag_rof = $input['pag_rof'];
                $other_income->pag_obs = $input['pag_obs'];
                $other_income->pag_tipo = $input['pag_tipo'];
                $other_income->pag_usu_id = Session::get('user.user_id', Auth::id());

                $other_income->save();

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
                $other_income = OtherIncome::findOrFail($id);
                $other_income->delete();

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
