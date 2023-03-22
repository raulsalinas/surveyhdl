<?php

namespace App\Http\Controllers;

use App\Models\AvanceDeUsuariosView;
use App\Models\Encuesta;
use App\Models\Muestra;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Muestreo;
use App\Models\Personal;
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
        $usuarios = User::with("personal")->get();
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

    public function obtenerResultadoPorUsuario($idEncuesta,$idUsuario)
    {

        $personal = Personal::where('usuario_id',$idUsuario)->first();

        $etiquetaList=['Satisfacción Alta', 'Satisfacción Media', 'Satisfacción Baja'];
        $sumaDeRespuestas=0;
        $data=[0,0,0];
 
        $muestreo = Muestreo::where('encuesta_id',$idEncuesta)->first();

        $muestraPreguntaRespuestaList = MuestraPreguntaRespuesta::with("respuesta")->where([['personal_id',$personal->id],['muestreo_id',$muestreo->id]])->get();
        foreach ($muestraPreguntaRespuestaList as $key => $pr) {
            $sumaDeRespuestas+= intval($pr->respuesta->nombre);
        }
        // Satisfacción laboral Alta:     141 – 180
        // Satisfacción laboral Media:    115 - 140 
        // Satisfacción laboral Baja:     36 - 114
        if($sumaDeRespuestas>=141){
            $data=[$sumaDeRespuestas,0,0];
        }else if($sumaDeRespuestas >= 115 && $sumaDeRespuestas <= 140){
            $data=[0,$sumaDeRespuestas,0];

        }else if($sumaDeRespuestas <= 114){
            $data=[0,0,$sumaDeRespuestas];
        }
 

        return response()->json(['etiqueta'=>$etiquetaList,'data'=>$data]);
    }

}
