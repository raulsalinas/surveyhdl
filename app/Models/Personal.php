<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'public.personal';
    protected $fillable = ['nombres','apellido_paterno','apellido_materno','nro_documento','tipo_id','usuario_id'];

    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'usuario_id');
    }
    public function tipo()
    {
        return $this->hasOne('App\Models\Tipo', 'id', 'tipo_id');
    }
    public function muestra_pregunta_respuesta()
    {
        return $this->hasMany('App\Models\MuestraPreguntaRespuesta', 'personal_id', 'id');
    }
}
