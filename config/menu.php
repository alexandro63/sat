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
            'isActive' => 'administration.*',
            'permission' => ['permiso.index', 'persona.index', 'usuario.index', 'grupo_usuario.index', 'ag_grupo_usuario.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Registro',
            'icon'     => 'fas fa-file-signature',
            'children' => 'registration',
            'isActive' => 'registration.*',
            'permission' => ['ambiente.index', 'carrera.index', 'materia.index', 'administrativo.index', 'docente.index', 'plan_academico.index', 'alumno_inscripcion.index', 'otros_ingresos.index', 'ajuste_docente.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Modúlos',
            'icon'     => 'fas fa-address-book',
            'children' => 'modules',
            'isActive' => 'modules.*',
            'permission' => ['graduacion_excelencia.index', 'proyecto_grado.index', 'tesis.index', 'trabajo_dirijido.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Reportes',
            'icon'     => 'fas fa-folder-open',
            'children' => 'reports',
            'isActive' => 'reports.*',
            'permission' => ['avance_estudiante.index', 'entregas_avance.index'],
        ],


        [
            'type'     => 'submenu',
            'title'    => 'Asistencias',
            'icon'     => 'fas fa-user-clock',
            'children' => 'attendance',
            'isActive' => 'attendance.*',
            'permission' => ['asistencias.docente', 'asistencias.modificador'],
        ],

        [
            'type'     => 'menu',
            'route'    => 'settings',
            'title'    => 'Configuraciones',
            'icon'     => 'fas fa-cogs',
            'activeOn' => 'settings.*',
            'permission' => 'configuracion.index',
        ],

    ],

    // Definición de los children
    'children' => [

        'administration' => [
            [
                'route' => 'roles.index',
                'title' => 'Roles',
                'permission' => 'permiso.index',
            ],
            [
                'route' => 'people.index',
                'title' => 'Personas',
                'permission' => 'persona.index',
            ],
            [
                'route' => 'users.index',
                'title' => 'Usuarios',
                'permission' => 'usuario.index',
            ]

        ],

        'registration' => [
            [
                'route' => 'degrees.index',
                'title' => 'Carreras',
                'permission' => 'carrera.index',
            ],
            [
                'route' => 'subjects.index',
                'title' => 'Modulo',
                'permission' => 'materia.index',
            ],
            [
                'route' => 'administrative.index',
                'title' => 'Administrativo',
                'permission' => 'administrativo.index',
            ],
            [
                'route' => 'teachers.index',
                'title' => 'Docentes',
                'permission' => 'docente.index',
            ],
            // [
            //     'route' => 'academic_planning.index',
            //     'title' => 'Planificación acádemica',
            //     'permission' => 'plan_academico.index',
            // ],
            [
                'route' => 'student_enrollments.index',
                'title' => 'Inscripción alumnos',
                'permission' => 'alumno_inscripcion.index',
            ],

            // [
            //     'route' => 'other_income.index',
            //     'title' => 'Otros ingresos',
            //     'permission' => 'otros_ingresos.index',
            // ],
            // [
            //     'route' => 'teacher_settings.index',
            //     'title' => 'Ajustes docentes',
            //     'permission' => 'ajuste_docente.index',
            // ]
        ],

        'modules' => [
            [
                'route' => 'tesis.index',
                'title' => 'Tesis',
                'permission' => 'tesis.index',
            ],
            [
                'route' => 'graduacion_excelencia.index',
                'title' => 'Graduación por Excelencia',
                'permission' => 'graduacion_excelencia.index',
            ],
            [
                'route' => 'proyecto_grado.index',
                'title' => 'Proyecto de Grado',
                'permission' => 'proyecto_grado.index',
            ],
            [
                'route' => 'trabajo_dirijido.index',
                'title' => 'Trabajo Dirijido',
                'permission' => 'trabajo_dirijido.index',
            ],

        ],

        'reports' => [

            //Reportes de Avance Estudiante
            [
                'route' => 'avance_estudiante.index',
                'title' => 'Avances del Estudiante',
                'permission' => 'avance_estudiante.index',
            ],
            [
                'route' => 'entregas_avance.index',
                'title' => 'Entregas de Avance',
                'permission' => 'entregas_avance.index',
            ],

        ],

        'attendance' => [
            [
                'route' => 'attendance.take',
                'title' => 'Registro de Marcador Docente',
                'permission' => 'asistencias.docente',
            ],
            [
                'route' => 'attendance.take',
                'title' => 'Modificar Marcadores',
                'permission' => 'asistencias.modificador',
            ]
        ]


    ],

];
