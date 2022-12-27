@section('cabecera')
Principal
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row" id='contenedorResumenEncuestas'>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Bienvenido! {{ Auth::user()->personal->nombres }}</h4>
                 <hr>
                <p class="mb-0">Usted esta en la página principal de resumen.</p>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary">Total de ingresos al sistema</h6>
                        <h4 class="card-text text-center link-success"><i class="fa-solid fa-user-check"></i> <span id="totalIngresosAlSistema">0</span> </h4>

                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary">Total de preguntas contestadas</h6>
                        <h4 class="card-text text-center link-success"><i class="fa-solid fa-check-double"></i> <span id="TotalDePreguntasContestadas">0</span> </h4>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/principal/resumen_usuario-view.js?v=1') }}"></script>
<script src="{{ asset('js/principal/resumen_usuario-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        const resumenUsuarioView = new ResumenUsuarioView(new ResumenUsuarioModel(csrf_token));
        resumenUsuarioView.obtenerInformacionDeResumen();
        resumenUsuarioView.eventos();
    });
</script>
@endsection