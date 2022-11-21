<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Personal;
use App\Models\Pregunta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EncuestasController extends Controller
{
    public function index(Request $request)
    {
    
        return view('encuestas.encuestas_index', get_defined_vars());
    }

    public function menuEncuestaList(){

        $encuestas = Encuesta::withTrashed()->get();
        $personal = Personal::withTrashed()->where('usuario_id',Auth::user()->id)->first();
    


               // $collect = collect($requerimiento);
        // $collect->put('total',$total);

        foreach ($encuestas as $keyEnc => $encuesta) {
            $preguntas= Pregunta::where('encuesta_id',$encuesta->id)->get();

            $cantidEncuestasCompletadas = MuestraPreguntaRespuesta::with('respuesta','respuesta.pregunta')->whereHas('respuesta.pregunta',function ($q) use ($encuesta) {
                $q->where('pregunta.encuesta_id', '=', $encuesta->id);
            })->where('personal_id',$personal->id)->get();

            $encuestaObj[]=[
                'id_encuesta'=>$encuesta->id,
                'nombre_encuesta'=>$encuesta->nombre,
                'preguntas'=>$preguntas,
                'total_preguntas' => $preguntas->count(),
                'cantidad_preguntas_completadas'=>$cantidEncuestasCompletadas->count(),
                'cantidad_preguntas_por_completar'=>($preguntas->count()) - ($cantidEncuestasCompletadas->count()) 
            ];
            //     $preguntaRespuestaDePersonal[] = MuestraPreguntaRespuesta::with('respuesta','respuesta.pregunta')->whereHas('respuesta',function ($q) use ($pregunta) {
            //     $q->where('respuesta.pregunta_id', '=', $pregunta->id);
            // })->where('personal_id',$personal->id)->get();
            // foreach ($preguntaRespuestaDePersonal as $keyPregRes => $preguntaRespuesta) {
            //     if($encuesta->id==$preguntaRespuesta->respuesta->pregunta->encuesta_id){
            //         $
            //     }
            // }

        } 
        return $encuestaObj;
    }
}