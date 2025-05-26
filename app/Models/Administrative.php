<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrative extends Model
{
    protected $table = "hr_administrativo";
    protected $primaryKey = "adm_id";
    protected $guarded = ['adm_id'];

    public function people()
    {
        return $this->belongsTo(People::class, 'adm_per_id', 'per_id');
    }
}
