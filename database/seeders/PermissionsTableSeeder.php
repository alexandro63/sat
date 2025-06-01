<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // ==== PERMISOS ====
            'permisos' => [
                'permiso.index',
                'permiso.create',
                'permiso.update',
                'permiso.delete',
            ],

            // ==== PERSONAS ====
            'personas' => [
                'persona.index',
                'persona.view',
                'persona.create',
                'persona.update',
                'persona.delete',
            ],

            // ==== USUARIOS ====
            'usuarios' => [
                'usuario.index',
                'usuario.view',
                'usuario.create',
                'usuario.update',
                'usuario.delete',
            ],

            // ==== PLANTEL ADMINISTRATIVO ====
            'plantel_administrativo' => [
                'plantel_administrativo.index',
                'plantel_administrativo.view',
                'plantel_administrativo.create',
                'plantel_administrativo.update',
                'plantel_administrativo.delete',
            ],

            // ==== DOCENTES ====
            'docentes' => [
                'docente.index',
                'docente.view',
                'docente.create',
                'docente.update',
                'docente.delete',
            ],

            // ==== PROGRAMA ACADÉMICO ====
            'programa_academico' => [
                'programa_academico.index',
                'programa_academico.view',
                'programa_academico.create',
                'programa_academico.update',
                'programa_academico.delete',
            ],

            // ==== ESTUDIANTE ====
            'estudiante' => [
                'estudiante.index',
                'estudiante.view',
                'estudiante.create',
                'estudiante.update',
                'estudiante.delete',
            ],

            // ==== OTROS INGRESOS ====
            'otros_ingresos' => [
                'otros_ingresos.index',
                'otros_ingresos.view',
                'otros_ingresos.create',
                'otros_ingresos.update',
                'otros_ingresos.delete',
            ],

            // ==== AJUSTE DOCENTE ====
            'ajuste_docentes' => [
                'ajuste_docente.index',
                'ajuste_docente.view',
                'ajuste_docente.create',
                'ajuste_docente.update',
                'ajuste_docente.delete',
            ],


            // === MODULOS ===
            'modulos' => [
                'tesis.index',
                'graduacion_excelencia.index',
                'proyecto_grado.index',
                'trabajo_dirijido.index',
            ],

            //=== REPORTES ===
            'reportes' => [
                'avance_estudiante.index',
                'entregas_avance.index'
            ],

            //=== ASISTENCIAS ===
            'asistencias' => [
                'asistencias.docente',
                'asistencias.modificador'
            ],

            //=== CONFIGURACIÓN ===
            'configuraciones' => [
                'configuracion.index',
            ]
        ];


        $insert_data = [];
        $time_stamp = Carbon::now()->toDateTimeString();

        // Flatten and insert the permissions
        foreach ($data as $permissions) {
            foreach ($permissions as $permission) {
                $insert_data[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => $time_stamp,
                    'updated_at' => $time_stamp
                ];
            }
        }

        Permission::insert($insert_data);
    }
}
