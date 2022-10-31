<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index(Request $request)
    {
        return view('principal.principal', get_defined_vars());
    }
}
