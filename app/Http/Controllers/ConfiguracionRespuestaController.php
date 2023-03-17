<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConfiguracionRespuestaController extends Controller
{

    public function listar(Request $request)
    {
        $data = Respuesta::withTrashed()->select('respuesta.*'
        )->where('pregunta_id',$request->id);

        return DataTables::of($data)
        ->addColumn('created_at', function ($data) {
            return $data->created_at?(date('d-m-Y', strtotime($data->created_at))):'';
        })
        ->addColumn('updated_at', function ($data) {
            return $data->updated_at?(date('d-m-Y', strtotime($data->updated_at))):'';
        })
        ->addColumn('deleted_at', function ($data) {
            return $data->deleted_at?(date('d-m-Y', strtotime($data->deleted_at))):'';
        })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar-respuesta" data-id="'.$data->id.'" ><i class="fa-solid fa-pencil"></i></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);
    }

    public function obtener($id){
        try {
        $error = "";
        $data= Respuesta::withTrashed()->find($id);
        if(empty($data)==false){
            $status = 'info';
            $mensaje = 'Se encontro un resultado';
        }else{
            $status = 'warning';
            $mensaje = 'No se encontro el registro';
        }
    } catch (Exception $ex) {
        $data = [];
        $status = 'error';
        $mensaje = 'Hubo un problema al intentar buscar el registro. Por favor intente de nuevo';
        $error = $ex;
    }
        return response()->json(array('data' => $data, 'status' => $status, 'mensaje' => $mensaje, 'error' => $error), 200);

    }

    public function obtenerListaRespuestas($id){
        try {
        $error = "";
        $data= Respuesta::where('pregunta_id',$id)->get();
        if(empty($data)==false){
            $status = 'info';
            $mensaje = 'Se encontro resultados';
        }else{
            $status = 'warning';
            $mensaje = 'No se encontro el registro';
        }
    } catch (Exception $ex) {
        $data = [];
        $status = 'error';
        $mensaje = 'Hubo un problema al intentar buscar el registro. Por favor intente de nuevo';
        $error = $ex;
    }
        return response()->json(array('data' => $data, 'status' => $status, 'mensaje' => $mensaje, 'error' => $error), 200);

    }

    public function aplicarRespuestasParaTodasLasPreguntas($id){
        try {
            $error = "";
            $data=[];
            // para aplicar
            $encuesta_id = Pregunta::where('id',$id)->first()->encuesta_id;
            $respuestasPreguntaDeReferencia= Respuesta::where('pregunta_id',$id)->orderBy('id')->get();
            $existentesRespuestas= Respuesta::where('pregunta_id','!=',$id)->orderBy('id')->get();
            $preguntasParaAplicar= Pregunta::where([['id','!=',$id],['encuesta_id',$encuesta_id]])->orderBy('id')->get();

            foreach ($existentesRespuestas as $keyEr => $er) {
                
                Respuesta::where('id',$er->id)->first()->delete();

            }

            foreach ($preguntasParaAplicar as $keyPpa => $ppa) {
                foreach ($respuestasPreguntaDeReferencia as $keyRpdr => $rpdr) {
                        $data= new Respuesta();
                        $data->pregunta_id =$ppa->id;
                        $data->nombre = $rpdr->nombre;
                        $data->save();
                }
            }


            if(empty($data)==false){
                $status = 'info';
                $mensaje = 'Se guardo las respuestas';
            }else{
                $status = 'warning';
                $mensaje = 'Hubo un problema al intentar guardar';
            }
        } catch (Exception $ex) {
            $data = [];
            $status = 'error';
            $mensaje = 'Hubo un problema al intentar guardar los registros. Por favor intente de nuevo';
            $error = $ex;
        }
            return response()->json(array('data' => $data, 'status' => $status, 'mensaje' => $mensaje, 'error' => $error), 200);
    
    }

    public function guardar(Request $request)
    {

        // try {
            // $validator = Validator::make($request->all(), ['documento' => 'unique:pgsql.public.respuesta']);

            // if ($validator->fails()) {
            //     $respuesta = 'duplicado';
            //     $alerta = 'warning';
            //     $mensaje = 'Duplicado, Se encontró un registro con el mismo contenido';
            //     $error = "";
            // } else {
                $data = Respuesta::withTrashed()->firstOrNew(['id' => intval($request->id)]);
                    $data->nombre = $request->nombre;
                    $data->pregunta_id = $request->pregunta_id;
                    if (!isset($request->estado)) {
                        $data->deleted_at = Carbon::now();
                    } else {
                        $data->deleted_at = null;
                    }
                $data->save();
    
                $respuesta = 'ok';
                $alerta = 'success';
                if ($request->id > 0) {
                    $mensaje = 'Se ha editado la respuesta';
                } else {
                    $mensaje = 'Se ha registrado la respuesta';
                }
                $error = '';
            // }
            
        // } catch (Exception $ex) {
        //     $respuesta = 'error';
        //     $alerta = 'error';
        //     $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
        //     $error = $ex;
        // }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
}
