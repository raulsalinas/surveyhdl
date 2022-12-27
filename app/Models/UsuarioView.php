<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioView extends Model
{

    protected $table = 'public.usuario_view';
    protected $fillable = ['nombre_completo','email','cantidad_inicios_de_sesion','fecha_alta_usuario','fecha_baja_usuario','cantidad_encuestas_activas','nombre_encuestas_activas'];


}
