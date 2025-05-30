<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'ac_docente';
    protected $primaryKey = 'doc_id';
    protected $guarded = ['doc_id'];

    public function people()
    {
        return $this->belongsTo(People::class, 'doc_per_id', 'per_id');
    }
}
