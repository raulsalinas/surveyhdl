<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvanceDeUsuariosView extends Model
{

    protected $table = 'public.avance_usuario_view';
    protected $fillable = ['email','nombre_muestreo','cantidad_encuestas','cantidad_respuestas','cantidad_preguntas','porcentaje_avance'];


}
