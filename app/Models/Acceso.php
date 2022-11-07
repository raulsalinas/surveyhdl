<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acceso extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'public.acceso';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function acceso_usuario()
    {
        return $this->hasMany('App\Models\AccesoUsuario', 'acceso_id', 'id');
    }

}

