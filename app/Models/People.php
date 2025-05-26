<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class People extends Model
{
    use HasFactory;

    protected  $table = 'gr_persona';
    protected $primaryKey = 'per_id';
    protected $fillable = [
        'per_nombres',
        'per_apellidopat',
        'per_apellidomat',
        'per_ci',
        'per_direccion',
        'per_telefono',
        'per_celular',
        'per_estado'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
