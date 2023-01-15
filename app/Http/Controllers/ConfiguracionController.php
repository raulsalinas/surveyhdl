<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Fecha;
use App\Models\Personal;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function configuracion_index(Request $request)
    {
        return view('configuracion.configuracion_index', get_defined_vars());
    }

    public function encuesta_index(Request $request)
    {
        $fechaList = $this->fechaList();
        $personalList = $this->personalList();
        $encuestas= Encuesta::all();

        return view('configuracion.encuesta.encuesta_index', get_defined_vars());
    }

    public function fechaList(){
        return Fecha::withTrashed()->get();
    }
    public function personalList(){
        return Personal::withTrashed()->with('usuario')->get();
    }
}
