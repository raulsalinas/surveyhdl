<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Respuesta;

class Pregunta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.pregunta';
    protected $fillable = ['nombre','respuesta_unica'];
    protected $appends = ['cantidad_respuestas'];





    public function getCantidadRespuestasAttribute()
    {
            $cantidadRespuestas = Respuesta::withTrashed()->
            leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.pregunta_id')
            
            ->where(
                [
                    ['respuesta.pregunta_id', $this->attributes['id']],
                    ['respuesta.deleted_at', '=',null]
                ]
            )
            ->count();
            return $cantidadRespuestas;

    }

    public function respuesta()
    {
        return $this->hasMany('App\Models\Respuesta', 'pregunta_id', 'id');
    }
}
