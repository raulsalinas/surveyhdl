<?php

namespace App\Http\ViewComposers;

use App\Models\Personal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AuthToViewComposer {

	public function compose(View $view) {
		$autenticado = [];
		if (Auth::check()){
			$usuario = Auth::user();
			$autenticado = $usuario;
			$autenticado['personal'] = Personal::where('usuario_id',$usuario->id)->first();
		}
		$view->with('auth_user', json_encode($autenticado));
	}
}
