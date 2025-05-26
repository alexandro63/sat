<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**Reportes de Avance Estudiante */
    public function avanceEstudiante()
    {
        return view('reportes.estudiante.avance_estudiante');
    }

    public function entregasAvance()
    {
        return view('reportes.estudiante.avance_estudiante');
    }
}
