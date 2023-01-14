<?php

namespace App\Http\Controllers;

use App\Models\AvanceDeUsuariosView;
use App\Models\Encuesta;
use App\Models\Muestra;
use App\Models\MuestraPreguntaRespuesta;
use App\Models\Muestreo;
use App\Models\Pregunta;
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
}
