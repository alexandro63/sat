<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'ac_carrera';
    protected $primaryKey = 'car_id';

    protected $fillable = [
        'car_nombre',
        'car_descripcion',
        'car_duracion',
    ];
}
