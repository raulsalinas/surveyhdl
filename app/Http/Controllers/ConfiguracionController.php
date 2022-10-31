<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function configuracion_index(Request $request)
    {
        return view('configuracion.configuracion_index', get_defined_vars());
    }

    public function encuesta_index(Request $request)
    {
        return view('configuracion.encuesta.encuesta_index', get_defined_vars());
    }
}
