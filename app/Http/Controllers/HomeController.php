<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\PlantelAdministrativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hour = now()->format('H');
        $dayOfWeek = now()->locale('es')->isoFormat('dddd');

        if ($hour >= 5 && $hour < 12) {
            $greeting = '🌞 Buenos días';
            $message = 'que tengas un excelente día';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = '🌅 Buenas tardes';
            $message = 'que tu tarde sea muy productiva';
        } else {
            $greeting = '🌜 Buenas noches';
            $message = 'que descanses bien esta noche';
        }

        $userName = Session::get('user.user_names');
        if ($userName) {
            $userName = ucwords(strtolower($userName));
            $greeting .= ', ' . $userName;
        }

        $greeting .= ". Feliz {$dayOfWeek}, {$message} !";

        $activeStudents = Estudiante::where('estado', 1)->count();
        $activeUsers = User::where('status', 1)->count();
        $activeTeachers = Docente::where('estado', 1)->count();
        $activeAdministrative = PlantelAdministrativo::where('estado', 1)->count();
        return view('home.index', compact('greeting', 'activeStudents', 'activeUsers', 'activeTeachers','activeAdministrative'));
    }
}
