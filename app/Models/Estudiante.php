<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'alumno';
    protected $primaryKey = 'alu_id';
    protected $guarded = ['alu_id'];

    public function student()
    {
        return $this->belongsTo(People::class, 'alu_per_id', 'per_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'alu_doc_rev_id', 'per_id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'alu_per_id', 'per_id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'alu_car_id', 'car_id');
    }

    public static function shifts()
    {
        return [
            'mañana' => 'Mañana',
            'tarde' => 'Tarde',
            'noche' => 'Noche'
        ];
    }

    public static function courses()
    {
        return [
            'regular' => 'Regular',
            'acelerado' => 'Acelerado'
        ];
    }
}
