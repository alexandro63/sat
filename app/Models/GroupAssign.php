<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAssign extends Model
{
    protected $table = 'ad_grupo_usuario';
    protected $primaryKey = 'gus_id';
    protected $fillable = ['gus_usu_id', 'gus_gru_id'];

    public function group()
    {
        return $this->belongsTo(GroupUser::class, 'gus_gru_id', 'gru_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'gus_usu_id', 'id');
    }
}
