<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPlanning extends Model
{
    protected $table = 'plan_academico';
    protected $primaryKey = 'plan_id';
    protected $guarded = ['plan_id'];


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'plan_mat_id', 'mat_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'plan_amb_id', 'amb_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'plan_doc_id', 'doc_id');
    }
}
