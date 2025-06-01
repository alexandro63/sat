<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docente';
    protected $guarded = ['id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'per_id');
    }
}
