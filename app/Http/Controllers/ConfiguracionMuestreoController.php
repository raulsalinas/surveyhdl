<?php

namespace App\Http\Controllers;

use App\Models\Fecha;
use App\Models\Muestreo;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConfiguracionMuestreoController extends Controller
{
    public function listar(Request $request)
    {
        $data = Muestreo::withTrashed()->select('muestreo.*'
        )->with('fecha');

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
                <button type="button" class="btn btn-xs btn-warning editar-muestreo" data-id="'.$data->id.'" title="Editar muestreo" ><i class="fa-solid fa-pencil"></i></button>
                <button type="button" class="btn btn-xs btn-primary muestreo-fecha" data-id="'.$data->id.'" title="Muestreo fecha"><i class="fa-solid fa-calendar"></i></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);
    }

    public function obtenerMuestreo($id){
        try {
        $error = "";
        $data= Muestreo::withTrashed()->find($id);
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
    public function obtenerFechas(Request $request){
 
        $data = Fecha::withTrashed()->with('muestreo')->where('fecha.muestreo_id',$request->id);

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
                <button type="button" class="btn btn-xs btn-warning fecha" data-id="'.$data->id.'" title="Fecha" ><i class="fa-solid fa-pencil"></i></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);

    }


    public function obtenerFecha($id){
        try {
        $error = "";
        $data= Fecha::with('muestreo')->withTrashed()->find($id);
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
}