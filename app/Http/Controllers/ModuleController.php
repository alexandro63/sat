<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function tesis()
    {
        return view('modulos.tesis');
    }

    public function proyectoGrado()
    {
        return view('modulos.proyecto_grado');
    }

    public function trabajoDirijido()
    {
        return view('modulos.trabajo_dirijido');
    }

    public function graduacionExcelencia()
    {
        return view('modulos.graduacion_excelencia');
    }
}
