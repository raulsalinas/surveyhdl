@section('cabecera')
Configuración
@endsection

@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-4">
        <div class="card mb-3 shadow-sm p-3 mb-5 bg-body rounded" style="max-width: 540px; text-align:center;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ url('images/configuracion/connected.svg') }}" class="img-fluid rounded-start p-2" style="height: 146px;" alt="gestión de encuestas">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"> <a href="{{ route('configuracion.encuesta.index') }}">Gestión de encuestas</a></h5>
                        <p class="card-text"><small class="text-muted">Encuesta, pregunta&respuesta, muestreo, muestra.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 shadow-sm p-3 mb-5 bg-body rounded" style="max-width: 540px; text-align:center;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ url('images/configuracion/personal_settings.svg') }}" class="img-fluid rounded-start p-2" style="height: 146px;" alt="gestión de usuarios">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('configuracion.usuario.index') }}">Gestión de usuarios</a></h5>
                        <p class="card-text"><small class="text-muted">Usuarios, accesos.</small></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection