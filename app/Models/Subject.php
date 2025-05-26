<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'ac_materia';
    protected $primaryKey = 'mat_id';
    protected $fillable = ['mat_car_id', 'mat_nombre', 'mat_descripcion'];


    public function degree()
    {
        return $this->belongsTo(Degree::class, 'mat_car_id', 'car_id');
    }
}
