<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance()
    {
        return view('tomar_asistencia.index');
    }
}
