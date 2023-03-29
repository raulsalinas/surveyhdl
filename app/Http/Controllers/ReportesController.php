<?php

namespace App\Http\Controllers;

use App\Models\AvanceDeUsuariosView;
use App\Models\Encuesta;
use App\Models\Muestra;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Muestreo;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\UsuarioView;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportesController extends Controller
{
    public function ReportesIndex(Request $request)
    {
        $encuestas= Encuesta::all();
        return view('reportes.reportes_index', get_defined_vars());
    }

    public function listarInformacionDeUsuario(Request $request)
    {
        $data = UsuarioView::all();

        return DataTables::of($data)
            ->addColumn('fecha_alta_usuario', function ($data) {
                return $data->fecha_alta_usuario ? (date('d-m-Y', strtotime($data->fecha_alta_usuario))) : '';
            })
            ->addColumn('fecha_baja_usuario', function ($data) {
                return $data->fecha_baja_usuario ? (date('d-m-Y', strtotime($data->fecha_baja_usuario))) : '';
            })
            ->make(true);
    }
    public function listarAvanceDeUsuario(Request $request)
    {
        $data = AvanceDeUsuariosView::all();

        return DataTables::of($data)
            ->make(true);
    }

    public function listarPreguntasPorEncuesta(Request $request)
    {
        $data = Pregunta::withTrashed()->with('encuesta.muestreo');

        return DataTables::of($data)
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? (date('d-m-Y', strtotime($data->created_at))) : '';
            })
            ->addColumn('updated_at', function ($data) {
                return $data->updated_at ? (date('d-m-Y', strtotime($data->updated_at))) : '';
            })
            ->addColumn('deleted_at', function ($data) {
                return $data->deleted_at ? (date('d-m-Y', strtotime($data->deleted_at))) : '';
            })
            ->make(true);
    }

    public function listarResultadosPorEncuesta(Request $request)
    {
        $muestreos = Muestreo::where('encuesta_id',$request->id_encuesta)->get();
        $idMuestreoList=[];
        foreach ($muestreos as $key => $muestreo) {
            $idMuestreoList[]=$muestreo->id;
        }
        $data = MuestraPreguntaRespuesta::with('personal.usuario','personal.muestra.fecha','respuesta.pregunta.encuesta','muestreo')->whereIn('muestreo_id',$idMuestreoList)->get();

        return DataTables::of($data)
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? (date('d-m-Y', strtotime($data->created_at))) : '';
            })
            ->addColumn('updated_at', function ($data) {
                return $data->updated_at ? (date('d-m-Y', strtotime($data->updated_at))) : '';
            })
            ->addColumn('deleted_at', function ($data) {
                return $data->deleted_at ? (date('d-m-Y', strtotime($data->deleted_at))) : '';
            })
            ->make(true);
    }

    public function obtenerReporteGrafico($idEncuesta){


        
        if($idEncuesta ==1){ // satisfaccion

            $dataTotalEncuestados= $this->obtenerDataTotalEncuestados($idEncuesta);

            return response()->json([
                'etiquetaTotalEncuestados'=>['Satisfacción Alta', 'Satisfacción Media', 'Satisfacción Baja'],'dataTotalEncuestados'=>$dataTotalEncuestados['data'],'total_encuestados'=>$dataTotalEncuestados['total_encuestados'],

            ]);
        }else if($idEncuesta ==2){ // liderazgo
            $etiquetaList=['Satisfacción Alta', 'Satisfacción Media', 'Satisfacción Baja'];

            $dataRecompensaContigente= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[8,10,11,12,16]);
            $dataDireccionPorExcepcion= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[2,5,7,9,18,26]);
            $dataCarisma= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[3,21,33,34]);
            $dataEstimulacionIntelectual= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[4,15,23,25,28,29,30]);
            $dataInspiracion= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[19,22,24]);
            $dataConsideracionIndividualizada= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[13,14,17]);
            $dataAusenciaLiderazgo= $this->obtenerDataDeIndicadorLiderazgo($idEncuesta,[1,6,20,27,31,32]);

            return response()->json(['etiqueta'=>$etiquetaList,
            'dataRecompensaContigente'=>$dataRecompensaContigente,
            'dataDireccionPorExcepcion'=>$dataDireccionPorExcepcion,
            'dataCarisma'=>$dataCarisma,
            'dataEstimulacionIntelectual'=>$dataEstimulacionIntelectual,
            'dataInspiracion'=>$dataInspiracion,
            'dataConsideracionIndividualizada'=>$dataConsideracionIndividualizada,
            'dataAusenciaLiderazgo'=>$dataAusenciaLiderazgo
            ]);
        }


    }


    public function obtenerDataDeIndicadorLiderazgo($idEncuesta,$grupoPregunta){
        $sumaDeRespuestas=0;
        $cantidadSatisfaccionBaja = 0;
        $cantidadSatisfaccionMedia = 0;
        $cantidadSatisfaccionAlta = 0;

        $idPreguntaList=[]; 
        $idRespuestaHabilitadaList=[];
        
        $preguntaList = Pregunta::whereIn('numero_pregunta',$grupoPregunta)->get();

        foreach ($preguntaList as $key => $pregunta) {
            $idPreguntaList[]=$pregunta->id;
        }

        $respuestaHabilitada = Respuesta::whereIn('pregunta_id',$idPreguntaList)->get();
        foreach ($respuestaHabilitada as $key => $value) {
            $idRespuestaHabilitadaList[]=$value->id;
        }
    
        $muestreo = Muestreo::where('encuesta_id',$idEncuesta)->first();

        $usuarioList = User::with('personal')->get();

        foreach ($usuarioList as $key => $usuario) {
            if($usuario->personal !=null && $usuario->personal->id >0){
                $muestraPreguntaRespuestaList = MuestraPreguntaRespuesta::with("respuesta")->whereIn('respuesta_id',$idRespuestaHabilitadaList)->where([['personal_id',$usuario->personal->id],['muestreo_id',$muestreo->id]])->get();
                foreach ($muestraPreguntaRespuestaList as $key => $pr) {
                    $sumaDeRespuestas+= intval($pr->respuesta->valor);
                }

                if($sumaDeRespuestas>=141){
                    $cantidadSatisfaccionAlta+=$sumaDeRespuestas;
                }else if($sumaDeRespuestas >= 115 && $sumaDeRespuestas <= 140){
                    $cantidadSatisfaccionMedia+=$sumaDeRespuestas;
        
                }else if($sumaDeRespuestas <= 114){
                    $cantidadSatisfaccionBaja+=$sumaDeRespuestas;
                }
            }
        }

        return [$cantidadSatisfaccionAlta,$cantidadSatisfaccionMedia,$cantidadSatisfaccionBaja];

    }

    public function obtenerDataTotalEncuestados($idEncuesta){
        $sumaDeRespuestas=0;
        $cantidadSatisfaccionBaja = 0;
        $cantidadSatisfaccionMedia = 0;
        $cantidadSatisfaccionAlta = 0;

        $idPreguntaList=[]; 
        $idRespuestaHabilitadaList=[];
        
        $preguntaList = Pregunta::where('numero_pregunta','>',0)->get();

        foreach ($preguntaList as $key => $pregunta) {
            $idPreguntaList[]=$pregunta->id;
        }

        $respuestaHabilitada = Respuesta::whereIn('pregunta_id',$idPreguntaList)->get();
        foreach ($respuestaHabilitada as $key => $value) {
            $idRespuestaHabilitadaList[]=$value->id;
        }
    
        $muestreo = Muestreo::where('encuesta_id',$idEncuesta)->first();

        $usuarioList = User::with('personal')->get();

        foreach ($usuarioList as $key => $usuario) {
            if($usuario->personal !=null && $usuario->personal->id >0){
                $muestraPreguntaRespuestaList = MuestraPreguntaRespuesta::with("respuesta")->whereIn('respuesta_id',$idRespuestaHabilitadaList)->where([['personal_id',$usuario->personal->id],['muestreo_id',$muestreo->id]])->get();
                foreach ($muestraPreguntaRespuestaList as $key => $pr) {
                    $sumaDeRespuestas+= intval($pr->respuesta->valor);
                }

                if($sumaDeRespuestas>=141){
                    $cantidadSatisfaccionAlta+=$sumaDeRespuestas;
                }else if($sumaDeRespuestas >= 115 && $sumaDeRespuestas <= 140){
                    $cantidadSatisfaccionMedia+=$sumaDeRespuestas;
        
                }else if($sumaDeRespuestas <= 114){
                    $cantidadSatisfaccionBaja+=$sumaDeRespuestas;
                }
            }
        }

        return ['total_encuestados'=>$usuarioList->count(),'data'=>[$cantidadSatisfaccionAlta,$cantidadSatisfaccionMedia,$cantidadSatisfaccionBaja]];

    }
}
