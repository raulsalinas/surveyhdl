<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuestraPreguntaRespuesta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.muestra_pregunta_respuesta';
    protected $fillable = ['respuesta_id','personal_id','muestreo_id'];



    public function respuesta()
    {
        return $this->hasOne('App\Models\Respuesta', 'id', 'respuesta_id');
    }
    public function muestreo()
    {
        return $this->hasOne('App\Models\Muestreo', 'id', 'muestreo_id');
    }
}
