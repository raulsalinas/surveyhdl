<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Personal;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrincipalController extends Controller
{
    public function index(Request $request)
    {
        return view('principal.principal', get_defined_vars());
    }

    public function obtenerInformacionDeResumen(Request $request){
        $personal = Personal::withTrashed()->where('usuario_id',Auth::user()->id)->first();
        $encuenstas = Encuesta::withTrashed()->with('pregunta','muestreo')->get();
        $cantidadDePreguntasContestadasDeUsuario= MuestraPreguntaRespuesta::where('personal_id',$personal->id)->count();
        $cantidadIniciosDeSesion= Auth::user()->cantidad_inicios_de_sesion;
        return response()->json( ['personal'=>$personal,'cantidad_inicios_sesion'=>$cantidadIniciosDeSesion,'encuestas'=>$encuenstas,'cantidad_preguntas_contestadas'=>$cantidadDePreguntasContestadasDeUsuario]);

    }
}
