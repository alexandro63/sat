<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    protected $guarded = ['id'];

    public function estudiante()
    {
        return $this->belongsTo(Persona::class, 'per_id');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'doc_rev_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'per_id');
    }

    public function programaAcademico()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'id_programa_academico');
    }
}
