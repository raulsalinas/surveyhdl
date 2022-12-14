<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ConfiguracionEncuestaController extends Controller
{

    public function listar(Request $request)
    {
        $data = Encuesta::withTrashed()->select('encuesta.*'
        );

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
                <button type="button" class="btn btn-xs btn-warning editar" data-id="'.$data->id.'" ><i class="fa-solid fa-pencil"></i></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);
    }

    public function obtener($id){
        try {
        $error = "";
        $data= Encuesta::withTrashed()->find($id);
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
            // $validator = Validator::make($request->all(), ['documento' => 'unique:pgsql.public.encuesta']);

            // if ($validator->fails()) {
            //     $respuesta = 'duplicado';
            //     $alerta = 'warning';
            //     $mensaje = 'Duplicado, Se encontr?? un registro con el mismo contenido';
            //     $error = "";
            // } else {
                $data = Encuesta::withTrashed()->firstOrNew(['id' => intval($request->id)]);
                    $data->nombre = $request->nombre;
                    if($request->estado>0 || empty($request->estado)!=false){
                        $data->deleted_at = Carbon::now();
                    }else{
                        $data->deleted_at = null;
                    }
                $data->save();
    
                $respuesta = 'ok';
                $alerta = 'success';
                if ($request->id > 0) {
                    $mensaje = 'Se ha editado la encuesta';
                } else {
                    $mensaje = 'Se ha registrado la encuesta';
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
