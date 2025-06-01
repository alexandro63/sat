<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantelAdministrativo extends Model
{
    protected $table = "plantel_administrativo";
    protected $guarded = ['id'];


    public function persona()
    {
        return $this->belongsTo(Persona::class, 'per_id');
    }

}
