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

            // ==== GRUPOS DE USUARIO ====
            'grupos' => [
                'grupo_usuario.index',
                'grupo_usuario.create',
                'grupo_usuario.update',
                'grupo_usuario.delete',
            ],

            // ==== RELACIÓN USUARIO⇄GRUPO ====
            'asignaciones_grupo' => [
                'ag_grupo_usuario.index',
                'ag_grupo_usuario.view',
                'ag_grupo_usuario.create',
                'ag_grupo_usuario.update',
                'ag_grupo_usuario.delete',
            ],

            // ==== REGISTRO ====
            'registros' => [
                'registro.view',
            ],

            // ==== AMBIENTES ====
            'ambientes' => [
                'ambiente.index',
                'ambiente.create',
                'ambiente.update',
                'ambiente.delete',
            ],

            // ==== CARRERAS ====
            'carreras' => [
                'carrera.index',
                'carrera.create',
                'carrera.update',
                'carrera.delete',
            ],

            // ==== MATERIAS ====
            'materias' => [
                'materia.index',
                'materia.view',
                'materia.create',
                'materia.update',
                'materia.delete',
            ],

            // ==== DOCENTES ====
            'docentes' => [
                'docente.index',
                'docente.view',
                'docente.create',
                'docente.update',
                'docente.delete',
            ],

            // ==== PLANIFICACIÓN ACADÉMICA ====
            'planificacion_academica' => [
                'plan_academica.index',
                'plan_academica.view',
                'plan_academica.create',
                'plan_academica.update',
                'plan_academica.delete',
            ],

            // ==== ALUMNOS – INSCRIPCIONES ====
            'alumno_inscripcion' => [
                'alumno.inscripcion.index',
                'alumno.inscripcion.view',
                'alumno.inscripcion.create',
                'alumno.inscripcion.update',
                'alumno.inscripcion.delete',
            ],

            // ==== OTROS INGRESOS ====
            'otros_ingresos' => [
                'otros_ingresos.index',
                'otros_ingresos.view',
                'otros_ingresos.create',
                'otros_ingresos.update',
                'otros_ingresos.delete',
            ],

            // ==== ADMINISTRATIVO ====
            'administrativo' => [
                'administrativo.index',
                'administrativo.view',
                'administrativo.create',
                'administrativo.update',
                'administrativo.delete',
            ],

            // — Horas trabajadas docente
            'horas_docente' => [
                'horas_docente.view',
                'horas_docente.generate',
            ],

            // — Cuentas pendientes (alumnos)
            'cuentas_pendientes' => [
                'cuentas_pendientes.index',
                'cuentas_pendientes.view',
                'cuentas_pendientes.update',
            ],

            // — Planilla de sueldos
            'planilla' => [
                'planilla.view',
                'planilla.generate',
            ],

            // — Reporte de marcado
            'reporte_marcado' => [
                'reporte_marcado.view',
                'reporte_marcado.generate',
            ],

            // — Reporte de pago
            'reporte_pago' => [
                'reporte_pago.view',
                'reporte_pago.generate',
            ],

            // — Cuentas por curso
            'cuentas_curso' => [
                'cuentas_curso.view',
                'cuentas_curso.update',
            ],

            // — Horas trabajadas administrativo
            'horas_administrativo' => [
                'horas_administrativo.view',
                'horas_administrativo.generate',
            ],

            // — Reporte de ingresos generales
            'reporte_ingresos' => [
                'reporte_ingresos.view',
                'reporte_ingresos.delete',
            ],

            // — Reporte de ingresos por carrera
            'reporte_ingresos_carreras' => [
                'reporte_ingresos_carreras.view',
                'reporte_ingresos_carreras.generate',
            ],

            // — Reporte de pago alumnos
            'reporte_pago_alumnos' => [
                'reporte_pago_alumnos.view',
                'reporte_pago_alumnos.generate',
            ],

            // ==== MARCADO ====
            'registro_marcado' => [
                'registro_marcado.index',
                'registro_marcado.view',
                'registro_marcado.create',
                'registro_marcado.update',
                'registro_marcado.delete',
            ],

            // ==== NOTAS DE ALUMNOS ====
            'notas_alumnos' => [
                'notas_alumnos.index',
                'notas_alumnos.view',
                'notas_alumnos.create',
                'notas_alumnos.update',
            ],
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
