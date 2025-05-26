<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'gr_ambiente';
    protected $primaryKey = 'amb_id';

    protected $guarded = ['amb_id'];
}
