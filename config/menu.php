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
            'children' => 'administracion',
            'isActive' => 'administracion.*',
            'permission' => ['permiso.index', 'persona.index', 'usuario.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Registro',
            'icon'     => 'fas fa-file-signature',
            'children' => 'registros',
            'isActive' => 'registros.*',
            'permission' => ['plantel_administrativo.index', 'docente.index','programa_academico.index','estudiante.index','proyecto.index','metodologia.index','modulo.index','pago.index','taller.index','avance-estudiante.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Modúlos',
            'icon'     => 'fas fa-address-book',
            'children' => 'modulos',
            'isActive' => 'modulos.*',
            'permission' => ['graduacion_excelencia.index', 'proyecto_grado.index', 'tesis.index', 'trabajo_dirijido.index'],
        ],

        [
            'type'     => 'submenu',
            'title'    => 'Reportes',
            'icon'     => 'fas fa-folder-open',
            'children' => 'reportes',
            'isActive' => 'reportes.*',
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

    ],

    // Definición de los children
    'children' => [

        'administracion' => [
            [
                'route' => 'roles.index',
                'title' => 'Roles',
                'permission' => 'permiso.index',
            ],
            [
                'route' => 'personas.index',
                'title' => 'Personas',
                'permission' => 'persona.index',
            ],
            [
                'route' => 'usuarios.index',
                'title' => 'Usuarios',
                'permission' => 'usuario.index',
            ]

        ],

        'registros' => [
            [
                'route' => 'plantel-administrativo.index',
                'title' => 'Plantel Administrativo',
                'permission' => 'plantel_administrativo.index',
            ],

            [
                'route' => 'docentes.index',
                'title' => 'Docentes',
                'permission' => 'docente.index',
            ],

            [
                'route' => 'programa-academico.index',
                'title' => 'Programa Académico',
                'permission' => 'programa_academico.index',
            ],

            [
                'route' => 'estudiantes.index',
                'title' => 'Estudiantes',
                'permission' => 'estudiante.index',
            ],

            [
                'route' => 'proyectos.index',
                'title' => 'Proyectos',
                'permission' => 'proyecto.index',
            ],

            [
                'route' => 'metodologias.index',
                'title' => 'Metodologías',
                'permission' => 'metodologia.index',
            ],

            [
                'route' => 'modulos.index',
                'title' => 'Modulo',
                'permission' => 'modulo.index',
            ],

            [
                'route' => 'pagos.index',
                'title' => 'Pagos',
                'permission' => 'pago.index',
            ],

            [
                'route' => 'talleres.index',
                'title' => 'Talleres',
                'permission' => 'taller.index',
            ],

            [
                'route' => 'avance-estudiante.index',
                'title' => 'Avance Estudiante',
                'permission' => 'avance-estudiante.index',
            ],

        ],

        // 'modules' => [
        //     [
        //         'route' => 'tesis.index',
        //         'title' => 'Tesis',
        //         'permission' => 'tesis.index',
        //     ],
        //     [
        //         'route' => 'graduacion_excelencia.index',
        //         'title' => 'Graduación por Excelencia',
        //         'permission' => 'graduacion_excelencia.index',
        //     ],
        //     [
        //         'route' => 'proyecto_grado.index',
        //         'title' => 'Proyecto de Grado',
        //         'permission' => 'proyecto_grado.index',
        //     ],
        //     [
        //         'route' => 'trabajo_dirijido.index',
        //         'title' => 'Trabajo Dirijido',
        //         'permission' => 'trabajo_dirijido.index',
        //     ],

        // ],

        // 'reports' => [

        //     //Reportes de Avance Estudiante
        //     [
        //         'route' => 'avance_estudiante.index',
        //         'title' => 'Avances del Estudiante',
        //         'permission' => 'avance_estudiante.index',
        //     ],
        //     [
        //         'route' => 'entregas_avance.index',
        //         'title' => 'Entregas de Avance',
        //         'permission' => 'entregas_avance.index',
        //     ],

        // ],

    ],

];
