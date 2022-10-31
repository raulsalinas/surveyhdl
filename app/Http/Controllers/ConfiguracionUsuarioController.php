<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionUsuarioController extends Controller
{
    public function index(Request $request)
    {
        return view('configuracion.usuario.panel_usuario', get_defined_vars());
    }
    public function listar(Request $request)
    {
        return 0;
    }
}
