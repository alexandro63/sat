<?php

use App\Models\People;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\GroupAssignController;
use App\Http\Controllers\OtherIncomeController;
use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\EnrolledStudentController;
use App\Http\Controllers\TeacherSettingController;
use App\Http\Controllers\AcademicPlanningController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentEnrollmentController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();


Route::middleware(['atlantis_menu', 'set_session_data', 'check_user_login', 'auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /**Administration*/
    Route::prefix('administration')->group(function () {
        //Roles
        Route::resource('roles', RoleController::class);
        Route::post('get-roles', [RoleController::class, 'getRoleData']);
        Route::post('get-routes', [RoleController::class, 'getRoutes']);

        //Users
        Route::resource('users', UserController::class);
        Route::get('get-users', [UserController::class, 'getUserData']);

        //Group User
        Route::resource('group_users', GroupUserController::class);
        Route::get('get-groups', [GroupUserController::class, 'getGroupUserData']);

        //People
        Route::resource('people', PeopleController::class);
        Route::get('get-people', [PeopleController::class, 'getPeopleData']);

        //Group Assign
        Route::resource('group_assign', GroupAssignController::class);
    });
    /**Registration */
    // Teachers
    Route::resource('registration/teachers', TeacherController::class);
    Route::get('registration/get-teachers', [TeacherController::class, 'getTeachersData']);

    //Degrees
    Route::resource('registration/degrees', DegreeController::class);
    Route::get('registration/get-degrees', [DegreeController::class, 'getDegreesData']);

    //Subjets
    Route::resource('registration/subjects', SubjectController::class);
    Route::get('registration/get-subjects', [SubjectController::class, 'getSubjectsData']);

    //Classrooms
    Route::resource('registration/classrooms', ClassroomController::class);
    Route::get('registration/get-classrooms', [ClassroomController::class, 'getClassroomsData']);

    //Teacher Settings
    Route::resource('registration/teacher_settings', TeacherSettingController::class);

    //Academic Planning
    Route::resource('registration/academic_planning', AcademicPlanningController::class);

    //Student Enrollments
    Route::resource('registration/student_enrollments', StudentEnrollmentController::class);
    Route::post('registration/get-students', [StudentEnrollmentController::class, 'getStudentsData']);

    //Other Income
    Route::resource('registration/other_income', OtherIncomeController::class);

    //Administrative
    Route::resource('registration/administrative', AdministrativeController::class);

    //Enrolled Students
    Route::resource('registration/enrolled_students', EnrolledStudentController::class);

    /** Reports */
    //Reportes de Avance Estudiante
      Route::prefix('reports')->group(function () {
        Route::get('avance-estudiante', [ReportController::class, 'avanceEstudiante'])->name('avance_estudiante.index');
        Route::get('entregas-avance', [ReportController::class, 'entregasAvance'])->name('entregas_avance.index');
    });


    Route::prefix('modules')->group(function () {
        Route::get('tesis', [ModuleController::class, 'tesis'])->name('tesis.index');
        Route::get('proyecto-grado', [ModuleController::class, 'proyectoGrado'])->name('proyecto_grado.index');
        Route::get('trabajo-dirijido', [ModuleController::class, 'trabajoDirijido'])->name('trabajo_dirijido.index');
        Route::get('graduacion-excelencia', [ModuleController::class, 'graduacionExcelencia'])->name('graduacion_excelencia.index');
    });

    /**Settings System */
    Route::get('settings-system', [SettingController::class, 'index'])->name('settings');
});

Route::get('attendance/take-attendance', [AttendanceController::class, 'attendance'])->name('attendance.take');
