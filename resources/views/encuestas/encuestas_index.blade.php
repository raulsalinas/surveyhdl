@section('cabecera')
Encuestas
@endsection

@extends('layouts.app')

@section('content')
  
<div class="row justify-content-md-left">
    <h4>Resumen</h4>
</div>
<div class="row justify-content-md-left" id="contenedorEncuestas"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/encuestas/listado_encuesta_menu-view.js?v=1') }}"></script>
<script src="{{ asset('js/encuestas/listado_encuesta_menu-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        const listadoEncuestaMenuView = new ListadoEncuestaMenuView(new ListadoEncuestaMenuModel(csrf_token));
        listadoEncuestaMenuView.listar(null);
        listadoEncuestaMenuView.eventos();
    });
</script>

@endsection