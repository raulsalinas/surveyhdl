<?php

namespace App\Http\Controllers;

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
                    if($request->estado>0 || empty($request->estado)!=false){
                        $data->deleted_at = Carbon::now();
                    }else{
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
