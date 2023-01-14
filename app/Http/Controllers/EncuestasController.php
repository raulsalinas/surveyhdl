<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Muestreo;
use App\Models\Personal;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EncuestasController extends Controller
{
    public function muestreoIndex(Request $request)
    {
    
        return view('encuestas.muestreos_index', get_defined_vars());
    }
    public function encuestaIndex(Request $request)
    {
    
        return view('encuestas.encuestas_index', get_defined_vars());
    }

    public function menuMuestreoList(){
        $muestreos = Muestreo::with('encuestas')->get();
        return $muestreos;
    }

    public function menuEncuestaList($idMuestreo,$idEncuesta){

        if($idEncuesta >0){
            return $this->obtenerInformacionDeAvance($idEncuesta);
        }

    }

    public function llenarEncuesta(){

        return view('encuestas.llenar_encuesta', get_defined_vars());

    }

    public function obtenerPreguntasDeEncuesta($idEncuesta){
        $preguntas = Pregunta::with(['encuesta','respuestas.muestraPreguntaRespuesta'=>function ($q) {
            $q->where('muestra_pregunta_respuesta.personal_id', '=', Auth::user()->personal->id);
        }]) 
        ->where("encuesta_id",$idEncuesta)->orderBy('id','asc')->get();
        return $preguntas;
    }
    public function obtenerInformacionDeAvance($idEncuesta){
        $encuestas = Encuesta::withTrashed()->where('id',$idEncuesta)->get();
        $personal = Personal::withTrashed()->where('usuario_id',Auth::user()->id)->first();
        // $collect = collect($requerimiento);
        // $collect->put('total',$total);
            foreach ($encuestas as $keyEnc => $encuesta) {
                $preguntas= Pregunta::where('encuesta_id',$encuesta->id)->get();

                
                    $cantidEncuestasCompletadas = MuestraPreguntaRespuesta::with('respuesta','respuesta.pregunta')->whereHas('respuesta.pregunta',function ($q) use ($encuesta) {
                        $q->where('pregunta.encuesta_id', '=', $encuesta->id);
                    })->where([['personal_id',$personal->id]])->get();
        
                    $encuestaObj[]=[
                        'id_encuesta'=>$encuesta->id,
                        'nombre_encuesta'=>$encuesta->nombre,
                        'preguntas'=>$preguntas,
                        'total_preguntas' => $preguntas->count(),
                        'cantidad_preguntas_completadas'=>$cantidEncuestasCompletadas->count(),
                        'cantidad_preguntas_por_completar'=>($preguntas->count()) - ($cantidEncuestasCompletadas->count()) 
                    ];
            }

        return $encuestaObj;
    }

    public function getIdRespuestaexistenteParaRemplazar($respuesta_id,$personal_id,$muestreo_id){
        $respuesta= Respuesta::find($respuesta_id);
        $RespuestaDePreguntaList = Respuesta::where([['pregunta_id',$respuesta->pregunta_id],['deleted_at',null]])->get();
        $idRespuestaDePreguntaList=[];

        foreach ($RespuestaDePreguntaList as $key => $value) {
            $idRespuestaDePreguntaList[]=intval($value->id);
        }
   
        $todaMuestraPreguntaRespuesta= MuestraPreguntaRespuesta::where([['muestreo_id',$muestreo_id],['personal_id',$personal_id],['deleted_at',null]])->get();
        foreach ($todaMuestraPreguntaRespuesta as $key => $value) {
            if(in_array(intval($value->respuesta_id),$idRespuestaDePreguntaList)){
                return $value->respuesta_id;
            
            }
        }
        return 0;

        
    }
    public function guardarRespuesta( Request $request){
        DB::beginTransaction();
        try {
            // $id = $request->id;
            // $muestreo_id = $request->muestreo_id;
            // $personal_id = $request->personal_id;
            // $respuesta_id = $request->respuesta_id;

            $mensaje = '';
            $estado = 'info';

            
            $idRespuestaParaRemplazar = $this->getIdRespuestaexistenteParaRemplazar($request->respuesta_id,$request->personal_id,$request->muestreo_id);
            
            if($idRespuestaParaRemplazar>0){
                $muestraPreguntaRespuesta= MuestraPreguntaRespuesta::where([['respuesta_id',$idRespuestaParaRemplazar],['muestreo_id',$request->muestreo_id],['personal_id',$request->personal_id],['deleted_at',null]])->first();            

                $muestraPreguntaRespuesta->muestreo_id=$request->muestreo_id;
                $muestraPreguntaRespuesta->personal_id= $request->personal_id;
                $muestraPreguntaRespuesta->respuesta_id=$request->respuesta_id;
                $muestraPreguntaRespuesta->save(); 
                $estado = 'success';
                $mensaje = 'Respuesta actualizada';
            }else{
                $newMuestraPreguntaRespuesta = new MuestraPreguntaRespuesta();
                $newMuestraPreguntaRespuesta->muestreo_id=$request->muestreo_id;
                $newMuestraPreguntaRespuesta->personal_id= $request->personal_id;
                $newMuestraPreguntaRespuesta->respuesta_id=$request->respuesta_id;
                $newMuestraPreguntaRespuesta->save(); 
                $estado = 'success';
                $mensaje = 'Respuesta guardada';

            }

            DB::commit();

            return response()->json(['estado'=>$estado,  'mensaje'=>$mensaje]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['estado'=>$estado, 'mensaje' => 'Hubo un problema al guardar la respuesta. Por favor intentelo de nuevo. Mensaje de error: ' . $e->getMessage()]);
        }
    }
}