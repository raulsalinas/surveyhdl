@section('cabecera')
Encuestas - Muestreo
@endsection

@extends('layouts.app')

@section('content')
<div class="row justify-content-md-left p-4" id="contenedorMuestreo">
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/encuestas/listado_muestreo_menu-view.js?v=1') }}"></script>
<script src="{{ asset('js/encuestas/listado_muestreo_menu-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        const listadoMuestreoMenuView = new ListadoMuestreoMenuView(new ListadoMuestreoMenuModel(csrf_token));
        listadoMuestreoMenuView.listar(null);
        // listadoMuestreoMenuView.eventos();
    });
</script>

@endsection