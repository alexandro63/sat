<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = "modulo";
    protected $guarded = ['id'];


    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    public function metodologia()
    {
        return $this->belongsTo(Metodologia::class, 'id_metodologia');
    }
}
