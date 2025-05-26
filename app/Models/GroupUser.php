<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'ad_grupo';
    protected $primaryKey = 'gru_id';
    protected $fillable = ['gru_nombre', 'gru_obs', 'gru_estado'];


}
