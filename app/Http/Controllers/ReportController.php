<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**Reportes de Personal Docente */
    public function teacherHours()
    {
        return view('reportes.docentes.horas_trabajadas');
    }

    public function teacherAttendance()
    {
        return view('reportes.docentes.marcados');
    }

    public function teacherPayments()
    {
        return view('reportes.docentes.pagos');
    }

    /**Reportes Administrativos */
    public function adminHours()
    {
        return view('reportes.administrativos.horas_trabajadas');
    }

    public function adminIncome()
    {
        return view('reportes.administrativos.ingresos');
    }

    /**Finanzas y Cuentas */
    public function generalDebts()
    {
        return view('reportes.finanzas.deudas_generales');
    }

    public function courseDebts()
    {
        return view('reportes.finanzas.deudas_por_curso');
    }

    public function payrolls()
    {
        return view('reportes.finanzas.planillas');
    }

    /**Reportes de Estudiantes */
    public function studentPayments()
    {
        return view('reportes.estudiantes.pagos');
    }

    public function careerIncome()
    {
        return view('reportes.estudiantes.ingresos_por_carrera');
    }

    /**Asignaciones */
    public function groupAssignments()
    {
        return view('reportes.asignaciones.grupos');
    }
}
