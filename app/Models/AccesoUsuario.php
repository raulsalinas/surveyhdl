<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccesoUsuario extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'public.acceso_usuario';
    protected $fillable = ['acceso_id','usuario_id'];

    // protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function acceso()
    {
        return $this->hasOne('App\Models\Acceso', 'id', 'acceso_id');
    }

}
