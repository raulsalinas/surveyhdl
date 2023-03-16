<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\AccesoUsuario;
use App\Models\Personal;
use App\Models\Tipo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ConfiguracionUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $tipoList = $this->tipoList();
        return view('configuracion.usuario.panel_usuario', get_defined_vars());
    }

    public function tipoList()
    {
        return Tipo::all();
    }

    public function listar(Request $request)
    {
        $data = User::withTrashed()->with('personal.tipo');

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
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                        <button type="button" class="btn btn-xs btn-warning editar-usuario" data-id="' . $data->id . '" title="Editar usuario" ><i class="fa-solid fa-pencil"></i></button>
                        <button type="button" class="btn btn-xs btn-info acceso-usuario" data-id="' . $data->id . '" title="Accesos de usuario"><i class="fa-solid fa-user-gear"></i></button>
                    </div>';
            })
            ->rawColumns(['accion'])->make(true);
    }

    public function obtener($id)
    {
        try {
            $error = "";
            $data = User::withTrashed()->with('personal.tipo')->find($id);
            if (empty($data) == false) {
                $status = 'info';
                $mensaje = 'Se encontro un resultado';
            } else {
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
        try {
            $validator = Validator::make($request->all(), ['email' => 'unique:pgsql.public.users']);

            if ($validator->fails()) {
                $respuesta = 'duplicado';
                $alerta = 'warning';
                $mensaje = 'El email ingresado ya se encuentra registrado';
                $error = "";
            } else {
                $dataUser = User::withTrashed()->firstOrNew(['id' => intval($request->id)]);
                $dataUser->email = $request->email;
                if (isset($request->contraseña) == true && trim($request->contraseña) != '') {
                    $dataUser->password = Hash::make($request->contraseña);
                }

                if (!isset($request->estado)) {
                    $dataUser->deleted_at = Carbon::now();
                } else {
                    $dataUser->deleted_at = null;
                }
                $dataUser->save();

                $dataPersonal = Personal::withTrashed()->firstOrNew(['usuario_id' => intval($request->id)]);
                $dataPersonal->nombres = $request->nombres;
                $dataPersonal->apellido_paterno = $request->apellido_paterno;
                $dataPersonal->apellido_materno = $request->apellido_materno;
                $dataPersonal->nro_documento = $request->nro_documento;
                $dataPersonal->tipo_id = $request->tipo_id;
                $dataPersonal->usuario_id = $dataUser->id;
                $dataPersonal->save();

                $respuesta = 'ok';
                $alerta = 'success';
                if ($request->id > 0) {
                    $mensaje = 'Se ha editado la encuesta';
                } else {
                    $mensaje = 'Se ha registrado la encuesta';
                }
                $error = '';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }


    public function obtenerAcceso($id)
    {
        try {
            $error = "";
            $data = AccesoUsuario::withTrashed()->with('acceso')->where('usuario_id', $id)->get();
            if (empty($data) == false) {
                $status = 'info';
                $mensaje = 'Se encontro un resultado';
            } else {
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

    public function actualizarAccesoPrueba()
    {
        $tipoPersonalId = 1;
        $usuariosConTipo = User::withTrashed()->with('personal')->whereHas('personal', function ($q) use ($tipoPersonalId) {
            $q->where('personal.tipo_id', '=', $tipoPersonalId);
        })->get();
        foreach ($usuariosConTipo as $keyUsuTipo => $usuTipo) {

            return $usuTipo->id;
        }

    
    }

    public function actualizarAcceso(Request $request)
    {
        $tipoPersonalId = $request->tipo_id;

        try {
            if (intval($tipoPersonalId) > 0) {

                $usuariosConTipo = User::withTrashed()->with('personal')->whereHas('personal', function ($q) use ($tipoPersonalId) {
                    $q->where('personal.tipo_id', '=', $tipoPersonalId);
                })->get();

                foreach ($usuariosConTipo as $keyUsuTipo => $usuTipo) {
                    foreach ($request->acceso as $keyAcceso => $acceso) {

                        $dataAccesUser = AccesoUsuario::withTrashed()->firstOrNew(['acceso_id' => $keyAcceso, 'usuario_id' => $usuTipo->id]);
                        $dataAccesUser->acceso_id = $keyAcceso;
                        $dataAccesUser->usuario_id =$usuTipo->id;

                        if ($acceso > 0 || $acceso != "false") {

                            $dataAccesUser->deleted_at = null;
                        } else {
                            $dataAccesUser->deleted_at = Carbon::now();
                        }
                        $dataAccesUser->save();
                    }
                }
            } else {
                foreach ($request->acceso as $key => $acceso) {

                    $dataAccesUser = AccesoUsuario::withTrashed()->firstOrNew(['acceso_id' => $key, 'usuario_id' => $request->id]);
                    $dataAccesUser->acceso_id = $key;
                    $dataAccesUser->usuario_id = $request->id;

                    if ($acceso > 0 || $acceso != "false") {

                        $dataAccesUser->deleted_at = null;
                    } else {
                        $dataAccesUser->deleted_at = Carbon::now();
                    }
                    $dataAccesUser->save();
                }
            }

            $respuesta = 'ok';
            $alerta = 'success';
            if ($request->id > 0) {
                $mensaje = 'Se ha editado el acceso';
            } else {
                $mensaje = 'Se ha registrado el acceso';
            }
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
}
