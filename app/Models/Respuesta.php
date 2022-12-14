<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respuesta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.respuesta';
    protected $fillable = ['nombre'];

    public function pregunta()
    {
        return $this->hasOne('App\Models\Pregunta', 'id', 'pregunta_id');
    }
    public function muestraPreguntaRespuesta()
    {
        return $this->hasOne('App\Models\MuestraPreguntaRespuesta', 'respuesta_id', 'id');
    }
}
