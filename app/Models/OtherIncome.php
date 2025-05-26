<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherIncome extends Model
{
    protected $table = 'fn_pago';
    protected $primaryKey = 'pag_id';
    protected $guarded = ['pag_id'];

    public function student()
    {
        return $this->belongsTo(StudentEnrollment::class, 'pag_alu_id', 'alu_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pag_usu_id', 'id');
    }
}
