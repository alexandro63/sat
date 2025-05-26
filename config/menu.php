<?php
return [

    // Menú principal
    'items' => [
        [
            'type'     => 'menu',
            'route'    => 'home',
            'title'    => 'Tablero',
            'icon'     => 'fas fa-home',
            'activeOn' => 'home.*',
        ],

        [
            'type'  => 'header',
            'title' => 'MÓDULOS',
            'icon'  => 'fa fa-ellipsis-h',
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Administración',
            'icon'     => 'fas fa-users',
            'children' => 'administration',
            'isActive' => 'administration.*'
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Registro',
            'icon'     => 'fas fa-file-signature',
            'children' => 'registration',
            'isActive' => 'registration.*'
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Reportes',
            'icon'     => 'fas fa-folder-open',
            'children' => 'reports',
            'isActive' => 'reports.*'
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Modúlos',
            'icon'     => 'fas fa-address-book',
            'children' => 'modules',
            'isActive' => 'modules.*'
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Asistencias',
            'icon'     => 'fas fa-user-clock',
            'children' => 'attendance',
            'isActive' => 'attendance.*'
        ],

        [
            'type'     => 'menu',
            'route'    => 'settings',
            'title'    => 'Configuraciones',
            'icon'     => 'fas fa-cogs',
            'activeOn' => 'settings.*',
        ],

    ],

    // Definición de los children
    'children' => [

        'administration' => [
            [
                'route' => 'roles.index',
                'title' => 'Roles',
            ],
            [
                'route' => 'people.index',
                'title' => 'Personas',
            ],
            [
                'route' => 'users.index',
                'title' => 'Usuarios',
            ],
            [
                'route' => 'group_users.index',
                'title' => 'Grupo de usuarios',
            ],
            [
                'route' => 'group_assign.index',
                'title' => 'Asignaciones de grupos',
            ],

        ],

        'registration' => [
            [
                'route' => 'classrooms.index',
                'title' => 'Ambientes',
            ],
            [
                'route' => 'degrees.index',
                'title' => 'Carreras',
            ],
            [
                'route' => 'subjects.index',
                'title' => 'Materias',
            ],
            [
                'route' => 'administrative.index',
                'title' => 'Administrativo',
            ],
            [
                'route' => 'teachers.index',
                'title' => 'Docentes',
            ],
            [
                'route' => 'academic_planning.index',
                'title' => 'Planificación acádemica',
            ],
            [
                'route' => 'student_enrollments.index',
                'title' => 'Inscripción alumnos',
            ],

            [
                'route' => 'other_income.index',
                'title' => 'Otros ingresos',
            ],
            [
                'route' => 'teacher_settings.index',
                'title' => 'Ajustes docentes',
            ]
        ],

        'reports' => [

            //Reportes de Personal Docente
            [
                'route' => 'teacher_hours.index',
                'title' => 'Horas trabajadas de docentes',
            ],
            [
                'route' => 'teacher_attendance.index',
                'title' => 'Marcado de docentes',
            ],
            [
                'route' => 'teacher_payments.index',
                'title' => 'Pagos a docentes',
            ],

            //Reportes Administrativos
            [
                'route' => 'admin_hours.index',
                'title' => 'Horas trabajadas del personal administrativo',
            ],
            [
                'route' => 'admin_income.index',
                'title' => 'Ingresos administrativos',
            ],

            //Finanzas y Cuentas
            [
                'route' => 'general_debts.index',
                'title' => 'Cuentas pendientes generales',
            ],
            [
                'route' => 'course_debts.index',
                'title' => 'Cuentas pendientes por curso',
            ],
            [
                'route' => 'payrolls.index',
                'title' => 'Planillas de pago',
            ],

            //Reportes de Estudiantes
            [
                'route' => 'student_payments.index',
                'title' => 'Pagos de alumnos',
            ],
            [
                'route' => 'career_income.index',
                'title' => 'Ingresos por carrera',
            ],

            //Asignaciones (extra)
            [
                'route' => 'group_assignn.index',
                'title' => 'Asignaciones de grupos',
            ],

        ],

        'modules' => [
            [
                'route' => 'tesis.index',
                'title' => 'Tesis'
            ],
            [
                'route' => 'proyecto_grado.index',
                'title' => 'Proyecto de Grado'
            ],
            [
                'route' => 'trabajo_dirijido.index',
                'title' => 'Trabajo Dirijido'
            ],
            [
                'route' => 'graduacion_excelencia.index',
                'title' => 'Graduación por Excelencia'
            ]
        ],

        'attendance' => [
            [
                'route' => 'attendance.take',
                'title' => 'Registro de Marcador Docente'
            ],
            [
                'route' => 'attendance.take',
                'title' => 'Modificar Marcadores'
            ]
        ]


    ],

];
