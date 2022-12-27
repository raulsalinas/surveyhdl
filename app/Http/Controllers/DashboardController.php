<?php

namespace App\Http\Controllers;

use App\Models\AvanceDeUsuariosView;
use App\Models\Encuesta;
use App\Models\Muestra;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\UsuarioView;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $encuestas = Encuesta::all();
        return view('dashboard.dashboard', get_defined_vars());
    }
    public function obtenerCifrasTotales()
    {
        $respuesta=[
            'cantidad_encuestas'=>Encuesta::count(),
            'cantidad_usuarios'=>User::count(),
            'cantidad_muestra'=>Muestra::count(),
        ];
        return response()->json($respuesta);
    }
    public function obtenerPreguntas($id)
    {
        return response()->json(Pregunta::where('encuesta_id',$id)->orderBy('id')->get());
    }
    public function obtenerUsuariosActivosYBajas()
    {
        $respuesta=[
           
            'cantidad_usuarios_activos'=>User::withTrashed()->whereNull('deleted_at')->count(),
            'cantidad_usuarios_de_baja'=>User::withTrashed()->whereNotNull('deleted_at')->count(),
        ];
        return response()->json($respuesta);
    }

    public function listarInformacionUsuarios(Request $request)
    {
        $data = UsuarioView::all();
 
        return DataTables::of($data)
        ->addColumn('fecha_alta_usuario', function ($data) {
            return $data->fecha_alta_usuario?(date('d-m-Y', strtotime($data->fecha_alta_usuario))):'';
        })
        ->addColumn('fecha_baja_usuario', function ($data) {
            return $data->fecha_baja_usuario?(date('d-m-Y', strtotime($data->fecha_baja_usuario))):'';
        })
        ->make(true);
    }
    public function AvanceDeUsuariosView(Request $request)
    {
        $data = AvanceDeUsuariosView::all();
 
        return DataTables::of($data)
        ->make(true);
    }

    public function obtenerResultadoPorPreguntas($idPregunta)
    {
        $respuestaList= Respuesta::where('pregunta_id',$idPregunta)->get();
        $idRespuestaList=[];
        $nombreRespuestaList=[];
        $respuesta=[];
        foreach ($respuestaList as $key => $value) {
            $idRespuestaList[] = $value->id;
            $nombreRespuestaList[] = $value->nombre;
        }
        
        $muestraPreguntaRespuestaList = MuestraPreguntaRespuesta::whereIn('respuesta_id',$idRespuestaList)->get();

        foreach ($idRespuestaList as $key => $respuestaId) {
            $i=0;
        foreach ($muestraPreguntaRespuestaList as $key => $pr) {
            if(intval($respuestaId) == intval($pr->respuesta_id)){
                $i++;
            }
        }
        $respuesta[] = $i;
        }

        return response()->json(['etiqueta'=>$nombreRespuestaList,'data'=>$respuesta]);
    }

}
