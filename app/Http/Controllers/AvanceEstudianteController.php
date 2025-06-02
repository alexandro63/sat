<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvanceEstudianteController extends Controller
{
    public function index()
    {
        return view('avance_estudiante.index');
    }
}
