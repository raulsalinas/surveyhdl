@section('cabecera')
Gestión  de Encuestas
@endsection

@extends('layouts.app')

@section('content')
<div class="container-md pt-4 p-3 border bg-light">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="encuesta-tab" data-bs-toggle="tab" data-bs-target="#encuesta-tab-pane" type="button" role="tab" aria-controls="encuesta-tab" aria-selected="true">Encuesta</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pregunta-tab" data-bs-toggle="tab" data-bs-target="#pregunta-tab-pane" -pane type="button" role="tab" aria-controls="pregunta-tab" aria-selected="false">Pregunta & Respuesta</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="muestreo-tab" data-bs-toggle="tab" data-bs-target="#muestreo-tab-pane" -pane type="button" role="tab" aria-controls="muestra-tab" aria-selected="false">Muestreo</button>
        </li>
        
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="muestra-tab" data-bs-toggle="tab" data-bs-target="#muestra-tab-pane" -pane type="button" role="tab" aria-controls="muestra-tab" aria-selected="false">Muestra</button>
        </li>



    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active mt-2" id="encuesta-tab-pane" role="tabpanel" aria-labelledby="encuesta-tab" tabindex="0">
            @include("configuracion/encuesta/encuesta_tab")
        </div>

        <div class="tab-pane fade" id="pregunta-tab-pane" role="tabpanel" aria-labelledby="pregunta-tab" tabindex="0">
            @include("configuracion/encuesta/pregunta_tab")
        </div>
        
        <div class="tab-pane fade" id="muestreo-tab-pane" role="tabpanel" aria-labelledby="muestreo-tab" tabindex="0">
            @include("configuracion/encuesta/muestreo_tab")
        </div>
        <div class="tab-pane fade" id="muestra-tab-pane" role="tabpanel" aria-labelledby="muestra-tab" tabindex="0">
            @include("configuracion/encuesta/muestra_tab")
        </div>

    </div>
</div>




@endsection

@section('scripts')
<script src="{{ asset('js/configuracion/listado_encuesta-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_encuesta-model.js?v=1') }}"></script>

<script src="{{ asset('js/configuracion/listado_pregunta-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_pregunta_respuesta-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_pregunta-model.js?v=1') }}"></script>

<script src="{{ asset('js/configuracion/listado_muestreo-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_muestreo-model.js?v=1') }}"></script>

<script src="{{ asset('js/configuracion/listado_muestra-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_muestra-model.js?v=1') }}"></script>
<script>
    $(document).ready(function() {
        const listadoEncuestaView = new ListadoEncuestaView(new ListadoEncuestaModel(csrf_token));
        listadoEncuestaView.listar(null);
        listadoEncuestaView.eventos();

        const listadoPreguntaView = new ListadoPreguntaView(new ListadoPreguntaModel(csrf_token),new ListadoPreguntaRespuestaView(new ListadoPreguntaModel(csrf_token)));
        listadoPreguntaView.listar(null);
        listadoPreguntaView.eventos();

        const listadoMuestreoView = new ListadoMuestreoView(new ListadoMuestreoModel(csrf_token));
        listadoMuestreoView.listar(null);
        listadoMuestreoView.eventos();

        const listadoMuestraView = new ListadoMuestraView(new ListadoMuestraModel(csrf_token));
        listadoMuestraView.listar(null);
        listadoMuestraView.eventos();
    });
</script>

@endsection