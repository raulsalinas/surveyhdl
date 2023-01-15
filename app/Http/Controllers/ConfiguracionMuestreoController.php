<?php

namespace App\Http\Controllers;

use App\Models\Fecha;
use App\Models\Muestreo;
use Carbon\Carbon;
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

    public function guardar(Request $request)
    {

        // try {
            // $validator = Validator::make($request->all(), ['documento' => 'unique:pgsql.public.pregunta']);

            // if ($validator->fails()) {
            //     $respuesta = 'duplicado';
            //     $alerta = 'warning';
            //     $mensaje = 'Duplicado, Se encontró un registro con el mismo contenido';
            //     $error = "";
            // } else {
                $muestreo = Muestreo::withTrashed()->firstOrNew(['id' => intval($request->id)]);
                    $muestreo->nombre = $request->nombre;
                    $muestreo->encuesta_id = $request->encuesta_id;
                    if($request->estado>0 || empty($request->estado)!=false){
                        $muestreo->deleted_at = Carbon::now();
                    }else{
                        $muestreo->deleted_at = null;
                    }
                $muestreo->save();

                $muestreoTieneFechaInicioFin = Fecha::where('muestreo_id',$muestreo->id)->get();

                if(count($muestreoTieneFechaInicioFin) ==0){
                    $fecha= new Fecha();
                    $fecha->fecha_inicio = $request->fecha_inicio;
                    $fecha->fecha_fin = $request->fecha_fin;
                    $fecha->muestreo_id = $muestreo->id;
                    $fecha->save();

                }

    
                $respuesta = 'ok';
                $alerta = 'success';
                if ($request->id > 0) {
                    $mensaje = 'Se ha editado un muestreo';
                } else {
                    $mensaje = 'Se ha registrado un muestreo';
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